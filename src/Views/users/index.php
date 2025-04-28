<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Usuários</h1>

    <a href="/configuracoes/usuarios/novo" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Novo Usuário
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Nome</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Função</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars(ucfirst($user['status'])) ?></td>
                    <td class="py-3 px-6">
                        <a href="/configuracoes/usuarios/<?= $user['id'] ?>/editar" class="text-indigo-600 hover:underline mr-4">Editar</a>
                        <form action="/configuracoes/usuarios/<?= $user['id'] ?>/excluir" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhum usuário encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
