@extends('templates.main_template')

@section('conteudo')

<h3 class="mb-3">
    <i class="bi bi-book"></i>
    Como Usar o MyFinance
</h3>
<h4>
    Um sistema Moderno, para controle Moderno
</h4>

<p>MyFinance é a solução definitiva para gerenciar suas finanças pessoais de forma simples e eficiente. <br> Com uma interface intuitiva e recursos poderosos, você pode acompanhar seus gastos de perto. <br>
    Diga adeus às planilhas complicadas e dê as boas-vindas a uma nova era de controle financeiro com o MyFinance.</p>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Tudo sob seu Controle!</h5>
        <ol>
            <li><strong>DEFINA</strong> seu saldo atual;</li>
            <li><strong>ADICIONE</strong> seus futuros recebimentos;</li>
            <li><strong>SUBTRAIA</strong> com os gastos;</li>
            <li><strong>INFORME</strong> as datas mais importantes para recebimentos ou gastos;</li>
            <li><strong>CONTROLE</strong> sua despesas com MyFinance, esteja de olho nos saldos futuros;</li>
            <li><strong>MONITORE</strong> seu histórico de recebimentos e gastos.</li>
        </ol>

        <h5 class="mt-4 mb-3">DICAS RÁPIDAS</h5>
        <ul>
            <li>O saldo atual se atualiza de acordo com os valores indicados e as datas.</li>
            <li>Gastos futuros ficam no histórico, mas só alteram o saldo atual quando a data chegar.</li>
            <li>O saldo futuro mostra a projeção com todas as transações registradas.</li>
            <li>Você pode editar e remover as transações no menu do histórico</li>
        </ul>
    </div>
</div>

@endsection('conteudo')