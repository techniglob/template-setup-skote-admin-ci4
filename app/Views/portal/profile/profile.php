<?= $this->extend('layouts/portal') ?>
<?= $this->section('css') ?>
<style>
    body {
        background: #f8fafc;
    }

    .profile-card {
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #6b7280;
        margin: 0 auto 12px;
        overflow: hidden;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-section-title {
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 4px;
    }

    .form-text {
        font-size: 13px;
        color: #6b7280;
    }

    .btn-purple {
        background: #6366f1;
        color: #fff;
    }

    .btn-purple:hover {
        background: #4f46e5;
        color: #fff;
    }

    .password-toggle {
        border: 1px solid #e5e7eb;
        padding: 15px;
        border-radius: 12px;
        background: #fafafa;
        margin-top: 20px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="card profile-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Edit Profile</h4>
                <small class="text-muted">Update your personal details and account settings.</small>
            </div>
        </div>

        <div class="row">
            <!-- Left: Profile Picture -->
            <div class="col-md-4 text-center border-end">
                <div class="avatar" id="avatarPreview">avatar</div>

                <!-- Hidden file input -->
                <input type="file" id="profile_pic" name="profile_pic" class="d-none"
                    accept=".jpg, .jpeg, .png, .gif">

                <!-- Trigger button -->
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2"
                    onclick="document.getElementById('profile_pic').click();">
                    ⬆ Upload new photo
                </button>

                <small class="d-block text-muted mb-3">PNG, JPG or GIF up to 5MB</small>
                <button type="button" class="btn btn-outline-danger btn-sm w-100 mb-2" onclick="removeAvatar()">✖ Remove</button>
            </div>

            <!-- Right: Form -->
            <div class="col-md-8 ps-4">
                <?php
                $attributes = ['class' => 'form-horizontal', 'enctype' => "multipart/form-data", "id" => "updateProfile"];
                echo form_open("", $attributes);
                ?>
                <div class="form-section-title">Personal Information</div>
                <p class="form-text">Last updated: 9/6/2025, 9:18:59 PM</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Username<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?= getBackUser()->username ?>"
                            placeholder="Enter username">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">First name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="<?= getBackUser()->first_name ?>"
                            placeholder="Enter first name">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Last name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="<?= getBackUser()->last_name ?>"
                            placeholder="Enter last name">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" value="<?= getBackUser()->email ?>" placeholder="Enter email" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?= getBackUser()->mobile ?>" placeholder="Include country code for SMS features (e.g: +91 1234567890).">
                        <small class="form-text"></small>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="d-flex justify-content-center mt-4">
                    <a href="<?= portalUrl('/dashboard') ?>" class="btn btn-light me-2">Back</a>
                    <button type="submit" id="submit" class="btn btn-success w-md">💾 Save changes</button>
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
    // Preview uploaded avatar
    document.getElementById('profile_pic').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').innerHTML =
                    `<img src="${e.target.result}" class="img-fluid rounded">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove avatar
    function removeAvatar() {
        document.getElementById('avatarPreview').innerHTML = "avatar";
        document.getElementById('profile_pic').value = "";
    }


    $("#updateProfile").validate({
        rules: {
            username: {
                required: true
            },
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,
            }
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
    /*  $("#updateProfile").ajaxForm({
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
     }); */
</script>

<?= $this->endSection() ?>