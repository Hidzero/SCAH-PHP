<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Gráficos Gerais') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="container-lg px-4">

      {{-- Row 1: três resumos lado a lado --}}
      <div class="row g-4 mb-6">
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header">Retiradas por Mês</div>
            <div class="card-body" style="height:250px;">
              <canvas id="chartRetiradas"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header">Manutenções por Status</div>
            <div class="card-body" style="height:250px;">
              <canvas id="chartManutencao"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="card h-100">
            <div class="card-header">Veículos em Uso x Disponíveis</div>
            <div class="card-body" style="height:250px;">
              <canvas id="chartVeiculos"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Row 2: evolução de retiradas e tempo médio --}}
      <div class="row g-4 mb-6">
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header">Evolução de Retiradas (Mês a Mês)</div>
            <div class="card-body" style="height:300px;">
              <canvas id="chartRetiradasAno"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header">Tempo Médio de Manutenção (dias)</div>
            <div class="card-body" style="height:300px;">
              <canvas id="chartTempoMedio"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Row 3: distribuição de status e top ferramentas --}}
      <div class="row g-4 mb-6">
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header">Status de Ferramentas</div>
            <div class="card-body" style="height:300px;">
              <canvas id="chartStatusFerramentas"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header">Top 5 Ferramentas Mais Retiradas</div>
            <div class="card-body" style="height:300px;">
              <canvas id="chartTopFerramentas"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Row 4: quilometragem médio full width --}}
      <div class="row g-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">Quilometragem Média Mensal</div>
            <div class="card-body" style="height:300px;">
              <canvas id="chartKmMedio"></canvas>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // antes…  
    const rawLabelsRet = @json(array_column($retiradasData, 'mes'));
    // ["2025-01","2025-02",…]

    // converte para ["janeiro 2025","fevereiro 2025",…]
    const labelsRet = rawLabelsRet.map(m => {
      const [year, month] = m.split('-');
      const date = new Date(year, month - 1);
      return date.toLocaleString('pt-BR', { month: 'long' }) + ' ' + year;
    });

    const dataRet = @json(array_column($retiradasData, 'total'));

    new Chart(
      document.getElementById('chartRetiradas'),
      {
        type: 'bar',
        data: {
          labels: labelsRet,
          datasets: [{
            label: 'Retiradas',
            data: dataRet
          }]
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              suggestedMax: 10,
              ticks: {
                stepSize: 1,
                precision: 0
              }
            }
          }
        }
      }
    );


    const labelsMan = @json(array_column($manutencaoData, 'status'));
    const dataMan = @json(array_column($manutencaoData, 'total'));
    new Chart(
      document.getElementById('chartManutencao'),
      {
        type: 'pie',
        data: {
          labels: labelsMan,
          datasets: [{
            label: 'Manutenções',
            data: dataMan
          }]
        },
        options: {
          maintainAspectRatio: false
        }
      }
    );

    const uso = @json($veiculosUso['em_uso']);
    const disp = @json($veiculosUso['disponiveis']);
    new Chart(
      document.getElementById('chartVeiculos'),
      {
        type: 'doughnut',
        data: {
          labels: ['Em Uso', 'Disponíveis'],
          datasets: [{
            label: 'Veículos',
            data: [uso, disp]
          }]
        },
        options: {
          maintainAspectRatio: false
        }
      }
    );

    // 1) Retiradas ao longo do ano
    // pega o array ["2025-01","2025-02",…]
    const rawLabelsAno = @json(array_column($retiradasAno, 'mes'));
    // converte para ["janeiro 2025","fevereiro 2025",…]
    const labelsAno = rawLabelsAno.map(m => {
      const [year, month] = m.split('-');
      const date = new Date(year, month - 1);
      // month: 'long' traz o nome completo em pt-BR
      return date.toLocaleString('pt-BR', { month: 'long' }) + ' ' + year;
    });

    const dataAno = @json(array_column($retiradasAno, 'total'));

    new Chart(document.getElementById('chartRetiradasAno'), {
      type: 'line',
      data: {
        labels: labelsAno,
        datasets: [{
          label: 'Retiradas',
          data: dataAno
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            precision: 0
          }
        }
      }
    });


    // 2) Tempo médio manutenção
    const labelsTM = @json(array_column($tempoMedio, 'mes'));
    const dataTM = @json(array_column($tempoMedio, 'media_dias'));
    new Chart(document.getElementById('chartTempoMedio'), {
      type: 'bar',
      data: { labels: labelsTM, datasets: [{ label: 'Dias Médios', data: dataTM }] },
      options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, precision: 0 } } }
    });

    // 3) Distribuição status ferramentas
    new Chart(document.getElementById('chartStatusFerramentas'), {
      type: 'doughnut',
      data: { labels: @json($distFerramenta['labels']), datasets: [{ data: @json($distFerramenta['data']) }] },
      options: { maintainAspectRatio: false }
    });

    // 4) Top 5 ferramentas
    const labelsTop = @json(array_column($topFerramentas, 'nome'));
    const dataTop = @json(array_column($topFerramentas, 'total'));

    new Chart(document.getElementById('chartTopFerramentas'), {
      type: 'bar',
      data: {
        labels: labelsTop,
        datasets: [{
          label: 'Retiradas',
          data: dataTop
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,    // marca de 1 em 1
              precision: 0    // sem casas decimais
            }
          }
        }
      }
    });


    // 5) Quilometragem média mensal
    // 5) Quilometragem média mensal (com mês por extenso + ano)
    const rawLabelsKm = @json(array_column($kmMedioMensal, 'mes'));
    // ["2025-01","2025-02",…]
    const labelsKm = rawLabelsKm.map(m => {
      const [year, month] = m.split('-');
      const date = new Date(year, month - 1);
      return date.toLocaleString('pt-BR', { month: 'long' }) + ' ' + year;
    });
    const dataKm = @json(array_column($kmMedioMensal, 'km_medio'));

    new Chart(document.getElementById('chartKmMedio'), {
      type: 'line',
      data: {
        labels: labelsKm,
        datasets: [{
          label: 'KM Médio',
          data: dataKm
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            precision: 0
          }
        }
      }
    });

  </script>
</x-app-layout>