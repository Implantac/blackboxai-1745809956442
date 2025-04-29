<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Detalhes do Recibo</h1>

    <div class="bg-white p-6 rounded shadow space-y-4">
        <div>
            <strong>Reserva ID:</strong> <?= htmlspecialchars($receipt['booking_id']) ?>
        </div>
        <div>
            <strong>Número do Recibo:</strong> <?= htmlspecialchars($receipt['receipt_number']) ?>
        </div>
        <div>
            <strong>Valor:</strong> R$ <?= number_format($receipt['amount'], 2, ',', '.') ?>
        </div>
        <div>
            <strong>Forma de Pagamento:</strong> <?= htmlspecialchars($receipt['payment_method']) ?>
        </div>
        <div>
            <strong>Data de Emissão:</strong> <?= htmlspecialchars($receipt['created_at']) ?>
        </div>
    </div>

    <div class="mt-6">
        <a href="/recibos" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voltar</a>
    </div>
</div>
