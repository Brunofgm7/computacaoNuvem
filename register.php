<?php 

include 'database.php';
include 'forms.php';
include 'navbar.php';
include 'scripts.php';

?>


<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">
                    <?php include('errors.php'); ?>
                    <form action="register.php" method="post">
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <input type="text" id="user" class="form-control" name="user" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="email" id="email" class="form-control" name="email" required>
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <label for="password2" class="col-md-4 col-form-label text-md-right">Repeat password</label>
                            <div class="col-md-6">
                                <input type="password" id="password2" class="form-control" name="password2" required>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4 pt-2">
                            <button type="submit" class="btn btn-primary" name="register">
                                Register
                            </button>
                            <a href="login.php" class="btn btn-link">
                                Already have account?
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