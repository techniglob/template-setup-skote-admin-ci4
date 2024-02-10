<!doctype html>
<html lang="en">

<head>

    <?=view('component/back/head')?>
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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class='card'>
                            <div class="card-body">
                                    <h4 class="card-title mb-4">Add Slider</h4>
                                    <?php 
                                    $attributes = ['class' => 'form-horizontal','enctype'=>"multipart/form-data", "id"=>"addSlider"];
                                    echo form_open("",$attributes);
                                    ?>

                                    <div class="row mb-3 required">
                                        <label for="image" class="col-form-label col-md-2">Image</label>
                                        <div class="col-md-10">
                                            <input type="file" required name="image" accept=".jpg, .jpeg, .png"
                                                class="form-control" id="image">
                                            <div class="error image"></div>

                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="submit" id="submit" value="submit"
                                            class="btn btn-success w-md">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>


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

    <script>
    $("#addSlider").validate({
        rules: {
            image: {
                required: true
            }
        },
        messages: {
            confirm_password: {
                equalTo: "The Confirm Password field does not match the New Password field."
            }
        }

    });
    $("#addSlider").ajaxForm({
        contentType: 'application/json',
        beforeSubmit: function() {
            var valid = $('#addSlider').valid();
            if (valid) {
                $("#submit").html("Loading...")
                return valid;
            }
        },
        success: function(response) {
            $("#submit").html("Change")
            if (response?.success) {
                notification();
                window.location.href = "<?=base_url('back-panel/slider')?>";
            }

            $(".password").html(response.message?.password ?? '');
            $(".new_password").html(response.message?.new_password ?? '');
            $(".confirm_password").html(response.message?.confirm_password ?? '');
        }
    });
    </script>

</body>

</html>