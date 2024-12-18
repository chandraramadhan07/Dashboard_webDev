<?php
session_start();
include "database/database.php";
include "php/paggination.php";

if (!isset($_SESSION['username'])) {
  header('location: index.php');
  exit();
}

$admin = $_SESSION['role'] === 'admin';

// SELECT & SEARCH FUNCTION

if(!isset($_GET['search'])) {
  $sql_laporan = "SELECT 
                  produk.id_produk, 
                  produk.nama_produk,  
                  produk.stok, 
                  produk.harga_beli, 
                  produk.harga_jual,
                  (produk.harga_jual - produk.harga_beli) AS laba,
                  ((produk.harga_jual - produk.harga_beli) * produk_keluar.jumlah_keluar) AS laba_penjualan,
                  kategori.nama_kategori,
                  produk_keluar.jumlah_keluar,
                  produk_keluar.created_at AS tanggal_keluar
                  FROM produk_keluar
                  LEFT JOIN produk ON produk.id_produk = produk_keluar.id_produk
                  LEFT JOIN kategori ON produk.kategori = kategori.id_kategori
                  ORDER BY produk_keluar.created_at DESC";
$result_laporan = mysqli_query($db, $sql_laporan);
} else {
  $filter_search = $_GET['search'];
  $sql_laporan_search = "SELECT 
                         produk.id_produk, 
                         produk.nama_produk, 
                         produk.stok, 
                         produk.harga_beli, 
                         produk.harga_jual,
                         (produk.harga_jual - produk.harga_beli) AS laba,
                         ((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) AS laba_penjualan,
                         kategori.nama_kategori, 
                         produk_keluar.jumlah_keluar,
                         produk_keluar.created_at AS tanggal_keluar
                         FROM produk_keluar
                         INNER JOIN produk ON produk.id_produk = produk_keluar.id_produk
                         INNER JOIN kategori ON produk.kategori = kategori.id_kategori
                         WHERE produk.nama_produk LIKE '%$filter_search%'
                         ORDER BY produk_keluar.created_at DESC";
 $result_laporan = mysqli_query($db, $sql_laporan_search);

}

// FILTER BULAN
if(isset($_GET['bulan'])) {
$sql_laporan_bulan = "SELECT 
                       produk.id_produk, 
                       produk.nama_produk, 
                       produk.stok, 
                       produk.harga_beli, 
                       produk.harga_jual,
                       (produk.harga_jual - produk.harga_beli) AS laba,
                       ((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) AS laba_penjualan,
                       kategori.nama_kategori, 
                       produk_keluar.jumlah_keluar,
                       produk_keluar.created_at AS tanggal_keluar
                       FROM produk_keluar
                       INNER JOIN produk ON produk.id_produk = produk_keluar.id_produk
                       INNER JOIN kategori ON produk.kategori = kategori.id_kategori
                       WHERE MONTH(produk_keluar.created_at) = '$_GET[bulan]'";
$result_laporan = mysqli_query($db, $sql_laporan_bulan);
}

if(isset($_GET['reset'])) {
  header('location: laporanKeluar.php');
}

// FILTER DATA BY BULAN
// if(isset($_GET['filter'])) {
//   $sql_laporan_bulan = "SELECT 
//                          produk.id_produk, 
//                          produk.nama_produk, 
//                          produk.stok, 
//                          produk.harga_beli, 
//                          produk.harga_jual,
//                          (produk.harga_jual - produk.harga_beli) AS laba,
//                          ((produk.harga_jual - produk.harga_beli)*produk_keluar.jumlah_keluar) AS laba_penjualan,
//                          kategori.nama_kategori, 
//                          produk_keluar.jumlah_keluar,
//                          produk_keluar.created_at AS tanggal_keluar
//                          FROM produk_keluar
//                          INNER JOIN produk ON produk.id_produk = produk_keluar.id_produk
//                          INNER JOIN kategori ON produk.kategori = kategori.id_kategori
//                          WHERE MONTH(produk_keluar.created_at) ='%$filter_bulan%'
//                          ORDER BY produk_keluar.created_at DESC";
//  $result_laporan = mysqli_query($db, $sql_laporan_bulan);
// }


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
          <a href="dashboard.php" class="menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-house-fill fs-5 mx-2"></i><span class="position-absolute">Dashboard</span></a>
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
          <a class="menu laporan-aside nav-link position-relative text-decoration-none mt-4 p-1 mx-2 rounded text-white" data-bs-toggle="collapse" href="#laporan" role="button" aria-expanded="false" aria-controls="laporan">
          <i class="bi bi-file-earmark-text-fill fs-5 mx-2"></i><span class="position-absolute">Laporan<i class="bi ms-2 bi-caret-down-fill"></i>
          </span>
          </a>
          <div class="kelolastok-dropdown collapse" id="laporan">
            <ul class="list-unstyled d-flex align-items-center flex-column gap-2">
              <li class="d-flex align-items-center my-2"><a href="laporanMasuk.php" class="menu d-flex p-1 nav-link text-white rounded"><svg class="icon-dropdown"version='1.1'id='Layer_1' xmlns='http://www.w3.org/2000/svg'xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'viewBox='0 0 122.88 94.45'style='enable-background: new 0 0 122.88 94.45'xml:space='preserve'width='20'height='20'fill='white'><g><path class='st0'd='M0,41.16h24.83v44.18H0V41.16L0,41.16z M36,11.76L71.01,0.1c0.42-0.14,0.86-0.13,1.24,0.01V0.1l35.47,12.15 c0.87,0.3,1.4,1.14,1.32,2.02c0.01,0.04,0.01,0.09,0.01,0.14v37.04l1.56-0.77c9.6-3.16,16.43,6.88,9.35,13.87 c-13.9,10.11-28.15,18.43-42.73,25.15c-10.59,6.44-21.18,6.22-31.76,0l-15.63-8.07V44.71h4.48V13.7 C34.31,12.71,35.04,11.89,36,11.76L36,11.76z M46.44,44.71c7.04,1.26,14.08,5.08,21.12,9.51h1.47V33.88L38.97,21.05v23.66H46.44 L46.44,44.71z M74.43,54.22h6.04c5.84,0.35,8.9,6.27,3.22,10.16c-2.67,1.96-5.84,2.7-9.26,2.86v4.89 C80.83,71.77,86.1,70,89.49,64.7l1.93-4.51l12.97-6.43V20.78L74.43,33.9V54.22L74.43,54.22z M69.04,67.12 c-0.65-0.05-1.31-0.1-1.96-0.16c-4.22-0.21-4.4,5.46,0,5.48c0.64,0.05,1.3,0.02,1.96-0.04v-1.5V67.12L69.04,67.12z M71.6,5.49 l-29.82,9.94l29.96,13.59l29.97-13.21L71.6,5.49L71.6,5.49z'/></g></svg><p class="submenu-dropdown m-0">Laporan Masuk</p></a></li>
              <li class="d-flex align-items-center"><a href="laporanKeluar.php" class="menu laporanKeluar-aside p-1 d-flex nav-link text-white rounded"><svg class="icon-dropdown" fill="white" width='20' height='20' xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 505 511.5"><path d="m336.11 39.84-115.38 68.94 135.38 18.4 111.32-69.44-131.32-17.9zm25.45 204.61c73.74 0 133.53 59.78 133.53 133.53 0 73.74-59.79 133.52-133.53 133.52-73.75 0-133.53-59.78-133.53-133.52 0-73.75 59.78-133.53 133.53-133.53zm-50.44 179.72 15.51-78.82 15.73 23.69c33.86-13.59 52.88-36 55.7-70.5 27.82 48.63 10.93 92.22-24.33 117.77l16.05 24.16-78.65-16.3h-.01zM204.83 126.13l-.09 141.71-51.45-35.04-51.46 29.07 6.1-148.91-88.54-12.03v312.98l178.95 23.13c2.52 7.1 5.47 13.99 8.85 20.63L9.3 432.07c-5.17-.2-9.3-4.47-9.3-9.68V89.86c.27-4.05 1.89-6.89 5.72-8.81L182.48.85c1.58-.72 3.52-1.01 5.25-.77l308.18 42.04c5.09.59 8.58 4.77 8.58 9.99v.02L505 280.9c-5.72-8.46-15.57-20.29-19.93-27.77V69.56l-115.81 74.93v59.81a174.846 174.846 0 0 0-19.39.36v-58.82l-145.04-19.71zm-81.52-30.58 112.17-69.44-47.58-6.49L44.24 84.8l79.07 10.75z"/></svg><p class="submenu-dropdown m-0">Laporan Keluar</p></a></li>
        </ul>
          </div> 
          <a href="logout.php" class="logout d-flex align-items-center text-decoration-none text-danger position-absolute mt-4 p-1 mx-2" aria-current="true"
            ><i class="bi bi-box-arrow-in-left fs-5 mx-2"></i><span>Logout</span></a
          >
        </div>
      </aside>

      <div class="content container-fluid">
        <nav class="navbar px-4 navbar-expand-lg">
          <div class="container-fluid position-relative d-flex align-items-center">
          <div class="header d-flex align-items-center ">
              <i id="hamburger-menu" class="bi bi-list mx-2" style="font-size: 2rem"></i>
              <div class="header-nav">
              <p class="fs-4 m-0 text-decoration-none fw-semibold" >Hello, <?php if($admin) {echo "Admin!";} else {echo "User!";}?></p>
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
                  <span class="fs-4 "><?php if($admin) {echo "Admin";} else {echo "User";}?></span>
                </div>
                <div class="logout-profil ">
                  <div class="m-auto border-bottom border-1 border-black border-dark-subtle"></div>
                  <div class="user d-flex align-items-center justify-content-center my-2">
                    <a href="logout.php" class="fs-5 text-decoration-none text-danger d-flex align-items-center"><i class="bi bi-box-arrow-in-left fs-5 mx-2"></i>Logout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>

        <div class="main-content position-absolute mt-5">
          <div class="container-fluid px-5 pt-4 py-5">
            <div class="= d-flex justify-content-between mb-3">
            <h2 class="mb-3">Laporan Barang Keluar</h2>

            <div class="filter d-flex">
                <form method="GET" class="d-flex" role="search">
                    <div class="input-group" style="height: 7px">
                        <input type="text" name="search" value="<?php if (isset($_GET['search'])) {echo $_GET['search'];} ?>" class="search form-control rounded-start-5 border-0" placeholder="Search by name" aria-label="Search" aria-describedby="search-icon">
                        <span class="search input-group-text rounded-end-5 border-0" id="search-icon">
                        <button type="submit" class="border-0 btn-search"><i class=" bi bi-search"></i></button>
                        </span>
                    </div>
                </form>
                <form>
                    <div class="mb-3">
                      <div class="d-flex align-items-center justify-content-center">
                        <form method="GET">
                          <select name="bulan" class="form-select ms-2">
                            <option selected>Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                          </select>
                          <button class="border-0 ms-2 rounded" type="submit">Filter</button>
                          <button name="reset">Reset</button>
                      </form>
                      </div>
                    </div>
                </form>
            </div>

            </div>
            <div class="flex-wrap container-fluid">
              <div class="data-stok row">
                <div class="card pt-5 cards shadow-sm border-0 col-md-12">
                  <div class="overflow-x-auto card-body">
                    <div class="table-responsive">
                    <table id="" class="table table-hover border-secondary px-2">
                      <thead>
                        <tr>
                          <th style="width: 30px;">No</th>
                          <th>ID Produk</th>
                          <th>Nama Produk</th>
                          <th>Kategori</th>
                          <th>Harga Beli</th>
                          <th>Harga Jual</th>
                          <th>Laba per Barang</th>
                          <th>Jumlah Keluar</th>
                          <th>Laba Penjualan</th>
                          <th>Tanggal Keluar</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $no =1;
                      while ($data = mysqli_fetch_assoc($result_laporan)):
                      ?>
                        <tr>
                          <td><?=$no++?></td>
                          <td><?=$data['id_produk'];?></td>
                          <td><?=$data['nama_produk'];?></td>
                          <td><?=$data['nama_kategori'];?></td>
                          <td>Rp <?=number_format($data['harga_beli'], 2, ",", ".");?></td>
                          <td>Rp <?=number_format($data['harga_jual'], 2, ",", ".");?></td>
                          <td>Rp <?=number_format($data['laba'], 2, ",", ".");?></td>
                          <td><?=$data['jumlah_keluar'];?></td>
                          <td>Rp <?=number_format($data['laba_penjualan'], 2, ",", ".");?></td>
                          <td><?=date('d F Y', strtotime($data['tanggal_keluar']));?></td>
                        </tr>
                      </tbody>
                      <?php endwhile; ?>
                    </table>
                    </div>
                    <div class="btn-download d-flex align-items-center justify-content-center">
                        <a href="" class="fs-4 text-white bg-primary px-4 rounded text-center"><i class="bi bi-cloud-arrow-down"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
  </body>
</html>
