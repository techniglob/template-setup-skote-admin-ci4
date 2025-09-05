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
<script src="<?= base_url('') ?>common/js/jquery.form.min.js"></script>
<!-- /////// -->
<script src="<?= base_url('') ?>common/js/jquery.validate.min.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        width: 'auto',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
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
        $.get(`<?= base_url('session-flash') ?>`, function(flash) {
            if (flash.status && flash.message) {
                showSessionToast(flash.status, flash.message);
            }
        });
    }

    function toggleButtonLoader(button, isLoading = true, loadingText = 'Loading...') {
        var button = $(`#${button}`);
        if (isLoading) {
            button.data('original-text', button.html());
            button.html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`);
            button.prop('disabled', true);
        } else {
            const originalText = button.data('original-text');
            if (originalText) {
                button.html(originalText);
            }
            button.prop('disabled', false);
        }
    }
</script>