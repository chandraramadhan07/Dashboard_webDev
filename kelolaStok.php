<?php
include "database/database.php";
session_start();


$sql_view_stock = "SELECT nama_produk, stok FROM produk";
$result_view_stock = mysqli_query($db, $sql_view_stock);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
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
            <h2 class="mb-3">Kelola Stok</h2>
            <div class="flex-wrap container-fluid">
              <div class="data-stok row">
                <div class="card cards shadow-sm border-0 col-md-12">
                  <div class="card-body">
                    <h5 class="card-title m-0 mb-3">Data Stock</h5>
                    <table class="table table-bordered border-secondary">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Produk</th>
                          <th>Stok</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if (mysqli_num_rows($result_view_stock) > 0) {
                          $no = 1;
                          while($data = mysqli_fetch_array($result_view_stock)){

                        echo "<tr>";
                          echo "<th>".$no++."</th>";
                          echo "<td>".$data['nama_produk']."</td>";
                          echo "<td>".$data['stok']."</td>";
                          echo "<td>";
                            echo "<div class='d-flex gap-2'>
                              <a href='' data-bs-toggle='modal' data-bs-target='#masuk' class='fs-5 text-white d-flex align-items-center justify-content-center bg-white rounded' style='width: 30px; height: 30px'
                                ><svg
                                  version='1.1'
                                  id='Layer_1'
                                  xmlns='http://www.w3.org/2000/svg'
                                  xmlns:xlink='http://www.w3.org/1999/xlink'
                                  x='0px'
                                  y='0px'
                                  viewBox='0 0 122.88 94.45'
                                  style='enable-background: new 0 0 122.88 94.45'
                                  xml:space='preserve'
                                  width='22'
                                  height='22'
                                >
                                  <style type='text/css'></style>
                                  <g>
                                    <path
                                      class='st0'
                                      d='M0,41.16h24.83v44.18H0V41.16L0,41.16z M36,11.76L71.01,0.1c0.42-0.14,0.86-0.13,1.24,0.01V0.1l35.47,12.15 c0.87,0.3,1.4,1.14,1.32,2.02c0.01,0.04,0.01,0.09,0.01,0.14v37.04l1.56-0.77c9.6-3.16,16.43,6.88,9.35,13.87 c-13.9,10.11-28.15,18.43-42.73,25.15c-10.59,6.44-21.18,6.22-31.76,0l-15.63-8.07V44.71h4.48V13.7 C34.31,12.71,35.04,11.89,36,11.76L36,11.76z M46.44,44.71c7.04,1.26,14.08,5.08,21.12,9.51h1.47V33.88L38.97,21.05v23.66H46.44 L46.44,44.71z M74.43,54.22h6.04c5.84,0.35,8.9,6.27,3.22,10.16c-2.67,1.96-5.84,2.7-9.26,2.86v4.89 C80.83,71.77,86.1,70,89.49,64.7l1.93-4.51l12.97-6.43V20.78L74.43,33.9V54.22L74.43,54.22z M69.04,67.12 c-0.65-0.05-1.31-0.1-1.96-0.16c-4.22-0.21-4.4,5.46,0,5.48c0.64,0.05,1.3,0.02,1.96-0.04v-1.5V67.12L69.04,67.12z M71.6,5.49 l-29.82,9.94l29.96,13.59l29.97-13.21L71.6,5.49L71.6,5.49z'
                                    />
                                  </g></svg
                              ></a>";
                              echo "<a href='' data-bs-toggle='modal' data-bs-target='#keluar' class='fs-5 text-white d-flex align-items-center justify-content-center bg-danger rounded' style='width: 30px; height: 30px'
                                ><svg
                                  xmlns='http://www.w3.org/2000/svg'
                                  shape-rendering='geometricPrecision'
                                  text-rendering='geometricPrecision'
                                  image-rendering='optimizeQuality'
                                  fill-rule='evenodd'
                                  clip-rule='evenodd'
                                  viewBox='0 0 505 511.5'
                                  width='22'
                                  height='22'
                                  fill='white'
                                >
                                  <path
                                    d='m336.11 39.84-115.38 68.94 135.38 18.4 111.32-69.44-131.32-17.9zm25.45 204.61c73.74 0 133.53 59.78 133.53 133.53 0 73.74-59.79 133.52-133.53 133.52-73.75 0-133.53-59.78-133.53-133.52 0-73.75 59.78-133.53 133.53-133.53zm-50.44 179.72 15.51-78.82 15.73 23.69c33.86-13.59 52.88-36 55.7-70.5 27.82 48.63 10.93 92.22-24.33 117.77l16.05 24.16-78.65-16.3h-.01zM204.83 126.13l-.09 141.71-51.45-35.04-51.46 29.07 6.1-148.91-88.54-12.03v312.98l178.95 23.13c2.52 7.1 5.47 13.99 8.85 20.63L9.3 432.07c-5.17-.2-9.3-4.47-9.3-9.68V89.86c.27-4.05 1.89-6.89 5.72-8.81L182.48.85c1.58-.72 3.52-1.01 5.25-.77l308.18 42.04c5.09.59 8.58 4.77 8.58 9.99v.02L505 280.9c-5.72-8.46-15.57-20.29-19.93-27.77V69.56l-115.81 74.93v59.81a174.846 174.846 0 0 0-19.39.36v-58.82l-145.04-19.71zm-81.52-30.58 112.17-69.44-47.58-6.49L44.24 84.8l79.07 10.75z'
                                  /></svg
                              ></a>";
                          }
                        }
                              ?>
                            </div>
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                    <div class="change-page d-flex gap-2 align-items-center justify-content-center">
                      <a href="" class="p-1 d-flex align-items-center justify-content-center fw-semibold bg-primary text-decoration-none text-dark rounded" style="width: 35px; height: 35px">1</a>
                      <a href="" class="p-1 d-flex align-items-center justify-content-center fw-semibold text-decoration-none text-dark rounded" style="width: 35px; height: 35px; background-color: var(--hover)">2</a>
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

  <!-- Modal -->
  <div class="modal fade" id="masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Barang Masuk</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="w-100 h-50 p-4 d-flex flex-column rounded-3 justify-content-center">
            <div class="mb-3">
              <select name="" id="" class="form-control">
                <option value="">-- Pilih Barang --</option>
                <option value="">Barang 1</option>
                <option value="">Barang 2</option>
                <option value="">Barang 3</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="number" placeholder="Jumlah" class="form-control" id="" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="keluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Barang Keluar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="w-100 h-50 p-4 d-flex flex-column rounded-3 justify-content-center">
            <div class="mb-3">
              <select name="" id="" class="form-control">
                <option value="">-- Pilih Barang --</option>
                <option value="">Barang 1</option>
                <option value="">Barang 2</option>
                <option value="">Barang 3</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="number" placeholder="Jumlah" class="form-control" id="" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</html>
