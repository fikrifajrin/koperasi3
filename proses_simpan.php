<?php
// Include / load file koneksi.php
include "koneksi.php";

// Ambil data yang dikirim dari form
$no_ktp = $_POST['no_ktp']; // Ambil data nis dan masukkan ke variabel nis
$nama_anggota = $_POST['nama_anggota']; // Ambil data nama dan masukkan ke variabel nama
$jenis_kel = $_POST['jenis_kel']; // Ambil data jenis_kelamin dan masukkan ke variabel jenis_kelamin
$tgl_lahir = $_POST['tgl_lahir']; // Ambil data telp dan masukkan ke variabel telp
$alamat = $_POST['alamat']; // Ambil data alamat dan masukkan ke variabel alamat
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

// Rename nama fotonya dengan menambahkan tanggal dan jam upload
$fotobaru = date('dmYHis').$foto;

// Set path folder tempat menyimpan fotonya
$path = "foto/".$fotobaru;

// Proses upload
// Cek apakah gambar berhasil diupload atau tidak
if(move_uploaded_file($tmp, $path)){ // Jika proses upload sukses
	// Proses simpan ke Database
	$sql = $pdo->prepare("INSERT INTO anggota VALUES(:no_ktp,:nama_anggota,:jenis_kel,:tgl_lahir,:foto,:alamat)");
	$sql->bindParam(':no_ktp', $no_ktp);
	$sql->bindParam(':nama_anggota', $nama_anggota);
	$sql->bindParam(':jenis_kel', $jenis_kel);
	$sql->bindParam(':tgl_lahir', $tgl_lahir);
	$sql->bindParam(':foto', $fotobaru);
	$sql->bindParam(':alamat', $alamat);
	$sql->execute(); // Eksekusi query insert
	
	// Load ulang view.php agar data yang baru bisa muncul di tabel pada view.php
	ob_start();
	include "view.php";
	$html = ob_get_contents();
	ob_end_clean();
	
	// Buat variabel reponse yang nantinya akan diambil pada proses ajax ketika sukses
	$response = array(
		'status'=>'sukses', // Set status
		'pesan'=>'Data berhasil disimpan', // Set pesan
		'html'=>$html // Set html
	);
}else{ // Jika proses upload gagal
	$response = array(
		'status'=>'gagal', // Set status
		'pesan'=>'Gambar gagal untuk diupload', // Set pesan
	);
}

echo json_encode($response); // konversi variabel response menjadi JSON
?>
