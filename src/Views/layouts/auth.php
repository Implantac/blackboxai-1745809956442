<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?> - Login</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center">
    <!-- Flash Messages -->
    <?php if (\App\Core\Application::$app->session->getFlash('success')): ?>
        <div class="max-w-md mx-auto px-4 mb-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p><?php echo \App\Core\Application::$app->session->getFlash('success'); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (\App\Core\Application::$app->session->getFlash('error')): ?>
        <div class="max-w-md mx-auto px-4 mb-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p><?php echo \App\Core\Application::$app->session->getFlash('error'); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-md mx-auto w-full px-4">
        <div class="text-center mb-8">
            <i class="fas fa-hotel text-4xl text-indigo-600 mb-2"></i>
            <h1 class="text-2xl font-bold text-gray-900">
                <?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?>
            </h1>
        </div>

        <div class="bg-white shadow-xl rounded-lg p-6 mb-6">
            <?= $content ?>
        </div>

        <p class="text-center text-gray-500 text-sm">
            &copy; <?= date('Y') ?> <?= $_ENV['APP_NAME'] ?? 'Sistema de Motel' ?>. Todos os direitos reservados.
        </p>
    </main>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
