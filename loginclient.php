<?php
require_once("services/db.php");
//require_once (membutuhkan satu kali koneksi to database) {function}
session_start();


$login_notification = "";

if (isset($_SESSION['is_login']) && $_SESSION['is_login']) {
    header("location: detailtable.php");
} //validasi user yang telah login tidak perlu login kembali



if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    //echo memunculkan inputan nya (post)


    $select_admin_query = "SELECT * FROM admin WHERE username ='$username' AND password ='$password'";
    //variabel query 
    $select_admin = $db->query($select_admin_query);
    //pemanggilan ke database
    //query(eksekusi) 

    if ($select_admin->num_rows > 0) {
        $admin = $select_admin->fetch_assoc();
        //fetch_assoc memanggil data single (permasing" field)

        //kalau berhasil login itu kita bikin session is loginnya jadi true
        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $admin['username'];

        header("location: detailtable.php");
    } else {
        $login_notification = "Akun admin tidak ditemukan";
    } //jika benar data pindah ke page index.  jika salah akan muncul notifikasi
    $db->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome Menyala Billiard Hall</title>
</head>


<body id="login">
    <br>
    <h2>
        🙌🏻🍻🎱🦯🎱Welcome to Menyala Billiard Hall🎱🦯🎱🍻🙌🏻
    </h2>
    <div class="super-center">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1>LOGIN USER</h1>
            <i><?= $login_notification ?></i>

            <!-- setelah button form page login di klik akan mencari data di file tersebut (mengeksekusi file yang ada di dalamnya atau file itu sendiri) -->
            <!-- method: post (rahasia) -->

            <label for="">Username</label>
            <input name="username">
            <label for="">Password</label>
            <input type="password" name="password">
            <br>
            <button type="submit" name="login">LOGIN</button>
        </form>
    </div>
    
    <div class="signature">
        <p>
            <center>PIC</center>
        </p>
        <p>
            (Muhammad Faizal)
        </p>
        <br>
    </div>
</body>

</html>