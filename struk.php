<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (isset($_POST['service']) && isset($_POST['price'])) {
    $service = $_POST['service'];
    $price   = $_POST['price'];

    
    $_SESSION['last_order'] = [
        "service" => $service,
        "price"   => $price,
        "date"    => date("d-m-Y H:i:s")
    ];
} else {
    if (!isset($_SESSION['last_order'])) {
        header("Location: order.php");
        exit;
    }
    $service = $_SESSION['last_order']['service'];
    $price   = $_SESSION['last_order']['price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Struk Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('bg.jpg') no-repeat center top;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    
    .navbar {
      backdrop-filter: blur(10px);
      background: rgba(255,255,255,0.6);
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
      z-index: 10;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 20px;
      color: #2c3e50 !important;
    }
    .logout-btn {
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
    }
    .logout-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 10px rgba(220,53,69,0.4);
    }

    
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      backdrop-filter: blur(8px);
      background: rgba(255,255,255,0.2);
      z-index: 1;
    }

    .receipt-box {
      position: relative;
      background: url('bg.jpg') repeat;
      background-size: cover;
      border-radius: 16px;
      padding: 30px;
      max-width: 500px;
      width: 100%;
      margin: auto;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.25);
      text-align: center;
      animation: fadeInUp 0.8s ease forwards;
      z-index: 2;
    }

    .receipt-box img {
      width: 80px;
      margin-bottom: 10px;
    }

    .receipt-box h2 {
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 5px;
    }

    .receipt-box p.slogan {
      font-size: 14px;
      font-style: italic;
      color: #555;
      margin-bottom: 20px;
    }

    .receipt-box .info {
      font-size: 16px;
      margin: 10px 0;
      text-align: left;
    }

    .btn-download {
      display: block;
      width: 100%;
      margin-top: 15px;
      border-radius: 8px;
      font-weight: 600;
    }

    @keyframes fadeInUp {
      0% {opacity: 0; transform: translateY(30px);}
      100% {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  
  <nav class="navbar px-4">
    <a class="navbar-brand" href="order.php">👑 Ratu Laundry</a>
    <div class="ms-auto">
      <button class="btn btn-danger logout-btn" id="logoutBtn">Logout</button>
    </div>
  </nav>

 
  <div class="receipt-box">
    <img src="logo.png" alt="Logo Laundry">
    <h2>Ratu Laundry</h2>
    <p class="slogan">"Dante pernah cuci baju disini!"</p>
    <hr>
    <p class="info"><b>Layanan:</b> <?= htmlspecialchars($service) ?></p>
    <p class="info"><b>Harga:</b> Rp <?= number_format($price, 0, ',', '.') ?>/kg</p>
    <p class="info"><b>Tanggal:</b> <?= $_SESSION['last_order']['date'] ?></p>
    <a href="struk_pdf.php" class="btn btn-success btn-download">Download Struk (PDF)</a>
    <a href="order.php" class="btn btn-secondary btn-download">Kembali ke Pesanan</a>
  </div>

  <script>
    document.getElementById("logoutBtn").addEventListener("click", function() {
      Swal.fire({
        title: "Yakin mau logout?",
        text: "Sesi kamu akan berakhir.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Logout!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "logout.php";
        }
      });
    });
  </script>

</body>
</html>
