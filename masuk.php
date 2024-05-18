<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ikan Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">ADMIN</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Ikan
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ikan Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ikan Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Ikan Masuk</h1>

                        <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Ikan
                            </button>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Qty</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--menampilkan data-->
                                    <?php
                                        $ambilsemuadatastock = mysqli_query($conn,"select * from masuk m, stock s where s.idikan = m.idikan");
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idi = $data['idikan'];
                                            $idm = $data['idmasuk'];
                                            $tanggal = $data['tanggal'];
                                            $jenisikan = $data['jenisikan'];
                                            $qty = $data['qty'];
                                            $keterangan = $data['keterangan'];
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$jenisikan;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idm;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idm;?>">
                                                Delete
                                            </button>
                                            </td>
                                        </tr>
                                        <!-- edit Modal -->
                                        <div class="modal" id="edit<?=$idm;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Ikan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                        <input type="number" name="qty" value="<?=$qty?>" class="form-control" required><br>
                                                        <input type="text" name="keterangan" value="<?=$keterangan?>" class="form-control" required><br>
                                                        <input type="hidden" name="idi" value="<?=$idi;?>">
                                                        <input type="hidden" name="idm" value="<?=$idm;?>">
                                                        <button type="submit" class="btn btn-primary" name="updateikanmasuk">Submit</button>
                                                        </div>
                                                    </form>

                                                </div>
                                             </div>
                                        </div>

                                        
                                        <!-- delete Modal -->
                                        <div class="modal" id="delete<?=$idm;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Ikan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <?=$jenisikan;?>?
                                                            <input type="hidden" name="idi" value="<?=$idi;?>">
                                                            <input type="hidden" name="kty" value="<?=$qty;?>">
                                                            <input type="hidden" name="idm" value="<?=$idm;?>">
                                                            <br>
                                                            <br>
                                                        <button type="submit" class="btn btn-danger" name="deleteikanmasuk">Hapus</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                        <?php
                                        };
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Ikan Masuk</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <form method="post">
        <div class="modal-body">

        <select name="ikannya"  class="form-control">
            <?php
                $ambilsemuadata = mysqli_query($conn,"select * from stock");
                while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                    $jenisikannya = $fetcharray['jenisikan'];
                    $idikannya = $fetcharray['idikan'];
        ?>
        <option value="<?=$idikannya;?>"><?=$jenisikannya;?></option>

        <?php
                }
            ?>
        </select>
        <br>
        <input type="number" name="qty" placeholder="Quantity" class="form-control" required><br>
        <input type="date" name="tanggal" placeholder="Tanggal" class="form-control" required><br>
        <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" required><br>
        <button type="submit" class="btn btn-primary" name="addikanmasuk">Submit</button>
        </div>
      </form>

    </div>
  </div>
</div>
</html>
