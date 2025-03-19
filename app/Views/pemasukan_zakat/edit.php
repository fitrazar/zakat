<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-3">
    <h2>Edit Penerima Zakat</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Penerima Zakat</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('penerima_zakat/update/' . $penerima['id']); ?>" method="post"
                enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warga_id">Nama Warga</label>
                            <select id="warga_id" name="warga_id" class="form-control select2">
                                <option value="">Pilih Warga</option>
                                <?php foreach ($warga as $w): ?>
                                    <option value="<?= $w['id']; ?>" data-rt="<?= $w['rt']; ?>" data-rw="<?= $w['rw']; ?>"
                                        data-jk="<?= $w['jenis_kelamin']; ?>" data-status="<?= $w['status']; ?>"
                                        data-alamat="<?= $w['alamat']; ?>" <?= ($w['id'] == $penerima['warga_id']) ? 'selected' : ''; ?>>
                                        <?= $w['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>RT/RW</label>
                            <input type="text" id="rt_rw" class="form-control" disabled
                                value="<?= $penerima['rt'] . '/' . $penerima['rw']; ?>">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" id="jenis_kelamin" class="form-control" disabled
                                value="<?= $penerima['jenis_kelamin']; ?>">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" id="status" class="form-control" disabled
                                value="<?= $penerima['status']; ?>">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea id="alamat" class="form-control" disabled><?= $penerima['alamat']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Jenis Zakat</label>
                            <select name="jenis_zakat" class="form-control">
                                <option value="uang" <?= ($penerima['jenis_zakat'] == 'uang') ? 'selected' : ''; ?>>Uang
                                </option>
                                <option value="beras" <?= ($penerima['jenis_zakat'] == 'beras') ? 'selected' : ''; ?>>
                                    Beras</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Input Jumlah & Satuan -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" id="jumlah" class="form-control"
                                value="<?= $penerima['jumlah'] ?>" required>
                            <small class="text-muted">Saldo kas: <span id="saldoKas">Mengambil
                                    data...</span></small>
                        </div>
                    </div>

                    <!-- Input Tanggal Terima -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Terima</label>
                            <input type="date" name="tanggal_terima" class="form-control"
                                value="<?= $penerima['tanggal_terima']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Bukti</label>
                        <input type="file" name="foto" class="form-control">
                        <input type="hidden" name="old_foto" value="<?= $penerima['foto']; ?>">
                        <small>* Kosongkan jika tidak ingin mengganti foto</small>
                        <br>
                        <img src="<?= base_url('uploads/bukti/' . $penerima['foto']); ?>" width="100">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('penerima_zakat'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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