<?php
session_start();
//membuat koneksi
$conn = mysqli_connect("localhost","root","","stocksayuran");

$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';

// menambah brang baru
if(isset($_POST['addnewsayuran'])){
    $namasayuran = $_POST['namasayuran'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];
    $harga_jual = $_POST['harga_jual'];

    $addtotable = mysqli_query($conn, "insert into stock (namasayuran, deskripsi, stock, satuan, harga, harga_jual) values('$namasayuran',' $deskripsi','$stock', '$satuan', '$harga', '$harga_jual')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $sayurannya = $_POST['sayurannya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    $kode_msk = 'KD' . substr(str_shuffle($str_result), 0, 10);
    $tgl_exp=$_POST['tgl_exp'];
    $tgl_masuk = date("Y-m-d");

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang= '$sayurannya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    // $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty, kode_msk, tgl_exp) values('$sayurannya','$penerima','$qty','$kode_msk','$tgl_exp')");

    $addtomasuk = mysqli_query($conn, "INSERT INTO `masuk`(`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`, `kode_msk`, `tgl_exp`) VALUES (NULL,'$sayurannya','$tgl_masuk','$penerima','$qty','$kode_msk','$tgl_exp')");

    $addtolaporanmasuk = mysqli_query($conn, "INSERT INTO `laporan_masuk` VALUES (NULL,'$sayurannya','$tgl_masuk','$penerima','$qty','$tgl_exp')");
    
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$sayurannya'");

    if($addtomasuk&&$updatestockmasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }

}
//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $sayurannya = $_POST['sayurannya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    $tanggal_sekarang = date('Y-m-d');
    $kode_msk = $_POST['kode_msk'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang= '$sayurannya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    
    $cekmasuksekarang = mysqli_query($conn, "select * from masuk where kode_msk= '$kode_msk'");
    $ambildatamasuk = mysqli_fetch_array($cekmasuksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $stockmasuksekarang = $ambildatamasuk['qty'];
    $tambahkanstockmasuksekarangdenganquantity = $stockmasuksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO `keluar`(`idkeluar`, `idbarang`, `tanggal`, `penerima`, `kode_msk`, `qty`) VALUES (null,'$sayurannya','$tanggal_sekarang','$penerima','$kode_msk','$qty')");
    
    $addtolaporan_keluar = mysqli_query($conn, "INSERT INTO `laporan_keluar`(`idkeluar`, `idbarang`, `tanggal`, `penerima`, `kode_msk`, `qty`) VALUES (null,'$sayurannya','$tanggal_sekarang','$penerima','$kode_msk','$qty')");

    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$sayurannya'");

    // $updatemasuk = mysqli_query($conn, "update masuk set qty='$tambahkanstockmasuksekarangdenganquantity' where kode_msk='$kode_msk'");
    if($addtokeluar&&$updatestockmasuk&&$addtolaporan_keluar){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }

}



//update info barang
if(isset($_POST['updatesayuran'])){
    $idb = $_POST['idb'];
    $namasayuran = $_POST['namasayuran'];
    $deskripsi = $_POST['deskripsi'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];
    $harga_jual = $_POST['harga_jual'];

    $update = mysqli_query($conn, "update stock set namasayuran='$namasayuran', deskripsi='$deskripsi', satuan='$satuan', harga='$harga', harga_jual='$harga_jual' where idbarang ='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}


// Mengahapus barang dari stock
if(isset($_POST['hapussayuran'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


//Mengubah data sayuran masuk
if(isset($_POST['updatesayuranmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg =  $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
             if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
             }
    } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
             if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
             }
    }

}




//Menghapus barang masuk
if(isset($_POST['hapussayuranmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
       header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}



//Mengubah data barang keluar
if(isset($_POST['updatesayurankeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $kode_msk = $_POST['kode_msk'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg =  $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    $qtymasukskrg = mysqli_query($conn,"select * from masuk where kode_msk='$kode_msk'");
    $qtymasuknya = mysqli_fetch_array($qtymasukskrg);
    $qtymasukskrg = $qtymasuknya['qty'];

    if((int)$qty>(int)$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kuranginmasuk = $qtymasukskrg - $selisih;
        $kurangistocknya = mysqli_query($conn,"UPDATE `stock` SET stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE `keluar` SET qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        $updatemasuk = mysqli_query($conn,"UPDATE masuk SET qty='$kuranginmasuk' where kode_msk='$kode_msk'");
            if($kurangistocknya&&$updatenya&&$updatemasuk){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
            }
    }  else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kuranginmasuk = $qtymasukskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"UPDATE `stock` SET stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"UPDATE `keluar` SET qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        $updatemasuk = mysqli_query($conn,"UPDATE masuk SET qty='$kuranginmasuk' where kode_msk='$kode_msk'");
            if($kurangistocknya&&$updatenya&&$updatemasuk){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
            }
    }

}


//Menghapus barang keluar
if(isset($_POST['hapussayurankeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];
    $kode_msk = $_POST['kode_msk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock+$qty;

    $getdatamsk = mysqli_query($conn,"select * from masuk where kode_msk='$kode_msk'");
    $datamsk = mysqli_fetch_array($getdatamsk);
    $dataqty = $datamsk['qty'];

    $selisihmsk = $dataqty+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $updatemsk = mysqli_query($conn,"update masuk set qty='$selisihmsk' where kode_msk='$kode_msk'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata&&$updatemsk){
       header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

//select expired

$query = "select *  from expired where qty > 0 ORDER BY exp ASC";
$getdataexp = mysqli_query($conn, $query);



?>