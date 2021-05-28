<?php

include 'database.php';
include 'scripts.php';
include 'forms.php';
include 'navbar.php';


if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] != '1') {
    header("location:index.php");
}
?>
<body style="background-image: url('bg_blue.jpg');" class="bgTTT">

<div class="container" style="padding-bottom:5%; padding-top:2%">
    <h1 class="text-center">Manage Games</h1>
    <table class="table table-active">
        <tbody>
            <?php
            $db = mysqli_connect('localhost', 'root', '', 'computacaonuvem');
            // $db = mysqli_connect('localhost', 'root', '14751127', 'computacaonuvem');

            $sql = "SELECT * FROM tipojogo";
            if ($result = $db->query($sql)) {
                while ($row = $result->fetch_assoc()) {

            ?>
                    <tr>
                        <td class="img_profileChange" style="padding-left: 150px"><img src="<?= $row["img"] ?>" class="img_profileChange" style="height:200px"></td>                        
                        <td class="align-middle" style="padding-left: 250px; font-weight: bold; font-size: 24px"><?php echo $row["nome"] ?></td>
                        <td class="align-middle text-center" style="padding-right: 150px">
                            <form action="managegames.php" method="post">
                                <input type="hidden" name="idJogo" id="idJogo" value="<?= $row["id"] ?>">
                                <?php
                                //verificar o estado do jogo
                                if ($row["available"] == 0){
                                    ?>
                                    <input type="submit" name="gameDisabled" id="gameDisabled" class="btn btn-success" value="Enable" onclick="enable()" style="font-weight: bold">
                                    <?php
                                } else {
                                    ?>
                                    <input type="submit" name="gameEnabled" id="gameEnabled" class="btn btn-danger" value="Disable" onclick="del()" style="font-weight: bold">
                                    <?php
                                }
                                ?>
                            </form>
                        </td>
                    </tr>

                <?php
                }
            }
            if (mysqli_num_rows($result) == 0) {
                ?>
                <tr>
                    <td colspan="3" class="text-center">No games available.</td>
                </tr>

            <?php
            }
            ?>
            
        </tbody>
    </table>
</div>

<?php
include 'footer.php';
?>

<script type="text/javascript">
    function del() {
        var del = confirm("Are you sure you want to disable this game?");
        if (del == true) {
            return true;
        } else {
            event.preventDefault();
        }
    }

    function enable() {
        var enable = confirm("Are you sure you want to enable this game?");
        if (enable == true) {
            return true;
        } else {
            event.preventDefault();
        }
    }
</script>

