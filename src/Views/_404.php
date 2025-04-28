<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full px-6 py-8">
        <div class="text-center">
            <div class="mb-6">
                <i class="fas fa-search text-6xl text-indigo-500"></i>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Página não encontrada
            </h2>
            
            <p class="text-gray-600 mb-8">
                A página que você está procurando não existe ou foi movida.
                <br>
                Por favor, verifique o endereço ou retorne à página inicial.
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

            <div class="mt-8">
                <p class="text-sm text-gray-500">
                    Se você acredita que isso é um erro, por favor 
                    <a href="/contato" class="text-indigo-600 hover:text-indigo-500">entre em contato</a> 
                    com nossa equipe de suporte.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Animação de fundo sutil -->
<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.fa-search {
    animation: pulse 2s infinite;
}
</style>
