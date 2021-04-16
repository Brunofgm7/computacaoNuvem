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
    header("location:login.php");
}
?>

<div class="container pt-4">
        <div class="card">
            <div class="card-header">
                Change Profile Image
            </div>
            <div class="card-body">
                <?php include('errors.php'); ?>
                <form action="changeProfilePic.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xxl-2 col-xl-4 col-md-6 col-sm-8">
                        <div class="image-upload">
                            <label for="fileToUpload">
                                <img class="img_profile" src="upload.png" class="rounded mx-auto d-block" />
                            </label>
                            <p class="label text-center">Upload File</p>
                            <input type="file" id="fileToUpload" name="fileToUpload" />
                            <input type="hidden" name="photo" id="photo" value="<?= $utilizador['imagemPerfil'] ?>">
                        </div>
                    </div>

                    <?php

                    $db = mysqli_connect('localhost', 'root', '', 'computacaoNuvem');

                    $sql = "SELECT * FROM profileimage";
                    if ($result = $db->query($sql)) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-xxl-2 col-xl-4 col-md-6 col-sm-8 d-flex justify-content-center">
                                <label>
                                    <input type="radio" name="imagem" id="imagem" value="<?= $row["image"] ?>">
                                    <img src="<?= $row["image"] ?>" class="img_profile">
                                </label>                    
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
                    
                    <div class="form-group row pt-2">
                        <div class="col-md-12 text-center">
                            <input type="submit" name="changeProfilePic" id="changeProfilePic" class="btn btn-dark" value="Change">
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>