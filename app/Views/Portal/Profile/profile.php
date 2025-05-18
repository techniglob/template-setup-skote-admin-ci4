<?= $this->extend('layouts/portal') ?>

<?= $this->section('content') ?>
<div class="row">

    <div class="col-md-12">
        <div class='card'>
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Profile</h4>
                <?php
                $attributes = ['class' => 'form-horizontal', 'enctype' => "multipart/form-data", "id" => "updateProfile"];
                echo form_open("", $attributes);
                ?>
                <div class="row mb-3 required">
                    <label for="full_name" class="col-form-label col-md-2">Full
                        Name</label>
                    <div class="col-md-10">
                        <input type="text" required name="full_name"
                            value="<?= getBackUser()->full_name ?>" class="form-control"
                            id="full_name">
                        <?= validation_show_error('full_name') ?>
                    </div>
                </div>
                <div class="row mb-3 required">
                    <label for="username" class="col-form-label col-md-2">Username</label>
                    <div class="col-md-10">
                        <input type="text" required name="username"
                            value="<?= getBackUser()->username ?>" class="form-control" id="username">
                        <div class="error username"></div>
                    </div>
                </div>
                <div class="row mb-3 required">
                    <label for="email" class="col-form-label col-md-2">E-mail</label>
                    <div class="col-md-10">
                        <input type="text" required name="email" value="<?= getBackUser()->email ?>"
                            class="form-control" id="email">
                        <div class="error email"></div>
                    </div>
                </div>
                <div class="row mb-3 required">
                    <label for="mobile" class="col-form-label col-md-2">Mobile</label>
                    <div class="col-md-10">
                        <input type="text" required name="mobile" value="<?= getBackUser()->mobile ?>"
                            class="form-control" id="mobile">
                        <?= validation_show_error('mobile') ?>
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

<?= $this->endSection() ?>
<?= $this->section('js') ?>

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
            if (response?.success) {
                notifyToast();
                $("#submit").html("Update")
                
            }

            $(".profile_pic").html(response.message?.profile_pic ?? '');
            $(".username").html(response.message?.username ?? '');
            $(".email").html(response.message?.email ?? '');
        }
    });
</script>
<?= $this->endSection('js') ?>