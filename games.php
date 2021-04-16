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
    <div class="d-flex justify-content-center">
        <a href="tictactoeOpponent.php"><h1> Tic Tac Toe </h1>
        <h2> por a imagem </h2></a>
    </div>
</div>

<?php
include 'footer.php';
?>