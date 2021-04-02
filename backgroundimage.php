<?php

include 'database.php';
include 'forms.php';
include 'navbar.php';
include 'scripts.php';

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
    header("location:index.php");
}
?>

<div class="container">
    <div class="row justify-content-center pt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Background Image
                </div>
                <div class="card-body">
                    <?php include('errors.php'); ?>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="image-upload">
                                <label for="fileToUpload">
                                    <img src="<?= $utilizador['imagemPerfil'] ?>" class="rounded mx-auto d-block" />
                                </label>
                                <p class="label text-center">Change Picture</p>
                                <input type="file" id="fileToUpload" name="fileToUpload" />
                                <input type="hidden" name="photo" id="photo" value="<?= $utilizador['imagemPerfil'] ?>">
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <label for="user" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <label for="user" class="form-control"><?= $utilizador['username'] ?></label>
                                <input type="hidden" name="user" value="<?= $utilizador['username'] ?>" id="user">
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="text" name="email" value="<?= $utilizador['email'] ?>" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="pass" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <a class="btn btn-secondary btn-lg btn-block" href="changepassword.php" role="button">Change Password</a>
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <label for="background" class="col-md-4 col-form-label text-md-right">Background</label>
                            <div class="col-md-6">
                                <a class="btn btn-secondary btn-lg btn-block" href="backgroundimage.php" role="button">Change Background Image</a>
                            </div>
                        </div>
                        <div class="form-group row pt-2">
                            <div class="col-md-12 text-center">
                                <input type="submit" name="submitEditProfile" id="submitEditProfile" class="btn btn-dark" value="Save">
                            </div>
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