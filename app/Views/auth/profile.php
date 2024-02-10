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
                                    <h4 class="card-title mb-4">Edit Profile</h4>
                                    <?php 
                                    $attributes = ['class' => 'form-horizontal','enctype'=>"multipart/form-data", "id"=>"updateProfile"];
                                    echo form_open("",$attributes);
                                    ?>
                                    <div class="row mb-3 required">
                                        <label for="full_name" class="col-form-label col-md-2">Full
                                            Name</label>
                                        <div class="col-md-10">
                                            <input type="text" required name="full_name"
                                                value="<?=getUserData()->full_name?>" class="form-control"
                                                id="full_name">
                                            <?=validation_show_error('full_name')?>
                                        </div>
                                    </div>
                                    <div class="row mb-3 required">
                                        <label for="username" class="col-form-label col-md-2">Username</label>
                                        <div class="col-md-10">
                                            <input type="text" required name="username"
                                                value="<?=getUserData()->username?>" class="form-control" id="username">
                                                <div class="error username"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 required">
                                        <label for="email" class="col-form-label col-md-2">E-mail</label>
                                        <div class="col-md-10">
                                            <input type="text" required name="email" value="<?=getUserData()->email?>"
                                                class="form-control" id="email">
                                                <div class="error email"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 required">
                                        <label for="mobile" class="col-form-label col-md-2">Mobile</label>
                                        <div class="col-md-10">
                                            <input type="text" required name="mobile" value="<?=getUserData()->mobile?>"
                                                class="form-control" id="mobile">
                                            <?=validation_show_error('mobile')?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="profile_pic" class="col-form-label col-md-2">Profile Pic</label>
                                        <div class="col-md-10">
                                            <input type="file" name="profile_pic" accept=".jpg, .jpeg, .png"
                                                class="form-control" id="profile_pic">
                                            <div class="error profile_pic"></div>

                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="submit" id="submit" value="submit"
                                            class="btn btn-success w-md">Update</button>
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
    $("#updateProfile").validate({
        rules: {
            full_name: {
                required: true
            },
            username: {
                required: true
            },
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            email: {
                email: "The Email field must contain a valid email address."
            },
            mobile: {
                number: "Please enter a valid number.",
                minlength: "Please enter valid mobile number",
                maxlength: "Please enter valid mobile number",
            },
        }

    });
    $("#updateProfile").ajaxForm({
        contentType: 'application/json',
        beforeSubmit: function() {
            var valid = $('#updateProfile').valid();
            if (valid) {
                $("#submit").html("Loading...")
                return valid;
            }
        },
        success: function(response) {
            if(response?.success){
                notification();
                $("#submit").html("Update")
                window.location.reload(true);
            }

            $(".profile_pic").html(response.message?.profile_pic ?? '');
            $(".username").html(response.message?.username ?? '');
            $(".email").html(response.message?.email ?? '');
            /* $("#send_otp").html("Send OTP");
            $("#submit_otp").html("Submit OTP");
            $(".institute_id").html(response.message?.institute_id ?? '');
            $(".course_id").html(response.message?.course_id ?? '');
            $(".quota").html(response.message?.quota ?? '');
            $(".mobile").html(response.message?.mobile ?? '');
            $(".email").html(response.message?.email ?? '');
            $(".otp").html(response.message?.otp ?? ''); */
            /* if (response.success) {
                if (response.data?.url) {
                    window.location.href = response.data.url;
                } else {
                    var time = 60;
                    timer(time);
                    var counter = setInterval(function() {
                        if (!timerOn) {
                            clearInterval(counter);
                            //alert(timerOn)
                            $("#send_otp_div").removeClass("d-none");
                            $("#otp").attr("required", false);
                            $(".submit_otp_div").addClass("d-none");
                            $('#otp').val('');
                            $(".otp").html('')
                        }

                    }, time);
                    //alert(timerOn);
                    $("#send_otp_div").addClass("d-none");
                    $("#otp").attr("required", true);
                    $(".submit_otp_div").removeClass("d-none");
                }
            } else {
                response.message && typeof response.message !== 'object' && alert(response.message);
            } */
        }
    });
    </script>

</body>

</html>