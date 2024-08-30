<?php
require_once("services/db.php");
session_start();

if ($_SESSION['is_login'] == false) {
    header("location : loginclient.php");
}

define("APP_NAME", "NOMOR MEJA ");

$no_meja = "";
$nama_pelanggan = "";
$jam_main = "";
$jam_keluar = "";
$update_notification = "";

if (isset($_GET['no_meja']) && $_GET['no_meja'] !== "") {
    $no_meja = $_GET['no_meja'];
}

if (isset($_GET['nama_pelanggan']) && $_GET['nama_pelanggan'] !== "") {
    $nama_pelanggan = $_GET['nama_pelanggan'];
}

if (isset($_GET['jam_main']) && $_GET['jam_main'] !== "") {
    $jam_main = $_GET['jam_main'];
}

if (isset($_GET['jam_keluar']) && $_GET['jam_keluar'] !== "") {
    $jam_main = $_GET['jam_keluar'];
    header("location: logoutclient.php?no_meja=$no_meja&nama_pelanggan=$nama_pelanggan&jam_main=$jam_main&jam_keluar=$jam_keluar");
}

if (isset($_POST['UPDATE'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $jam_main = $_POST['jam_main'];
    $jam_keluar = $_POST['jam_keluar'];

    $update_mejabl_query = "UPDATE mejabl SET nama_pelanggan='$nama_pelanggan', jumlah_orang='$jumlah_orang', jam_main='$jam_main', jam_keluar='$jam_keluar', status=1 WHERE no_meja='$no_meja'";

    $update_mejabl = $db->query($update_mejabl_query);

    if ($update_mejabl) {
        header("location: detailtable.php");
    } else {
        $update_notification = "Gagal update data meja, silahkan coba lagi";
    }
    $db->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Update Meja</title>
</head>

<body id="nomeja">
    <?php include("layouting/tag.php"); ?>
    <div class="super-center">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h1><?= APP_NAME;
                echo $no_meja ?></h1>
            <i><?= $update_notification ?></i>
            <label>Nama Pelanggan</label>
            <input name="nama_pelanggan" />
            <label>Jumlah Orang</label>
            <input name="jumlah_orang" />
            <label for="start-time">Jam main</label>
            <input name="jam_main" type="time" id="start-time">
            <label for="end-time">Jam keluar</label>
            <input name="jam_keluar" type="time" id="end-time">
            <br><br>
            <button type="submit" name="UPDATE">UPDATE</button>
            <br><br>
            <div id="countdown"></div>

            <script>
                function startCountdown() {
                    var startTimeInput = document.getElementById("start-time").value;
                    var endTimeInput = document.getElementById("end-time").value;

                    var startTime = new Date("2000-01-01T" + startTimeInput + ":00");
                    var endTime = new Date("2000-01-01T" + endTimeInput + ":00");

                    var timeDifference = endTime - startTime;

                    var countdown = document.getElementById("countdown");
                    var timerInterval = setInterval(function() {
                        var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                        countdown.innerHTML = "Sisa waktu: " + hours + " jam " + minutes + " menit " + seconds + " detik ";

                        if (timeDifference <= 0) {
                            clearInterval(timerInterval);
                            countdown.innerHTML = "Waktu telah habis";
                        } else {
                            timeDifference -= 1000;
                        }
                    }, 1000);
                }
            </script>
</body>

</html>
</body>

</html>
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