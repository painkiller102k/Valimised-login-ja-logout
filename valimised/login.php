<?php
include('conf.php');
session_start();
global $yhendus;
$error = "";

if (isset($_SESSION['tuvastamine'])) {
    header("Location: admin.php");
    exit();
}

// kontrollime kas väljad on täidetud
if (!empty($_POST['login']) && !empty($_POST['pass'])) {

    //eemaldame kasutaja sisestusest kahtlase pahna
    $login = htmlspecialchars(trim($_POST['login']));
    $pass  = htmlspecialchars(trim($_POST['pass']));

    // SIIA UUS KONTROLL
    $sool = 'taiestisuvalinetekst';
    $kryp = crypt($pass, $sool);

    // kontrollime andmebaasi
    $paring = "select * from users 
               where username='$login' and password='$kryp'";

    $valjund = mysqli_query($yhendus, $paring);

    if (mysqli_num_rows($valjund) == 1) {

        $_SESSION['user'] = $login;
        $_SESSION['tuvastamine'] = 'ok';

        if ($login === 'admin') {
            $_SESSION['name'] = 'admin';
        } else {
            $_SESSION['name'] = 'opilane';
        }

        header("Location: valimised.php");
        exit();
    }
    else {
        $error = "Vale kasutajanimi või parool";
    }

}
?>
<?php
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
<link rel="stylesheet" href="loginStyle.css">
<h1>Login TARpv24 presidendi valimised</h1>
<form action="" method="post">
    Login: <input type="text" name="login"><br>
    Password: <input type="password" name="pass"><br>
    <input type="submit" value="Logi sisse">
</form>
