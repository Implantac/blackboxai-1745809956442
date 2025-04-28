<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Detalhes da Reserva</h1>

    <div class="bg-white p-6 rounded shadow space-y-4">
        <div>
            <strong>Quarto:</strong> <?= htmlspecialchars($booking['room_number'] ?? 'N/A') ?>
        </div>
        <div>
            <strong>Cliente:</strong> <?= htmlspecialchars($booking['client_name'] ?? 'N/A') ?>
        </div>
        <div>
            <strong>Documento:</strong> <?= htmlspecialchars($booking['client_document'] ?? 'N/A') ?>
        </div>
        <div>
            <strong>Check-in:</strong> <?= htmlspecialchars($booking['check_in']) ?>
        </div>
        <div>
            <strong>Check-out:</strong> <?= htmlspecialchars($booking['check_out'] ?? 'N/A') ?>
        </div>
        <div>
            <strong>Status:</strong> <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $booking['status']))) ?>
        </div>
        <div>
            <strong>Valor Total:</strong> R$ <?= number_format($booking['total_amount'] ?? 0, 2, ',', '.') ?>
        </div>
        <div>
            <strong>Status do Pagamento:</strong> <?= htmlspecialchars(ucfirst($booking['payment_status'] ?? 'N/A')) ?>
        </div>
        <div>
            <strong>Forma de Pagamento:</strong> <?= htmlspecialchars($booking['payment_method'] ?? 'N/A') ?>
        </div>
        <div>
            <strong>Observações:</strong>
            <p><?= nl2br(htmlspecialchars($booking['notes'] ?? '')) ?></p>
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <?php if ($booking['status'] === 'em_andamento'): ?>
        <form action="/reservas/<?= $booking['id'] ?>/checkout" method="POST">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Check-out
            </button>
        </form>
        <?php endif; ?>

        <?php if ($booking['status'] !== 'cancelada'): ?>
        <form action="/reservas/<?= $booking['id'] ?>/cancelar" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Cancelar
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>
