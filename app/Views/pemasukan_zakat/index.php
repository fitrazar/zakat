<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pemasukan Zakat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemasukan Zakat</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pemasukan Zakat</h3>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3 mt-3 p-3"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <a href="<?= base_url('pemasukan_zakat/create'); ?>" class="btn btn-primary">Tambah
                            Pemasukan</a>

                        <a href="<?= base_url('pemasukan_zakat/cetak_pdf'); ?>" class="btn btn-danger ml-2"
                            target="_blank">Cetak PDF</a>

                        <!-- <a href="<?= base_url('pemasukan_zakat/cetak_excel'); ?>" class="btn btn-success ml-2">Cetak
                            Excel</a> -->
                    </div>

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <div class="form-group mt-3">
                            <label for="filter_warga">Pilih Warga untuk Dicetak</label>
                            <select id="filter_warga" class="form-control select2">
                                <option value="">Semua Warga</option>
                                <?php foreach ($pemasukan_zakat as $w): ?>
                                    <option value="<?= $w['nama']; ?>"><?= $w['nama']; ?> (<?= $w['tanggal_masuk']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-3 ml-2">
                            <label for="filter_tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" id="filter_tanggal_mulai" class="form-control">
                        </div>

                        <div class="form-group mt-3 ml-2">
                            <label for="filter_tanggal_akhir">Tanggal Akhir</label>
                            <input type="date" id="filter_tanggal_akhir" class="form-control">
                        </div>

                        <button id="cetak_pdf_filtered" class="btn btn-danger mt-4 ml-2">Cetak PDF (Filter)</button>
                        <!-- <button id="cetak_excel_filtered" class="btn btn-success mt-4 ml-2">Cetak Excel
                            (Filter)</button> -->
                    </div>


                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Warga</th>
                                    <th>Jenis Zakat</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pemasukan_zakat as $p): ?>
                                    <tr>
                                        <td><?= $p['nama']; ?></td>
                                        <td><?= ucfirst($p['jenis_zakat']); ?></td>
                                        <td><?= $p['jenis'] == 'uang' ? 'Rp ' . number_format($p['jumlah'], 0, ',', '.') : $p['jumlah'] . ' ltr'; ?>
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($p['tanggal_masuk'])); ?></td>
                                        <td>
                                            <a href="<?= base_url('pemasukan_zakat/edit/' . $p['id']); ?>"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete(<?= $p['id']; ?>)">Hapus</button>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#detailModal<?= $p['id']; ?>">Detail</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal<?= $p['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Pemasukan Zakat</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama Warga:</strong> <?= $p['nama']; ?></p>
                                                    <p><strong>Jumlah Keluarga:</strong> <?= $p['jumlah_keluarga']; ?></p>
                                                    <p><strong>Jenis Zakat:</strong> <?= ucfirst($p['jenis_zakat']); ?></p>
                                                    <p><strong>Jenis:</strong> <?= ucfirst($p['jenis']); ?></p>
                                                    <p><strong>Jumlah:</strong>
                                                        <?= $p['jenis'] == 'uang' ? 'Rp ' . number_format($p['jumlah'], 0, ',', '.') : $p['jumlah'] . ' ltr'; ?>
                                                    </p>
                                                    <p><strong>Tanggal Masuk:</strong>
                                                        <?= date('d-m-Y', strtotime($p['tanggal_masuk'])); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();

        function getFilterParams() {
            let nama = $('#filter_warga').val();
            let tanggal_mulai = $('#filter_tanggal_mulai').val();
            let tanggal_akhir = $('#filter_tanggal_akhir').val();
            let params = [];

            if (nama) params.push("nama=" + nama);
            if (tanggal_mulai) params.push("tanggal_mulai=" + tanggal_mulai);
            if (tanggal_akhir) params.push("tanggal_akhir=" + tanggal_akhir);

            return params.length ? "?" + params.join("&") : "";
        }

        $('#cetak_pdf_filtered').click(function () {
            let url = "<?= base_url('pemasukan_zakat/cetak_pdf'); ?>" + getFilterParams();
            window.open(url, "_blank");
        });

        $('#cetak_excel_filtered').click(function () {
            let url = "<?= base_url('pemasukan_zakat/cetak_excel'); ?>" + getFilterParams();
            window.location.href = url;
        });
    });
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('pemasukan_zakat/delete/'); ?>" + id;
            }
        });
    }
</script>
<?= $this->endSection(); ?>