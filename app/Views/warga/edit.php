<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="<?= base_url('warga'); ?>" class="breadcrumb-item">
                        <li>Dashboard</li>
                    </a>
                    <li class="breadcrumb-item active">Edit Data Warga</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Warga</h3>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form action="<?= base_url('warga/update/' . $warga['id']); ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $warga['nama']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control"
                                    required><?= $warga['alamat']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Keluarga</label>
                                <input type="number" name="jumlah_keluarga" class="form-control"
                                    value="<?= $warga['jumlah_keluarga']; ?>" required>
                            </div>

                            <?php if (is_admin()): ?>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="number" name="rt" class="form-control" value="<?= (int) $warga['rt']; ?>"
                                        required>
                                </div>
                            <?php elseif (is_rt()): ?>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="number" name="rt" class="form-control" value="<?= (int) $warga['rt']; ?>"
                                        readonly>
                                </div>
                            <?php endif; ?>


                            <div class="form-group">
                                <label>RW</label>
                                <input type="number" name="rw" class="form-control" value="<?= (int) $warga['rw']; ?>"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Mampu" <?= $warga['status'] == 'Mampu' ? 'selected' : ''; ?>>Mampu
                                    </option>
                                    <option value="Tidak Mampu" <?= $warga['status'] == 'Tidak Mampu' ? 'selected' : ''; ?>>Tidak Mampu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="Laki - Laki" <?= $warga['jenis_kelamin'] == 'Laki - Laki' ? 'selected' : ''; ?>>Laki - Laki
                                    </option>
                                    <option value="Perempuan" <?= $warga['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan" id="pekerjaan" class="form-control">
                                    <?php
                                    $listPekerjaan = ["Mahasiswa", "Pelajar", "Buruh", "Ibu Rumah Tangga", "Tidak Bekerja", "Pegawai Negeri", "Karyawan Swasta", "Wiraswasta", "Petani", "Nelayan", "Pensiunan"];
                                    $pekerjaanTersimpan = $warga['pekerjaan'];
                                    $isPekerjaanLainnya = !in_array($pekerjaanTersimpan, $listPekerjaan);

                                    foreach ($listPekerjaan as $pekerjaan) {
                                        $selected = ($pekerjaanTersimpan == $pekerjaan) ? 'selected' : '';
                                        echo "<option value='$pekerjaan' $selected>$pekerjaan</option>";
                                    }
                                    ?>
                                    <option value="Lainnya" <?= $isPekerjaanLainnya ? 'selected' : ''; ?>>Lainnya
                                    </option>
                                </select>
                                <input type="text" id="pekerjaan_lain" name="pekerjaan_lain" class="form-control mt-2"
                                    placeholder="Masukkan pekerjaan..."
                                    style="display: <?= $isPekerjaanLainnya ? 'block' : 'none'; ?>;"
                                    value="<?= $isPekerjaanLainnya ? $pekerjaanTersimpan : ''; ?>">
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="<?= base_url('warga'); ?>" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let pekerjaanSelect = document.getElementById("pekerjaan");
        let pekerjaanLainInput = document.getElementById("pekerjaan_lain");

        pekerjaanSelect.addEventListener("change", function () {
            if (pekerjaanSelect.value === "Lainnya") {
                pekerjaanLainInput.style.display = "block";
            } else {
                pekerjaanLainInput.style.display = "none";
                pekerjaanLainInput.value = "";
            }
        });
    });
</script>

<?= $this->endSection(); ?>