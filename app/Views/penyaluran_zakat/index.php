<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penyaluran Zakat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Penyaluran Zakat</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Penyaluran Zakat</h3>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <a href="<?= base_url('penyaluran_zakat/create'); ?>" class="btn btn-primary">Tambah
                            Penyaluran</a>
                        <a href="<?= base_url('penyaluran_zakat/cetak_pdf') ?>" class="btn btn-danger ml-3">Cetak
                            PDF</a>
                        <a href="<?= base_url('penyaluran_zakat/cetak_excel') ?>" class="btn btn-success ml-3">Export
                            Excel</a>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($penyaluran)): ?>
                                <?php $no = 1;
                                    foreach ($penyaluran as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['kategori']) ?></td>
                                    <td><?= esc($row['jumlah']) ?></td>
                                    <td><?= esc($row['satuan']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                    <td><?= esc($row['keterangan']) ?></td>
                                    <td>
                                        <a href="<?= base_url('penyaluran_zakat/edit/' . $row['id']) ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete(<?= $row['id']; ?>)">Hapus</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak tersedia.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
            window.location.href = "<?= base_url('penyaluran_zakat/delete/'); ?>" + id;
        }
    });
}
</script>
<?= $this->endSection(); ?>