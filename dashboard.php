<?php
session_start();
include ("database/database.php");

if (!isset($_SESSION['username'])) {
  header('location: index.php');
  exit();
}

$admin = $_SESSION['role'] === 'admin';

$limit_baris = 3;

// JUMLAH PRODUK MASUK
$sql_jumlah_masuk = "SELECT SUM(jumlah_masuk) as total_masuk FROM produk_masuk";
$result_jumlah_masuk = mysqli_query($db, $sql_jumlah_masuk);
if ($result_jumlah_masuk) {
  $jumlah = mysqli_fetch_assoc($result_jumlah_masuk);
  $jumlah_masuk = $jumlah['total_masuk'];
}

// TABEL PRODUK KELUAR
$sql_jumlah_keluar = "SELECT SUM(jumlah_keluar) AS total_keluar FROM produk_keluar;";
$result_jumlah_keluar = mysqli_query($db, $sql_jumlah_keluar);
if ($result_jumlah_keluar) {
  $jumlah_keluar = mysqli_fetch_assoc($result_jumlah_keluar);
  $tampil_keluar = $jumlah_keluar['total_keluar'];
}

// TABEL PRODUK LABA
$sql_jumlah_laba = "SELECT IFNULL(SUM((produk.harga_jual - produk.harga_beli) * produk_keluar.jumlah_keluar), 0) AS laba
                    FROM produk
                    LEFT JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk";
$result_jumlah_laba = mysqli_query($db, $sql_jumlah_laba);
if ($result_jumlah_laba) {
  $jumlah = mysqli_fetch_assoc($result_jumlah_laba);
  $jumlah_laba = $jumlah['laba'];
}

// TABEL PRODUK keluar
$sql_jumlah_keluar = "SELECT * FROM produk_keluar";
$result_jumlah_keluar = mysqli_query($db, $sql_jumlah_keluar);
$jumlah_keluar = mysqli_num_rows($result_jumlah_keluar);

// PRODUK MASUK
$sql_produk_masuk = "SELECT produk.nama_produk, produk_masuk.jumlah_masuk FROM produk_masuk INNER JOIN produk ON produk_masuk.id_produk = produk.id_produk ORDER BY produk_masuk.id_masuk DESC LIMIT $limit_baris";
$result_produk_masuk = mysqli_query($db, $sql_produk_masuk);

// PRODUK KELUAR
$sql_produk_keluar = "SELECT produk.nama_produk, produk_keluar.jumlah_keluar FROM produk_keluar INNER JOIN produk ON produk_keluar.id_produk = produk.id_produk ORDER BY produk_keluar.id_keluar DESC LIMIT $limit_baris";
$result_produk_keluar = mysqli_query($db, $sql_produk_keluar);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - <?php if($admin) {echo "Admin";} else {echo "User";}?></title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="./asset/logo-img.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  </head>
  <body>
    <div class="d-flex main">
      <aside id="sidebar" class="sidebar cards pt-2 ">
        <div class="list-group mt-3">
        <a href="" class="close-btn p-1"><i class="bi bi-x-lg text-white fs-5 mx-2"></i></a>
        <div class="d-flex mb-4 align-items-center">
          <img src="asset/logo-img.png" class="logo-image mt-4 p-1 mx-3" alt="">
          <span class="logo fs-5 position-absolute my-3" style="color: var(--icon)">Gudang Budi</span>
        </div>
        <div class="position-relative">
          <button id="arrow-button" class="arrow position-absolute border-0 shadow-lg d-flex align-items-center justify-content-center rounded-5"><i class="bi bi-arrow-right"></i></button>
        </div>
          <a href="dashboard.php" class="menu dashboard-aside text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-house-fill fs-5 mx-2"></i><span class="position-absolute">Dashboard</span></a>
          <a href="manageData.php" class="<?php if(!$admin){echo "d-none";}?> menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-dropbox fs-5 mx-2"></i><span class="position-absolute">Manage Data</span></a>
          <a class="<?php if(!$admin){echo "d-none";}?> menu nav-link position-relative text-decoration-none mt-4 p-1 mx-2 rounded text-white" data-bs-toggle="collapse" href="#kelolaProduk" role="button" aria-expanded="false" aria-controls="kelolaProduk">
          <i class="bi bi-box-seam-fill fs-5 mx-2"></i><span class="position-absolute">Kelola Stok<i class="bi ms-2 bi-caret-down-fill"></i>
          </span>
          </a>
          <div class="kelolastok-dropdown collapse" id="kelolaProduk">
            <ul class="list-unstyled d-flex align-items-center flex-column gap-2">
              <li class="d-flex align-items-center my-2"><a href="barangMasuk.php" class="menu d-flex p-1 nav-link text-white rounded"><svg class="icon-dropdown"version='1.1'id='Layer_1' xmlns='http://www.w3.org/2000/svg'xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'viewBox='0 0 122.88 94.45'style='enable-background: new 0 0 122.88 94.45'xml:space='preserve'width='20'height='20'fill='white'><g><path class='st0'd='M0,41.16h24.83v44.18H0V41.16L0,41.16z M36,11.76L71.01,0.1c0.42-0.14,0.86-0.13,1.24,0.01V0.1l35.47,12.15 c0.87,0.3,1.4,1.14,1.32,2.02c0.01,0.04,0.01,0.09,0.01,0.14v37.04l1.56-0.77c9.6-3.16,16.43,6.88,9.35,13.87 c-13.9,10.11-28.15,18.43-42.73,25.15c-10.59,6.44-21.18,6.22-31.76,0l-15.63-8.07V44.71h4.48V13.7 C34.31,12.71,35.04,11.89,36,11.76L36,11.76z M46.44,44.71c7.04,1.26,14.08,5.08,21.12,9.51h1.47V33.88L38.97,21.05v23.66H46.44 L46.44,44.71z M74.43,54.22h6.04c5.84,0.35,8.9,6.27,3.22,10.16c-2.67,1.96-5.84,2.7-9.26,2.86v4.89 C80.83,71.77,86.1,70,89.49,64.7l1.93-4.51l12.97-6.43V20.78L74.43,33.9V54.22L74.43,54.22z M69.04,67.12 c-0.65-0.05-1.31-0.1-1.96-0.16c-4.22-0.21-4.4,5.46,0,5.48c0.64,0.05,1.3,0.02,1.96-0.04v-1.5V67.12L69.04,67.12z M71.6,5.49 l-29.82,9.94l29.96,13.59l29.97-13.21L71.6,5.49L71.6,5.49z'/></g></svg><p class="submenu-dropdown m-0">Barang Masuk</p></a></li>
              <li class="d-flex align-items-center"><a href="barangKeluar.php" class="menu p-1 d-flex nav-link text-white rounded"><svg class="icon-dropdown" fill="white" width='20' height='20' xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 505 511.5"><path d="m336.11 39.84-115.38 68.94 135.38 18.4 111.32-69.44-131.32-17.9zm25.45 204.61c73.74 0 133.53 59.78 133.53 133.53 0 73.74-59.79 133.52-133.53 133.52-73.75 0-133.53-59.78-133.53-133.52 0-73.75 59.78-133.53 133.53-133.53zm-50.44 179.72 15.51-78.82 15.73 23.69c33.86-13.59 52.88-36 55.7-70.5 27.82 48.63 10.93 92.22-24.33 117.77l16.05 24.16-78.65-16.3h-.01zM204.83 126.13l-.09 141.71-51.45-35.04-51.46 29.07 6.1-148.91-88.54-12.03v312.98l178.95 23.13c2.52 7.1 5.47 13.99 8.85 20.63L9.3 432.07c-5.17-.2-9.3-4.47-9.3-9.68V89.86c.27-4.05 1.89-6.89 5.72-8.81L182.48.85c1.58-.72 3.52-1.01 5.25-.77l308.18 42.04c5.09.59 8.58 4.77 8.58 9.99v.02L505 280.9c-5.72-8.46-15.57-20.29-19.93-27.77V69.56l-115.81 74.93v59.81a174.846 174.846 0 0 0-19.39.36v-58.82l-145.04-19.71zm-81.52-30.58 112.17-69.44-47.58-6.49L44.24 84.8l79.07 10.75z"/></svg><p class="submenu-dropdown m-0">Barang Keluar</p></a></li>
            </ul>
          </div>
          <a class="menu nav-link position-relative text-decoration-none mt-4 p-1 mx-2 rounded text-white" data-bs-toggle="collapse" href="#laporan" role="button" aria-expanded="false" aria-controls="laporan">
          <i class="bi bi-file-earmark-text-fill fs-5 mx-2"></i><span class="position-absolute">Laporan<i class="bi ms-2 bi-caret-down-fill"></i>
          </span>
          </a>
          <div class="kelolastok-dropdown collapse" id="laporan">
            <ul class="list-unstyled d-flex align-items-center flex-column gap-2">
              <li class="d-flex align-items-center my-2"><a href="laporanMasuk.php" class="menu d-flex p-1 nav-link text-white rounded"><svg class="icon-dropdown"version='1.1'id='Layer_1' xmlns='http://www.w3.org/2000/svg'xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'viewBox='0 0 122.88 94.45'style='enable-background: new 0 0 122.88 94.45'xml:space='preserve'width='20'height='20'fill='white'><g><path class='st0'd='M0,41.16h24.83v44.18H0V41.16L0,41.16z M36,11.76L71.01,0.1c0.42-0.14,0.86-0.13,1.24,0.01V0.1l35.47,12.15 c0.87,0.3,1.4,1.14,1.32,2.02c0.01,0.04,0.01,0.09,0.01,0.14v37.04l1.56-0.77c9.6-3.16,16.43,6.88,9.35,13.87 c-13.9,10.11-28.15,18.43-42.73,25.15c-10.59,6.44-21.18,6.22-31.76,0l-15.63-8.07V44.71h4.48V13.7 C34.31,12.71,35.04,11.89,36,11.76L36,11.76z M46.44,44.71c7.04,1.26,14.08,5.08,21.12,9.51h1.47V33.88L38.97,21.05v23.66H46.44 L46.44,44.71z M74.43,54.22h6.04c5.84,0.35,8.9,6.27,3.22,10.16c-2.67,1.96-5.84,2.7-9.26,2.86v4.89 C80.83,71.77,86.1,70,89.49,64.7l1.93-4.51l12.97-6.43V20.78L74.43,33.9V54.22L74.43,54.22z M69.04,67.12 c-0.65-0.05-1.31-0.1-1.96-0.16c-4.22-0.21-4.4,5.46,0,5.48c0.64,0.05,1.3,0.02,1.96-0.04v-1.5V67.12L69.04,67.12z M71.6,5.49 l-29.82,9.94l29.96,13.59l29.97-13.21L71.6,5.49L71.6,5.49z'/></g></svg><p class="submenu-dropdown m-0">Laporan Masuk</p></a></li>
              <li class="d-flex align-items-center"><a href="laporanKeluar.php" class="menu p-1 d-flex nav-link text-white rounded"><svg class="icon-dropdown" fill="white" width='20' height='20' xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 505 511.5"><path d="m336.11 39.84-115.38 68.94 135.38 18.4 111.32-69.44-131.32-17.9zm25.45 204.61c73.74 0 133.53 59.78 133.53 133.53 0 73.74-59.79 133.52-133.53 133.52-73.75 0-133.53-59.78-133.53-133.52 0-73.75 59.78-133.53 133.53-133.53zm-50.44 179.72 15.51-78.82 15.73 23.69c33.86-13.59 52.88-36 55.7-70.5 27.82 48.63 10.93 92.22-24.33 117.77l16.05 24.16-78.65-16.3h-.01zM204.83 126.13l-.09 141.71-51.45-35.04-51.46 29.07 6.1-148.91-88.54-12.03v312.98l178.95 23.13c2.52 7.1 5.47 13.99 8.85 20.63L9.3 432.07c-5.17-.2-9.3-4.47-9.3-9.68V89.86c.27-4.05 1.89-6.89 5.72-8.81L182.48.85c1.58-.72 3.52-1.01 5.25-.77l308.18 42.04c5.09.59 8.58 4.77 8.58 9.99v.02L505 280.9c-5.72-8.46-15.57-20.29-19.93-27.77V69.56l-115.81 74.93v59.81a174.846 174.846 0 0 0-19.39.36v-58.82l-145.04-19.71zm-81.52-30.58 112.17-69.44-47.58-6.49L44.24 84.8l79.07 10.75z"/></svg><p class="submenu-dropdown m-0">Laporan Keluar</p></a></li>
          </ul>
          </div> 
          <a href="logout.php" class="logout d-flex align-items-center text-decoration-none text-danger position-absolute mt-4 p-1 mx-2" aria-current="true"
            ><i class="bi bi-box-arrow-in-left fs-5 mx-2"></i><span>Logout</span></a
          >
        </div>
      </aside>

      <div class="content container-fluid">
        <nav class="navbar px-4 ">
          <div class="container-fluid position-relative d-flex align-items-center">
            <div class="header d-flex align-items-center">
              <i id="hamburger-menu" class="bi bi-list mx-2" style="font-size: 2rem"></i>
              <div class="header-nav">
                <p class="fs-4 m-0 fw-semibold" >Hello, <?php if($admin) {echo "Admin!";} else {echo "User!";} ?></p>
                <p class="d-flex m-0">May your day always be right</p>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn cards border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi text-secondary bi-sun-fill"></i>
              </button>
              <ul class="dropdown-menu cards">
                <li><a id="lightmode-mobile" class="dropdown-item text-secondary" href="#"><i class="me-2 bi bi-sun-fill"></i>light</a></li>
                <li><a id="darkmode-mobile" class="dropdown-item text-secondary" href="#"><i class="me-2 bi bi-moon-stars-fill"></i>Dark</a></li>
              </ul>
            </div>
            <div class="profile cards rounded-5 p-1 d-flex justify-content-between">
              <input class="switch" type="checkbox" id="darkmode-toggle" />
              <label class="checkbox-label" for="darkmode-toggle">
                <i class="sun bi bi-sun-fill"></i>
                <i class="moon bi bi-moon-stars-fill"></i>
              </label>
              <a href="#" id="profil" class="d-flex align-items-center justify-content-center text-decoration-none"
                ><i class="bi bi-person-fill fs-5 d-flex bg-white d-flex align-items-center justify-content-center rounded-5 text-secondary"></i
              ></a>
            </div>

            <div id="popup" class="popup cards position-absolute rounded shadow-lg">
              <div class="user-profil p-4">
                <div class="user-info d-flex align-items-center justify-content-center">
                  <img src="asset/user.png" class="w-50 mb-3" alt="" />
                  <h2>Budi</h2>
                </div>
                <div class="m-auto border-bottom border-1 border-black border-dark-subtle"></div>
                <div class="user d-flex align-items-center justify-content-center my-2">
                  <span class="fs-4 "><?php if($admin) {echo "Admin";} else {echo "User";} ?></span>
                </div>
                <div class="logout-profil ">
                  <div class="m-auto border-bottom border-1 border-black border-dark-subtle"></div>
                  <div class="user d-flex align-items-center justify-content-center my-2">
                    <a href="logout.php" class="logout fs-5 text-decoration-none text-danger d-flex align-items-center"><i class="bi bi-box-arrow-in-left fs-5 mx-2"></i>Logout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>

        <div class="main-content position-absolute mt-5">
          <div class="container-fluid px-5 pt-4 py-5">
            <h2 class="mb-3">Dashboard</h2>
            <div id="setion-dashboard" class="d-flex gap-4 flex-wrap">
              <div class="info-stok d-flex gap-4 col">
                <div class="card cards shadow-sm border-0 col">
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2">Barang Masuk</h6>
                    <div class="data d-flex px-4 justify-content-between">
                      <img src="asset/open-box.png" class="object-fit-contain" style="width: 70px" />
                      <h2 class="card-title mt-3"><?=$jumlah_masuk;?></h2>
                    </div>
                  </div>
                </div>
                <div class="card cards shadow-sm border-0 col">
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2 ">Barang Keluar</h6>
                    <div class="data d-flex px-4 justify-content-between">
                      <img src="asset/return-box.png" class="object-fit-contain" style="width: 70px" />
                      <h2 class="card-title mt-3"><?= $tampil_keluar ?></h2>
                    </div>
                  </div>
                </div>
                <div class="card cards shadow-sm border-0 col">
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2 ">Laba</h6>
                    <div class="data d-flex px-4 justify-content-between">
                      <img src="asset/money.png" class="object-fit-contain" style="width: 50px">
                      <h2 class="card-title mt-3">Rp <?= number_format("$jumlah_laba", 2, ",", ".") ?></h2>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row gap-4">
                <div class="data-stok d-flex gap-4">
                  <div class="card cards shadow-sm border-0 col">
                    <div class="card-body">
                      <h5 class="card-title">Barang Masuk</h5>
                      <div class="mt-3 d-flex justify-content-between gap-3">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            while($masuk = mysqli_fetch_array($result_produk_masuk)):
                            ?>
                              <tr>
                              <th><?=$no++?></th>
                                <td><?= $masuk['nama_produk'] ?></td>
                                <td><?= $masuk['jumlah_masuk'] ?></td>
                              </tr>
                              <?php endwhile; ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

                  <div class="card cards shadow-sm border-0 col">
                    <div class="card-body">
                      <h5 class="card-title">Barang Keluar</h5>
                      <div class="mt-3 d-flex justify-content-between gap-3">
                          <table class="table table-hover rounded-2">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            while($keluar = mysqli_fetch_array($result_produk_keluar)):
                            ?>
                              <tr>
                                <th><?=$no++?></th>
                                <td><?= $keluar['nama_produk'] ?></td>
                                <td><?= $keluar['jumlah_keluar'] ?></td>
                              </tr>
                              <?php endwhile; ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="chart d-flex m-0 gap-4 col">
                  <div class="card cards d-flex align-items-center shadow-sm border-0 px-2 col">
                    <canvas id="cookieChart"></canvas>
                  </div>

                  <div class="card cards d-flex align-items-center shadow-sm border-0 px-2 col">
                    <canvas id="lineChart"></canvas>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
      var canvasElement = document.getElementById("cookieChart").getContext('2d');
      var config = {
      type: "bar",
      data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [
          {
            label: "Masuk",
            data: [<?php 
                    $barang_masuk = [
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-01%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-02%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-03%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-04%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-05%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-06%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-07%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-08%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-09%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-10%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-11%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_masuk) FROM produk_masuk WHERE created_at LIKE '2024-12%' ")),
                  ];
                  echo implode(",", $barang_masuk);
                  ?>],
          },
          {
            label: "Keluar",
            data: [<?php 
                    $barang_keluar = [
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-01%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-02%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-03%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-04%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-05%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-06%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-07%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-08%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-09%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-10%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-11%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM(jumlah_keluar) FROM produk_keluar WHERE created_at LIKE '2024-12%' ")),
                  ];
                  echo implode(",", $barang_keluar);
                  ?>],
          },
        ],
      },
      option: {
        responsive: true,
        scales: {
          x: {
            stacked: false,
          },
          y: {
            beginAtZero: true,
          },
        },
      },
    };

    new Chart(canvasElement, config);



    const ctx = document.getElementById('lineChart').getContext('2d');
    const config_line = {
    type: 'line',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"], // Label bulan
        datasets: [{
            label: 'Laba Hasil Penjualan',
            data: [<?php 
                    $barang_masuk = [
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-01%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-02%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-03%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-04%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-05%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-06%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-07%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-08%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-09%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-10%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-11%' ")),
                      mysqli_fetch_column(mysqli_query($db, "SELECT SUM((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) as laba FROM produk INNER JOIN produk_keluar ON produk_keluar.id_produk = produk.id_produk WHERE produk_keluar.created_at LIKE '2024-12%' ")),
                  ];
                  echo implode(",", $barang_masuk);
                  ?>], 
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointRadius: 4,
                  }]
            },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Values'
                    }
                }
            }
        }
    };
    const lineChart = new Chart(ctx, config_line);

    </script>
  </body>
</html>
