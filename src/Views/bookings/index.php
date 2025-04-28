<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Reservas</h1>

    <a href="/reservas/nova" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Nova Reserva
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Quarto</th>
                    <th class="py-3 px-6 text-left">Cliente</th>
                    <th class="py-3 px-6 text-left">Check-in</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['room_number'] ?? 'N/A') ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['client_name'] ?? 'N/A') ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($booking['check_in']) ?></td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 rounded text-sm font-semibold 
                            <?= $booking['status'] === 'em_andamento' ? 'bg-green-100 text-green-800' : 
                                ($booking['status'] === 'pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-gray-100 text-gray-800') ?>">
                            <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        <a href="/reservas/<?= $booking['id'] ?>" class="text-indigo-600 hover:underline mr-4">Ver</a>
                        <?php if ($booking['status'] === 'em_andamento'): ?>
                        <form action="/reservas/<?= $booking['id'] ?>/checkout" method="POST" class="inline">
                            <button type="submit" class="text-green-600 hover:underline mr-2">Check-out</button>
                        </form>
                        <?php endif; ?>
                        <?php if ($booking['status'] !== 'cancelada'): ?>
                        <form action="/reservas/<?= $booking['id'] ?>/cancelar" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                            <button type="submit" class="text-red-600 hover:underline">Cancelar</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($bookings)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhuma reserva encontrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
