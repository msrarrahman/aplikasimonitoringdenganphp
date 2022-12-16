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
    <title>Stok Sayur Mayur</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Ribhan Sayur Mayur</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stok Sayur Mayur
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Sayur Mayur Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Sayur Mayur Keluar
                        </a>
                        <a class="nav-link" href="laporan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Laporan Keluar
                        </a>
                        <a class="nav-link active" href="laporan-masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Laporan Masuk
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
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="mt-4">Laporan Masuk Stok Sayur Mayur</h1>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <!-- Button to Open the Modal -->
                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Tambah Sayur Mayur
                                        </button> -->
                                    
                                    <!-- make form filter -->
                                    <form action="" method="get">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Bulan</label>
                                            <input type="month" name="bulan" id="exampleFormControlSelect1">
                                        </div>
                                        <button type="submit" class="btn btn-primary">filter</button>
                                        <a href="laporan-masuk.php" class="btn btn-secondary">reset</a>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="laporanTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>nama</th>
                                                    <th>stok</th>
                                                    <th>Tanggal</th>
                                                    <th>harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $queryData = "SELECT * FROM masuk INNER JOIN stock ON masuk.idbarang = stock.idbarang";
                                                // cek ada parameter bulan atau tidak
                                                if (isset($_GET['bulan'])) {
                                                    $bulan = $_GET['bulan'];
                                                    $bulan = explode('-', $bulan)[1];
                                                    $queryData .= " WHERE MONTH(tanggal) = '$bulan'";
                                                }
                                                $ambilsemuadatastock = mysqli_query($conn, $queryData);

                                                $i = 1;
                                                $totalHarga = 0;
                                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {

                                                    $namasayuran = $data['namasayuran'];
                                                    $idb = $data['idbarang'];
                                                    $stock = $data['qty'];
                                                    $hargaSatuan = $data['harga_jual'] * $stock;
                                                    $totalHarga += $hargaSatuan;
                                                    $tanggal = $data['tanggal'];
                                                ?>

                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $namasayuran; ?></td>
                                                        <td><?= $stock; ?></td>
                                                        <td><?= $tanggal ?></td>
                                                        <td>Rp.<?= number_format($hargaSatuan, 0, ',', '.'); ?></td>
                                                        <!-- <td>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idb; ?>">
                                                        Edit
                                                        </button>
                                                        <input type="hidden" name="idbarangygmaudihapus" values="<?= $idb; ?>">
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                                        Delete
                                                        </button>
                                                        </td> -->
                                                    </tr>

                                                    <!-- Edit Modal Modal -->
                                                    <div class="modal fade" id="edit<?= $idb; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Barang</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <form method="post">
                                                                    <div class="modal-body">
                                                                        <input type="text" name="namasayuran" value="<?= $namasayuran; ?>" class="form-control" required>
                                                                        <br>
                                                                        <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                                        <br>
                                                                        <input type="text" name="satuan" placeholder="Satuan Barang (Kg, Buah, Dll.)" value="<?= $satuan; ?>" class="form-control" required>
                                                                        <br>
                                                                        <input type="number" name="harga" placeholder="Harga" value="<?= $harga; ?>" class="form-control" required>
                                                                        <br>
                                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                        <button type="submit" class="btn btn-primary" name="updatesayuran">submit</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete<?= $idb; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Hapus Barang?</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <form method="post">
                                                                    <div class="modal-body">
                                                                        Apakah anda yakin ingin menghapus <?= $namasayuran; ?>?
                                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                        <br>
                                                                        <br>
                                                                        <button type="submit" class="btn btn-danger" name="hapussayuran">Hapus</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>

                                    </div>

                                <?php
                                                };

                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th style="text-align:right">Total Harga:</th>
                                        <th>Rp. <?= number_format($totalHarga, 0, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Sayur Mayur</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="namasayuran" placeholder="Nama sayuran" class="form-control" required>
                    <br>
                    <input type="text" name="deskripsi" placeholder="Deskripsi barang" class="form-control" required>
                    <br>
                    <input type="number" name="stock" class="form-control" placeholder="stock" required>
                    <br>
                    <input type="text" name="satuan" placeholder="Satuan barang (Kg, Buah, Dll.)" class="form-control" required>
                    <br>
                    <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addnewsayuran">submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

</html>