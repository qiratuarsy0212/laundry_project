👑 Ratu Laundry Management system 
Deskripsi
Aplikasi manajemen laundry berbasis web dengan fitur:
- Registrasi & login user
- Pemesanan layanan laundry
- Cetak struk PDF
- Admin dapat mengelola pesanan, ubah status, hapus, dan melihat laporan transaksi

 Tools yang Digunakan
- PHP 8.x
- MySQL / MariaDB
- Bootstrap 5
- SweetAlert2
- FPDF (untuk cetak PDF)
- XAMPP / Laragon (local server)

Akun Dummy
Admin
- Username: admin  
- Password: admin123  

User
- Username: user1  
- Password: user123  

Cara Menjalankan
1. Clone / download project ini.
2. Import database.sql ke MySQL (buat database db_laundry dulu).
3. Edit conn.php jika perlu (user/pass database).
4. Jalankan dengan XAMPP / Laragon (taruh folder di htdocs).
5. Akses di browser:  
   - http://localhost/laundry/login.php → Login  
   - http://localhost/laundry/admin_dashboard.php → Dashboard admin  
   - http://localhost/laundry/order.php → Pemesanan user
