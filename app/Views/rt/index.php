<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data RT</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a href="/" class="breadcrumb-item">
                        <li>Dashboard</li>
                    </a>
                    <li class="breadcrumb-item active">Data RT</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data RT</h3>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success mb-3 mt-3 p-3"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <a href="<?= base_url('rt/create'); ?>" class="btn btn-primary">Tambah RT</a>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>RT</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rt_list as $rt): ?>
                                <tr>
                                    <td><?= $rt['name']; ?></td>
                                    <td><?= $rt['username']; ?></td>
                                    <td><?= $rt['rt'] ?? '-'; ?></td>
                                    <td>
                                        <a href="<?= base_url('rt/edit/' . $rt['id']); ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete(<?= $rt['id']; ?>)">Hapus</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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
            window.location.href = "<?= base_url('rt/delete/'); ?>" + id;
        }
    });
}
</script>
<?= $this->endSection(); ?>