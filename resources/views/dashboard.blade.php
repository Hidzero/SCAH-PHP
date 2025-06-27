<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="container mx-auto px-4">

      <!-- Row 1: Resumos rápidos -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Retiradas por Mês</h3>
          <div class="h-52">
            <canvas id="chartRetiradas"></canvas>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Manutenções por Status</h3>
          <div class="h-52">
            <canvas id="chartManutencao"></canvas>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Veículos em Uso x Disponíveis</h3>
          <div class="h-52">
            <canvas id="chartVeiculos"></canvas>
          </div>
        </div>
      </div>

      <!-- Row 2: Gráficos comparativos -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Evolução de Retiradas (Mês a Mês)</h3>
          <div class="h-64">
            <canvas id="chartRetiradasAno"></canvas>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Tempo Médio de Manutenção (dias)</h3>
          <div class="h-64">
            <canvas id="chartTempoMedio"></canvas>
          </div>
        </div>
      </div>

      <!-- Row 3: Distribuição e Top 5 -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Status de Ferramentas</h3>
          <div class="h-64">
            <canvas id="chartStatusFerramentas"></canvas>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="text-lg font-medium text-gray-700 mb-2">Top 5 Ferramentas Mais Retiradas</h3>
          <div class="h-64">
            <canvas id="chartTopFerramentas"></canvas>
          </div>
        </div>
      </div>

      <!-- Row 4: Quilometragem média -->
      <div class="bg-white rounded-lg shadow p-4 mb-10">
        <h3 class="text-lg font-medium text-gray-700 mb-2">Quilometragem Média Mensal</h3>
        <div class="h-64">
          <canvas id="chartKmMedio"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Retiradas por Mês
    const rawLabelsRet = @json(array_column($retiradasData, 'mes'));
    const labelsRet = rawLabelsRet.map(m => {
      const [year, month] = m.split('-');
      return new Date(year, month - 1)
        .toLocaleString('pt-BR', { month: 'long' }) + ' ' + year;
    });
    const dataRet = @json(array_column($retiradasData, 'total'));
    new Chart(document.getElementById('chartRetiradas'), {
      type: 'bar',
      data: { labels: labelsRet, datasets: [{ label: 'Retiradas', data: dataRet }] },
      options: { maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, suggestedMax:10, ticks:{ stepSize:1, precision:0 } } } }
    });

    // Manutenções por Status
    new Chart(document.getElementById('chartManutencao'), {
      type: 'pie',
      data: { labels: @json(array_column($manutencaoData,'status')), datasets:[{ data:@json(array_column($manutencaoData,'total')) }] },
      options:{ maintainAspectRatio:false }
    });

    // Veículos em Uso x Disponíveis
    new Chart(document.getElementById('chartVeiculos'), {
      type: 'doughnut',
      data:{ labels:['Em Uso','Disponíveis'], datasets:[{ data:[@json($veiculosUso['em_uso']),@json($veiculosUso['disponiveis'])] }] },
      options:{ maintainAspectRatio:false }
    });

    // Evolução de Retiradas (Ano)
    const rawLabelsAno = @json(array_column($retiradasAno,'mes'));
    const labelsAno = rawLabelsAno.map(m => {
      const [year, month] = m.split('-');
      return new Date(year, month-1)
        .toLocaleString('pt-BR',{ month:'long' })+ ' '+year;
    });
    new Chart(document.getElementById('chartRetiradasAno'), {
      type:'line',
      data:{ labels:labelsAno, datasets:[{ label:'Retiradas', data:@json(array_column($retiradasAno,'total')) }] },
      options:{ maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, precision:0 } } }
    });

    // Tempo Médio de Manutenção
    new Chart(document.getElementById('chartTempoMedio'), {
      type:'bar',
      data:{ labels:@json(array_column($tempoMedio,'mes')), datasets:[{ label:'Dias Médios', data:@json(array_column($tempoMedio,'media_dias')) }] },
      options:{ maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, precision:0 } } }
    });

    // Status de Ferramentas
    new Chart(document.getElementById('chartStatusFerramentas'), {
      type:'doughnut',
      data:{ labels:@json($distFerramenta['labels']), datasets:[{ data:@json($distFerramenta['data']) }] },
      options:{ maintainAspectRatio:false }
    });

    // Top 5 Ferramentas
    new Chart(document.getElementById('chartTopFerramentas'), {
      type:'bar',
      data:{ labels:@json(array_column($topFerramentas,'nome')), datasets:[{ label:'Retiradas', data:@json(array_column($topFerramentas,'total')) }] },
      options:{ maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, ticks:{ stepSize:1, precision:0 } } } }
    });

    // Quilometragem Média Mensal
    const rawLabelsKm = @json(array_column($kmMedioMensal,'mes'));
    const labelsKm = rawLabelsKm.map(m => {
      const [year, month] = m.split('-');
      return new Date(year, month-1)
        .toLocaleString('pt-BR',{ month:'long' })+' '+year;
    });
    new Chart(document.getElementById('chartKmMedio'), {
      type:'line',
      data:{ labels:labelsKm, datasets:[{ label:'KM Médio', data:@json(array_column($kmMedioMensal,'km_medio')) }] },
      options:{ maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, precision:0 } } }
    });
  </script>
</x-app-layout>
