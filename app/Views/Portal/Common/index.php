<?= $this->extend('Layouts/portal') ?>
<?= $this->section('css') ?>
<?php
foreach ($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">

    <div class="col-md-12">

        <?php echo $output; ?>

    </div>
</div>
<!-- end row -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>

<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?= $this->endSection() ?>