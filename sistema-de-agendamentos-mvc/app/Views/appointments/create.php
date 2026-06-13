<?php $title = 'Novo Agendamento – SchedMVC'; ?>
<?php include ROOT . '/app/Views/layouts/header.php'; ?>

<div class="min-h-screen bg-slate-50 flex flex-col">

  <header class="h-14 bg-white border-b border-slate-200 flex items-center px-6 gap-4 shrink-0">
    <a href="/dashboard" class="text-slate-400 hover:text-slate-700 text-sm transition">&larr; Voltar</a>
    <h1 class="text-base font-bold text-slate-800">Novo Agendamento</h1>
  </header>

  <div class="flex-1 flex items-start justify-center p-6">
    <div class="w-full max-w-lg">

      <?php if ($error): ?>
      <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-5 text-sm">
        <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
        <form method="POST" action="/appointments" class="space-y-5" id="apptForm">

          <!-- Tipo -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo de Agendamento</label>
            <select name="type" id="typeSelect"
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="Standard">Padrão</option>
              <option value="Urgent">Urgente</option>
              <option value="Professional">Profissional / Comercial</option>
            </select>
          </div>

          <!-- Título -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Título <span class="text-rose-500">*</span></label>
            <input type="text" name="title" required placeholder="Ex: Consulta médica"
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <!-- Descrição -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Descrição</label>
            <textarea name="description" rows="3" placeholder="Detalhes opcionais..."
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
          </div>

          <!-- Data e Hora -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Data <span class="text-rose-500">*</span></label>
              <input type="date" name="date" required
                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-1">Hora</label>
              <input type="time" name="time"
                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>

          <!-- Campo exclusivo Urgente -->
          <div id="fieldPriority" class="hidden">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nível de Prioridade <span class="text-rose-500">*</span></label>
            <select name="priority_level"
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="Alta">Alta</option>
              <option value="Altíssima">Altíssima</option>
            </select>
          </div>

          <!-- Campo exclusivo Profissional -->
          <div id="fieldClient" class="hidden">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nome do Cliente / Paciente <span class="text-rose-500">*</span></label>
            <input type="text" name="client_name" placeholder="Ex: João Silva"
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
            Salvar Agendamento
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const typeSelect    = document.getElementById('typeSelect');
  const fieldPriority = document.getElementById('fieldPriority');
  const fieldClient   = document.getElementById('fieldClient');

  function updateFields() {
    const v = typeSelect.value;
    fieldPriority.classList.toggle('hidden', v !== 'Urgent');
    fieldClient.classList.toggle('hidden', v !== 'Professional');
  }

  typeSelect.addEventListener('change', updateFields);
  updateFields();
</script>

<?php include ROOT . '/app/Views/layouts/footer.php'; ?>
