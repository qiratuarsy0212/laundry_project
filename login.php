<?php
session_start();

// Kalau tombol login ditekan
if (isset($_POST['login'])) {
    // Simpan data user ke session (dummy)
    $_SESSION['user_id'] = 1; 
    $_SESSION['role'] = 'user';

    // Arahkan langsung ke halaman pemesanan
    header("Location: order.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Ratu Laundry</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: url('logindante.png') no-repeat right center;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: flex-start;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 15px;
      margin-left: 80px;
      width: 300px;
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
    }
    .login-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .login-box button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background: #2c3e50;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
    .login-box button:hover {
      background: #1a242f;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>LOGIN</h2>
    <form action="" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</body>
</html>
