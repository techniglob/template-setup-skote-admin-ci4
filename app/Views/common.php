<!doctype html>
<html lang="en">

<head>

    <?=view('component/back/head')?>

    <?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>

</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?=view('component/back/header')?>
        <?=view('component/back/sidebar')?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page breadcrumb -->
                    <?=view('component/back/breadcrumb')?>
                    <!-- end page breadcrumb -->
                    <div class="row">

                        <div class="col-md-12">

                            <?php echo $output; ?>

                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?=view('component/back/footer')?>


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?=view('component/back/script')?>

    <?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>


    <script>
    /* $("#changePassword").validate({
        rules: {
            password: {
                required: true
            },
            new_password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            confirm_password: {
                equalTo: "The Confirm Password field does not match the New Password field."
            }
        }

    });
    $("#changePassword").ajaxForm({
        contentType: 'application/json',
        beforeSubmit: function() {
            var valid = $('#changePassword').valid();
            if (valid) {
                $("#submit").html("Loading...")
                return valid;
            }
        },
        success: function(response) {
            $("#submit").html("Change")
            if (response?.success) {
                notification();
                // window.location.reload(true);
            }

            $(".password").html(response.message?.password ?? '');
            $(".new_password").html(response.message?.new_password ?? '');
            $(".confirm_password").html(response.message?.confirm_password ?? '');
        }
    }); */
    </script>

</body>

</html>