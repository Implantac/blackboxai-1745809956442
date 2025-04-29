<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Editar Reserva Futura</h1>

    <form method="POST" action="/reservas/futuras/<?= htmlspecialchars($futureBooking['id']) ?>/editar" class="space-y-6 bg-white p-6 rounded shadow">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">

        <div>
            <label for="room_id" class="block text-sm font-medium text-gray-700">Quarto</label>
            <select name="room_id" id="room_id" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <?php foreach ($rooms as $room): ?>
                <option value="<?= $room['id'] ?>" <?= $room['id'] == $futureBooking['room_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($room['number']) ?> - <?= ucfirst($room['type']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="client_name" class="block text-sm font-medium text-gray-700">Nome do Cliente</label>
            <input type="text" name="client_name" id="client_name" required value="<?= htmlspecialchars($futureBooking['client_name']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="client_document" class="block text-sm font-medium text-gray-700">Documento</label>
            <input type="text" name="client_document" id="client_document" value="<?= htmlspecialchars($futureBooking['client_document']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="reservation_date" class="block text-sm font-medium text-gray-700">Data da Reserva</label>
            <input type="datetime-local" name="reservation_date" id="reservation_date" required value="<?= htmlspecialchars($futureBooking['reservation_date']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Salvar
            </button>
        </div>
    </form>
</div>
