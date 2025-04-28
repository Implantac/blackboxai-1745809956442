<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?></title>
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/css/colors.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-primary">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">
                <i class="fas fa-hotel mr-2"></i>
                <span class="font-weight-bold"><?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?></span>
            </a>
            
            <?php if (!\App\Core\Application::isGuest()): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link">
                        <i class="fas fa-chart-line mr-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/quartos" class="nav-link">
                        <i class="fas fa-bed mr-1"></i> Quartos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/reservas" class="nav-link">
                        <i class="fas fa-calendar-alt mr-1"></i> Reservas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/financeiro" class="nav-link">
                        <i class="fas fa-dollar-sign mr-1"></i> Financeiro
                    </a>
                </li>
                <li class="nav-item">
                    <form action="/logout" method="post" class="d-inline">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i> Sair
                        </button>
                    </form>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </nav>


    <!-- Flash Messages -->
    <?php if (\App\Core\Application::$app->session->getFlash('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p><?php echo \App\Core\Application::$app->session->getFlash('success'); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (\App\Core\Application::$app->session->getFlash('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p><?php echo \App\Core\Application::$app->session->getFlash('error'); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{content}}
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; <?= date('Y') ?> <?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?>. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
