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
    //vitorias, derrotas, jogosFeitos, empates
    if (!$utilizador) {
        exit("utilizador inexistente.");
    }
} else {
    header("location:login.php");
}

$totalwr = $utilizador['vitorias'] + $utilizador['derrotas'];
$wr = $utilizador['vitorias'] * 100 / $totalwr;

?>

<body style="background-image: url('bg.png');" class="bgTTT">

<div class="container pt-5">
    <?php include('errors.php'); ?>
    <table class="table">
        <thead class="table-dark" >
            <tr class="text-center">
                <th scope="col">Wins</th>
                <th scope="col">Draws</th>
                <th scope="col">Defeats</th>
                <th scope="col">Win Rate %</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td><?= $utilizador['vitorias'] ?></td>
                <td><?= $utilizador['empates'] ?></td>
                <td><?= $utilizador['derrotas'] ?></td>
                <td><b><?= $wr ?>%</th>
            </tr>
        </tbody>
        </table>

        <table class="table">
        <thead class="thead-light">
            <tr class="text-center">
                <th scope="col">Home</th>
                <th scope="col">Score</th>
                <th scope="col">Away</th>
            </tr>
        </thead>
        <tbody class="text-center">

        <?php
        $userid = $utilizador['id'];
        $sql = "SELECT * FROM jogos WHERE idVisitado = '$userid' or idVisitante = '$userid'";
            if ($result = $db->query($sql) > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['vencedor'] == $userid) {
        ?>
                        <tr class="table-success" style="margin-top: 20px !important">
                            <td><?= $row['idVisitado'] ?></td>
                            <td>Win</td>
                            <td><?= $row['idVisitante'] ?></td>
                        </tr> 
                <?php
                    } else if ($row['vencedor'] == '0') {
                        ?>
                        <tr class="table-warning">
                            <td><?= $row['idVisitado'] ?></td>
                            <td>Draw</td>
                            <td><?= $row['idVisitante'] ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr class="table-danger">
                            <td><?= $row['idVisitado'] ?></td>
                            <td>Loss</td>
                            <td><?= $row['idVisitante'] ?></td>
                        </tr>
                    <?php
                    }
                }
            }
                ?>  
        </tbody>
    </table>
</div>



<?php
include 'footer.php';
?>