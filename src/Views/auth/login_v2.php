<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary to-secondary px-4">
    <div class="max-w-md w-full bg-primary rounded-lg shadow-lg p-10 text-white">
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-extrabold">Login</h2>
            <p class="mt-2 text-accent-light">Entre com suas credenciais para acessar o sistema</p>
        </div>

    <form method="POST" action="/login" class="space-y-6">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?= \App\Core\Application::$app->session->get('csrf_token') ?>">

        <div>
            <label for="email" class="block text-sm font-semibold text-accent-light">Email</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '') ?>" required 
                    class="appearance-none block w-full px-4 py-3 border border-secondary rounded-md shadow-sm 
                    placeholder-accent-light focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent" <?= isset($require2FA) && $require2FA ? 'readonly' : '' ?>>
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-accent-light">Senha</label>
            <div class="mt-1">
                <input id="password" name="password" type="password" <?= isset($require2FA) && $require2FA ? 'readonly' : 'required' ?>
                    class="appearance-none block w-full px-4 py-3 border border-secondary rounded-md shadow-sm 
                    placeholder-accent-light focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
            </div>
        </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox" 
                        class="h-5 w-5 text-accent focus:ring-accent border-secondary rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-accent-light">
                        Lembrar-me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="/esqueci-senha" class="font-semibold text-accent hover:text-accent-dark">
                        Esqueceu sua senha?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-3 px-6 border border-transparent rounded-md shadow-lg text-lg 
                    font-semibold text-primary bg-accent hover:bg-accent-dark focus:outline-none focus:ring-4 
                    focus:ring-offset-2 focus:ring-accent transition">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</div>
