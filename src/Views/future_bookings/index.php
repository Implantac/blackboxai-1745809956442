<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Reservas Futuras</h1>

    <a href="/reservas/futuras/nova" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Nova Reserva Futura
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Quarto</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-left">Data da Reserva</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($futureBookings as $booking): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['room_id']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['client_name']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['reservation_date']) ?></td>
                    <td class="py-3 px-6"><?= ucfirst($booking['status']) ?></td>
                    <td class="py-3 px-6">
                        <a href="/reservas/futuras/<?= $booking['id'] ?>/editar" class="text-indigo-600 hover:underline mr-4">Editar</a>
                        <form action="/reservas/futuras/<?= $booking['id'] ?>/excluir" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva futura?');">
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($futureBookings)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhuma reserva futura encontrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
