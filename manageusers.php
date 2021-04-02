<?php

include 'database.php';
include 'forms.php';
include 'navbar.php';
include 'scripts.php';


if (!isset($_SESSION['isAdmin']) && !$_SESSION['isAdmin'] == '1') {
    header("location:index.php");
}
?>

<div class="container">
    <h1 class="text-center">All Users</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col"></th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db = mysqli_connect('localhost', 'root', '', 'computacaoNuvem');

            $sql = "SELECT * FROM user";
            if ($result = $db->query($sql)) {
                while ($row = $result->fetch_assoc()) {

            ?>
                    <tr>

                        <td class="img_profile"><img src="<?= $row["imagemPerfil"] ?>" class="img_profile" style="height:200px"></td>
                        <td class="align-middle"><?php echo $row["username"] ?></td>
                        <td class="align-middle"><?php echo $row["email"] ?></td>
                        <td class="align-middle">
                            fazer reset password
                            <form action="manageusers.php" method="post">
                                <input type="hidden" name="idUser" id="idUser" value="<?= $row["id"] ?>">
                                <input type="submit" name="deleteUser" id="deleteUser" class="btn btn-danger" value="Delete" onclick="del()">
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