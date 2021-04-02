<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';

?>

<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Recover Password
                </div>
                <div class="card-body">
                    <?php include('errors.php'); ?>
                    <form action="recoverpassword.php" method="post">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="text" name="email" value="" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4 pt-2">
                            <button type="submit" class="btn btn-primary" name="recoverPassword">
                                Send
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