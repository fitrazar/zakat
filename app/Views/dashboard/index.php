<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->

            <!-- Saldo Zakat Masuk -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp <?= number_format($saldo_uang_masuk, 0, ',', '.'); ?></h3>
                        <p>Saldo Zakat Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Saldo Zakat Keluar -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rp <?= number_format($saldo_uang_keluar, 0, ',', '.'); ?></h3>
                        <p>Saldo Zakat Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Saldo Zakat Akhir -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rp <?= number_format($saldo_uang_akhir, 0, ',', '.'); ?></h3>
                        <p>Saldo Zakat Akhir</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Saldo Zakat Masuk -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $saldo_beras_masuk; ?> KG</h3>
                        <p>Saldo Zakat Beras Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Saldo Zakat Keluar -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $saldo_beras_keluar; ?> KG</h3>
                        <p>Saldo Zakat Beras Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Saldo Zakat Akhir -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $saldo_beras_akhir; ?> KG</h3>
                        <p>Saldo Zakat Beras Akhir</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Jumlah Total Warga -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_warga; ?></h3>
                        <p>Total Warga</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Jumlah Penerima Zakat -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_penerima; ?></h3>
                        <p>Penerima Zakat</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>





            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Grafik Zakat Masuk & Keluar
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#bar-chart" data-toggle="tab">Bar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#pie-chart" data-toggle="tab">Pie</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Bar Chart -->
                            <div class="chart tab-pane active" id="bar-chart"
                                style="position: relative; height: 300px;">
                                <canvas id="bar-chart-canvas" height="300"></canvas>
                            </div>

                            <!-- Pie Chart -->
                            <div class="chart tab-pane" id="pie-chart" style="position: relative; height: 300px;">
                                <canvas id="pie-chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        const zakatMasuk = JSON.parse('<?= $zakat_masuk; ?>');
        const zakatKeluar = JSON.parse('<?= $zakat_keluar; ?>');

        const zakatBerasMasuk = JSON.parse('<?= $zakat_beras_masuk; ?>');
        const zakatBerasKeluar = JSON.parse('<?= $zakat_beras_keluar; ?>');

        const zakatMasukData = new Array(12).fill(0);
        const zakatKeluarData = new Array(12).fill(0);

        const zakatBerasMasukData = new Array(12).fill(0);
        const zakatBerasKeluarData = new Array(12).fill(0);

        zakatMasuk.forEach(item => zakatMasukData[item.bulan - 1] = item.total);
        zakatKeluar.forEach(item => zakatKeluarData[item.bulan - 1] = item.total);

        zakatBerasMasuk.forEach(item => zakatBerasMasukData[item.bulan - 1] = item.total);
        zakatBerasKeluar.forEach(item => zakatBerasKeluarData[item.bulan - 1] = item.total);

        const barChartCanvas = document.getElementById("bar-chart-canvas").getContext("2d");
        new Chart(barChartCanvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Penerimaan Zakat",
                    backgroundColor: "#28a745",
                    data: zakatMasukData
                },
                {
                    label: "Penyaluran Zakat",
                    backgroundColor: "#dc3545",
                    data: zakatKeluarData
                },
                {
                    label: "Penerimaan Zakat Beras",
                    backgroundColor: "#5132a8",
                    data: zakatBerasMasukData
                },
                {
                    label: "Penyaluran Zakat Beras",
                    backgroundColor: "#db770b",
                    data: zakatBerasKeluarData
                },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const pieChartCanvas = document.getElementById("pie-chart-canvas").getContext("2d");
        new Chart(pieChartCanvas, {
            type: "pie",
            data: {
                labels: ["Penerimaan Zakat", "Penyaluran Zakat", "Penerimaan Zakat Beras",
                    "Penyaluran Zakat Beras"
                ],
                datasets: [{
                    data: [
                        zakatMasukData.reduce((a, b) => a + b, 0),
                        zakatKeluarData.reduce((a, b) => a + b, 0),
                        zakatBerasMasukData.reduce((a, b) => a + b, 0),
                        zakatBerasKeluarData.reduce((a, b) => a + b, 0)
                    ],
                    backgroundColor: ["#28a745", "#dc3545", "#5132a8", "#db770b"]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
<?= $this->endSection(); ?>