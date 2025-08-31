<?php
session_start();
require("fpdf186/fpdf.php"); // arahkan sesuai lokasi fpdf

if (!isset($_SESSION['last_order'])) {
    header("Location: order.php");
    exit;
}

$order = $_SESSION['last_order'];

// Buat PDF dengan ukuran custom 13,5 x 17 cm
$pdf = new FPDF('P', 'mm', array(135, 170));
$pdf->AddPage();

// Background
if (file_exists('bg.jpg')) {
    $pdf->Image('bg.jpg', 0, 0, 135, 170);
}

// Logo (center di atas)
if (file_exists('logo.png')) {
    $pdf->Image('logo.png', 55, 10, 25);
}

// Spacer biar turun setelah logo
$pdf->Ln(40);

// Judul Brand
$pdf->SetFont("Arial", "B", 18);
$pdf->Cell(0, 10, "Ratu Laundry", 0, 1, "C");

// Slogan
$pdf->SetFont("Arial", "I", 11);
$pdf->Cell(0, 8, '"Dante pernah cuci baju disini!"', 0, 1, "C");
$pdf->Ln(8);

// Sub Judul
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(0, 10, "Struk Pemesanan Laundry", 0, 1, "C");
$pdf->Ln(5);

// Isi struk
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(50, 10, "Layanan", 1);
$pdf->Cell(0, 10, $order['service'], 1, 1);

$pdf->Cell(50, 10, "Harga", 1);
$pdf->Cell(0, 10, "Rp " . number_format($order['price'], 0, ',', '.') . "/kg", 1, 1);

$pdf->Cell(50, 10, "Tanggal", 1);
$pdf->Cell(0, 10, $order['date'], 1, 1);

// Footer terima kasih
$pdf->Ln(15);
$pdf->SetFont("Arial", "", 11);
$pdf->MultiCell(0, 8, "Terima kasih telah menggunakan layanan Ratu Laundry. Kami tunggu pesanan Anda berikutnya!", 0, "C");

// Output PDF (langsung download)
$pdf->Output("D", "struk_pemesanan.pdf");
?>
