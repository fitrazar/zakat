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
                    <a href="/" class="breadcrumb-item">
                        <li>Dashboard</li>
                    </a>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div><!-- /.col -->

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Penerima Zakat</h3>
                    </div>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-3 mt-3 p-3"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('penerima_zakat/store'); ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="warga_id">Nama Warga</label>
                                        <select id="warga_id" name="warga_id" class="form-control select2">
                                            <option value="">Pilih Warga</option>
                                            <?php foreach ($warga as $w): ?>
                                                <option value="<?= $w['id']; ?>" data-rt="<?= $w['rt']; ?>"
                                                    data-rw="<?= $w['rw']; ?>" data-jk="<?= $w['jenis_kelamin']; ?>"
                                                    data-status="<?= $w['status']; ?>" data-alamat="<?= $w['alamat']; ?>">
                                                    <?= $w['nama']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>RT/RW</label>
                                        <input type="text" id="rt_rw" class="form-control" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <input type="text" id="jenis_kelamin" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" id="status" class="form-control" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea id="alamat" class="form-control" disabled></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Zakat</label>
                                        <select name="jenis" class="form-control">
                                            <option value="uang">Uang</option>
                                            <option value="beras">Beras</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="text" name="jumlah" id="jumlah" class="form-control" required>
                                        <small class="text-muted">Saldo kas: <span id="saldoKas">Mengambil
                                                data...</span></small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Terima</label>
                                        <input type="date" name="tanggal_terima" class="form-control"
                                            value="<?= date('Y-m-d'); ?>" required>
                                    </div>
                                </div>


                                <!-- Foto -->
                                <div class="form-group">
                                    <label for="foto">Bukti</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('penerima_zakat'); ?>" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
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