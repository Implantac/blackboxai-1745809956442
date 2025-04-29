<div class="py-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Assinaturas</h1>

    <a href="/subscriptions/novo" class="inline-block mb-4 px-4 py-2 bg-accent text-primary rounded hover:bg-accent-dark">
        <i class="fas fa-plus mr-2"></i> Nova Assinatura
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Motel</th>
                    <th class="py-3 px-6 text-left">Plano</th>
                    <th class="py-3 px-6 text-left">Preço</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Início</th>
                    <th class="py-3 px-6 text-left">Término</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptions as $subscription): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6"><?= htmlspecialchars($subscription['motel_id']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($subscription['plan_name']) ?></td>
                    <td class="py-3 px-6">R$ <?= number_format($subscription['price'], 2, ',', '.') ?></td>
                    <td class="py-3 px-6"><?= ucfirst($subscription['status']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($subscription['start_date']) ?></td>
                    <td class="py-3 px-6"><?= htmlspecialchars($subscription['end_date']) ?></td>
                    <td class="py-3 px-6">
                        <a href="/subscriptions/<?= $subscription['id'] ?>/editar" class="text-indigo-600 hover:underline mr-4">Editar</a>
                        <form action="/subscriptions/<?= $subscription['id'] ?>/excluir" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta assinatura?');">
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($subscriptions)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Nenhuma assinatura encontrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
