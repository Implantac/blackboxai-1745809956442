<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Novo Recibo</h1>

    <form method="POST" action="/recibos/novo/<?= $booking['id'] ?>" class="space-y-6 bg-white p-6 rounded shadow">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">

        <div>
            <label class="block text-sm font-medium text-gray-700">Reserva</label>
            <p class="mt-1"><?= htmlspecialchars($booking['client_name']) ?> - Quarto <?= htmlspecialchars($booking['room_number'] ?? '') ?></p>
        </div>

        <div>
            <label for="receipt_number" class="block text-sm font-medium text-gray-700">Número do Recibo</label>
            <input type="text" name="receipt_number" id="receipt_number" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Valor</label>
            <input type="number" name="amount" id="amount" required step="0.01" min="0"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Forma de Pagamento</label>
            <select name="payment_method" id="payment_method" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="dinheiro">Dinheiro</option>
                <option value="cartao">Cartão</option>
                <option value="pix">PIX</option>
                <option value="outro">Outro</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Salvar
            </button>
        </div>
    </form>
</div>
