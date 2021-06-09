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

<body style="background-image: url('bg_blue.jpg');" class="bgTTT">

<div class="container" style="padding-bottom:5%; padding-top:2%">
    <h1 class="text-center" style="padding-bottom:1%">Reset password</h1>
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
    <div class="card" style="background-color:rgba(0,0,0,0.1)">
        <div class="card-body" style="font-size:22px">
            <?php include('errors.php'); ?>
            <form action="resetpassword.php?key=<?= $key ?>" method="post">
                <div class="row">
                    <label for="password1" class="col-md-4 col-form-label text-md-right">New Password</label>
                    <div class="col-md-6">
                        <input type="password" id="password1" class="form-control" name="password1" required>
                    </div>
                </div>
                <div class="row pt-2">
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