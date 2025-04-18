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
                        <h3 class="card-title">Tambah Data Pemasukan Zakat</h3>
                    </div>
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('pemasukan_zakat/store'); ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <textarea id="nama" name="nama" class="form-control" required></textarea>
                                        <small class="text-muted">Pisahkan dengan koma</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Keluarga</label>
                                        <input type="text" id="jumlah_keluarga" name="jumlah_keluarga"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="infaq" class="form-label">Infaq</label>
                                        <input type="text" name="infaq" id="infaq" class="form-control">
                                        <small class="text-muted">Tidak wajib</small>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Zakat</label>
                                        <select name="jenis_zakat" class="form-control">
                                            <option value="Zakat Fitrah">Zakat Fitrah</option>
                                            <option value="Zakat Maal">Zakat Maal</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis</label>
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
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" class="form-control"
                                            value="<?= date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('pemasukan_zakat'); ?>" class="btn btn-secondary">Kembali</a>
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
    new AutoNumeric('#infaq', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 2,
        unformatOnSubmit: true
    });
</script>

<?= $this->endSection(); ?>