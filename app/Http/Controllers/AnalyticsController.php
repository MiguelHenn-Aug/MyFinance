<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AnalyticsController extends Controller
{
    protected function getLoggedUser(): ?Usuarios
    {
        $userId = session('user_id');
        return $userId ? Usuarios::find($userId) : null;
    }

    protected function authorizedUser(): Usuarios
    {
        $user = $this->getLoggedUser();

        if (! $user) {
            abort(401);
        }

        return $user;
    }

    protected function getAccount(Usuarios $user): Account
    {
        return $user->account()->firstOrCreate([
            'usuario_id' => $user->usu_id,
        ], [
            'current_balance' => 0,
            'currency' => 'BRL',
        ]);
    }

    private function isCurrentOrPastDate(?string $date): bool
    {
        if (! $date) {
            return false;
        }

        $entryDate = Carbon::parse($date)->startOfDay();
        return $entryDate->lte(Carbon::today());
    }

    private function canRegisterLoss(Account $account, float $amount, ?int $ignoreId = null, ?string $date = null): bool
    {
        if (! $this->isCurrentOrPastDate($date)) {
            return true;
        }

        $transactionsQuery = $account->transactions()->whereDate('transaction_date', '<=', Carbon::today());

        if ($ignoreId) {
            $transactionsQuery->where('id', '!=', $ignoreId);
        }

        $received = $transactionsQuery->where('type', 'Recebimento')->sum('amount');
        $spent = $transactionsQuery->where('type', 'Gasto')->sum('amount');
        $balance = $account->current_balance + $received - $spent;

        return $balance - $amount >= 0;
    }

    public function data(Request $request): JsonResponse
    {
        $account = $this->getAccount($this->authorizedUser());

        return response()->json([
            'initial_balance' => $account->current_balance,
            'entries' => $account->transactions()->orderBy('transaction_date')->orderBy('id')->get(),
        ]);
    }

    public function saveBalance(Request $request): JsonResponse
    {
        $request->validate([
            'initial_balance' => ['required', 'numeric', 'min:0'],
        ]);

        $account = $this->getAccount($this->authorizedUser());
        $account->current_balance = round($request->input('initial_balance'), 2);
        $account->save();

        return response()->json([
            'state' => [
                'initial_balance' => $account->current_balance,
                'entries' => $account->transactions()->orderBy('transaction_date')->orderBy('id')->get(),
            ],
        ]);
    }

    public function saveEntry(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'in:Recebimento,Gasto'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $account = $this->getAccount($this->authorizedUser());
        $amount = round($request->input('amount'), 2);
        $transactionDate = $request->input('date');

        if ($request->input('type') === 'Gasto' && !$this->canRegisterLoss($account, $amount, null, $transactionDate)) {
            return response()->json(['message' => 'Saldo insuficiente para registrar este gasto.'], 422);
        }

        $account->transactions()->create([
            'type' => $request->input('type'),
            'amount' => $amount,
            'transaction_date' => $request->input('date'),
            'description' => $request->input('description'),
            'status' => 'Pago',
        ]);

        $account->refresh();

        return response()->json([
            'state' => [
                'initial_balance' => $account->current_balance,
                'entries' => $account->transactions()->orderBy('transaction_date')->orderBy('id')->get(),
            ],
        ]);
    }

    public function updateEntry(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'in:Recebimento,Gasto'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $account = $this->getAccount($this->authorizedUser());
        $transaction = Transaction::findOrFail($id);

        if ($transaction->account_id !== $account->id) {
            abort(403);
        }

        $amount = round($request->input('amount'), 2);
        $transactionDate = $request->input('date');

        if ($request->input('type') === 'Gasto' && !$this->canRegisterLoss($account, $amount, $transaction->id, $transactionDate)) {
            return response()->json(['message' => 'Saldo insuficiente para atualizar este gasto.'], 422);
        }

        $transaction->update([
            'type' => $request->input('type'),
            'amount' => $amount,
            'transaction_date' => $request->input('date'),
            'description' => $request->input('description'),
        ]);

        $account->refresh();

        return response()->json([
            'state' => [
                'initial_balance' => $account->current_balance,
                'entries' => $account->transactions()->orderBy('transaction_date')->orderBy('id')->get(),
            ],
        ]);
    }

    public function deleteEntry(int $id): JsonResponse
    {
        $account = $this->getAccount($this->authorizedUser());
        $transaction = Transaction::findOrFail($id);

        if ($transaction->account_id !== $account->id) {
            abort(403);
        }

        $transaction->delete();
        $account->refresh();

        return response()->json([
            'state' => [
                'initial_balance' => $account->current_balance,
                'entries' => $account->transactions()->orderBy('transaction_date')->orderBy('id')->get(),
            ],
        ]);
    }
}
