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
                        <h3 class="card-title">Tambah Data Warga</h3>
                    </div>
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger mb-3 mt-3 p-3"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('warga/store'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Nama -->
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                            required></textarea>
                                    </div>

                                    <!-- Jumlah Keluarga -->
                                    <div class="form-group">
                                        <label for="jumlah_keluarga">Jumlah Keluarga</label>
                                        <input type="number" class="form-control" id="jumlah_keluarga"
                                            name="jumlah_keluarga" required>
                                    </div>

                                    <!-- Umur -->
                                    <div class="form-group">
                                        <label for="umur">Umur</label>
                                        <input type="number" class="form-control" id="umur" name="umur" required>
                                    </div>

                                    <!-- No HP -->
                                    <div class="form-group">
                                        <label for="no_hp">No HP</label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <!-- RT -->
                                    <?php if (is_admin()): ?>
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="number" class="form-control" id="rt" name="rt" required>
                                    </div>
                                    <?php elseif (is_rt()): ?>
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="number" class="form-control" id="rt" name="rt"
                                            value="<?= session()->get('rt'); ?>" readonly>
                                    </div>
                                    <?php endif; ?>


                                    <!-- RW -->
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="number" class="form-control" id="rw" name="rw" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Mampu">Mampu</option>
                                            <option value="Tidak Mampu">Tidak Mampu</option>
                                        </select>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="Laki - Laki">Laki - Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <!-- Pekerjaan -->
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <select class="form-control" name="pekerjaan" id="pekerjaan" required>
                                            <option value="">-- Pilih Pekerjaan --</option>
                                            <option value="Mahasiswa">Mahasiswa</option>
                                            <option value="Pelajar">Pelajar</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                                            <option value="Buruh">Buruh</option>
                                            <option value="Petani">Petani</option>
                                            <option value="Nelayan">Nelayan</option>
                                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                            <option value="Wirausaha">Wirausaha</option>
                                            <option value="Pedagang">Pedagang</option>
                                            <option value="Pensiunan">Pensiunan</option>
                                            <option value="Tidak Bekerja">Tidak Bekerja</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <!-- Input pekerjaan lainnya (default hidden) -->
                                    <div class="form-group" id="pekerjaan_lainnya" style="display: none;">
                                        <label for="pekerjaan_lain">Masukkan Pekerjaan</label>
                                        <input type="text" class="form-control" name="pekerjaan_lain"
                                            id="pekerjaan_lain">
                                    </div>


                                    <!-- Foto -->
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Simpan & Kembali -->
                            <div class="d-flex justify-content-between mt-3">
                                <a href="<?= base_url('warga'); ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#pekerjaan').change(function() {
        if ($(this).val() == 'Lainnya') {
            $('#pekerjaan_lainnya').show();
        } else {
            $('#pekerjaan_lainnya').hide();
            $('#pekerjaan_lain').val('');
        }
    });
});
</script>

<?= $this->endSection(); ?>