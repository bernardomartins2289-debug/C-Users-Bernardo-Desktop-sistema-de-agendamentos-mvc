<?php $title = 'Dashboard – SchedMVC'; ?>
<?php include ROOT . '/app/Views/layouts/header.php'; ?>

<?php
$total        = count($appointments);
$totalStd     = count(array_filter($appointments, fn($a) => $a['type'] === 'Standard'));
$totalUrgent  = count(array_filter($appointments, fn($a) => $a['type'] === 'Urgent'));
$totalProf    = count(array_filter($appointments, fn($a) => $a['type'] === 'Professional'));
$userName     = htmlspecialchars(Session::get('user_name'));
$userEmail    = htmlspecialchars(Session::get('user_email'));
?>

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-56 bg-slate-900 text-slate-300 flex flex-col shrink-0">
    <div class="p-5 border-b border-slate-800 flex items-center gap-3">
      <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center font-bold text-white text-sm">S</div>
      <span class="text-lg font-bold text-white">SchedMVC</span>
    </div>
    <nav class="flex-1 py-4 px-3 space-y-1 text-sm">
      <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-md bg-slate-800 text-white font-semibold">
        &#128197; Dashboard
      </a>
      <a href="/appointments/create" class="flex items-center gap-2 px-3 py-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 transition">
        &#43; Novo Agendamento
      </a>
    </nav>
    <div class="p-4 border-t border-slate-800">
      <div class="text-xs text-slate-500 mb-1 truncate"><?= $userName ?></div>
      <div class="text-xs text-slate-600 mb-3 truncate"><?= $userEmail ?></div>
      <a href="/logout" class="block text-center text-xs bg-slate-800 hover:bg-rose-900 text-slate-300 hover:text-white py-1.5 rounded transition">
        Sair
      </a>
    </div>
  </aside>

  <!-- Main -->
  <main class="flex-1 flex flex-col overflow-auto">

    <!-- Header -->
    <header class="h-14 bg-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0">
      <h1 class="text-base font-bold text-slate-800">Gerenciar Agendamentos</h1>
      <a href="/appointments/create"
        class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-medium hover:bg-blue-700 transition">
        + Novo Agendamento
      </a>
    </header>

    <div class="p-6 space-y-6">

      <!-- Alerts -->
      <?php if ($success): ?>
      <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm">
        <?= htmlspecialchars($success) ?>
      </div>
      <?php endif; ?>
      <?php if ($error): ?>
      <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg text-sm">
        <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <!-- Stats -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php
        $stats = [
          ['label' => 'Total',        'value' => $total,       'color' => 'bg-slate-100 text-slate-800'],
          ['label' => 'Padrão',       'value' => $totalStd,    'color' => 'bg-violet-50 text-violet-700'],
          ['label' => 'Urgentes',     'value' => $totalUrgent, 'color' => 'bg-rose-50 text-rose-700'],
          ['label' => 'Profissional', 'value' => $totalProf,   'color' => 'bg-emerald-50 text-emerald-700'],
        ];
        foreach ($stats as $s): ?>
        <div class="<?= $s['color'] ?> rounded-xl p-4 border border-slate-200">
          <div class="text-2xl font-bold"><?= $s['value'] ?></div>
          <div class="text-xs font-medium mt-0.5 opacity-70"><?= $s['label'] ?></div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
          <span class="text-sm font-semibold text-slate-700">Lista de Agendamentos (<?= $total ?>)</span>
          <span class="text-xs text-slate-400 font-mono">MVC · Singleton · Factory</span>
        </div>

        <?php if (empty($appointments)): ?>
        <div class="p-10 text-center text-slate-400">
          <div class="text-3xl mb-3">&#128197;</div>
          <p class="font-semibold text-slate-600 mb-1">Nenhum agendamento ainda</p>
          <p class="text-sm">Clique em "Novo Agendamento" para começar.</p>
        </div>
        <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
              <tr>
                <th class="px-5 py-3 text-left">Título</th>
                <th class="px-4 py-3 text-left">Tipo</th>
                <th class="px-4 py-3 text-left">Data</th>
                <th class="px-4 py-3 text-left">Hora</th>
                <th class="px-4 py-3 text-left">Detalhes</th>
                <th class="px-4 py-3 text-right">Ações</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php foreach ($appointments as $a): ?>
              <?php
              $typeBadge = match($a['type']) {
                'Urgent'       => 'bg-rose-100 text-rose-700',
                'Professional' => 'bg-emerald-100 text-emerald-700',
                default        => 'bg-violet-100 text-violet-700',
              };
              $typeLabel = match($a['type']) {
                'Urgent'       => 'Urgente',
                'Professional' => 'Profissional',
                default        => 'Padrão',
              };
              ?>
              <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 font-medium text-slate-800 max-w-xs truncate">
                  <?= htmlspecialchars($a['title']) ?>
                </td>
                <td class="px-4 py-3">
                  <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold <?= $typeBadge ?>">
                    <?= $typeLabel ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-slate-600"><?= htmlspecialchars($a['date']) ?></td>
                <td class="px-4 py-3 text-slate-600"><?= htmlspecialchars($a['time']) ?></td>
                <td class="px-4 py-3 text-slate-500 text-xs max-w-xs truncate">
                  <?php if ($a['type'] === 'Urgent'): ?>
                    Prioridade: <strong><?= htmlspecialchars($a['priority_level'] ?? '—') ?></strong>
                  <?php elseif ($a['type'] === 'Professional'): ?>
                    Cliente: <strong><?= htmlspecialchars($a['client_name'] ?? '—') ?></strong>
                  <?php else: ?>
                    <?= htmlspecialchars(mb_strimwidth($a['description'] ?? '', 0, 50, '…')) ?>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                  <a href="/appointments/<?= $a['id'] ?>/edit"
                    class="inline-block text-xs px-3 py-1 bg-slate-100 hover:bg-blue-100 text-slate-700 hover:text-blue-700 rounded transition font-medium">
                    Editar
                  </a>
                  <form method="POST" action="/appointments/<?= $a['id'] ?>/delete" class="inline"
                    onsubmit="return confirm('Deseja realmente excluir este agendamento?')">
                    <button type="submit"
                      class="text-xs px-3 py-1 bg-slate-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded transition font-medium">
                      Excluir
                    </button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>

      <!-- Design Patterns Info -->
      <div class="bg-blue-50 border border-blue-100 rounded-lg px-5 py-4 text-xs text-slate-600 leading-relaxed">
        <strong class="text-blue-800 uppercase tracking-wide text-[10px]">Padrões de Projeto Aplicados</strong><br>
        <strong>MVC</strong> — Models (<code>Appointment</code>, <code>User</code>), Views (PHP puro), Controllers (<code>AppointmentController</code>, <code>AuthController</code>).<br>
        <strong>Singleton</strong> — <code>Database::getInstance()</code> garante uma única conexão PDO com MySQL.<br>
        <strong>Factory</strong> — <code>AppointmentFactory::create()</code> instancia <code>Standard</code>, <code>Urgent</code> ou <code>Professional</code> com validação polimórfica.
      </div>

    </div>

    <footer class="mt-auto py-3 px-6 text-xs text-slate-400 border-t border-slate-200 bg-white">
      SchedMVC &copy; 2026 &mdash; PHP 8.2 + MySQL 8 + Docker
    </footer>
  </main>
</div>

<?php include ROOT . '/app/Views/layouts/footer.php'; ?>
