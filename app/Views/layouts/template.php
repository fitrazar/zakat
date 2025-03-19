<?= $this->include('layouts/header'); ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?= $this->include('layouts/navbar'); ?>
        <?= $this->include('layouts/sidebar'); ?>
        <div class="content-wrapper">
            <?= $this->renderSection('content'); ?>
        </div>
        <?= $this->include('layouts/footer'); ?>
    </div>
</body>