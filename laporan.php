<?php
session_start();
require("conn.php");

if ($_SESSION['role'] !== 'admin') { exit; }

$result = $koneksi->query("
    SELECT services.service_name, COUNT(*) as total_pesanan, SUM(orders.price) as total_pendapatan
    FROM orders
    JOIN services ON orders.service_id = services.id
    WHERE orders.status = 'diambil'
    GROUP BY services.service_name
");
?>

<h2>Laporan Transaksi</h2>
<table border="1">
    <tr>
        <th>Layanan</th>
        <th>Jumlah Pesanan</th>
        <th>Total Pendapatan</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['service_name'] ?></td>
        <td><?= $row['total_pesanan'] ?></td>
        <td>Rp <?= number_format($row['total_pendapatan'],0,',','.') ?></td>
    </tr>
    <?php } ?>
</table>
