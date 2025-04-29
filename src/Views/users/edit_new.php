<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Editar Usuário</h1>

    <form method="POST" action="/configuracoes/usuarios/<?= htmlspecialchars($user['id']) ?>/editar" class="space-y-6 bg-white p-6 rounded shadow">
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
            <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($user['email']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha (deixe em branco para manter)</label>
            <input type="password" name="password" id="password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Função</label>
            <select name="role" id="role" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                <option value="gerente" <?= $user['role'] === 'gerente' ? 'selected' : '' ?>>Gerente</option>
                <option value="recepcionista" <?= $user['role'] === 'recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Ativo</option>
                <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Permissões</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="permissions[]" value="manage_rooms" class="form-checkbox" <?= in_array('manage_rooms', $user['permissions'] ?? []) ? 'checked' : '' ?>>
                    <span class="ml-2">Gerenciar Quartos</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="permissions[]" value="manage_bookings" class="form-checkbox" <?= in_array('manage_bookings', $user['permissions'] ?? []) ? 'checked' : '' ?>>
                    <span class="ml-2">Gerenciar Reservas</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="permissions[]" value="manage_finance" class="form-checkbox" <?= in_array('manage_finance', $user['permissions'] ?? []) ? 'checked' : '' ?>>
                    <span class="ml-2">Gerenciar Financeiro</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="permissions[]" value="manage_users" class="form-checkbox" <?= in_array('manage_users', $user['permissions'] ?? []) ? 'checked' : '' ?>>
                    <span class="ml-2">Gerenciar Usuários</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Salvar
            </button>
        </div>
    </form>
</div>
