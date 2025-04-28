<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Novo Quarto</h1>

    <form method="POST" action="/quartos/novo" class="space-y-6 bg-white p-6 rounded shadow">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">
        <div>
            <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
            <input type="text" name="number" id="number" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
            <select name="type" id="type" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="standard">Standard</option>
                <option value="luxo">Luxo</option>
                <option value="suite">Suíte</option>
            </select>
        </div>

        <div>
            <label for="price_hour" class="block text-sm font-medium text-gray-700">Preço por Hora</label>
            <input type="number" name="price_hour" id="price_hour" step="0.01" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="price_overnight" class="block text-sm font-medium text-gray-700">Preço Pernoite</label>
            <input type="number" name="price_overnight" id="price_overnight" step="0.01" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="description" id="description" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div>
            <label for="features" class="block text-sm font-medium text-gray-700">Características (JSON)</label>
            <textarea name="features" id="features" rows="3" placeholder='{"tv":true,"ar":true,"frigobar":true}'
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Salvar
            </button>
        </div>
    </form>
</div>
