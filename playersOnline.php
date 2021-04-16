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
        exit("utilizador inexistente.");
    }
} else {
    header("location:login.php");
}

?>

<div class="panel panel-default">
    <div class="panel-heading">Players Online</div>
    <div id="user_login_status" class="panel-body">

    </div>
    </div>
</div>

<script>
$(document).ready(function(){
function update_user_activity() {
    var action = 'update_time';
    $.ajax({
    url:"action.php",
    method:"POST",
    data:{action:action},
    success:function(data)
    {

    }
    });
}
setInterval(function(){ 
 update_user_activity();
}, 1000); //a cada segundo dá update à atividade do user

fetch_user_login_data();
setInterval(function(){
 fetch_user_login_data();
}, 1000); //a cada segundo vai verificar quem está online
function fetch_user_login_data() {
    var action = "fetch_data";
    $.ajax({
    url:"action.php",
    method:"POST",
    data:{action:action},
    success:function(data)
    {
    $('#user_login_status').html(data);
    }
    });
}

});
</script>
