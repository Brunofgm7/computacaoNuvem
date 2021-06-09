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
        exit("utilizador inexistente.");
    }

}
?>

<body style="background-image: url('bg.png');" class="bgTTT">

<div class="container" style="padding-top: 40px;">
<table>
<tbody>
<h1 style="color:#f3a522; text-align: center; padding-bottom: 5%" >Play with your friends and see who thrives!</h1>
<?php

//$db = mysqli_connect('localhost', 'root', '', 'computacaonuvem');
$db = mysqli_connect('localhost', 'root', '14751127', 'computacaonuvem');
$count = 0;

$sql = "SELECT * FROM tipojogo";
if ($result = $db->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        if($row["available"] == 1) {
            $count = 1;
        ?>
        
        <tr>
        <div class="d-flex justify-content-center">
            <h1 style="color:#f3a522"><?= $row['nome'] ?></h1>
        </tr>
        <tr>
            <div class="d-flex justify-content-center" style="padding-top: 30px; padding-bottom:5%">
            <a href="<?= $row["url"] ?>"><img src="<?= $row["img"] ?>" width="400"></a>
        </div>
        </tr>
        <?php
        }
    }
    if ($count == 0) {
        ?>
        <img src="maintenance.gif" width="600dp" class="center">
        <h1 style="color:#f3a522 !important; text-align:center; font-family:comic sans ms">&#9888;&#65039;  Games under maintenance  &#9888;&#65039;</h1>
        <?php
    }
}
?>
<tbody>
</table>
</div>

</body>

<?php
include 'footer.php';
?>