<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ROW 1: Statistik -->
<div class="flex flex-wrap gap-4 justify-between mb-6">
    <!-- Total Siswa -->
    <div class="flex-1 min-w-[200px] bg-gradient-to-br from-blue-50 to-blue-100 shadow-md rounded-2xl flex items-center px-6 py-5 gap-4 transition-all hover:scale-[1.03] hover:shadow-lg duration-200">
        <div class="bg-blue-500 p-4 rounded-xl shadow text-white text-2xl flex items-center justify-center animate-pulse">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div class="uppercase text-xs text-blue-600 font-bold tracking-wider mb-1">Total Siswa</div>
            <div class="text-2xl font-extrabold text-blue-700"><?= number_format($totalSiswa) ?></div>
        </div>
    </div>
    <!-- Total Guru -->
    <div class="flex-1 min-w-[200px] bg-gradient-to-br from-green-50 to-emerald-100 shadow-md rounded-2xl flex items-center px-6 py-5 gap-4 transition-all hover:scale-[1.03] hover:shadow-lg duration-200">
        <div class="bg-emerald-500 p-4 rounded-xl shadow text-white text-2xl flex items-center justify-center animate-pulse">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div>
            <div class="uppercase text-xs text-emerald-600 font-bold tracking-wider mb-1">Total Guru</div>
            <div class="text-2xl font-extrabold text-emerald-700"><?= number_format($totalGuru) ?></div>
        </div>
    </div>
    <!-- Total Kelas -->
    <div class="flex-1 min-w-[200px] bg-gradient-to-br from-yellow-50 to-yellow-100 shadow-md rounded-2xl flex items-center px-6 py-5 gap-4 transition-all hover:scale-[1.03] hover:shadow-lg duration-200">
        <div class="bg-yellow-400 p-4 rounded-xl shadow text-white text-2xl flex items-center justify-center animate-pulse">
            <i class="fa-solid fa-school"></i>
        </div>
        <div>
            <div class="uppercase text-xs text-yellow-600 font-bold tracking-wider mb-1">Total Kelas</div>
            <div class="text-2xl font-extrabold text-yellow-700"><?= number_format($totalKelas) ?></div>
        </div>
    </div>
    <!-- Total Mapel -->
    <div class="flex-1 min-w-[200px] bg-gradient-to-br from-pink-50 to-pink-100 shadow-md rounded-2xl flex items-center px-6 py-5 gap-4 transition-all hover:scale-[1.03] hover:shadow-lg duration-200">
        <div class="bg-pink-500 p-4 rounded-xl shadow text-white text-2xl flex items-center justify-center animate-pulse">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div>
            <div class="uppercase text-xs text-pink-600 font-bold tracking-wider mb-1">Total Mapel</div>
            <div class="text-2xl font-extrabold text-pink-700"><?= number_format($totalMapel) ?></div>
        </div>
    </div>
</div>

<!-- ROW 2: Chart Siswa per Kelas -->
<div class="mt-6 rounded-2xl shadow-md bg-white">
    <div class="p-6 border-b">
        <div class="flex items-center gap-2 mb-1">
            <i class="fa-solid fa-chart-column text-blue-500"></i>
            <span class="font-semibold text-slate-700 text-lg">Jumlah Siswa Per Kelas</span>
        </div>
        <div class="text-xs text-slate-500">Statistik siswa aktif berdasarkan kelas terbaru</div>
    </div>
    <div class="p-6">
        <canvas id="chart-kelas" height="130"></canvas>
    </div>
</div>

<!-- CHART.JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari PHP
    const kelasLabels = <?= json_encode(array_column($kelasData, 'nama_kelas')) ?>;
    const kelasCounts = <?= json_encode(array_map('intval', array_column($kelasData, 'jumlah_siswa'))) ?>;

    // Chart
    new Chart(document.getElementById('chart-kelas'), {
        type: 'bar',
        data: {
            labels: kelasLabels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: kelasCounts,
                backgroundColor: 'rgba(59,130,246,0.75)',
                borderColor: 'rgba(59,130,246,1)',
                borderRadius: 8,
                barThickness: 38,
                maxBarThickness: 48,
                hoverBackgroundColor: 'rgba(37, 99, 235, 1)',
                hoverBorderColor: '#2563eb'
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2563eb',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Kelas', color: '#64748b', font: { weight: 'bold' } },
                    grid: { display: false }
                },
                y: {
                    title: { display: true, text: 'Jumlah Siswa', color: '#64748b', font: { weight: 'bold' } },
                    beginAtZero: true,
                    grid: { color: '#e0e7ef', borderDash: [6, 4] }
                }
            },
            animation: {
                duration: 900,
                easing: 'easeOutBounce'
            }
        }
    });
</script>
<?= $this->endSection() ?>
