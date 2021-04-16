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
        <div class="title" style="text-align:center;">Ready?</div>
        <div class="options">
            <button class="start">Start</button>
        </div>
        </div>
    </div> 

    <!-- playboard section -->
    <div class="play-board">
        <div class="details">
        <div class="players">
            <span class="Xturn">X's Turn</span>
            <span class="Oturn">O's Turn</span>
            <div class="slider"></div>
        </div>
        </div>
        <div class="play-area">
        <section>
            <span class="box1 pt-5"></span>
            <span class="box2 pt-5"></span>
            <span class="box3 pt-5"></span>
        </section>
        <section>
            <span class="box4 pt-5"></span>
            <span class="box5 pt-5"></span>
            <span class="box6 pt-5"></span>
        </section>
        <section>
            <span class="box7 pt-5"></span>
            <span class="box8 pt-5"></span>
            <span class="box9 pt-5"></span>
        </section>
        </div>
    </div>

    <!-- result box -->
    <form action="tictactoeLocal.php" method="post">
    <div class="result-box">
        <div class="won-text"></div>      
            <button type="submit" class="btn btn-primary" name="replayLocal">Replay</button>
    </div>
    </form>

    <script src="scriptTicTacToeLocal.js"></script>
    </div>
</body>