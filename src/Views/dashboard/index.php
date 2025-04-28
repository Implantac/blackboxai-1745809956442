<div class="py-6">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-sm text-gray-700">Visão geral do sistema</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total de Quartos -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hotel text-2xl text-indigo-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total de Quartos</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900"><?= $stats['totalRooms'] ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quartos Ocupados -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-door-closed text-2xl text-red-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Quartos Ocupados</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900"><?= $stats['occupiedRooms'] ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quartos Disponíveis -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-door-open text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Quartos Disponíveis</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900"><?= $stats['availableRooms'] ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Faturamento do Dia -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Faturamento do Dia</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    R$ <?= number_format($stats['todayRevenue'], 2, ',', '.') ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Ocupação por Tipo -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ocupação por Tipo de Quarto</h3>
            <div class="h-64" x-data="{
                init() {
                    const ctx = this.$refs.chart.getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Standard', 'Luxo', 'Suíte'],
                            datasets: [{
                                data: [
                                    <?= $stats['roomTypeOccupancy']['standard'] ?? 0 ?>,
                                    <?= $stats['roomTypeOccupancy']['luxo'] ?? 0 ?>,
                                    <?= $stats['roomTypeOccupancy']['suite'] ?? 0 ?>
                                ],
                                backgroundColor: ['#4F46E5', '#7C3AED', '#EC4899']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }
            }">
                <canvas x-ref="chart"></canvas>
            </div>
        </div>

        <!-- Últimas Reservas -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Últimas Reservas</h3>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quarto
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check-in
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recentBookings as $booking): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($booking['room_number']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($booking['client_name']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('H:i', strtotime($booking['check_in'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $booking['status'] === 'em_andamento' ? 'bg-green-100 text-green-800' : 
                                        ($booking['status'] === 'pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-gray-100 text-gray-800') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentBookings)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Nenhuma reserva encontrada
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a href="/quartos/novo" class="bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-plus-circle text-2xl text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Novo Quarto</h4>
                        <p class="mt-1 text-sm text-gray-500">Adicionar novo quarto</p>
                    </div>
                </div>
            </a>

            <a href="/reservas/nova" class="bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-plus text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Nova Reserva</h4>
                        <p class="mt-1 text-sm text-gray-500">Criar nova reserva</p>
                    </div>
                </div>
            </a>

            <a href="/relatorios" class="bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-bar text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Relatórios</h4>
                        <p class="mt-1 text-sm text-gray-500">Ver relatórios</p>
                    </div>
                </div>
            </a>

            <a href="/configuracoes" class="bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-cog text-2xl text-gray-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-base font-medium text-gray-900">Configurações</h4>
                        <p class="mt-1 text-sm text-gray-500">Ajustar configurações</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
