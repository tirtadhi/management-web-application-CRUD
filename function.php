<?php
session_start();

//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","perikanan");


//Menambah Ikan baru
if(isset($_POST['addnewikan'])){
    $jenisikan = $_POST['jenisikan'];
    $ukuranikan = $_POST['ukuranikan'];
    $hargaikan = $_POST['hargaikan'];
    $stokikan = $_POST['stokikan'];
    $lokasiikan = $_POST['lokasiikan'];

    $addtotable = mysqli_query($conn,"Insert into stock (jenisikan,ukuranikan,hargaikan,stokikan,lokasiikan) values('$jenisikan','$ukuranikan','$hargaikan','$stokikan','$lokasiikan')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
};

//Menambah ikan masuk
if(isset($_POST['addikanmasuk'])){
    $ikannya = $_POST['ikannya'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang= mysqli_query($conn, "select * from stock where idikan='$ikannya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stokikan'];
    $tambahkanstoksekarangdenganquantity = $stocksekarang+$qty;


    $addtomasuk = mysqli_query($conn,"insert into masuk (idikan, tanggal, keterangan, qty) values('$ikannya','$tanggal','$keterangan', '$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stokikan='$tambahkanstoksekarangdenganquantity' where idikan='$ikannya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    }else{
        echo 'Gagal';
        header('location:masuk.php');
    }
};

//Menambah ikan keluar
if(isset($_POST['addikankeluar'])){
    $ikannya = $_POST['ikannya'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang= mysqli_query($conn, "select * from stock where idikan='$ikannya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stokikan'];
    $kurangkanstoksekarangdenganquantity = $stocksekarang-$qty;


    $addtokeluar = mysqli_query($conn,"insert into keluar (idikan, tanggal, keterangan, qty) values('$ikannya','$tanggal','$keterangan', '$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stokikan='$kurangkanstoksekarangdenganquantity' where idikan='$ikannya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    }else{
        echo 'Gagal';
        header('location:keluar.php');
    }
}


//update info ikan
if(isset($_POST['updateikan'])){
    $idi = $_POST['idi'];
    $jenisikan = $_POST['jenisikan'];
    $ukuranikan = $_POST['ukuranikan'];
    $hargaikan = $_POST['hargaikan'];
    $lokasiikan = $_POST['lokasiikan'];

    $update = mysqli_query($conn, "update stock set jenisikan='$jenisikan', ukuranikan='$ukuranikan', hargaikan='$hargaikan', lokasiikan='$lokasiikan' where idikan='$idi'");
    if($update){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}

//hapus ikan dari stock
if(isset($_POST['deleteikan'])){
    $idi = $_POST['idi'];

    $delete = mysqli_query($conn,"delete from stock where idikan='$idi'");
    if($delete){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}
//mengubah data ikan masuk
if(isset($_POST['updateikanmasuk'])){
    $idi = $_POST['idi'];
    $idm = $_POST['idm'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    $lihatstock = mysqli_query($conn, "select * from stock where idikan='$idi'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stokikan'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stokikan='$kurangin' where idikan='$idi'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$keterangan'  where idmasuk='$idm'");
        if($kurangistocknya&&$updatenya){
            header('location:masuk.php');
        }else{
            echo 'Gagal';
            header('location:masuk.php');
        }
    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stokikan='$kurangin' where idikan='$idi'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$keterangan'  where idmasuk='$idm'");
        if($kurangistocknya&&$updatenya){
            header('location:masuk.php');
        }else{
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}


//hapus ikan masuk
if(isset($_POST['deleteikanmasuk'])){
    $idi = $_POST['idi'];
    $idm = $_POST['idm'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idikan='$idi'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stokikan'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn, "update stock set stokikan='$selisih' where idikan='$idi'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    }else{
        header('location:masuk.php');
    }
}


//mengubah data ikan keluar
if(isset($_POST['updateikankeluar'])){
    $idi = $_POST['idi'];
    $idk = $_POST['idk'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    $lihatstock = mysqli_query($conn, "select * from stock where idikan='$idi'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stokikan'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stokikan='$kurangin' where idikan='$idi'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan'  where idkeluar='$idk'");
        if($kurangistocknya&&$updatenya){
            header('location:keluar.php');
        }else{
            echo 'Gagal';
            header('location:keluar.php');
        }
    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stokikan='$kurangin' where idikan='$idi'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', keterangan='$keterangan'  where idkeluar='$idk'");
        if($kurangistocknya&&$updatenya){
            header('location:keluar.php');
        }else{
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}


//hapus ikan keluar
if(isset($_POST['deleteikankeluar'])){
    $idi = $_POST['idi'];
    $idk = $_POST['idk'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idikan='$idi'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stokikan'];

    $selisih = $stock+$qty;

    $update = mysqli_query($conn, "update stock set stokikan='$selisih' where idikan='$idi'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    }else{
        header('location:keluar.php');
    }
}




?>