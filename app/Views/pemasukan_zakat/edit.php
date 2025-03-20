<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-3">
    <h2>Edit Pemasukan Zakat</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Pemasukan Zakat</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('pemasukan_zakat/update/' . $pemasukan['id']); ?>" method="post"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                value="<?= $pemasukan['nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Keluarga</label>
                            <input type="text" id="jumlah_keluarga" name="jumlah_keluarga" class="form-control"
                                value="<?= $pemasukan['jumlah_keluarga']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="infaq" class="form-label">Infaq</label>
                            <input type="text" name="infaq" id="infaq" class="form-control"
                                value="<?= $pemasukan['infaq']; ?>">
                            <small class="text-muted">Tidak wajib</small>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Zakat</label>
                            <select name="jenis_zakat" class="form-control">
                                <option value="Zakat Fitrah" <?= ($pemasukan['jenis_zakat'] == 'Zakat Fitrah') ? 'selected' : ''; ?>>Zakat Fitrah
                                </option>
                                <option value="Zakat Maal" <?= ($pemasukan['jenis_zakat'] == 'Zakat Maal') ? 'selected' : ''; ?>>Zakat Maal
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control">
                                <option value="uang" <?= ($pemasukan['jenis'] == 'uang') ? 'selected' : ''; ?>>Uang
                                </option>
                                <option value="beras" <?= ($pemasukan['jenis'] == 'beras') ? 'selected' : ''; ?>>
                                    Beras</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control"
                                value="<?= $pemasukan['jumlah']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="<?= $pemasukan['tanggal_masuk']; ?>" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('pemasukan_zakat'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.8.1"></script>
<script>
    new AutoNumeric('#jumlah', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 2,
        unformatOnSubmit: true
    });
    new AutoNumeric('#infaq', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 2,
        unformatOnSubmit: true
    });
</script>
<script>
    $(document).ready(function () {
        $('.select2').select2();

        $('#warga_id').change(function () {
            let selected = $(this).find('option:selected');
            $('#rt_rw').val(selected.data('rt') + "/" + selected.data('rw'));
            $('#jenis_kelamin').val(selected.data('jk'));
            $('#status').val(selected.data('status'));
            $('#alamat').val(selected.data('alamat'));
        });
    });
</script>
<script>
    $(document).ready(function () {
        function getSaldoKas() {
            $.ajax({
                url: "<?= base_url('kas_zakat/saldo') ?>",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    $("#saldoKas").html("Uang: " + response.uang + " | Beras: " + response.beras +
                        " kg");
                },
                error: function () {
                    $("#saldoKas").html("Gagal mengambil saldo.");
                }
            });
        }
        getSaldoKas();
    });
</script>
<?= $this->endSection(); ?>