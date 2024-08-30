<?php
require_once "services/db.php";
session_start();

if ($_SESSION['is_login'] == false) {
    header("location : loginclient.php");
}

define("APP_NAME", "Menyala Billiard Hall");
//require_once (membutuhkan satu kali koneksi to database) {function} : force project jadi error tidak lanjut ke project berikutnya//
//define (final value website) : parameter 1 nama, parameter 2 value//

setlocale(LC_TIME, 'id_ID.UTF-8');

// Set the timezone to Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');


// SELECT SEMUA DATA, yang jam keluar < jam sekarang

$jam_sekarang = date("H:i:s");
$data_meja = "SELECT * FROM mejabl WHERE jam_keluar < '$jam_sekarang'";
$execute = $db->query($data_meja);
while ($see = mysqli_fetch_object($execute)) {

    $hari = date("Y-m-d");
    $insert_report_harian = "INSERT INTO reportdaily VALUES (null, '$see->no_meja', '$see->nama_pelanggan', '$hari', '$see->jam_keluar')";
    $db->query($insert_report_harian);
}

$seleksi = "UPDATE mejabl SET 
    nama_pelanggan = null,
    jumlah_orang = null,
    status = 0,
    jam_main = null,
    jam_keluar = null
WHERE jam_keluar < '$jam_sekarang'";
$db->query($seleksi);



$select_mejabl_query = "SELECT * FROM mejabl";
$count_mejabl_query = "SELECT COUNT(status) as total_count, SUM(status=1) as total_row FROM mejabl";

$select_mejabl = $db->query($select_mejabl_query);
$count_mejabl = $db->query($count_mejabl_query);

$status = $count_mejabl->fetch_assoc();
$jumlah_meja = $status['total_count'];
$meja_isi = $status['total_row'];

$is_full = false;

if ($jumlah_meja == $meja_isi) {
    $is_full = true;
}


//pemanggilan meja = query untuk mengammbil semua data meja
//eksekusi
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title> <?= APP_NAME ?> </title>
</head>

<body id="meja">

    <?php include("layouting/tag.php") ?>
    </br>
    </br>


    <div class="row">
        <div class="column">
            <img src="./profil_image/bola kecil.jpg" style="width:100%" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
        </div>
        <div class="column">
            <img src="./profil_image/perempuan.webp" style="width:100%" onclick="openModal();currentSlide(2)" class="hover-shadow cursor">
        </div>
        <div class="column">
            <img src="./profil_image/break.jpg" style="width:100%" onclick="openModal();currentSlide(3)" class="hover-shadow cursor">
        </div>
        <div class="column">
            <img src="./profil_image/set break.jpg" style="width:100%" onclick="openModal();currentSlide(4)" class="hover-shadow cursor">
        </div>
    </div>

    <div id="myModal" class="modal">
        <span class="close cursor" onclick="closeModal()">&times;</span>
        <div class="modal-content">

            <div class="mySlides">
                <div class="numbertext">1 / 4</div>
                <img src="./profil_image/bola kecil.jpg" style="width:100%">
            </div>

            <div class="mySlides">
                <div class="numbertext">2 / 4</div>
                <img src="./profil_image/by one.jpg" style="width:100%">
            </div>

            <div class="mySlides">
                <div class="numbertext">3 / 4</div>
                <img src="./profil_image/break.jpg" style="width:100%">
            </div>

            <div class="mySlides">
                <div class="numbertext">4 / 4</div>
                <img src="./profil_image/set break.jpg" style="width:100%">
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <div class="caption-container">
                <p id="caption"></p>
            </div>


            <div class="column">
                <img class="demo cursor" src="./profil_image/bola kecil.jpg" style="width:100%" onclick="currentSlide(1)" alt="bola kecil">
            </div>
            <div class="column">
                <img class="demo cursor" src="./profil_image/by one.jpg" style="width:100%" onclick="currentSlide(2)" alt="by one">
            </div>
            <div class="column">
                <img class="demo cursor" src="./profil_image/break.jpg" style="width:100%" onclick="currentSlide(3)" alt="break">
            </div>
            <div class="column">
                <img class="demo cursor" src="./profil_image/set break.jpg" style="width:100%" onclick="currentSlide(4)" alt="set break">
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>
    <br>
    <br>
    <h1 align="center">
        <?php
        $sisa_meja =  $jumlah_meja - $meja_isi;
        if ($is_full) {
            echo "<h1 align='center'>Meja Penuh</h1>";
        } else {
            echo "<h1 align='center'>$sisa_meja Meja Kosong</h1>";
        }
        ?>
    </h1>

    <div class="container">
        <?php

        foreach ($select_mejabl as $mejabl) {
            //maaping lewat foreach
        ?>
            <div class="card" onclick="goToMeja('<?= $mejabl['no_meja'] ?>', '<?= $mejabl['nama_pelanggan'] ?>')">
                <b><?= $mejabl['no_meja'] ?></b>
                <p>
                    <?= $mejabl['nama_pelanggan'] == NULL && $mejabl['jumlah_orang'] ==  NULL ? "meja kosong"
                        : $mejabl['nama_pelanggan'] .  "<br>" . $mejabl['jumlah_orang'] . " orang" . "<br>" .  $mejabl['jam_main'] . "<br>" .  $mejabl['jam_keluar']  ?>

                    <?php if (isset($mejabl['nama_pelanggan'])) { ?>
                        <br>
                        <span class="meja" data-jamMasuk="<?= date("H:i:s") ?>" data-jamKeluar="<?= $mejabl['jam_keluar'] ?>"></span>
                    <?php } ?>
                </p>

            </div>

        <?php  } ?>
    </div>

    <script>
        function goToMeja(no_meja, nama_pelanggan) {
            const url = "mejaclient.php";
            const params = `?no_meja=${no_meja}&nama_pelanggan=${nama_pelanggan}`

            window.location.replace(url + params);
        }
    </script>
    <script>
        var elements = document.querySelectorAll('.meja');

        elements.forEach(function(element) {
            var startTimeInput = element.getAttribute("data-jamMasuk");
            var endTimeInput = element.getAttribute("data-jamKeluar");

            var referenceDate = new Date();
            var startTime = new Date(referenceDate.toDateString() + " " + startTimeInput);
            var endTime = new Date(referenceDate.toDateString() + " " + endTimeInput);
            // console.log(startTimeInput);

            var timeDifference = endTime - startTime;

            var countdown = document.getElementById("countdown");
            var timerInterval = setInterval(function() {
                var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                element.innerHTML = "Sisa waktu: " + hours + " jam " + minutes + " menit " + seconds + " detik ";

                if (timeDifference <= 0) {
                    clearInterval(timerInterval);
                    // element.innerHTML = "Waktu telah habis";

                    location.reload();
                } else {
                    timeDifference -= 1000;
                }
            }, 1000);
        });
    </script>
</body>

</html>