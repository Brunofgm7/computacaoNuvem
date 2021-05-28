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
    <h1 class="text-center" style="padding-bottom:1%">Add game</h1>
        <div class="col-md-8">
            <div class="card" style="background-color:rgba(0,0,0,0.1)">
                <div class="card-body" style="font-size:18px">
                    <?php include('errors.php'); ?>
                    <form action="addgame.php" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="gameName" class="col-md-6 col-form-label text-md-right">Game name</label>
                            <div class="col-md-6">
                                <input type="text" id="gameName" class="form-control" name="gameName" required>
                            </div>
                        </div>
                            <div class="form-group row pt-4">
                                <label for="gameImage" class="col-md-6 col-form-label text-md-right">Game image</label>
                                <div class="col-md-6">
                                    <input type="file" id="gameImage" name="gameImage" accept="image/png, image/jpeg">
                                </div>
                            </div>
                            <div class="form-group row pt-4">
                                <label for="gameFile" class="col-md-6 col-form-label text-md-right">Game file</label>
                                <div class="col-md-6">
                                    <input type="file" id="gameFile" name="gameFile[]" multiple>
                                </div>
                            </div>
                        <div class="col-md-6 offset-md-5 pt-4">
                            <button type="submit" class="btn btn-success" name="addGame">Save</button>
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