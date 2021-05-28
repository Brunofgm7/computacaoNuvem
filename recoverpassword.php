<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';

?>
<body style="background-image: url('bg_blue.jpg');" class="bgTTT">

<div class="container" style="padding-bottom:5%; padding-top:2%">
    <h1 class="text-center" style="padding-bottom:1%">Recover Password</h1>
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card" style="background-color:rgba(0,0,0,0.1)">
                <div class="card-body" style="font-size:22px">
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