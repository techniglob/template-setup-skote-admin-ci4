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
    // Pass PHP session data to JavaScript variables
    const toastData = {
        status: "<?= strtolower(session()->getFlashdata('status') ?? '') ?>",
        message: "<?= session()->getFlashdata('message') ?? '' ?>",
        title: "<?= session()->getFlashdata('title') ?? '' ?>"
    };

    function showToastr(status = 'error', message = 'Your work has been saved', title = 'No title') {
        toastr[status](message, title);
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "100000",
            "timeOut": "500000",
            "extendedTimeOut": "100000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    $(document).ready(function() {
        if (toastData.status) {
            showToastr(toastData.status, toastData.message, toastData.title);
        }
    });

    function notifyToast() {
        if (toastData.status) {
            showToastr(toastData.status, toastData.message, toastData.title);
        }
    }
</script>