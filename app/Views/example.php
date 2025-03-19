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
                    <li class="breadcrumb-item active">Data</li>
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

                    <div class="d-flex justify-content-start align-items-center p-3">
                        <a href="<?= base_url('warga'); ?>" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<?= $this->endSection(); ?>