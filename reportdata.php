<?php
require_once("services/pdf/fpdf.php");
require_once("services/db.php");

session_start();

if ($_SESSION['is_login'] == false) {
    header("location: loginclient.php");
}

if (isset($_POST['report'])) {
    $hari = $_POST['hari'];
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetTitle("Laporan Pengunjung");
    $pdf->SetFont("Arial", "B", 14);


    $select_reportdaily_querry = "SELECT * FROM reportdaily WHERE hari='$hari'";
    $select_reportdaily = $db->query($select_reportdaily_querry);

    if ($select_reportdaily->num_rows > 0) {
        $pdf->Text(10, 6, "Laporan Pengunjung Menyala Billiard Hall Tanggal $hari");
        $pdf->Ln(6);
        $pdf->Text(10, 12, "total $select_reportdaily->num_rows pengunjung.");
        $pdf->Cell(24, 10, "no meja", 1, 0);
        $pdf->Cell(48, 10, "nama pelanggan", 1, 0);
        $pdf->Cell(38, 10, "hari keluar", 1, 0);
        $pdf->Cell(38, 10, "jam keluar", 1, 0);
        $pdf->Cell(40, 10, "", 0, 1);
        foreach ($select_reportdaily as $reportdaily) {
            $pdf->Cell(24,  10, $reportdaily["no_meja"], 1, 0);
            $pdf->Cell(48, 10, $reportdaily["nama_pelanggan"], 1, 0);
            $pdf->Cell(38, 10, $reportdaily["hari"], 1, 0);
            $pdf->Cell(38, 10, $reportdaily["jam"], 1, 1);
        }
        $pdf->Output();
    } else {
        $pdf->SetFont("Arial", "B", 14);
        $pdf->Cell(38, 10, "Tidak ada laporan untuk tanggal $hari", 0, 1);
        $pdf->Output();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css " />
    <title>REPORT</title>
</head>

<body id="report">
    <?php include("layouting/tag.php") ?>
    <div class="super-center">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h3>
                <center>Cetak PDF</center>
            </h3>
            <input type="date" name="hari"></input>
            <br>
            <button type="submit" name="report">Generate Report</button>
        </form>
    </div>
    <div class="signature">
        <p>
            <center>PIC</center>
        </p>
        <p>(Muhammad Faizal)</p>
        <br>
    </div>
</body>

</html>