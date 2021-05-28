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
    <h1 class="text-center">All Users</h1>
    <table class="table table-active">
        <thead class="thead-light" style="font-size: 22px">
            <tr>
                <th scope="col"></th>
                <th scope="col" style="padding-left: 75px;">Username</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('errors.php');
            $db = mysqli_connect('localhost', 'root', '', 'computacaonuvem');
                    // $db = mysqli_connect('localhost', 'root', '14751127', 'computacaonuvem');

            $sql = "SELECT * FROM user";
            if ($result = $db->query($sql)) {
                while ($row = $result->fetch_assoc()) {

            ?>
                    <tr>

                        <td class="img_profile"><img src="<?= $row["imagemPerfil"] ?>" class="img_profile" style="height:200px"></td>
                        <td class="align-middle" style="padding-left: 75px; font-size: 22px"><?php echo $row["username"] ?></td>
                        <td class="align-middle" style="font-size: 22px"><?php echo $row["email"] ?></td>
                        <td class="align-middle">
                            <form action="manageusers.php" method="post">
                                <input type="hidden" name="idUser" id="idUser" value="<?= $row["id"] ?>">
                                <input type="submit" name="resetImageUser" id="resetImageUser" class="btn btn-warning" value="Reset Image" onclick="del()"  style="margin: 5px !important; font-weight: bold">
                                <input type="submit" name="deleteUser" id="deleteUser" class="btn btn-danger" value="Delete" onclick="del()" style="margin: 5px !important; font-weight: bold">
                            </form>
                        </td>
                    </tr>

                <?php
                }
            }
            if (mysqli_num_rows($result) == 0) {
                ?>
                <tr>

                    <td colspan="5" class="text-center">No users registered.</td>
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
        var del = confirm("Are you sure you want to delete?");
        if (del == true) {
            return true;
        } else {
            event.preventDefault();
        }
    }
</script>