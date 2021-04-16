<?php

include 'database.php';
include 'forms.php';
include 'scripts.php';

if(isset($_POST["action"])) {

    $last_activity = date("Y-m-d H:i:s", STRTOTIME('-1 hour'));

    if($_POST["action"] == "update_time") {
    
    $smt = $pdo->prepare('UPDATE last_activity_user SET last_activity=? WHERE user_id=?');
    $smt->execute([$last_activity, $_SESSION['idUser']]);

    }
    if($_POST["action"] == "fetch_data") {
        $sql = "SELECT last_activity_user.user_id, user.username, user.imagemPerfil FROM last_activity_user
        INNER JOIN user
        ON user.id = last_activity_user.user_id
        WHERE last_activity > DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $count = $statement->rowCount();
        ?>
        <div class="table-responsive">
        <div class=align:right>
         <?= $count ?> Users Online
        </div>
        <table class="table table-bordered table-striped">
         <tr>
          <th>Username</th>
          <th>Image</th>
         </tr>
         <?php
        $i = 0;
        foreach($result as $row) {
        $i = $i + 1;
        ?>
            <tr> 
            <td><?= $row["username"] ?></td>
            <td><img src="<?= $row["imagemPerfil"] ?>" class="img-thumbnail" width="50" /></td>
            <!-- TODO (Convidar)-->
            </tr>
        <?php
       }
       ?>
       </table></div>
       <?php

    }
}
?>

