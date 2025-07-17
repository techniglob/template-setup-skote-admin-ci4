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

    function showSessionToast(status = 'error', message = 'Your work has been saved') {
        Toast.fire({
            icon: status,
            title: message
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->has('status')): ?>
            showSessionToast(`<?= session()->getFlashdata('status') ?>`, `<?= session()->getFlashdata('message') ?>`);
        <?php endif; ?>
    });

    function notifyToast() {
        $.get(`<?=base_url('session-flash')?>`, function(flash) {
            if (flash.status && flash.message) {
                showSessionToast(flash.status, flash.message);
            }
        });
    }
</script>