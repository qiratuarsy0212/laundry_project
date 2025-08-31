<?php
session_start();
require("conn.php");

if ($_SESSION['role'] !== 'admin') { exit; }

$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM orders WHERE id=$id");
$order = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = $_POST['status'];
    
   
    $old_status = $order['status'];
    $stmt = $koneksi->prepare("INSERT INTO status_logs (order_id, old_status, new_status) VALUES (?,?,?)");
    $stmt->bind_param("iss", $id, $old_status, $status);
    $stmt->execute();

    
    $stmt = $koneksi->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: admin_orders.php");
    exit;
}
?>

<form method="post">
    <label>Status:</label>
    <select name="status">
        <option value="pending" <?= $order['status']=="pending"?"selected":"" ?>>Pending</option>
        <option value="proses" <?= $order['status']=="proses"?"selected":"" ?>>Proses</option>
        <option value="selesai" <?= $order['status']=="selesai"?"selected":"" ?>>Selesai</option>
        <option value="diambil" <?= $order['status']=="diambil"?"selected":"" ?>>Diambil</option>
    </select>
    <button type="submit">Simpan</button>
</form>
