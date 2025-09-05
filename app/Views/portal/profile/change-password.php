<?= $this->extend('layouts/portal') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class='card'>
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Profile</h4>
                <?php
                $attributes = ['class' => 'form-horizontal', 'enctype' => "multipart/form-data", "id" => "changePassword"];
                echo form_open("", $attributes);
                ?>
                <div class="row mb-3 required">
                    <label for="password" class="col-form-label col-md-2">Password</label>
                    <div class="col-md-10">
                        <input type="text" required name="password" class="form-control"
                            id="password">
                        <div class="error password"></div>
                    </div>
                </div>
                <div class="row mb-3 required">
                    <label for="new_password" class="col-form-label col-md-2">New Password</label>
                    <div class="col-md-10">
                        <input type="text" required name="new_password" class="form-control"
                            id="new_password">
                        <div class="error new_password"></div>
                    </div>
                </div>
                <div class="row mb-3 required">
                    <label for="confirm_password" class="col-form-label col-md-2">Confirm
                        Password</label>
                    <div class="col-md-10">
                        <input type="text" required name="confirm_password" class="form-control"
                            id="confirm_password">
                        <div class="error confirm_password"></div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" id="submit" value="submit"
                        class="btn btn-success w-md">Change</button>
                </div>
                </form>
            </div>
        </div>


    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>

<script>
    $("#changePassword").validate({
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
                $('#changePassword')[0].reset();
            }
            notifyToast();

            $(".password").html(response.message?.password ?? '');
            $(".new_password").html(response.message?.new_password ?? '');
            $(".confirm_password").html(response.message?.confirm_password ?? '');
        }
    });
</script>
<?= $this->endSection('js') ?>