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

<div class="container" style="padding-bottom:5%; padding-top:2%">
    <h1 class="text-center" style="padding-bottom:1%">Profile</h1>
    <table class="table table-active table-borderless" style="font-size: 20px">
        <thead>
        <th></th>
        <th></th>
        </thead>
        <tbody>
            <?php include('errors.php'); ?>
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>
                        <div class="image-upload">
                            <label for="fileToUpload">
                                <a href="changeProfilePic.php"><img src="<?= $utilizador['imagemPerfil'] ?>" class="rounded mx-auto d-block"></a>
                            </label>
                            <p class="label text-center">Change Picture</p>
                            <input type="file" id="fileToUpload" name="fileToUpload" />
                            <input type="hidden" name="photo" id="photo" value="<?= $utilizador['imagemPerfil'] ?>">
                        </div>
                    </td>
                    <td>
                    <div class="image-upload">
                        <label for="fileToUpload">
                            <a href="changebackgroundimage.php"><img src="<?= $utilizador['backgroundImage'] ?>" class="rounded mx-auto d-block"></a>
                        </label>
                        <p class="label text-center">Game Background</p>
                        <input type="file" id="fileToUpload" name="fileToUpload" />
                        <input type="hidden" name="photo" id="photo" value="<?= $utilizador['backgroundImage'] ?>">
                    </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; padding-top: 2%">
                    <label for="user" class="col-md-4 col-form-label text-md-right">Username</label>
                    </td>
                    <td style="padding-top: 2%">
                    <div class="col-md-6">
                        <label for="user" class="form-control"><?= $utilizador['username'] ?></label>
                        <input type="hidden" name="user" value="<?= $utilizador['username'] ?>" id="user">
                    </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    </td>
                    <td>
                    <div class="col-md-6">
                        <input type="text" name="email" value="<?= $utilizador['email'] ?>" id="email" class="form-control">
                    </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center">
                    <label for="pass" class="col-md-4 col-form-label text-md-right">Password</label>
                    </td>
                    <td>
                    <div class="col-md-6">
                        <a class="btn btn-secondary btn-lg btn-block" href="changepassword.php" role="button">Change Password</a>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                    <div class="col-md-12 text-center">
                        <input type="submit" name="submitEditProfile" id="submitEditProfile" class="btn btn-success" value="Save">
                    </div>
                    </td>
                </tr>
            </form>
        </tbody>
    </table>
</div>

<?php
include 'footer.php';
?>