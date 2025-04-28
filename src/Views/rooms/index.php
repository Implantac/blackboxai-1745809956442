<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Gestão de Quartos</h1>

    <a href="/quartos/novo" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Novo Quarto
    </a>

    <div id="room-list" class="overflow-x-auto opacity-0 transition-opacity duration-500">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Número</th>
                    <th class="py-3 px-6 text-left">Tipo</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Preço Hora</th>
                    <th class="py-3 px-6 text-left">Preço Pernoite</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody id="room-list-body">
                <!-- Room rows will be loaded here asynchronously -->
            </tbody>
        </table>
    </div>

    <div id="loading-spinner" class="flex justify-center items-center mt-4">
        <svg class="animate-spin h-8 w-8 text-accent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomList = document.getElementById('room-list');
        const roomListBody = document.getElementById('room-list-body');
        const loadingSpinner = document.getElementById('loading-spinner');

        fetch('/api/quartos/disponiveis')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.style.display = 'none';
                roomList.style.opacity = 1;

                if (data.availableRooms.length === 0) {
                    roomListBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">Nenhum quarto encontrado.</td></tr>';
                    return;
                }

                data.availableRooms.forEach(room => {
                    const row = document.createElement('tr');
                    row.classList.add('border-b', 'hover:bg-gray-50');
                    row.innerHTML = `
                        <td class="py-3 px-6">${room.number}</td>
                        <td class="py-3 px-6 capitalize">${room.type}</td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 rounded text-sm font-semibold 
                                ${room.status === 'disponivel' ? 'bg-green-100 text-green-800' : 
                                    (room.status === 'ocupado' ? 'bg-red-100 text-red-800' : 
                                    'bg-yellow-100 text-yellow-800')}">
                                ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                            </span>
                        </td>
                        <td class="py-3 px-6">R$ ${parseFloat(room.price_hour).toFixed(2).replace('.', ',')}</td>
                        <td class="py-3 px-6">R$ ${parseFloat(room.price_overnight).toFixed(2).replace('.', ',')}</td>
                        <td class="py-3 px-6">
                            <a href="/quartos/${room.id}/editar" class="text-indigo-600 hover:underline mr-4">Editar</a>
                            <form action="/quartos/${room.id}/excluir" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este quarto?');">
                                <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                            </form>
                        </td>
                    `;
                    roomListBody.appendChild(row);
                });
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                roomListBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-red-600">Erro ao carregar os quartos.</td></tr>';
                roomList.style.opacity = 1;
                console.error('Erro ao carregar quartos:', error);
            });
    });
</script>
