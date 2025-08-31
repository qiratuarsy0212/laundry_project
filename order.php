<?php
session_start();
require("conn.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service_name = $_POST['service'];
    $price        = $_POST['price'];
    $user_id      = $_SESSION['user_id'];

    
    $stmt = $koneksi->prepare("SELECT id FROM services WHERE service_name = ?");
    $stmt->bind_param("s", $service_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();

    if ($service) {
        $service_id = $service['id'];

        
        $stmt = $koneksi->prepare("INSERT INTO orders (user_id, service_id, price, order_date, status) VALUES (?, ?, ?, NOW(), 'pending')");
        $stmt->bind_param("iii", $user_id, $service_id, $price);
        $stmt->execute();

        
        $_SESSION['last_order'] = [
            "service" => $service_name,
            "price"   => $price,
            "date"    => date("d-m-Y H:i:s")
        ];

        header("Location: struk.php");
        exit;
    } else {
        echo "<script>alert('Layanan tidak ditemukan di database!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pemesanan Laundry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('pesan.jpg') no-repeat center top;
      background-size: cover;
    }

    
    .navbar {
      backdrop-filter: blur(10px);
      background: rgba(255,255,255,0.6);
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
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

    
    @keyframes fadeInUp {
      0% {opacity: 0; transform: translateY(30px);}
      100% {opacity: 1; transform: translateY(0);}
    }
    @keyframes slideDown {
      0% {opacity: 0; transform: translateY(-40px);}
      100% {opacity: 1; transform: translateY(0);}
    }

    .page-title {
      text-align: center;
      font-size: 28px;
      font-weight: 700;
      color: #2c3e50;
      margin-top: 40px;
      margin-bottom: 30px;
      opacity: 0;
      animation: slideDown 0.8s ease forwards;
    }

    .page-title::after {
      content: "";
      display: block;
      width: 100px;
      height: 4px;
      background: #2c3e50;
      margin: 10px auto 0;
      border-radius: 4px;
    }

    .service-card {
      background: #fff;
      border: 2px solid #2c3e50;
      border-radius: 14px;
      box-shadow: 0px 5px 12px rgba(0,0,0,0.15);
      padding: 20px;
      text-align: center;
      width: 230px;
      margin: auto;
      transition: all 0.25s ease;
      opacity: 0;
      animation: fadeInUp 0.9s ease forwards;
    }
    .service-card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    }

    .service-card img {
      width: 160px;
      height: 160px;
      object-fit: contain;
      margin-bottom: 12px;
    }

    .service-card h5 {
      font-size: 16px;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .service-card button {
      width: 100%;
      border-radius: 8px;
      font-weight: bold;
      font-size: 13px;
      padding: 8px;
    }
  </style>
</head>
<body>


  <nav class="navbar px-4">
    <a class="navbar-brand" href="#">👑 Ratu Laundry</a>
    <div class="ms-auto">
      <button class="btn btn-danger logout-btn" id="logoutBtn">Logout</button>
    </div>
  </nav>

  
  <div class="text-center">
    <div class="page-title">Silahkan Pilih Jenis Pesanan Anda</div>
  </div>

  <div class="container mb-5">
    <div class="row justify-content-center g-4">

      
      <div class="col-md-3">
        <form method="POST">
          <div class="service-card">
            <img src="lipatstrika.png" alt="Lipat + Setrika">
            <h5>Lipat + Setrika</h5>
            <input type="hidden" name="service" value="Lipat + Setrika">
            <input type="hidden" name="price" value="15000">
            <button type="submit" class="btn btn-primary">Rp 15.000/kg</button>
          </div>
        </form>
      </div>

      
      <div class="col-md-3">
        <form method="POST">
          <div class="service-card">
            <img src="cucikring.png" alt="Cuci Kering">
            <h5>Cuci Kering</h5>
            <input type="hidden" name="service" value="Cuci Kering">
            <input type="hidden" name="price" value="5000">
            <button type="submit" class="btn btn-primary">Rp 5.000/kg</button>
          </div>
        </form>
      </div>

      
      <div class="col-md-3">
        <form method="POST">
          <div class="service-card">
            <img src="kilat.png" alt="Laundry Kilat">
            <h5>Laundry Kilat</h5>
            <input type="hidden" name="service" value="Laundry Kilat">
            <input type="hidden" name="price" value="20500">
            <button type="submit" class="btn btn-primary">Rp 20.500/kg</button>
          </div>
        </form>
      </div>

    </div>
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
