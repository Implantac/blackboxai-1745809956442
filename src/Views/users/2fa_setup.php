<div class="py-6 max-w-md mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Configuração de Autenticação em Duas Etapas (2FA)</h1>

    <?php if (isset($error)): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <p class="mb-4">Use um aplicativo autenticador (como Google Authenticator ou Authy) para escanear o QR code abaixo:</p>

    <div class="mb-6 text-center">
        <img src="<?= $qrCodeUrl ?? '' ?>" alt="QR Code 2FA" class="mx-auto" />
    </div>

    <form method="POST" action="/configuracoes/usuarios/2fa" class="space-y-4">
        <div>
            <label for="two_factor_code" class="block text-sm font-medium text-gray-700">Código de Verificação</label>
            <input type="text" name="two_factor_code" id="two_factor_code" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Digite o código do aplicativo autenticador">
        </div>

        <div class="flex justify-between">
            <button type="submit" name="action" value="enable"
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Ativar 2FA
            </button>
            <button type="submit" name="action" value="disable"
                class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                Desativar 2FA
            </button>
        </div>
    </form>
</div>
