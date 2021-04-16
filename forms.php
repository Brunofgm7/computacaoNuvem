<?php
session_start();
$errors = array();

include 'database.php';
$db = mysqli_connect('localhost', 'root', '', 'computacaoNuvem');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

//Server settings
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'computacaonuvem3@gmail.com';                     //SMTP username
$mail->Password   = 'computacao_nuvem7';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


//Register

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['user']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $password2 = mysqli_real_escape_string($db, $_POST['password2']);
    $userkey = password_hash($username . $password . date("Y/m/d"), PASSWORD_BCRYPT);

    if ($password != $password2) {
        array_push($errors, 'Passwords are not the same!');
    }
    if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5 || strlen($_POST['password2']) > 20 || strlen($_POST['password2']) < 5) {
        array_push($errors, 'Password has to be between 5 and 20 characters!');
    }


    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($db, $sql);
    $sql2 = "SELECT * FROM user WHERE email = '$email'";
    $result2 = mysqli_query($db, $sql2);
    if (mysqli_num_rows($result) >= 1) {
        array_push($errors, "Username already exist!");
    } else if (mysqli_num_rows($result2) >= 1) {
        array_push($errors, "Email already exist!");
    }

    // se não houve erro nenhum, então adicionar na BD
    if (count($errors) == 0) {
        //encriptar a password para inserir na BD
        $password_encriptada = password_hash($password, PASSWORD_BCRYPT);
        // insira o utilizador na BD
        $sql = "INSERT INTO user (username, email, password, imagemPerfil, vitorias, empates , derrotas, jogosFeitos, backgroundImage, contaVerificada ,isAdmin,userKey) 
        VALUES ('$username','$email','$password_encriptada','profileP/stock.jpg','0','0','0','0','background/stock.png','0','0','$userkey')";
        mysqli_query($db, $sql);

        $mail->setFrom('computacaonuvem3@gmail.com', 'Games R Us');
        $mail->addAddress($email, $username);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Register on Games R Us website';

        $message = "<strong>Hello $username</strong>,<br />
                    Thanks for registering on Games R Us website!<br />
                    <b>This is an automatic message, do not reply!</b>";

        $mail->Body    = "<html><head><style>p{font-family:Arial;font-size:12px}</style></head><body>$message</body>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        header('location: login.php');

        
    }
}


//login

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['user']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
    $smt->execute([$username]);
    $utilizador = $smt->fetch(PDO::FETCH_ASSOC);

    $userpass = $utilizador['password'];
    if (!password_verify($password, $userpass)) {
        array_push($errors, 'Password is incorrect!');
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
            $smt->execute([$_SESSION["username"]]);
            $utilizador = $smt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['idUser'] = $utilizador['id']; 
            $user_id = $_SESSION['idUser'];
            $last_activity = date("Y-m-d H:i:s", STRTOTIME('-1 hour'));

            // verifica se já existe na tabela last_activity_user
            $sql = "SELECT * FROM last_activity_user WHERE user_id = $user_id";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) >= 1) {
                //já existe o user, então update
                $sql = "UPDATE last_activity_user (user_id, last_activity) VALUES ($user_id, '$last_activity')";
                mysqli_query($db, $sql);
            } else {
                // não existe esse user na tabela, portanto podemos inserir
                $sql = "INSERT INTO last_activity_user (user_id, last_activity) VALUES ($user_id, '$last_activity')";
                mysqli_query($db, $sql);
            }

            if ($utilizador['isAdmin'] == '1') {
                $_SESSION['isAdmin'] = $utilizador['isAdmin'];
            } else {
                $_SESSION['isAdmin'] = 0;
            }
            // redirecionar para a homepage
            header('location: index.php');
        } else {
            array_push($errors, "Username is incorrect!");
        }
    }
}


//logout

if (isset($_GET['logout'])) {
    session_destroy();
    $idUser = $_SESSION['idUser'];
    $query = "DELETE FROM last_activity_user WHERE user_id=$idUser";
    $result = mysqli_query($db, $query);
    unset($_SESSION['username']);
    unset($_SESSION['isAdmin']);
    unset($_SESSION['idUser']);
    header('location: index.php');
}

//perfil

if (isset($_POST['submitEditProfile'])) {
    
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    
    $smt = $pdo->prepare('UPDATE user SET email=? WHERE username=?');
    $smt->execute([$email, $_SESSION["username"]]);
    header('location: profile.php');

}

// Change profile pic

if (isset($_POST['changeProfilePic'])) {
    $r = 1;
    $help = 0;
    $pic = $_FILES["fileToUpload"]["name"] != "" ? "profileP/" . "profileP_" . $_SESSION["username"] . ".jpg" : $_POST["photo"];

    if(isset($_POST['imagem'])){
        $imageStock = mysqli_real_escape_string($db, $_POST['imagem']);

        $smt = $pdo->prepare('UPDATE user SET imagemPerfil=? WHERE username=?');
        $smt->execute([$imageStock, $_SESSION["username"]]);

        $help = 1;
        header('location: profile.php');
    }

    $target_dir = "profileP/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES) && $_FILES["fileToUpload"]["size"] > 0) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $r = 0;
            array_push($errors, 'File is not an image.');
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $r = 0;
            array_push($errors, 'Sorry, your file is too large.');
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $r = 0;
            array_push($errors, 'Sorry, only JPG, JPEG, PNG files are allowed.');
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $r = 0;
            array_push($errors, 'Sorry, your file was not uploaded.');
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                rename($target_dir . $_FILES["fileToUpload"]["name"], $target_dir . "profileP_" . $_SESSION["username"] . ".jpg");
            } else {
                $r = 0;
                array_push($errors, 'Sorry, there was an error uploading your file.');
            }
        }
    }else{
        //array_push($errors, 'Sorry, there was an error uploading your file.');
    }
    
    if ($_FILES["fileToUpload"]["name"] == "") {
        $r = 1;
    }
    if ($r == 1 && count($errors)==0 && $help == 0) {

        $smt = $pdo->prepare('UPDATE user SET imagemPerfil=? WHERE username=?');
        $smt->execute([$pic, $_SESSION["username"]]);
        header('location: profile.php');
    }
    
}

// Change background Image

// Change profile pic

if (isset($_POST['changebackgroundimage'])) {
    $r = 1;
    $help = 0;
    $pic = $_FILES["fileToUpload"]["name"] != "" ? "background/" . "background_" . $_SESSION["username"] . ".jpg" : $_POST["photo"];
    

    if(isset($_POST['imagem'])){
        $imageStock = mysqli_real_escape_string($db, $_POST['imagem']);

        $smt = $pdo->prepare('UPDATE user SET backgroundImage=? WHERE username=?');
        $smt->execute([$imageStock, $_SESSION["username"]]);
        
        $help = 1;
        header('location: profile.php');
    }

    $target_dir = "background/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES) && $_FILES["fileToUpload"]["size"] > 0) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $r = 0;
            array_push($errors, 'File is not an image.');
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $r = 0;
            array_push($errors, 'Sorry, your file is too large.');
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $r = 0;
            array_push($errors, 'Sorry, only JPG, JPEG, PNG files are allowed.');
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $r = 0;
            array_push($errors, 'Sorry, your file was not uploaded.');
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                rename($target_dir . $_FILES["fileToUpload"]["name"], $target_dir . "background_" . $_SESSION["username"] . ".jpg");
            } else {
                $r = 0;
                array_push($errors, 'Sorry, there was an error uploading your file.');
            }
        }
    }else{
        //array_push($errors, 'Sorry, there was an error uploading your file.');
    }
    
    if ($_FILES["fileToUpload"]["name"] == "") {
        $r = 1;
    }
    if ($r == 1 && count($errors)==0 && $help == 0) {

        $smt = $pdo->prepare('UPDATE user SET backgroundImage=? WHERE username=?');
        $smt->execute([$pic, $_SESSION["username"]]);
        header('location: profile.php');
    }
}


//recover password

if (isset($_POST['recoverPassword'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);

    $sql = "SELECT * FROM user WHERE email='$email'";
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $key = $row['userKey'];
           
            $mail->setFrom('computacaonuvem3@gmail.com', 'Games R Us');
        $mail->addAddress($email);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recover password Games R Us';

        $message = "To recover your password click the link below:
                <br/>
                <a href='https://localhost/computacaonuvem/resetpassword.php?key=$key'>Reset your password.</a><br/>
                <b>This is an automatic message, do not reply!</b><br/>
                <b>If you didn't asked for a password reset, ignore this message.";

        $mail->Body    = "<html><head><style>p{font-family:Arial;font-size:12px}</style></head><body>$message</body></html>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();

        header('location: login.php');
        }
    } elseif (mysqli_num_rows($result) == 0) {
        array_push($errors, "Email doesn't exist!");
    }
}

//reset password

if (isset($_POST['resetPassword'])) {
    $userkey = $_POST['key'];
    $PassNova = mysqli_real_escape_string($db, $_POST['password1']);
    $cPassNova = mysqli_real_escape_string($db, $_POST['password2']);

    if ($PassNova != $cPassNova) {
        array_push($errors, 'Passwords are not the same!');
    }
    if (strlen($_POST['password1']) > 20 || strlen($_POST['password1']) < 5 || strlen($_POST['password2']) > 20 || strlen($_POST['password2']) < 5) {
        array_push($errors, 'Password has to be between 5 and 20 characters!');
    }

    $sql = "SELECT * FROM user";
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $currentuserkey = $row['userKey'];
            $user = $row['username'];
            if ($userkey == $currentuserkey) {
                if (count($errors) == 0) {
                    $novaPassword_encrip = password_hash($PassNova, PASSWORD_BCRYPT);
                    $userkey = password_hash($user . $PassNova . date("Y/m/d"), PASSWORD_BCRYPT);

                    $query = "SELECT * FROM user WHERE username='$user'";
                    $result = mysqli_query($db, $query);

                    if (mysqli_num_rows($result) == 1) {
                        $sql = "SELECT password FROM user WHERE username = '$user'";
                        $result = mysqli_query($db, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $smt = $pdo->prepare('UPDATE user SET password=?, userKey=? WHERE username=?');
                            $smt->execute([$novaPassword_encrip, $userkey, $user]);
                            header('location: login.php');
                        } else {
                            array_push($errors, "User not found!");
                        }
                    }
                }
            }
        }
    }
}

//replay 

if (isset($_POST['replay'])) {
    $winner = mysqli_real_escape_string($db, $_POST['winner']);
    $username = $_SESSION['username'];
    $idUser = $_SESSION['idUser'];
    if($winner == "player"){

        $smt = $pdo->prepare('INSERT INTO jogos (idVisitado, idVisitante, vencedor , idJogo) VALUES (?, ?, ?, ?)');
        $smt->execute([$idUser, '1',$idUser, '1']);


        $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
        $smt->execute([$username]);
        $utilizador = $smt->fetch(PDO::FETCH_ASSOC);

        $vitorias = $utilizador['vitorias'] + 1;
        $jogosFeitos = $utilizador['jogosFeitos'] + 1; 

        $smt = $pdo->prepare('UPDATE user SET vitorias=?, jogosFeitos=? WHERE username = ?');
        $smt->execute([$vitorias, $jogosFeitos, $_SESSION["username"]]);
        
    }else if($winner == "bot"){
        $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
        $smt->execute([$username]);
        $utilizador = $smt->fetch(PDO::FETCH_ASSOC);
        
        $smt = $pdo->prepare('INSERT INTO jogos (idVisitado, idVisitante, vencedor, idJogo) VALUES (?, ?, ?, ?)');
        $smt->execute([$idUser, '1','1', '1']);

        $derrotas = $utilizador['derrotas'] + 1; 
        $jogosFeitos = $utilizador['jogosFeitos'] + 1; 

        $smt = $pdo->prepare('UPDATE user SET derrotas=?, jogosFeitos=? WHERE username = ?');
        $smt->execute([$derrotas, $jogosFeitos, $_SESSION["username"]]);

    }else if($winner == "draw"){
        $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
        $smt->execute([$username]);
        $utilizador = $smt->fetch(PDO::FETCH_ASSOC);

        $smt = $pdo->prepare('INSERT INTO jogos (idVisitado, idVisitante, vencedor, idJogo) VALUES (?, ?, ?, ?)');
        $smt->execute([$idUser, '1', '0', '1']);

        $empates = $utilizador['empates'] + 1; 
        $jogosFeitos = $utilizador['jogosFeitos'] + 1; 

        $smt = $pdo->prepare('UPDATE user SET empates=?, jogosFeitos=? WHERE username = ?');
        $smt->execute([$empates, $jogosFeitos, $_SESSION["username"]]);
    }
    header('location: tictactoe.php');
}

//Replay local

if (isset($_POST['replayLocal'])) {
    header('location: tictactoeLocal.php');
}


//delete user

if (isset($_POST["deleteUser"])) {
    $idUser = $_POST['idUser'];
    $sql = "SELECT * FROM user WHERE id=$idUser";
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {//TODO
            if ($row['imagemPerfil'] != 'profileP/stock.jpg' && $row['imagemPerfil'] != 'profileP/default.png' && $row['imagemPerfil'] != 'profileP/default2.jpg' && $row['imagemPerfil'] != 'profileP/default3.jpg' && $row['imagemPerfil'] != 'profileP/default4.jpg' && $row['imagemPerfil'] != 'profileP/default5.png' ) {
                unlink($row["imagemPerfil"]);
            }else{
                array_push($errors, 'You can\'t delete this image.');
            }
        }
    }

    $query = "DELETE FROM user WHERE id=$idUser";
    $result = mysqli_query($db, $query);
}

//resetImageUser

if (isset($_POST["resetImageUser"])) {
    $idUser = $_POST['idUser'];
    $stockImage = "profileP/stock.jpg";
    $sql = "SELECT * FROM user WHERE id=$idUser";
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) {//TODO
            if ($row['imagemPerfil'] != 'profileP/stock.jpg' && $row['imagemPerfil'] != 'profileP/default.png' && $row['imagemPerfil'] != 'profileP/default2.jpg' && $row['imagemPerfil'] != 'profileP/default3.jpg' && $row['imagemPerfil'] != 'profileP/default4.jpg' && $row['imagemPerfil'] != 'profileP/default5.png' ) {
               unlink($row["imagemPerfil"]);

                $smt = $pdo->prepare('UPDATE user SET imagemPerfil=? WHERE id=?');
                $smt->execute([$stockImage, $idUser]);

            }else{
                array_push($errors, 'You can\'t delete this image.');
            }
        }
    }
}


//delete profile image

if (isset($_POST["deleteProfileImage"])) {
    $idImage = $_POST['idImage'];
    $sql = "SELECT * FROM profileImage WHERE id=$idImage";
    if ($result = $db->query($sql)) {
        while ($row = $result->fetch_assoc()) { 
            if ($row['image'] != 'profileP/stock.jpg') {
                unlink($row["image"]);
            }else{
                array_push($errors, 'You can\'t delete this image.');
            }
        }
    }

    $query = "DELETE FROM profileImage WHERE id=$idImage";
    $result = mysqli_query($db, $query);
}

//add profile image

if (isset($_POST["addProfileImage"])) {
    $image = "profileP/". "profileP_" . $_FILES["image"]["name"];

    $r = 1;

    $target_dir = "profileP/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES) && $_FILES["image"]["size"] > 0) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $r = 0;
            array_push($errors, 'File is not an image.');
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $r = 0;
            array_push($errors, 'Sorry, your file is too large.');
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $r = 0;
            array_push($errors, 'Sorry, only JPG, JPEG, PNG files are allowed.');
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $r = 0;
            array_push($errors, 'Sorry, your file was not uploaded.');
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                rename($target_dir . $_FILES["image"]["name"], $target_dir . "profileP_" . $_FILES["image"]["name"] . ".jpg");
                $image = $target_dir . "profileP_" . $_FILES["image"]["name"] . ".jpg";
                if ($_FILES["image"]["name"] == "") {
                    $r = 1;
                }
                if ($r == 1 && count($errors)==0) {
            
                    $smt = $pdo->prepare('INSERT INTO profileImage (image) VALUES (?)');
                    $smt->execute([$image]);
                    header('location: manageprofileimages.php');
                }
            } else {
                $r = 0;
                array_push($errors, 'Sorry, there was an error uploading your file.');
            }
        }
    }else{
        //array_push($errors, 'Sorry, there was an error uploading your file.');
    }
}

// change password

if (isset($_POST['changepassword'])) {
    $currentPassword = mysqli_real_escape_string($db, $_POST['currentpassword']);
    $PassNova = mysqli_real_escape_string($db, $_POST['password1']);
    $cPassNova = mysqli_real_escape_string($db, $_POST['password2']);

    $username = $_SESSION['username'];

    $smt = $pdo->prepare('SELECT * FROM user WHERE username=?');
    $smt->execute([$username]);
    $utilizador = $smt->fetch(PDO::FETCH_ASSOC);

    $passAtual = $utilizador['password']; 
    
    if (!password_verify($currentPassword, $passAtual)) {
        array_push($errors, 'Current password is incorrect!');
    }
    if ($PassNova != $cPassNova) {
        array_push($errors, 'Passwords are not the same!');
    }
    if (strlen($_POST['password1']) > 20 || strlen($_POST['password1']) < 5 || strlen($_POST['password2']) > 20 || strlen($_POST['password2']) < 5) {
        array_push($errors, 'Password has to be between 5 and 20 characters!');
    }

    if (count($errors) == 0) {      
        $novaPassword_encrip = password_hash($PassNova, PASSWORD_BCRYPT);
        $userkey = password_hash($username . $PassNova . date("Y/m/d"), PASSWORD_BCRYPT);

        $query = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {
            $sql = "SELECT password FROM user WHERE username = '$username'";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0) {
                $smt = $pdo->prepare('UPDATE user SET password=?, userKey=? WHERE username=?');
                $smt->execute([$novaPassword_encrip, $userkey, $username]);
                header('location: profile.php');
            } else {
                array_push($errors, "User not found!");
            }
        }
    }
}