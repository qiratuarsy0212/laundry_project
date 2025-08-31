<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
echo "<h1>Selamat datang User, " . $_SESSION['name'] . "!</h1>";
echo "<a href='logout.php'>Logout</a>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Ratu Laundry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('bg.jpg') no-repeat center top;
      background-size: cover;
    }

    /* Navbar */
    .navbar {
      background: rgba(44,62,80,0.9);
      padding: 15px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    .navbar-brand {
      color: #fff;
      font-weight: 700;
      font-size: 20px;
    }
    .navbar .btn-logout {
      background: #e74c3c;
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .navbar .btn-logout:hover {
      background: #c0392b;
      transform: scale(1.05);
      box-shadow: 0px 4px 12px rgba(231, 76, 60, 0.6);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar d-flex justify-content-between">
    <span class="navbar-brand">Ratu Laundry</span>
    <button class="btn btn-logout" id="btnLogout">Logout</button>
  </nav>

  <script>
    document.getElementById("btnLogout").addEventListener("click", function() {
      Swal.fire({
        title: 'Yakin mau keluar?',
        text: "Sesi kamu akan berakhir.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#7f8c8d',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "logout.php";
        }
      });
    });
  </script>

</body>
</html>
