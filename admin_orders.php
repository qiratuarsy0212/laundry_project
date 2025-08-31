<?php
session_start();
require("conn.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$result = $koneksi->query("
    SELECT orders.id, users.username, services.service_name, orders.price, orders.status, orders.order_date
    FROM orders
    JOIN users ON orders.user_id = users.id
    JOIN services ON orders.service_id = services.id
    ORDER BY orders.order_date DESC
");
?>

<h2>Data Pemesanan Laundry</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Pelanggan</th>
        <th>Layanan</th>
        <th>Harga</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['service_name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['order_date'] ?></td>
        <td>
            <a href="edit_order.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_order.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>
