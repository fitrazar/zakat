<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Penyaluran Zakat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('penyaluran_zakat'); ?>">Penyaluran Zakat</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Penyaluran Zakat</h3>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger mb-3 mt-3 p-3"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('penyaluran_zakat/store') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori Penerima</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="Fakir Miskin">Fakir Miskin</option>
                                    <option value="Mualaf">Mualaf</option>
                                    <option value="Amil">Amil</option>
                                    <option value="Gharimin">Gharimin</option>
                                    <option value="Fisabilillah">Fisabilillah</option>
                                    <option value="Ibnu Sabil">Ibnu Sabil</option>
                                    <option value="Yatim Piatu">Yatim Piatu</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select name="satuan" id="satuan" class="form-control" required>
                                    <option value="Rupiah">Rupiah</option>
                                    <option value="Kilogram">Kilogram</option>
                                    <option value="Liter">Liter</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" step="0.01" name="jumlah" id="jumlah" class="form-control"
                                    required>
                                <small class="text-muted">Saldo kas: <span id="saldoKas">Mengambil
                                        data...</span></small>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= base_url('penyaluran_zakat'); ?>" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    function getSaldoKas() {
        $.ajax({
            url: "<?= base_url('kas_zakat/saldo') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                $("#saldoKas").html("Uang: " + response.uang + " | Beras: " + response.beras +
                    " kg");
            },
            error: function() {
                $("#saldoKas").html("Gagal mengambil saldo.");
            }
        });
    }

    getSaldoKas();
});
</script>

<?= $this->endSection(); ?>