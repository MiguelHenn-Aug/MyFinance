@extends('templates.main_template')

@section('conteudo')

<style>
    .dashboard-header {
        margin-bottom: 2rem;
    }
    .dashboard-header h3 {
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .dashboard-header p {
        max-width: 720px;
        color: #6c757d;
    }
    .dashboard-summary .card {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 1rem;
        background: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .dashboard-summary .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 45px rgba(20, 54, 96, 0.08);
    }
    .dashboard-summary .card-body {
        padding: 1.5rem 1.4rem;
    }
    .dashboard-summary .card h6 {
        letter-spacing: 0.12em;
        color: #212529;
        text-transform: uppercase;
        font-size: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .dashboard-summary .card h2 {
        font-size: 2.15rem;
        font-weight: 700;
    }
    .balance-card .card-header,
    .entry-card .card-header,
    .chart-card .card-header,
    .history-card .card-header {
        background-color: #f8f9fa;
        font-weight: 700;
        border-bottom: 1px solid #e9ecef;
    }
    .card.border-0.shadow-sm {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 1rem;
    }
    .card.border-0.shadow-sm .card-header {
        border-radius: 1rem 1rem 0 0;
    }
    .toggle-buttons .btn {
        min-width: 145px;
        border-width: 2px;
        font-weight: 600;
    }
    .toggle-buttons .btn.active {
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.16);
    }
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 700;
        color: #495057;
    }
    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }
    #entry-mode-label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.75rem;
    }
    #summary-future {
        color: #0d6efd;
    }
</style>

<div class="dashboard-header">
    <h3 class="mb-1">
        <i class="bi bi-speedometer2"></i>
        Análise Financeira
    </h3>
    <p class="text-muted mb-0">
        Gerencie seu saldo, ganhos e gastos com clareza. Tudo armazenado para sua próxima sessão.
    </p>
</div>

<p class="text-muted">
    Insira seu saldo atual e registre gastos ou recebimentos. O gráfico será atualizado imediatamente.
</p>

<div class="row mb-4 dashboard-summary">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-dark small">Saldo atual</h6>
                <h2 class="mb-0 text-dark" id="summary-balance">R$ 0,00</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-dark small">Recebimentos</h6>
                <h2 class="mb-0 text-success" id="summary-received">R$ 0,00</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-dark small">Gastos</h6>
                <h2 class="mb-0 text-danger" id="summary-spent">R$ 0,00</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-uppercase text-dark small">Saldo futuro estimado</h6>
                <h2 class="mb-0 text-primary" id="summary-future">R$ 0,00</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                Saldo inicial
            </div>
            <div class="card-body">
                <form id="balance-form">
                    <div class="mb-3">
                        <label for="initial-balance" class="form-label">Valor do saldo</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="initial-balance" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="balance-save-button">Salvar saldo</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header">
                Adicionar ganho ou gasto
            </div>
            <div class="card-body">
                <div class="d-flex mb-3 toggle-buttons">
                    <button type="button" id="add-gain-button" class="btn btn-success me-2 active">ADICIONAR GANHO</button>
                    <button type="button" id="add-loss-button" class="btn btn-outline-danger">ADICIONAR GASTO</button>
                </div>

                <form id="entry-form">
                    <input type="hidden" id="entry-id">
                    <input type="hidden" id="entry-type" value="Recebimento">
                    <div class="mb-3">
                        <label class="form-label" id="entry-mode-label">Novo lançamento: Ganho</label>
                        <input type="text" class="form-control" id="entry-description" placeholder="Descrição (Ex: Venda, Aluguel)" required>
                    </div>
                    <div class="mb-3">
                        <label for="entry-value" class="form-label">Valor</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" id="entry-value" required>
                    </div>
                    <div class="mb-3">
                        <label for="entry-date" class="form-label">Data</label>
                        <input type="date" class="form-control" id="entry-date" required>
                    </div>
                    <div id="entry-help" class="text-danger small mb-3"></div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success" id="entry-submit">Adicionar</button>
                        <button type="button" class="btn btn-outline-secondary" id="entry-cancel" style="display:none;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                Gráfico de saldo
            </div>
            <div class="card-body">
                <canvas id="dashboard-chart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        Histórico de transações
            </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th class="text-end">Valor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="entries-table"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="editConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editConfirmModalLabel">Editar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="edit-confirm-body">
                Deseja editar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirm-edit-button">Sim, editar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editValueModal" tabindex="-1" aria-labelledby="editValueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editValueModalLabel">Ajustar valor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit-entry-value" class="form-label" id="edit-value-label">Novo valor</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" id="edit-entry-value">
                </div>
                <div id="edit-value-help" class="text-danger small"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="save-edit-value-button">Salvar alteração</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const apiUrl = '{{ route('analytics.data') }}';
    const balanceUrl = '{{ route('analytics.saveBalance') }}';
    const entryUrl = '{{ route('analytics.saveEntry') }}';
    const csrfToken = '{{ csrf_token() }}';
    const chartElement = document.getElementById('dashboard-chart').getContext('2d');
    const gainButton = document.getElementById('add-gain-button');
    const lossButton = document.getElementById('add-loss-button');
    const entryTypeInput = document.getElementById('entry-type');
    const entrySubmit = document.getElementById('entry-submit');
    const entryCancel = document.getElementById('entry-cancel');
    const entryModeLabel = document.getElementById('entry-mode-label');
    const entryHelp = document.getElementById('entry-help');
    const balanceInput = document.getElementById('initial-balance');
    const balanceSaveButton = document.getElementById('balance-save-button');
    const editConfirmModalElement = document.getElementById('editConfirmModal');
    const editValueModalElement = document.getElementById('editValueModal');
    const editEntryValueInput = document.getElementById('edit-entry-value');
    const editValueHelp = document.getElementById('edit-value-help');
    let editConfirmModal;
    let editValueModal;
    let currentState = { initial_balance: 0, entries: [] };
    let editingId = null;
    let pendingEditEntry = null;
    const updateEntryPath = id => `/finance-entry/${id}/update`;
    const deleteEntryPath = id => `/finance-entry/${id}/remove`;

    const financeChart = new Chart(chartElement, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Saldo acumulado',
                data: [],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                fill: true,
                tension: 0.25,
            }],
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: true },
            },
            scales: {
                x: {
                    title: { display: true, text: 'Data' },
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Saldo (R$)' },
                },
            },
        },
    });

    const moneyFormat = value => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

    const parseDateValue = dateString => {
        if (!dateString) {
            return null;
        }

        let date = new Date(dateString);
        if (!isNaN(date)) {
            return date;
        }

        const cleaned = dateString.replace(/\s+/g, 'T').replace(/\//g, '-');
        date = new Date(cleaned);
        return isNaN(date) ? null : date;
    };

    const formatDate = dateString => {
        const date = parseDateValue(dateString);
        return date ? date.toLocaleDateString('pt-BR') : dateString;
    };

    const sumByType = (entries, type, filter = () => true) =>
        entries
            .filter(entry => entry.type === type && filter(entry))
            .reduce((sum, entry) => sum + Number(entry.amount), 0);

    const isCurrentOrPastEntry = dateString => {
        const entryDate = parseDateValue(dateString);
        if (!entryDate) {
            return false;
        }
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        entryDate.setHours(0, 0, 0, 0);
        return entryDate <= today;
    };

    const computeCurrentBalance = state => {
        const received = sumByType(state.entries, 'Recebimento', entry => isCurrentOrPastEntry(entry.date));
        const spent = sumByType(state.entries, 'Gasto', entry => isCurrentOrPastEntry(entry.date));
        return Number(state.initial_balance) + received - spent;
    };

    const computeSeries = state => {
        const entries = [...state.entries].sort((a, b) => a.date.localeCompare(b.date));
        const labels = [];
        const values = [];
        let balance = Number(state.initial_balance);

        if (entries.length) {
            entries.forEach(entry => {
                const amount = Number(entry.amount) * (entry.type === 'Gasto' ? -1 : 1);
                balance += amount;
                labels.push(formatDate(entry.date));
                values.push(Number(balance.toFixed(2)));
            });
        } else {
            labels.push(formatDate(new Date().toISOString().split('T')[0]));
            values.push(Number(balance.toFixed(2)));
        }

        return { labels, values };
    };

    const updateSummary = state => {
        const currentBalance = computeCurrentBalance(state);
        const received = sumByType(state.entries, 'Recebimento');
        const spent = sumByType(state.entries, 'Gasto');
        const futureBalance = state.entries.length
            ? Number(state.initial_balance) + received - spent
            : 0;

        document.getElementById('summary-balance').textContent = moneyFormat(currentBalance);
        document.getElementById('summary-received').textContent = moneyFormat(received);
        document.getElementById('summary-spent').textContent = moneyFormat(spent);
        document.getElementById('summary-future').textContent = moneyFormat(futureBalance);
    };

    const updateTable = state => {
        const tbody = document.getElementById('entries-table');
        tbody.innerHTML = '';
        const orderedEntries = [...state.entries].sort((a, b) => b.date.localeCompare(a.date));

        if (!orderedEntries.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-secondary py-3">Nenhuma transação registrada ainda.</td></tr>';
            return;
        }

        orderedEntries.forEach(entry => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formatDate(entry.date)}</td>
                <td>${entry.type}</td>
                <td>${entry.description}</td>
                <td class="text-end ${entry.type === 'Gasto' ? 'text-danger' : 'text-success'}">${moneyFormat(entry.amount)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary me-1" data-edit-id="${entry.id}">Editar</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-delete-id="${entry.id}">Remover</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    };

    const refreshChart = state => {
        const series = computeSeries(state);
        financeChart.data.labels = series.labels;
        financeChart.data.datasets[0].data = series.values;
        financeChart.update();
    };

    const updateBalanceButtonLabel = () => {
        balanceSaveButton.textContent = currentState.initial_balance > 0 ? 'Atualizar saldo' : 'Salvar saldo';
    };

    const validateBalanceInput = () => {
        const balance = Number(balanceInput.value || 0);
        const sameValue = balance === currentState.initial_balance;
        const valid = balance >= 0 && !sameValue;
        balanceSaveButton.disabled = !valid;
        return valid;
    };

    const updateControls = state => {
        const balance = computeCurrentBalance(state);
        const spendingDisabled = balance <= 0;
        lossButton.disabled = spendingDisabled;
        if (spendingDisabled && entryTypeInput.value === 'Gasto') {
            setEntryType('Recebimento');
        }
        updateBalanceButtonLabel();
        validateBalanceInput();
    };

    const render = state => {
        currentState = state;
        updateSummary(state);
        updateTable(state);
        refreshChart(state);
        updateControls(state);
    };

    const setEntryType = type => {
        entryTypeInput.value = type;
        if (type === 'Gasto') {
            gainButton.classList.remove('active', 'btn-success');
            gainButton.classList.add('btn-outline-success');
            lossButton.classList.add('active', 'btn-danger');
            lossButton.classList.remove('btn-outline-danger');
            entrySubmit.classList.remove('btn-success');
            entrySubmit.classList.add('btn-danger');
            entrySubmit.textContent = editingId ? 'Atualizar gasto' : 'Adicionar gasto';
            entryModeLabel.textContent = editingId ? 'Editar lançamento: Gasto' : 'Novo lançamento: Gasto';
        } else {
            lossButton.classList.remove('active', 'btn-danger');
            lossButton.classList.add('btn-outline-danger');
            gainButton.classList.add('active', 'btn-success');
            gainButton.classList.remove('btn-outline-success');
            entrySubmit.classList.remove('btn-danger');
            entrySubmit.classList.add('btn-success');
            entrySubmit.textContent = editingId ? 'Atualizar ganho' : 'Adicionar ganho';
            entryModeLabel.textContent = editingId ? 'Editar lançamento: Ganho' : 'Novo lançamento: Ganho';
        }
        validateEntryForm();
    };

    const postJson = async (url, body) => {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(body),
        });

        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || 'Erro na requisição');
        }

        return data;
    };

    const validateEntryForm = () => {
        const amount = Number(document.getElementById('entry-value').value || 0);
        const date = document.getElementById('entry-date').value;
        const balance = computeCurrentBalance(currentState);
        const isCurrentOrPast = isCurrentOrPastEntry(date);

        if (entryTypeInput.value === 'Gasto' && isCurrentOrPast && amount > balance) {
            entryHelp.textContent = 'Saldo insuficiente para registrar este gasto.';
            entrySubmit.disabled = true;
            return false;
        }

        entryHelp.textContent = '';
        entrySubmit.disabled = false;
        return true;
    };

    const resetEntryForm = () => {
        editingId = null;
        document.getElementById('entry-id').value = '';
        document.getElementById('entry-description').value = '';
        document.getElementById('entry-value').value = '';
        document.getElementById('entry-date').value = new Date().toISOString().split('T')[0];
        entryModeLabel.textContent = 'Novo registro';
        entryCancel.style.display = 'none';
        setEntryType('Recebimento');
    };

    const init = async () => {
        try {
            const response = await fetch(apiUrl);
            const data = await response.json();
            const state = {
                initial_balance: Number(data.initial_balance ?? 0),
                entries: data.entries ?? [],
            };
            render(state);
            document.getElementById('initial-balance').value = state.initial_balance;
        } catch (error) {
            alert('Não foi possível carregar os dados do dashboard. Verifique a conexão com o servidor.');
            render({ initial_balance: 0, entries: [] });
            document.getElementById('initial-balance').value = 0;
        }
        validateBalanceInput();
        document.getElementById('entry-date').value = new Date().toISOString().split('T')[0];
        resetEntryForm();
    };

    document.getElementById('balance-form').addEventListener('submit', async event => {
        event.preventDefault();
        const balance = Number(balanceInput.value || 0);
        if (balance === currentState.initial_balance) {
            alert('O valor informado é igual ao saldo atual. Nada será alterado.');
            balanceInput.value = currentState.initial_balance;
            return;
        }

        if (currentState.initial_balance > 0 && balance !== currentState.initial_balance) {
            const confirmEdit = confirm('Deseja alterar o saldo atual?');
            if (!confirmEdit) {
                balanceInput.value = currentState.initial_balance;
                validateBalanceInput();
                return;
            }
        }

        try {
            const response = await postJson(balanceUrl, { initial_balance: balance });
            render(response.state);
            document.getElementById('initial-balance').value = response.state.initial_balance;
        } catch (error) {
            alert(error.message);
        }
    });

    document.getElementById('entry-form').addEventListener('submit', async event => {
        event.preventDefault();
        if (!validateEntryForm()) {
            return;
        }

        if (editingId) {
            const confirmUpdate = confirm('Deseja salvar as alterações deste registro?');
            if (!confirmUpdate) {
                return;
            }
        }

        const entry = {
            type: entryTypeInput.value,
            amount: Number(document.getElementById('entry-value').value || 0),
            date: document.getElementById('entry-date').value,
            description: document.getElementById('entry-description').value.trim(),
        };

        try {
            const response = editingId
                ? await postJson(updateEntryPath(editingId), entry)
                : await postJson(entryUrl, entry);
            render(response.state);
            resetEntryForm();
        } catch (error) {
            alert(error.message);
        }
    });

    const showEditConfirm = entry => {
        pendingEditEntry = entry;
        document.getElementById('edit-confirm-body').textContent = `Deseja editar o registro "${entry.description}" (${entry.type})?`;
        editConfirmModal.show();
    };

    const showEditValueModal = () => {
        if (!pendingEditEntry) {
            return;
        }
        document.getElementById('editValueModalLabel').textContent = `Editar ${pendingEditEntry.type.toLowerCase()}`;
        document.getElementById('edit-value-label').textContent = `Valor novo para ${pendingEditEntry.type.toLowerCase()}`;
        editEntryValueInput.value = Number(pendingEditEntry.amount).toFixed(2);
        editValueHelp.textContent = '';
        editValueModal.show();
    };

    document.getElementById('confirm-edit-button').addEventListener('click', () => {
        editConfirmModal.hide();
        showEditValueModal();
    });

    const saveEditedValue = async () => {
        if (!pendingEditEntry) {
            return;
        }

        const amount = Number(editEntryValueInput.value || 0);
        if (amount <= 0) {
            editValueHelp.textContent = 'Informe um valor válido maior que zero.';
            return;
        }

        const entry = {
            type: pendingEditEntry.type,
            amount,
            date: pendingEditEntry.date,
            description: pendingEditEntry.description,
        };

        try {
            const response = await postJson(updateEntryPath(pendingEditEntry.id), entry);
            render(response.state);
            resetEntryForm();
            editValueModal.hide();
            pendingEditEntry = null;
        } catch (error) {
            editValueHelp.textContent = error.message;
        }
    };

    document.getElementById('save-edit-value-button').addEventListener('click', saveEditedValue);

    document.getElementById('entries-table').addEventListener('click', async event => {
        const button = event.target.closest('button');
        if (!button) {
            return;
        }

        const editId = button.dataset.editId;
        const deleteId = button.dataset.deleteId;

        if (editId) {
            const entry = currentState.entries.find(item => item.id == editId);
            if (!entry) {
                alert('Registro não encontrado para edição.');
                return;
            }
            showEditConfirm(entry);
            return;
        }

        if (deleteId) {
            if (!confirm('Remover este registro?')) {
                return;
            }
            try {
                const response = await postJson(deleteEntryPath(deleteId), {});
                render(response.state);
                if (editingId === deleteId) {
                    resetEntryForm();
                }
            } catch (error) {
                alert(error.message);
            }
        }
    });

    gainButton.addEventListener('click', () => setEntryType('Recebimento'));
    lossButton.addEventListener('click', () => setEntryType('Gasto'));
    document.getElementById('entry-value').addEventListener('input', validateEntryForm);
    balanceInput.addEventListener('input', validateBalanceInput);
    entryCancel.addEventListener('click', resetEntryForm);
    window.addEventListener('load', () => {
        editConfirmModal = new bootstrap.Modal(editConfirmModalElement);
        editValueModal = new bootstrap.Modal(editValueModalElement);
        init();
    });
</script>

@endsection('conteudo')