<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';

if (isset($_SESSION["username"])) {
    //verificar se o formulário foi submetido 

    //retirar os valores da base de dados associados ao nosso identificador
    $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
    $smt->execute([$_SESSION["username"]]);
    $utilizador = $smt->fetch(PDO::FETCH_ASSOC);
    //se nao existir contacto com este ID

    if (!$utilizador) {
        exit("utlizador inexistente.");
    }
} else {
    header("location:login.php");
}

?>
<body style="background-image: url('bg_blue.jpg');" class="bgTTT">

<div class="container">
    <div class="row justify-content-center pt-4">
    <h1 class="text-center" style="padding-bottom:1%">Change profile picture</h1>
        <div class="col-md-8">
            <div class="card" style="background-color:rgba(0,0,0,0.1)">
                <div class="card-body">
                    <?php include('errors.php'); ?>
                    <form action="changepassword.php" method="post">
                        <div class="form-group row">
                            <label for="currentpassword" class="col-md-6 col-form-label text-md-right">Current Password</label>
                            <div class="col-md-6">
                                <input type="password" id="currentpassword" class="form-control" name="currentpassword" required>
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="password1" class="col-md-6 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password1" class="form-control" name="password1" required>
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="password2" class="col-md-6 col-form-label text-md-right">Confirm New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password2" class="form-control" name="password2" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-5 pt-4">
                            <input type="hidden" name="key" value="<?= $key ?>">
                            <button type="submit" class="btn btn-success" name="changepassword">
                                Save
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