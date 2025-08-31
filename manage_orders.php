<?php
session_start();
require("conn.php");

// Cek apakah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Hapus pesanan
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $koneksi->query("DELETE FROM orders WHERE id = $id");
    header("Location: manage_orders.php");
    exit;
}

// Ubah status pesanan
if (isset($_POST['update_status'])) {
    $id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $stmt = $koneksi->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Simpan log status (opsional)
    $stmtLog = $koneksi->prepare("INSERT INTO status_logs (order_id, old_status, new_status) VALUES (?, ?, ?)");
    $stmtLog->bind_param("iss", $id, $_POST['old_status'], $status);
    $stmtLog->execute();

    header("Location: manage_orders.php");
    exit;
}

// Ambil semua pesanan
$result = $koneksi->query("
    SELECT o.id, u.username, s.service_name, o.price, o.order_date, o.status
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN services s ON o.service_id = s.id
    ORDER BY o.order_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h2>📋 Kelola Pesanan</h2>
  <a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali</a>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Pengguna</th>
        <th>Layanan</th>
        <th>Harga</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['service_name']) ?></td>
          <td>Rp <?= number_format($row['price'],0,',','.') ?></td>
          <td><?= $row['order_date'] ?></td>
          <td>
            <form method="POST" class="d-flex">
              <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
              <input type="hidden" name="old_status" value="<?= $row['status'] ?>">
              <select name="status" class="form-select me-2">
                <option value="pending" <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                <option value="proses" <?= $row['status']=='proses'?'selected':'' ?>>Proses</option>
                <option value="selesai" <?= $row['status']=='selesai'?'selected':'' ?>>Selesai</option>
                <option value="diambil" <?= $row['status']=='diambil'?'selected':'' ?>>Diambil</option>
              </select>
              <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
            </form>
          </td>
          <td>
            <a href="manage_orders.php?delete=<?= $row['id'] ?>" 
               class="btn btn-sm btn-danger" 
               onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
