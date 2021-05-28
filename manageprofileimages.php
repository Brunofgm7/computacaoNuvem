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
    <h1 class="text-center">Default Profile Pictures</h1>
    <table class="table table-active">
        <tbody>
            <?php
            $db = mysqli_connect('localhost', 'root', '', 'computacaonuvem');
            // $db = mysqli_connect('localhost', 'root', '14751127', 'computacaonuvem');

            $sql = "SELECT * FROM profileImage";
            if ($result = $db->query($sql)) {
                while ($row = $result->fetch_assoc()) {

            ?>
                    <tr>
                        <td class="img_profileChange" style="padding-left: 250px"><img src="<?= $row["image"] ?>" class="img_profileChange" style="height:200px"></td>                        
                        <td class="align-middle text-center">
                            <form action="manageprofileimages.php" method="post">
                                <input type="hidden" name="idImage" id="idImage" value="<?= $row["id"] ?>">
                                <input type="submit" name="deleteProfileImage" id="deleteProfileImage" class="btn btn-danger" value="Delete" onclick="del()" style="font-weight: bold">
                            </form>
                        </td>
                    </tr>
                <?php
                }
            }
            if (mysqli_num_rows($result) == 0) {
                ?>
                <tr>
                    <td colspan="3" class="text-center">No images in database.</td>
                </tr>

            <?php
            }
            ?>
            
            <form action="manageprofileimages.php" method="post" enctype="multipart/form-data">
            <tr>
                <td colspan="3" class="align-middle text-center">
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg">
                    
                </td>
            </tr>
            <tr>
                <td colspan="3" class="align-middle text-center" >
                    <input type="submit" name="addProfileImage" id="addProfileImage" class="btn btn-success" value="Add new image">
                </td>
            </tr>
            </form>
            
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