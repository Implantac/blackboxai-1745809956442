<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Dashboard</h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $stats['totalRooms'] ?></h3>
                            <p>Total de Quartos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $stats['occupiedRooms'] ?></h3>
                            <p>Quartos Ocupados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-door-closed"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['availableRooms'] ?></h3>
                            <p>Quartos Disponíveis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>R$ <?= number_format($stats['todayRevenue'], 2, ',', '.') ?></h3>
                            <p>Faturamento do Dia</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ocupação por Tipo de Quarto</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="roomTypeChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Últimas Reservas</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="max-height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Quarto</th>
                                        <th>Cliente</th>
                                        <th>Check-in</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBookings as $booking): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($booking['room_number']) ?></td>
                                        <td><?= htmlspecialchars($booking['client_name']) ?></td>
                                        <td><?= date('H:i', strtotime($booking['check_in'])) ?></td>
                                        <td>
                                            <span class="badge 
                                                <?= $booking['status'] === 'em_andamento' ? 'bg-success' : 
                                                    ($booking['status'] === 'pendente' ? 'bg-warning' : 'bg-secondary') ?>">
                                                <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($recentBookings)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhuma reserva encontrada</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'donut',
                height: 300
            },
            series: [
                <?= $stats['roomTypeOccupancy']['standard'] ?? 0 ?>,
                <?= $stats['roomTypeOccupancy']['luxo'] ?? 0 ?>,
                <?= $stats['roomTypeOccupancy']['suite'] ?? 0 ?>
            ],
            labels: ['Standard', 'Luxo', 'Suíte'],
            colors: ['#1a2234', '#2a3245', '#ff9800'],
            legend: {
                position: 'bottom'
            }
        };

        var chart = new ApexCharts(document.querySelector("#roomTypeChart"), options);
        chart.render();
    });
</script>
