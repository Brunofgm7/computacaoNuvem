<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';


$key = $_GET['key'];

if ($key == "") {
    header("location:index.php");
}
?>

<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Reset Password
                </div>
                <div class="card-body">
                    <?php include('errors.php'); ?>
                    <form action="resetpassword.php?key=<?= $key ?>" method="post">
                        <div class="form-group row">
                            <label for="password1" class="col-md-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password1" class="form-control" name="password1" required>
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="password2" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password2" class="form-control" name="password2" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4 pt-2">
                            <input type="hidden" name="key" value="<?= $key ?>">
                            <button type="submit" class="btn btn-primary" name="resetPassword">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>