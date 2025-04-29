<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Editar Assinatura</h1>

    <form method="POST" action="/subscriptions/<?= htmlspecialchars($subscription['id']) ?>/editar" class="space-y-6 bg-white p-6 rounded shadow">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">

        <div>
            <label for="motel_id" class="block text-sm font-medium text-gray-700">Motel</label>
            <input type="number" name="motel_id" id="motel_id" required value="<?= htmlspecialchars($subscription['motel_id']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="plan_name" class="block text-sm font-medium text-gray-700">Plano</label>
            <input type="text" name="plan_name" id="plan_name" required value="<?= htmlspecialchars($subscription['plan_name']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
            <input type="number" name="price" id="price" required step="0.01" min="0" value="<?= htmlspecialchars($subscription['price']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="active" <?= $subscription['status'] === 'active' ? 'selected' : '' ?>>Ativo</option>
                <option value="inactive" <?= $subscription['status'] === 'inactive' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
            <input type="date" name="start_date" id="start_date" required value="<?= htmlspecialchars($subscription['start_date']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Término</label>
            <input type="date" name="end_date" id="end_date" required value="<?= htmlspecialchars($subscription['end_date']) ?>"
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
