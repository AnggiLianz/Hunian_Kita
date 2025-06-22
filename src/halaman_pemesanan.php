<?php
// Verifikasi apakah form sudah disubmit atau belum
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host       = "localhost";
    $username   = "root";
    $password   = "";
    $db         = "pemesanan";

    $koneksi    = mysqli_connect($host, $username, $password, $db);

    if (!$koneksi){
        die("koneksi gagal:". mysqli_connect_error());
    }

    $nama              = $_POST['nama'];
    $email             = $_POST['email'];
    $no_hp             = $_POST['no_hp'];
    $properti          = $_POST['properti']; 
    $tanggal           = $_POST['tanggal'];
    $durasi            = $_POST['durasi'];

    // Fungsi untuk menghitung total harga sewa
    function hitungTotalSewa($properti, $durasi) {
        $hargaSewa = [
            "kamar" => 500000,
            "pavilion" => 1000000,
            "rumah" => 2000000,
            "kios" => 1500000,
            "ruko" => 2500000
        ];

        if (array_key_exists($properti, $hargaSewa)) {
            return $durasi * $hargaSewa[$properti];
        } else {
            return "Tipe properti tidak valid.";
        }
    }

   $total_sewa_display = ""; 
    if (isset($_POST['submit']) && $_POST['submit'] == 'Hitung Total Sewa') {
        $total_sewa = hitungTotalSewa($properti, $durasi);
        $total_sewa_display = "<div class='d-flex justify-content-center mt-4'>
    <div class='card shadow-sm border-0' style='max-width: 500px; width: 100%; background-color:rgb(212, 240, 254);'>
        <div class='card-body'>
            <h6 class='text-muted mb-2'>Total harga sewa:</h6>
            <h5 class='fw-bold text-primary'>Rp" . number_format($total_sewa, 0, ',', '.') . "</h5>
        </div>
    </div>
</div>";
    } elseif (isset($_POST['submit']) && $_POST['submit'] == 'pesan') {
        // Query untuk menyimpan data ke dalam database
        $total_sewa = hitungTotalSewa($properti, $durasi);
        $sql = "INSERT INTO pemesanan (nama, email, no_hp, properti, tanggal, durasi, total_sewa)
                VALUES ('$nama', '$email', '$no_hp', '$properti', '$tanggal', '$durasi', '$total_sewa')";

        if ($koneksi->query($sql) === TRUE) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil!',
                        text: 'Pesanan kamu sudah disimpan.',
                        confirmButtonColor: '#3085d6'
                    });
                });
            </script>";
            $_POST = array();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }

    $koneksi->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .navbar {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 0;
        }

        .navbar .nav-link.active,
        .navbar .navbar-brand {
            color: white;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .collapse.navbar-collapse {
            justify-content: flex-end;
        }

        .fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease-in-out;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container-form {
            max-width: 800px;
            margin: auto auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        
    </style>
</head>
<body>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="../index.html">Hunian Kita</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="halaman_pemesanan.php">Pemesanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="halaman_history.php">Daftar Pesanan</a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <!-- form pemesanan menggunakan container dan form group -->
      <div class="container-form">
        <h1 style="padding-bottom: 30px; padding-top: 20px;"><strong>Pemesanan</strong></h1>
        <form action="" method="post">

        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" id="nama" placeholder="Masukkan Nama Lengkap" required value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Masukkan Email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="no_hp">No. HP:</label>
            <input type="tel" name="no_hp" id="no_hp" placeholder="Nomor Handphone" required value="<?php echo isset($_POST['no_hp']) ? $_POST['no_hp'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="properti">Properti:</label>
            <select class="form-select" aria-label="Default select example" name="properti" required>
                <option value="" selected>Pilih Properti:</option>
                <option value="kamar" <?php echo (isset($_POST['properti']) && $_POST['properti'] == 'kamar') ? 'selected' : ''; ?>>Kamar</option>
                <option value="pavilion" <?php echo (isset($_POST['properti']) && $_POST['properti'] == 'pavilion') ? 'selected' : ''; ?>>Pavilion</option>
                <option value="rumah" <?php echo (isset($_POST['properti']) && $_POST['properti'] == 'rumah') ? 'selected' : ''; ?>>Rumah</option>
                <option value="kios" <?php echo (isset($_POST['properti']) && $_POST['properti'] == 'kios') ? 'selected' : ''; ?>>Kios</option>
                <option value="ruko" <?php echo (isset($_POST['properti']) && $_POST['properti'] == 'ruko') ? 'selected' : ''; ?>>Ruko</option>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" required value="<?php echo isset($_POST['tanggal']) ? $_POST['tanggal'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="durasi">Durasi (bulan):</label>
            <input type="number" name="durasi" id="durasi" required value="<?php echo isset($_POST['durasi']) ? $_POST['durasi'] : ''; ?>">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Hitung Total Sewa">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" id="submit" value="pesan">
        </div>
        <?php if (!empty($total_sewa_display)) echo $total_sewa_display; ?>
    </form>

        <?php
        
        ?>
    </div>
    </div>

    <footer class="bg-dark text-white py-3">
        <div class="container">
            <center>Anggita Ardilianz Faticha - 1938315860-5</center>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
