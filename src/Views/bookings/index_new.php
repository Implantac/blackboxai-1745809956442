<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Reservas</h1>

    <a href="/reservas/nova" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Nova Reserva
    </a>

    <div id="booking-list" class="overflow-x-auto opacity-0 transition-opacity duration-500">
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
            <tbody id="booking-list-body">
                <!-- Booking rows will be loaded here asynchronously -->
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
        const bookingList = document.getElementById('booking-list');
        const bookingListBody = document.getElementById('booking-list-body');
        const loadingSpinner = document.getElementById('loading-spinner');

        fetch('/api/reservas/ativas')
            .then(response => response.json())
            .then(data => {
                loadingSpinner.style.display = 'none';
                bookingList.style.opacity = 1;

                if (data.activeBookings.length === 0) {
                    bookingListBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-500">Nenhuma reserva encontrada.</td></tr>';
                    return;
                }

                data.activeBookings.forEach(booking => {
                    const row = document.createElement('tr');
                    row.classList.add('border-b', 'hover:bg-gray-50');
                    row.innerHTML = `
                        <td class="py-3 px-6">${booking.room_number || 'N/A'}</td>
                        <td class="py-3 px-6">${booking.client_name || 'N/A'}</td>
                        <td class="py-3 px-6">${booking.check_in}</td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 rounded text-sm font-semibold 
                                ${booking.status === 'em_andamento' ? 'bg-green-100 text-green-800' : 
                                    (booking.status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-gray-100 text-gray-800')}">
                                ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1).replace('_', ' ')}
                            </span>
                        </td>
                        <td class="py-3 px-6">
                            <a href="/reservas/${booking.id}" class="text-indigo-600 hover:underline mr-4">Ver</a>
                            ${booking.status === 'em_andamento' ? `
                            <form action="/reservas/${booking.id}/checkout" method="POST" class="inline">
                                <button type="submit" class="text-green-600 hover:underline mr-2">Check-out</button>
                            </form>` : ''}
                            ${booking.status !== 'cancelada' ? `
                            <form action="/reservas/${booking.id}/cancelar" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                <button type="submit" class="text-red-600 hover:underline">Cancelar</button>
                            </form>` : ''}
                        </td>
                    `;
                    bookingListBody.appendChild(row);
                });
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                bookingListBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-red-600">Erro ao carregar as reservas.</td></tr>';
                bookingList.style.opacity = 1;
                console.error('Erro ao carregar reservas:', error);
            });
    });
</script>
