<?php
include "database/database.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  </head>
  <body>
    <div class="d-flex main">
      <aside id="sidebar" class="sidebar position-relative pt-2 rounded-end-4">
        <div class="d-flex align-items-center justify-content-center">
          <span class="d-flex align-items-center justify-content-center my-3" style="color: var(--icon)">Logo</span>
        </div>
        <!-- <div class="m-auto border-bottom w-75 border-secondary"></div> -->
        <button id="arrow-button" class="arrow position-absolute border-0 shadow-lg d-flex align-items-center justify-content-center rounded-5"><i class="bi bi-arrow-right"></i></button>
        <div class="list-group mt-3">
          <a href="dashboard.php" class="menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-house-fill fs-5 mx-2"></i><span class="position-absolute">Dashboard</span></a>
          <a href="manageData.php" class="menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-dropbox fs-5 mx-2"></i><span class="position-absolute">Manage Data</span></a>
          <a href="kelolaStok.php" class="menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-box-seam-fill fs-5 mx-2"></i><span class="position-absolute">Kelola Stok</span></a>
          <a href="laporan.php" class="menu text-decoration-none mt-4 p-1 mx-2 rounded" aria-current="true"><i class="bi bi-file-earmark-text-fill fs-5 mx-2"></i><span class="position-absolute">Laporan</span></a>
          <a href="logout.php" class="logout d-flex align-items-center text-decoration-none text-danger position-absolute mt-4 p-1 mx-2" aria-current="true"
            ><i class="bi bi-box-arrow-in-left fs-5 mx-2"></i><span class="=position-absolute">Logout</span></a
          >
        </div>
      </aside>

      <div class="content container-fluid">
        <nav class="navbar px-4 navbar-expand-lg">
          <div class="container-fluid position-relative d-flex align-items-center">
            <div class="header">
              <a class="navbar-brand fw-semibold" href="#">Hallo, Admin!</a>
              <p class="d-flex">May your day always be right</p>
            </div>
            <div class="profile rounded-5 p-1 d-flex justify-content-between">
              <input class="switch" type="checkbox" id="darkmode-toggle" />
              <label class="checkbox-label" for="darkmode-toggle">
                <i class="bi bi-sun-fill rounded-5"></i>
                <i class="bi bi-moon-stars-fill rounded-5"></i>
              </label>
              <a href="#" id="profil" class="d-flex align-items-center justify-content-center rounded-5 text-decoration-none"
                ><i class="bi bi-person-fill fs-5 d-flex bg-white d-flex align-items-center justify-content-center rounded-end-4 rounded-start-4 text-secondary"></i
              ></a>
            </div>

            <div id="popup" class="popup position-absolute rounded shadow-lg">
              <div class="user-profil p-4">
                <div class="user-info d-flex align-items-center justify-content-center">
                  <img src="asset/user.png" class="w-50 mb-3" alt="" />
                  <h2>Budi</h2>
                </div>
                <div class="m-auto border-bottom border-1 border-black border-dark-subtle w-75"></div>
              </div>
            </div>
          </div>
        </nav>

        <div class="main-content position-absolute mt-5">
          <div class="container-fluid px-5 pt-4 py-5">
            <h2 class="mb-3">Dashboard</h2>
            <div class="row gap-4 m-auto flex-wrap container-fluid">
              <div class="info-stok d-flex gap-4">
                <div class="card cards bg-secondari-teritary shadow-sm border-0 col-4">
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-body-secondary">Barang Masuk</h6>
                    <div class="data d-flex justify-content-between">
                      <img src="asset/open-box.png" class="object-fit-contain" style="width: 70px" />
                      <h2 class="card-title mt-3">100</h2>
                    </div>
                  </div>
                </div>
                <div class="card cards bg-secondari-teritary shadow-sm border-0 col-4">
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-body-secondary">Barang Keluar</h6>
                    <div class="data d-flex justify-content-between">
                      <img src="asset/return-box.png" class="object-fit-contain" style="width: 70px" />
                      <h2 class="card-title mt-3">100</h2>
                    </div>
                  </div>
                </div>
              </div>

              <div class="data-stok d-flex gap-4">
                <div class="card cards bg-secondari-teritary shadow-sm border-0 col">
                  <div class="card-body">
                    <h5 class="card-title">Barang Masuk</h5>
                    <div class="mt-3 d-flex justify-content-between gap-3">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th>1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                          </tr>
                          <tr>
                            <th>2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                          </tr>
                          <tr>
                            <th>3</th>
                            <td>Larry the Bird</td>
                            <td>Larry the Bird</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card cards bg-secondari-teritary shadow-sm border-0 col">
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
                          <tr>
                            <th>1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                          </tr>
                          <tr>
                            <th>2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                          </tr>
                          <tr>
                            <th>3</th>
                            <td>Larry the Bird</td>
                            <td>Larry the Bird</td>
                          </tr>
                        </tbody>
                      </table>
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
