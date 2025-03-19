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
                    <li class="breadcrumb-item active">Data Warga</li>
                </ol>
            </div><!-- /.col -->


            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Warga</h3>
                    </div>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3 mt-3 p-3"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <a href="<?= base_url('warga/create'); ?>" class="btn btn-primary">Tambah
                            Warga</a>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Jumlah Keluarga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($warga as $w): ?>
                                    <tr>
                                        <td><?= $w['nama']; ?></td>
                                        <td><?= $w['alamat']; ?></td>
                                        <td><?= str_pad($w['rt'], 2, '0', STR_PAD_LEFT); ?>/<?= str_pad($w['rw'], 2, '0', STR_PAD_LEFT); ?>
                                        </td>
                                        <td><?= $w['jumlah_keluarga']; ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                onclick="showDetail('<?= $w['nama']; ?>', '<?= $w['alamat']; ?>', '<?= str_pad($w['rt'], 2, '0', STR_PAD_LEFT); ?>', '<?= str_pad($w['rw'], 2, '0', STR_PAD_LEFT); ?>', '<?= $w['jumlah_keluarga']; ?>', '<?= $w['pekerjaan']; ?>', '<?= $w['status']; ?>', '<?= $w['jenis_kelamin']; ?>')">
                                                Detail
                                            </button>
                                            <a href="<?= base_url('warga/edit/' . $w['id']); ?>"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete(<?= $w['id']; ?>)">Hapus</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>RT/RW</th>
                                    <th>Jumlah Keluarga</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Modal Detail Warga -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Warga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                        <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                        <p><strong>RT/RW:</strong> <span id="detailRTRW"></span></p>
                        <p><strong>Jumlah Keluarga:</strong> <span id="detailJumlahKeluarga"></span></p>
                        <p><strong>Pekerjaan:</strong> <span id="detailPekerjaan"></span></p>
                        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                        <p><strong>Jenis Kelamin:</strong> <span id="detailKelamin"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                window.location.href = "<?= base_url('warga/delete/'); ?>" + id;
            }
        });
    }

    function showDetail(nama, alamat, rt, rw, jumlahKeluarga, pekerjaan, status, kelamin) {
        document.getElementById("detailNama").textContent = nama;
        document.getElementById("detailAlamat").textContent = alamat;
        document.getElementById("detailRTRW").textContent = rt + "/" + rw;
        document.getElementById("detailJumlahKeluarga").textContent = jumlahKeluarga;
        document.getElementById("detailPekerjaan").textContent = pekerjaan;
        document.getElementById("detailStatus").textContent = status;
        document.getElementById("detailKelamin").textContent = kelamin;

        $('#detailModal').modal('show');
    }
</script>
<?= $this->endSection(); ?>