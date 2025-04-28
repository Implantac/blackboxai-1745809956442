<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full px-6 py-8">
        <div class="text-center">
            <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <?= $code ?? 500 ?>
            </h1>
            
            <h2 class="text-xl font-semibold text-gray-700 mb-4">
                <?php if ($code == 404): ?>
                    Página não encontrada
                <?php elseif ($code == 403): ?>
                    Acesso negado
                <?php else: ?>
                    Ocorreu um erro
                <?php endif; ?>
            </h2>
            
            <p class="text-gray-600 mb-8">
                <?= $message ?? 'Desculpe, ocorreu um erro inesperado.' ?>
            </p>
            
            <div class="space-x-4">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm 
                          font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none 
                          focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
                
                <a href="/" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm 
                          font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 
                          focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-home mr-2"></i>
                    Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>
