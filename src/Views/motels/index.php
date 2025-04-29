<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Gerenciamento de Motéis</h1>

    <a href="/motels/novo" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Novo Motel
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Nome</th>
                    <th class="py-3 px-6 text-left">Endereço</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motels as $motel): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6"><?= htmlspecialchars($motel['name']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($motel['address']) ?></td>
                    <td class="py-3 px-6">
                        <a href="/motels/<?= $motel['id'] ?>/editar" class="text-indigo-600 hover:underline mr-4">Editar</a>
                        <form action="/motels/<?= $motel['id'] ?>/excluir" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este motel?');">
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($motels)): ?>
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">Nenhum motel encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
