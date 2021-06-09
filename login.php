<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';

if (!isset($_SESSION["username"])) {
    //Se não tiver sessão iniciada

} else {
    header("location:profile.php");
}
?>
<body style="background-image: url('bg_blue.jpg');" class="bgTTT">


<div class="container" style="padding-bottom:5%; padding-top:2%">
<h1 class="text-center" style="padding-bottom:1%">Login</h1>
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card" style="background-color:rgba(0,0,0,0.1)">
                <div class="card-body" style="font-size:22px">
                    <?php include('errors.php'); ?>
                    <form action="login.php" method="post">
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <input type="text" id="user" class="form-control" name="user" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4 pt-2">
                            <button type="submit" class="btn btn-primary" name="login">
                                Login
                            </button>
                            <a href="recoverpassword.php" class="btn btn-link">
                                Forgot Your Password?
                            </a>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>