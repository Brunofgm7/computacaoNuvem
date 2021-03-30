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
    $userkey = password_hash($username . $password, PASSWORD_BCRYPT);

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
    unset($_SESSION['username']);
    unset($_SESSION['isAdmin']);
    header('location: index.php');
}