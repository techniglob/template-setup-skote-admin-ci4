<!-- JAVASCRIPT -->
<script src="<?= base_url('') ?>back/js/jquery.min.js"></script>
<script src="<?= base_url('') ?>back/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('') ?>back/js/metisMenu.min.js"></script>
<script src="<?= base_url('') ?>back/js/simplebar.min.js"></script>
<script src="<?= base_url('') ?>back/js/waves.min.js"></script>

<!-- apexcharts -->
<script src="<?= base_url('') ?>back/js/apexcharts.min.js"></script>
<script src="<?= base_url('') ?>back/js/sweetalert2.js"></script>

<!-- App js -->
<script src="<?= base_url('') ?>back/js/app.js"></script>

<!-- Ajax Form -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<!-- /////// -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        width: 'auto',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    function showToast(icon, title) {
        Toast.fire({
            icon: icon,
            title: title
        });
    }

    // Pass PHP session data to JavaScript variables
    const toastData = {
        status: "<?= strtolower(session()->getFlashdata('status') ?? '') ?>",
        message: "<?= session()->getFlashdata('message') ?? '' ?>"
    };

    function showSessionToast(status = 'error', message = 'Your work has been saved') {
        Toast.fire({
            icon: status,
            title: message
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (toastData.status) {
            showSessionToast(toastData.status, toastData.message);
        }
    });

    function notifyToast() {
        if (toastData.status) {
            showSessionToast(toastData.status, toastData.message);
        }
    }
</script>