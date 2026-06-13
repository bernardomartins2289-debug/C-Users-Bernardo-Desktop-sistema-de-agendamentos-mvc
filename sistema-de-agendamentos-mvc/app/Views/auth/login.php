<?php $title = 'Login – SchedMVC'; ?>
<?php include ROOT . '/app/Views/layouts/header.php'; ?>

<div class="min-h-screen flex items-center justify-center p-4 bg-slate-100">
  <div class="w-full max-w-md">

    <div class="text-center mb-8">
      <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3 text-white text-xl font-bold shadow">S</div>
      <h1 class="text-2xl font-bold text-slate-800">SchedMVC</h1>
      <p class="text-slate-500 text-sm mt-1">Sistema de Agendamentos em PHP + MySQL</p>
    </div>

    <?php if ($error): ?>
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-4 text-sm">
      <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-4 text-sm">
      <?= htmlspecialchars($success) ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
      <h2 class="text-lg font-bold text-slate-800 mb-6">Entrar na conta</h2>
      <form method="POST" action="/login" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
          <input type="email" name="email" required placeholder="seu@email.com"
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
          <input type="password" name="password" required placeholder="••••••"
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>
        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
          Entrar
        </button>
      </form>
    </div>

    <p class="text-center text-sm text-slate-500 mt-4">
      Não tem conta? <a href="/register" class="text-blue-600 font-semibold hover:underline">Cadastre-se</a>
    </p>
    <p class="text-center text-xs text-slate-400 mt-2">
      Usuário de teste:
      <code class="bg-slate-200 px-1 rounded">teste@teste.com</code> /
      <code class="bg-slate-200 px-1 rounded">teste123</code>
    </p>

  </div>
</div>

<?php include ROOT . '/app/Views/layouts/footer.php'; ?>
