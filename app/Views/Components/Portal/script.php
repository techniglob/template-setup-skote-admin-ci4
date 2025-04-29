<!-- JAVASCRIPT -->
<script src="<?= base_url('') ?>back/js/jquery.min.js"></script>
<script src="<?= base_url('') ?>back/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('') ?>back/js/metisMenu.min.js"></script>
<script src="<?= base_url('') ?>back/js/simplebar.min.js"></script>
<script src="<?= base_url('') ?>back/js/waves.min.js"></script>

<!-- apexcharts -->
<script src="<?= base_url('') ?>back/js/apexcharts.min.js"></script>
<script src="<?= base_url('') ?>back/js/toastr.min.js"></script>

<!-- App js -->
<script src="<?= base_url('') ?>back/js/app.js"></script>

<!-- Ajax Form -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<!-- /////// -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        <?php if (session()->has('status')) { ?>
            toastr["<?= strtolower(session()->getFlashdata('status') ?? 'error') ?>"]("<?= session()->getFlashdata('message') ?? 'Your work has been saved' ?>",
                "<?= session()->getFlashdata('title') ?? 'No title' ?>")

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        <?php } ?>
    });

    function notifyToast() {
        <?php if (session()->has('status')) { ?>
            toastr["<?= strtolower(session()->getFlashdata('status') ?? 'error') ?>"]("<?= session()->getFlashdata('message') ?? 'Your work has been saved' ?>",
                "<?= session()->getFlashdata('title') ?? 'No title' ?>")

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        <?php } ?>
    }
</script>