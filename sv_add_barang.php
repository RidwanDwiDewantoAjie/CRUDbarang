
<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$kdbrg=$_POST["kdbrg"];
$nmbrg=$_POST["nmbrg"];
$hrgbrg=$_POST["hrgbrg"];
$Stokbrg=$_POST["Stokbrg"];
$uploadOk=1;

//Set lokasi dan nama file foto
$folderupload ="foto/";
$fileupload = $folderupload . basename($_FILES['Gbrbrg']['name']); // foto/A12.2018.05555.jpg
$filefoto = basename($_FILES['Gbrbrg']['name']);                  // A12.2018.0555.jpg

//ambil jenis file
$jenisfilefoto = strtolower(pathinfo($fileupload,PATHINFO_EXTENSION)); //jpg,png,gif

// Check jika file foto sudah ada
if (file_exists($fileupload)) {
    echo "Maaf, file foto sudah ada<br>";
    $uploadOk = 0;
}

// Check ukuran file
if ($_FILES["Gbrbrg"]["size"] > 1000000) {
    echo "Maaf, ukuran file foto harus kurang dari 1 MB<br>";
    $uploadOk = 0;
}

// Hanya file tertentu yang dapat digunakan
if($jenisfilefoto != "jpg" && $jenisfilefoto != "png" && $jenisfilefoto != "jpeg"
&& $jenisfilefoto != "gif" ) {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan<br>";
    $uploadOk = 0;
}

// Check jika terjadi kesalahan
if ($uploadOk == 0) {
    echo "Maaf, file tidak dapat terupload<br>";
// jika semua berjalan lancar
} else {
    if (move_uploaded_file($_FILES["Gbrbrg"]["tmp_name"], $fileupload)) {        
        //membuat query
		$sql="insert barang values('','$kdbrg','$nmbrg','$hrgbrg', '$Stokbrg', '$filefoto')";
		mysqli_query($koneksi,$sql);
		header("location:update_barang.php");
		//echo "File ". basename( $_FILES["foto"]["name"]). " berhasil diupload";
    } else {
        echo "Data gagal tersimpan";
    }
}
?>