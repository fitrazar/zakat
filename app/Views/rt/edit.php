<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Edit RT</h3>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('rt/update/' . $rt['id']); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($rt['name']); ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= esc($rt['username']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="mb-3">
                    <label for="rt" class="form-label">RT</label>
                    <input type="number" class="form-control" id="rt" name="rt" value="<?= esc($rt['rt']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('rt'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>