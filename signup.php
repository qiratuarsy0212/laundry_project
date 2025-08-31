<?php
include "conn.php";

if (isset($_POST['signup'])) {
    $name  = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $pass  = md5($_POST['password']); 

    
    $check = $koneksi->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
        if ($koneksi->query($query) === TRUE) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Gagal daftar: " . $koneksi->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - Ratu Laundry</title>
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
    .signup-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 15px;
      margin-left: 80px;
      width: 320px;
    }
    .signup-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .signup-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    .signup-box button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background: #2c3e50;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
    .signup-box button:hover {
      background: #1a242f;
    }
    .error { color: red; text-align: center; }
    .success { color: green; text-align: center; }
  </style>
</head>
<body>
  <div class="signup-box">
    <h2>SIGN UP</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="POST">
      <input type="text" name="name" placeholder="Nama" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="signup">Daftar</button>
    </form>
    <p style="text-align:center; margin-top:10px;">
      Sudah punya akun? <a href="login.php">Login</a>
    </p>
  </div>
</body>
</html>
