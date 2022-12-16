<?php
include './function.php';
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
                        <a class="nav-link active" href="dashboard.php">
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
                        <a class="nav-link " href="laporan-masuk.php">
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
                    <h1 class="mt-4">Dashboard</h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-transparent border-0 text-dark">
                                        </div>
                                        <div class="card-body">
                                            <!-- make card dashboard -->
                                            <?php
                                            $query = "SELECT COUNT(*) FROM stock";
                                            $query2 = "SELECT COUNT(*) FROM masuk";
                                            $query3 = "SELECT COUNT(*) FROM keluar";

                                            $result = mysqli_query($conn, $query);
                                            $result2 = mysqli_query($conn, $query2);
                                            $result3 = mysqli_query($conn, $query3);

                                            $row = mysqli_fetch_array($result);
                                            $row2 = mysqli_fetch_array($result2);
                                            $row3 = mysqli_fetch_array($result3);

                                            $jumlah = $row[0];
                                            $jumlah2 = $row2[0];
                                            $jumlah3 = $row3[0];
                                            $data = [
                                                'Jumlah Data Sayur' => [
                                                    'url' => 'index.php',
                                                    'data' => $jumlah
                                                ],
                                                'Jumlah Data Masuk' => [
                                                    'url' => 'masuk.php',
                                                    'data' => $jumlah2
                                                ],
                                                'Jumlah Data Keluar' => [
                                                    'url' => 'keluar.php',
                                                    'data' => $jumlah3
                                                ],

                                            ];
                                            ?>
                                            <div class="row">
                                                <?php foreach ($data as $key => $value) : ?>
                                                    <div class="col-xl-4 col-md-6">
                                                        <a class="card card-stats" href="<?= $value['url'] ?>">
                                                            <!-- Card body -->
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <h5 class="card-title text-uppercase text-muted mb-0"><?= $key ?></h5>
                                                                        <span class="h2 font-weight-bold mb-0">
                                                                            <?= $value['data'] ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                                            <i class="fas fa-chart-bar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <!-- Table -->
                                        <div class="row">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama sayuran</th>
                                                                <th>Tanggal Expired</th>
                                                                <th>Expired</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                        while ($dataexp = mysqli_fetch_array($getdataexp)) {
                                                            $getnamasayuran = $dataexp['namasayuran'];
                                                            $gettgl_exp = $dataexp['tgl_exp'];
                                                            $getexp = $dataexp['exp'];
                                                            if($getexp<=0){
                                                                $getstatus="Sudah Expired";
                                                            }elseif($getexp==1){
                                                               $getstatus="Akan Expired";
                                                            }elseif($getexp>1){
                                                               $getstatus="Belum Expired";
                                                             }
                                                        ?>
                                                        <tr>
                                                        <td><?= $getnamasayuran; ?></td>
                                                        <td><?= $gettgl_exp; ?></td>
                                                        <td><?= $getexp; ?> Hari</td>
                                                        <td><?= $getstatus; ?></td>
                                                        </tr>
                                                        <?php }; ?>
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
                    <input type="number" min="1" name="stock" class="form-control" placeholder="stock" required>
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