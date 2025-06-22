<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        </style>
</head>
<body>
     <!--navbar-->
     <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Hunian Kita</a>
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
    <!-- history pesanan -->
    <div class="container">
        <h1 class="my-4" style="padding-top: 30px;">Daftar Pesanan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Pemesanan</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No. HP</th>
                    <th scope="col">Properti</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Durasi</th>
                    <th scope="col">Total Sewa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $host       = "localhost";
                $username   = "root";
                $password   = "";
                $db         = "pemesanan";
                
                $koneksi    = mysqli_connect($host, $username, $password, $db);
                
                if (!$koneksi){
                    die("koneksi gagal:". mysqli_connect_error());
                }
                // Query untuk mengambil data pesanan
                $sql = "SELECT * FROM pemesanan";
                $result = $koneksi->query($sql);

                // Periksa apakah ada data yang ditemukan
                if ($result->num_rows > 0) {
                    // Output data dari setiap baris
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_pemesanan"] . "</td>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["no_hp"] . "</td>";
                        echo "<td>" . $row["properti"] . "</td>";
                        echo "<td>" . $row["tanggal"] . "</td>";
                        echo "<td>" . $row["durasi"] . "</td>";
                        echo "<td>Rp " . number_format($row["total_sewa"], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada pesanan yang ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
