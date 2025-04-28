<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Detalhes do Quarto</h1>

    <div class="bg-white p-6 rounded shadow space-y-4">
        <div>
            <strong>Número:</strong> <?= htmlspecialchars($room['number']) ?>
        </div>
        <div>
            <strong>Tipo:</strong> <?= htmlspecialchars(ucfirst($room['type'])) ?>
        </div>
        <div>
            <strong>Status:</strong> <?= htmlspecialchars(ucfirst($room['status'])) ?>
        </div>
        <div>
            <strong>Preço por Hora:</strong> R$ <?= number_format($room['price_hour'], 2, ',', '.') ?>
        </div>
        <div>
            <strong>Preço Pernoite:</strong> R$ <?= number_format($room['price_overnight'], 2, ',', '.') ?>
        </div>
        <div>
            <strong>Descrição:</strong>
            <p><?= nl2br(htmlspecialchars($room['description'])) ?></p>
        </div>
        <div>
            <strong>Características:</strong>
            <pre class="bg-gray-100 p-2 rounded text-sm"><?= htmlspecialchars($room['features']) ?></pre>
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="/quartos/<?= $room['id'] ?>/editar" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Editar
        </a>
        <form action="/quartos/<?= $room['id'] ?>/excluir" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este quarto?');">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Excluir
            </button>
        </form>
    </div>
</div>
