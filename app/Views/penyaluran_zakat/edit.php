<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Penyaluran Zakat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('penyaluran_zakat'); ?>">Penyaluran Zakat</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Penyaluran Zakat</h3>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger mb-3 mt-3 p-3"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('penyaluran_zakat/update/' . $penyaluran['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $penyaluran['id'] ?>">

                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori Penerima</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="Fakir Miskin"
                                        <?= $penyaluran['kategori'] == 'Fakir Miskin' ? 'selected' : '' ?>>Fakir Miskin
                                    </option>
                                    <option value="Mualaf" <?= $penyaluran['kategori'] == 'Mualaf' ? 'selected' : '' ?>>
                                        Mualaf</option>
                                    <option value="Amil" <?= $penyaluran['kategori'] == 'Amil' ? 'selected' : '' ?>>Amil
                                    </option>
                                    <option value="Gharimin"
                                        <?= $penyaluran['kategori'] == 'Gharimin' ? 'selected' : '' ?>>Gharimin</option>
                                    <option value="Fisabilillah"
                                        <?= $penyaluran['kategori'] == 'Fisabilillah' ? 'selected' : '' ?>>Fisabilillah
                                    </option>
                                    <option value="Ibnu Sabil"
                                        <?= $penyaluran['kategori'] == 'Ibnu Sabil' ? 'selected' : '' ?>>Ibnu Sabil
                                    </option>
                                    <option value="Yatim Piatu"
                                        <?= $penyaluran['kategori'] == 'Yatim Piatu' ? 'selected' : '' ?>>Yatim Piatu
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select name="satuan" id="satuan" class="form-control" required>
                                    <option value="Rupiah" <?= $penyaluran['satuan'] == 'Rupiah' ? 'selected' : '' ?>>
                                        Rupiah</option>
                                    <option value="Kilogram"
                                        <?= $penyaluran['satuan'] == 'Kilogram' ? 'selected' : '' ?>>
                                        Kilogram</option>
                                    <option value="Liter" <?= $penyaluran['satuan'] == 'Liter' ? 'selected' : '' ?>>
                                        Liter
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" step="0.01" name="jumlah" id="jumlah" class="form-control"
                                    value="<?= $penyaluran['jumlah'] ?>" required>
                                <small class="text-muted">Saldo kas: <span id="saldoKas">Mengambil
                                        data...</span></small>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="<?= $penyaluran['tanggal'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control"
                                    rows="3"><?= $penyaluran['keterangan'] ?></textarea>
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