<?php

    include 'database.php';
    include 'forms.php';
    include 'navbar.php';
    include 'scripts.php';

    if (!isset($_SESSION["username"])) {
        header("location:register.php?error1");
    }else{
        $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
        $smt->execute([$_SESSION["username"]]);
        $utilizador = $smt->fetch(PDO::FETCH_ASSOC);
        //se nao existir contacto com este ID
        if (!$utilizador) {
            exit("utlizador inexistente.");
        }
    }
?>
<body style="background-image: url(<?= $utilizador['backgroundImage'] ?>)" class="bgTTT">
    <div class="select-box">
        <header>Tic Tac Toe</header>
        <div class="content">
        <div class="title">Select your opponent</div>
        <div class="options">
            <button class="online" onclick="location.href='#'">Online</button>
            <button class="bot" onclick="location.href='tictactoe.php'">Bot</button>
            <button class="local" onclick="location.href='tictactoeLocal.php'">Local</button>
        </div>
        </div>
    </div> 
    </div>
</body>