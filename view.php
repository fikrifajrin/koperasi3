<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th class="text-center">NO</th>
			<th class="text-center">FOTO</th>
			<th>NO KTP</th>
			<th>NAMA</th>
			<th>JENIS KELAMIN</th>
			<th>TANGGAL LAHIR</th>
			<th>USIA</th>
			<th>ALAMAT</th>
			<th colspan="2" class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
		</tr>
		<?php
		// Include / load file koneksi.php
		include "koneksi.php";
		
		// Buat query untuk menampilkan semua data siswa
		$sql = $pdo->prepare("SELECT *, YEAR(CURDATE()) - YEAR(tgl_lahir) AS usia FROM anggota");
		$sql->execute(); // Eksekusi querynya
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
		?>
			<tr>
				<td class="align-middle text-center"><?php echo $no; ?></td>
				<td class="align-middle text-center">
					<img src="foto/<?php echo $data['foto']; ?>" width="80" height="100">
				</td>
				<td class="align-middle"><?php echo $data['no_ktp']; ?></td>
				<td class="align-middle"><?php echo $data['nama_anggota']; ?></td>
				<td class="align-middle"><?php echo $data['jenis_kel']; ?></td>
				<td class="align-middle"><?php echo $data['tgl_lahir']; ?></td>
				<td class="align-middle"><?php echo $data['usia']; ?></td>
				<td class="align-middle"><?php echo $data['alamat']; ?></td>
				<td class="align-middle text-center">
					<a href="javascript:void();" data-toggle="modal" data-target="#form-modal" onclick="edit(<?php echo $no; ?>);" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
				<td class="align-middle text-center">
					<a href="javascript:void();" data-toggle="modal" data-target="#delete-modal" onclick="hapus(<?php echo $no; ?>);" class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></a>
				</td>
			</tr>
			<!--
			-- Membuat sebuah textbox hidden yang akan digunakan untuk form ubah
			-->
			<input type="hidden" id="no_ktp-value-<?php echo $no; ?>" value="<?php echo $data['no_ktp']; ?>">
			<input type="hidden" id="nama_anggota-value-<?php echo $no; ?>" value="<?php echo $data['nama_anggota']; ?>">
			<input type="hidden" id="jenis_kel-value-<?php echo $no; ?>" value="<?php echo $data['jenis_kel']; ?>">
			<input type="hidden" id="tgl_lahir-value-<?php echo $no; ?>" value="<?php echo $data['tgl_lahir']; ?>">
			<input type="hidden" id="alamat-value-<?php echo $no; ?>" value="<?php echo $data['alamat']; ?>">
		<?php
			$no++; // Tambah 1 setiap kali looping
		}
		?>
	</table>
</div>

<script>
// Fungsi ini akan dipanggil ketika tombol edit diklik
function edit(no){
	$("#btn-simpan").hide(); // Sembunyikan tombol simpan
	$("#btn-ubah, #checkbox_foto").show(); // Munculkan tombol ubah dan checkbox foto
	
	// Set judul modal dialog menjadi Form Ubah Data
	$("#modal-title").html("Form Ubah data");
	
	var no_ktp = $("#no_ktp-value-" + no).val(); // Ambil nis dari input type hidden
	var nama_anggota = $("#nama_anggota-value-" + no).val(); // Ambil nama dari input type hidden
	var jenis_kel = $("#jenis_kel-value-" + no).val(); // Ambil jenis kelamin dari input type hidden
	var tgl_lahir = $("#tgl_lahir-value-" + no).val(); // Ambil telp dari input type hidden
	var alamat = $("#alamat-value-" + no).val(); // Ambil alamat dari input type hidden
	
	// Set value dari textbox nis yang ada di form
	// Set textbox nis menjadi Readonly
	$("#no_ktp").val(no_ktp).attr("readonly","readonly");
	
	$("#nama_anggota").val(nama_anggota); // Set value dari textbox nama yang ada di form
	$("#jenis_kel").val(jenis_kel); // Set value dari textbox nama yang ada di form
	$("#tgl_lahir").val(tgl_lahir); // Set value dari textbox nama yang ada di form
	$("#alamat").val(alamat); // Set value dari textbox nama yang ada di form
	$("#foto").val("");
}

// Fungsi ini akan dipanggil ketika tombol hapus diklik
function hapus(no){
	var no_ktp = $("#no_ktp-value-" + no).val(); // Ambil nis dari input type hidden
	
	// Set textbox hidden nis yang ada di modal dialog hapus
	$("#data-no_ktp").val(no_ktp);
}
</script>
