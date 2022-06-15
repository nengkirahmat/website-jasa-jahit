<?php
include "koneksi.php";
if (isset($_POST['simpan_catalog'])){
	$judul=$_POST['judul'];
	$jenis_bahan=$_POST['jenis_bahan'];
	$ukuran=$_POST['ukuran'];
	$harga=$_POST['harga'];
	$gambar=$_FILES['gambar']['name'];
	$keterangan=$_POST['keterangan'];
	$folder="gambar/";
	$folder=$folder.basename($_FILES['gambar']['name']);
	if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder)){
		$query=$con->prepare("insert into catalog values ('',:judul,:jenis_bahan,:ukuran,:harga,:gambar,:keterangan)");
		$query->BindParam(":judul",$judul);
		$query->BindParam(":jenis_bahan",$jenis_bahan);
		$query->BindParam(":ukuran",$ukuran);
		$query->BindParam(":harga",$harga);
		$query->BindParam(":gambar",$gambar);
		$query->BindParam(":keterangan",$keterangan);
		$query->execute();
		header('location:index.php?page=catalog');
	}
}

if (isset($_POST['simpan_saran'])){
	$nama=$_POST['nama'];
	$email=$_POST['email'];
	$judul=$_POST['judul'];
	$saran=$_POST['saran'];
		$query=$con->prepare("insert into saran values ('',:nama,:email,:judul,:saran,Now())");
		$query->BindParam(":nama",$nama);
		$query->BindParam(":email",$email);
		$query->BindParam(":judul",$judul);
		$query->BindParam(":saran",$saran);
		$query->execute();
		header('location:index.php?page=saran');
}

if (isset($_POST['simpan_pemesanan'])){
	$nama=$_POST['nama'];
	$hp=$_POST['hp'];
	$alamat=$_POST['alamat'];
	$id_catalog=$_POST['id_catalog'];
	$file=$_FILES['file']['name'];
	$folder="gambar/";
	$folder=$folder.basename($_FILES['file']['name']);
	if (!empty($_FILES['file']['name'])){
		move_uploaded_file($_FILES['file']['tmp_name'], $folder);
	}
	$ukuran=$_POST['ukuran'];
	$tgl=$_POST['tgl'];
	$keterangan=$_POST['keterangan'];
	$query=$con->prepare("insert into pemesanan values ('',:nama,:hp,:alamat,:id_catalog,:ukuran,:tgl,:file,:keterangan,'1',Now())");
	$query->BindParam(":nama",$nama);
	$query->BindParam(":hp",$hp);
	$query->BindParam(":alamat",$alamat);
	$query->BindParam(":id_catalog",$id_catalog);
	$query->BindParam(":ukuran",$ukuran);
	$query->BindParam(":tgl",$tgl);
	$query->BindParam(":file",$file);
	$query->BindParam(":keterangan",$keterangan);
	$query->execute();
	$query=$con->prepare("select id_pemesanan from pemesanan where telpon=:telpon order by id_pemesanan desc");
	$query->BindParam(":telpon",$hp);
	$query->execute();
	$query=$query->fetch();
	$id_pemesanan=$query['id_pemesanan'];
	header('location:cetak_pemesanan.php?cetak_pemesanan='.$id_pemesanan);
}

	if (isset($_POST['kirim_pembayaran'])){
		$id_pemesanan=$_POST['id_pemesanan'];
		$nama_rek=$_POST['nama_rek'];
		$no_rek=$_POST['no_rek'];
		$jml_transfer=$_POST['jumlah'];
		$tgl=$_POST['tgl'];
		$keterangan=$_POST['keterangan'];
		$query=$con->prepare("insert into pembayaran values ('',:id_pemesanan,:nama_rek,:no_rek,:jml_transfer,:tgl,:keterangan,'Menunggu Persetujuan')");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->BindParam(":nama_rek",$nama_rek);
		$query->BindParam(":no_rek",$no_rek);
		$query->BindParam(":jml_transfer",$jml_transfer);
		$query->BindParam(":tgl",$tgl);
		$query->BindParam(":keterangan",$keterangan);
		$query->execute();
		$query=$con->prepare("update pemesanan set status='2' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=pembayaran');
	}

	if (isset($_POST['simpan_testimoni'])){
		$nama=$_POST['nama'];
		$isi=$_POST['isi'];
		$query=$con->prepare("insert into testimoni values ('',:nama,:isi,'Tidak Tampil',Now())");
		$query->BindParam(":nama",$nama);
		$query->BindParam(":isi",$isi);
		$query->execute();
		header('location:index.php?page=testimoni');
	}

	if (!empty($_GET['update_testimoni'])){
		$id_testimoni=$_GET['update_testimoni'];
		$query=$con->prepare("select * from testimoni where id_testimoni=:id_testimoni");
		$query->BindParam(":id_testimoni",$id_testimoni);
		$query->execute();
		$query=$query->fetch();
		if ($query['status']=="Tidak Tampil"){
			$query=$con->prepare("update testimoni set status='Tampil' where id_testimoni=:id_testimoni");
			$query->BindParam(":id_testimoni",$id_testimoni);
			$query->execute();
			header('location:index.php?page=data_testimoni');
		}else{
			$query=$con->prepare("update testimoni set status='Tidak Tampil' where id_testimoni=:id_testimoni");
			$query->BindParam(":id_testimoni",$id_testimoni);
			$query->execute();
			header('location:index.php?page=data_testimoni');
		}
	}

	if (!empty($_GET['hapus_testimoni'])){
		$id_testimoni=$_GET['hapus_testimoni'];
		$query=$con->prepare("delete from testimoni where id_testimoni=:id_testimoni");
		$query->BindParam(":id_testimoni",$id_testimoni);
		$query->execute();
		header('location:index.php?page=data_testimoni');
	}

	if (!empty($_GET['hapus_saran'])){
		$id_saran=$_GET['hapus_saran'];
		$query=$con->prepare("delete from saran where id_saran=:id_saran");
		$query->BindParam(":id_saran",$id_saran);
		$query->execute();
		header('location:index.php?page=data_saran');
	}

	if (!empty($_GET['hapus_pemesanan'])){
		$id_pemesanan=$_GET['hapus_pemesanan'];
		$query=$con->prepare("delete from pemesanan where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pemesanan');
	}

	if (!empty($_GET['hapus_pembayaran'])){
		$id_pembayaran=$_GET['hapus_pembayaran'];
		$query=$con->prepare("delete from pembayaran where id_pembayaran=:id_pembayaran");
		$query->BindParam(":id_pembayaran",$id_pembayaran);
		$query->execute();
		header('location:index.php?page=data_pembayaran');
	}

	if (!empty($_GET['hapus_catalog'])){
		$id_catalog=$_GET['hapus_catalog'];
		$query=$con->prepare("delete from catalog where id_catalog=:id_catalog");
		$query->BindParam(":id_catalog",$id_catalog);
		$query->execute();
		header('location:index.php?page=catalog');
	}

	if (!empty($_GET['setujui_pembayaran'])){
		$id_pembayaran=$_GET['setujui_pembayaran'];
		$query=$con->prepare("update pembayaran set status='Disetujui' where id_pembayaran=:id_pembayaran");
		$query->BindParam(":id_pembayaran",$id_pembayaran);
		$query->execute();
		$query=$con->prepare("select id_pemesanan from pembayaran where id_pembayaran=:id_pembayaran");
		$query->BindParam(":id_pembayaran",$id_pembayaran);
		$query->execute();
		$query=$query->fetch();
		$id_pemesanan=$query['id_pemesanan'];
		$query=$con->prepare("update pemesanan set status='4' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pembayaran');
	}

	if (!empty($_GET['tolak_pembayaran'])){
		$id_pembayaran=$_GET['tolak_pembayaran'];
		$query=$con->prepare("update pembayaran set status='Ditolak' where id_pembayaran=:id_pembayaran");
		$query->BindParam(":id_pembayaran",$id_pembayaran);
		$query->execute();
		$query=$con->prepare("select id_pemesanan from pembayaran where id_pembayaran=:id_pembayaran");
		$query->BindParam(":id_pembayaran",$id_pembayaran);
		$query->execute();
		$query=$query->fetch();
		$id_pemesanan=$query['id_pemesanan'];
		$query=$con->prepare("update pemesanan set status='3' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pembayaran');
	}

	if (!empty($_GET['pesanan_selesai'])){
		$id_pemesanan=$_GET['pesanan_selesai'];
		$query=$con->prepare("update pemesanan set status='6' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pemesanan');
	}

	if (!empty($_GET['kirim_pesanan'])){
		$id_pemesanan=$_GET['kirim_pesanan'];
		$query=$con->prepare("update pemesanan set status='7' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pemesanan');
	}


	if (!empty($_GET['page']) and $_GET['page']=="pengerjaan" and !empty($_GET['token'])){
		$id_pemesanan=$_GET['token'];
		$query=$con->prepare("update pemesanan set status='5' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=data_pemesanan');
	}

	if (!empty($_GET['pesanan_diterima'])){
		$id_pemesanan=$_GET['pesanan_diterima'];
		$query=$con->prepare("update pemesanan set status='8' where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		header('location:index.php?page=testimoni');
	}

	if (isset($_POST['login'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$query=$con->prepare("select * from login where username=:username and password=:password");
		$query->BindParam(":username",$username);
		$query->BindParam(":password",$password);
		$query->execute();
		$cek=$query->rowCount();
		if ($cek>0){
			$q=$query->fetch();
			session_start();
		$_SESSION['username']=$q['username'];
			header('location:index.php');
		}
		}

	if (!empty($_GET['keluar']) and $_GET['keluar']=="true"){
		session_destroy();
		header('location:index.php');
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>RUMAH JAHIT RIFQA</title>
	<style>
		body{
			margin: 0;padding: 0;
		}
		.header{
			background: #1967be;height: 150px;
		}
		.header h1{
			color: white;margin:0 0 0 40px;padding-top:40px;font-size: 60px;
		}
		.navbar ul{
			padding: 0;overflow: hidden;list-style: none;width: 100%;background:#2780e3;margin: 0;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.24);
		}
		.navbar ul li{
			float: left;
		}
		.navbar ul li a{
			display: block;padding: 12px 16px;background: transparent;color: white;font-size: 20px;text-decoration: none;
		}
		.navbar ul li a:hover{
			display: block;padding: 12px 16px;background: #1967be;color: white;
		}
		.content{
			width: 80%; background: transparent; float: left; margin: 0; min-height: 800px;
		}
		.sidebar{
			width: 20%;float: left;margin: 0;background: #2780e3;
		}
		.isi{
			width: 96%;margin-top: 10px; margin-left: 2%; margin-bottom: 10px;
		}
		.body-isi{
			width: 33.3%;float: left;
		}
		.sampul{
			width: 90%;background: #eee;margin-left: 5%;padding-top:10px;padding-bottom: 10px;margin-bottom: 10px;
		}
		.header-isi{
			width: 90%;margin-left: 5%;height: 35px;
		}
		.gambar-isi{
			width: 90%;margin-left: 5%;height: 400px;
		}
		.keterangan-isi{
			width: 90%;margin-left: 5%;height: 40px;margin-top: 5px;
		}
		.btn{
			text-decoration: none;padding: 12px 16px;display: block;background: #da470e;margin: 0; color: white; text-align: center; max-width: 100px;float: left;margin-right: 5px;
		}
		.btn:hover{
			background: #bf2828;color: white;
		}
		.btn1{
			text-decoration: none;padding: 12px 16px;display: block;background: #0dabb7;margin: 0; color: white; text-align: center; max-width: 200px;float: left;margin-right: 5px;
		}
		.btn1:hover{
			background: #08808f;color: white;
		}
		.btn2{
			background: red;border-color: transparent;color: white;padding: 6px 16px;margin-top: 5px;
		}
		.btn2:hover{
			background: #d51825;border-color: red;
		}
		.btn3{margin: 5px; padding: 2px;background: blue;color: white;text-decoration: none;display: block;text-align: center;}
		.btn3:hover{background: red;color: white;}
		.gambar-isi img{
			opacity: 0.8;
		}
		.gambar-isi img:hover{
			opacity: 1;
		}
		.aside{
			margin: 10px 0 10px 0; width: 96%; margin-left: 2%;
		}
		.aside ul{
			list-style: none;
			overflow: hidden;
			margin: 0;
			padding: 0;
			height: 100%;
		}
		.aside ul li a{
			padding: 12px 16px;
			color: #fff;
			display: block;
			text-decoration: none;
		}
		.aside ul li a:hover{
			background:#e7e7e7;
			color: #666;
		}
		.img-detail{
			max-width: 50%; float: left; margin-right: 40px;
		}
		.detail{
			font-size: 20px;
		}
		.footer{
			clear: both;
			width: 100%;
			background: #2780e3; 
			display: block;
			margin:0;
			color: white;
		}
		input,select,textarea{
			padding: 5px;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.24);
		}
	</style>
</head>
<body>
<div class="header">
	<h1>Rumah Jahit Rifqa</h1>
</div>
<div class="navbar">
	<ul>
		<li><a href="index.php">Beranda</a></li>
		<li><a href="index.php?page=contact">Contact</a></li>
		<li><a href="index.php?page=tentang">Tentang</a></li>
		<li><a href="index.php?page=saran">Kritik & Saran</a></li>
		<li><a href="index.php?page=pemesanan">Pemesanan</a></li>
		<li><a href="index.php?page=pembayaran">Pembayaran</a></li>
		<li><a href="index.php?page=cek_ongkir">Cek Ongkir</a></li>
		<li><a href="index.php?page=cek_pemesanan">Cek Pemesanan</a></li>
		<li><a href="index.php?page=testimoni">Testimoni</a></li>
	</ul>
</div>
<div class="content">
	<!-- Awal Class isi -->
	<div class="isi">

	<?php
	//Menampilkan form pemesanan dengan desain sendiri
	if (!empty($_GET['page']) and $_GET['page']=="pemesanan"){ ?>
	<h3>Pemesanan Jahitan Desain Sendiri</h3>
	* Upload desain anda, atau Jelaskan lebih rinci di Keterangan<br>
	* Untuk Biaya desain sendiri dan Ongkos Kirim silahkan hubungi CS kami<br>
	* Cek Ongkos Kirim <a target="_blank" href="index.php?page=cek_ongkir">DISINI</a>

	<form action="#" method="POST" enctype="multipart/form-data">
		<label>Nama Lengkap *</label><br>
		<input type="text" name="nama" required=""><br>
		<label>Telpon / HP / WA *</label><br>
		<input type="text" name="hp" required=""><br>
		<label>Alamat Lengkap *</label><br>
		<textarea name="alamat" required=""></textarea><br>
		<div style="display: none;">
		<label>Kode Catalog</label><br>
		<input type="text" name="id_catalog"><br>
		</div>
		<label>Upload Desain Anda Jika Ada</label><br>
		<input type="file" name="file"><br>
		<label>Ukuran Pesanan *</label><br>
		<select name="ukuran" required="">
			<option value="">Pilih Ukuran</option>
			<option value="S">S</option>
			<option value="M">M</option>
			<option value="L">L</option>
			<option value="XL">XL</option>
			<option value="Lainnya">Lainnya</option>
		</select><br>
		<label>Tanggal Penjemputan *</label><br>
		<input type="text" name="tgl" placeholder="YYYY-MM-DD" required=""><br>
		<label>Keterangan *</label><br>
		<textarea name="keterangan" required=""></textarea><br>
		<input type="submit" class="btn2" name="simpan_pemesanan" value="Kirim">
	</form>

	<?php } ?>

	<?php
	//Menampilkan form pemesanan sesuai catalog
	if (!empty($_GET['pemesanan'])){ ?>
	<h3>Pemesanan Jahitan Berdasarkan Desain Catalog</h3>
	* Pemesanan lewat formulir dibawah ini akan menyesuaikan dengan desain catalog yang anda pilih<br>
	* Cek Ongkos Kirim <a target="_blank" href="index.php?page=cek_ongkir">DISINI</a>
	<form action="#" method="POST" enctype="multipart/form-data">
		<label>Nama Lengkap *</label><br>
		<input type="text" name="nama" required=""><br>
		<label>Telpon / HP *</label><br>
		<input type="text" name="hp" required=""><br>
		<label>Alamat Lengkap *</label><br>
		<textarea name="alamat" required=""></textarea><br>
		<label>Kode Catalog Dipilih</label><br>
		<input type="text" name="id_catalog" readonly="readonly" value="<?php echo $_GET['pemesanan']; ?>"><br>
		<div style="display: none;">
		<label>Upload Desain Anda Jika Ada</label><br>
		<input type="file" name="file"><br>
		</div>
		<label>Ukuran Pesanan *</label><br>
		<select name="ukuran" required="">
			<option value="">Pilih Ukuran</option>
			<option value="S">S</option>
			<option value="M">M</option>
			<option value="L">L</option>
			<option value="XL">XL</option>
			<option value="Lainnya">Lainnya</option>
		</select><br>
		<label>Tanggal Pengambilan *</label><br>
		<input type="text" name="tgl" placeholder="YYYY-MM-DD" required=""><br>
		<label>Keterangan *</label><br>
		<textarea name="keterangan" required=""></textarea><br>
		<input type="submit" class="btn2" name="simpan_pemesanan" value="Kirim">
	</form>

	<?php } ?>

		<?php
		//Menampilkan data pemesanan pada halaman admin
		if (!empty($_GET['page']) and $_GET['page']=="data_pemesanan"){ ?>
		<h3>Data Pemesanan</h3>
		Keterangan Angka pada kolom <b>Status</b> 
		<ol>
			<li>Menunggu Pembayaran</li>
			<li>Menunggu Persetujuan Pembayaran</li>
			<li>Pembayaran Ditolak</li>
			<li>Persiapan Pengerjaan (Pembayaran Telah Disetujui)</li>
			<li>Sedang Dikerjakan</li>
			<li>Pengerjaan Selesai dan Persiapan Pengiriman (Pada tahap ini kami akan menghubungi anda ke nomor kontak yang telah anda berikan)</li>
			<li>Telah Dikirim</li>
			<li>Jika Pesanan Telah Diterima</li>
		</ol>
		<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Pemesanan</th>
			<th style="text-align: center;">Nama Pemesan</th>
			<th style="text-align: center;">Telpon / HP</th>
			<th style="text-align: center;">Alamat</th>
			<th style="text-align: center;">Kode Catalog</th>
			<th style="text-align: center;">File Upload</th>
			<th style="text-align: center;">Ukuran</th>
			<th style="text-align: center;">Tgl Pengambilan</th>
			<th style="text-align: center;">Keterangan</th>
			<th style="text-align: center;">Status</th>
			<th style="text-align: center;">Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$query=$con->prepare("select * from pemesanan order by id_pemesanan desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_pemesanan']; ?></td>
				<td><?php echo $q['nama']; ?></td>
				<td style="text-align: center;"><?php echo $q['telpon']; ?></td>
				<td><?php echo $q['alamat']; ?></td>
				<td style="text-align: center;"><?php if ($q['id_catalog']<>"0"){ ?><a target="_blank" href="index.php?detail=<?php echo $q['id_catalog']; ?>">Lihat Catalog</a><?php }else{ echo "Tidak Ada / Desain Sendiri"; } ?></td>
				<td><?php if (!empty($q['file'])){ ?><a href="gambar/<?php echo $q['file']; ?>">Download</a><?php }else{ echo "Tidak Ada"; } ?></td>
				<td style="text-align: center;"><?php echo $q['ukuran']; ?></td>
				<td style="text-align: center;"><?php echo $q['tgl_pengambilan']; ?></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				<td>
				<?php if ($q['status']=="4"){ ?>
				<a class="btn3" href="index.php?page=pengerjaan&token=<?php echo $q['id_pemesanan']; ?>">Sedang Dikerjakan</a>
				<?php } ?>
				<?php if ($q['status']=="5"){ ?> <a class="btn3" href="index.php?pesanan_selesai=<?php echo $q['id_pemesanan']; ?>">Selesai</a> <?php } ?>
				<?php if ($q['status']=="6"){ ?> <a class="btn3" href="index.php?kirim_pesanan=<?php echo $q['id_pemesanan']; ?>">Kirim Pesanan</a> <?php } ?>
				<a class="btn3" href="index.php?hapus_pemesanan=<?php echo $q['id_pemesanan']; ?>">Hapus</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>

		<?php
		//Menampilkan catalog / halaman Beranda
		if (empty($_GET['page']) and empty($_GET['detail']) and empty($_GET['pemesanan'])){
		$query=$con->prepare("select * from catalog order by id_catalog desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q) {
		?>
		<div class="body-isi">
		<div class="sampul">
		<div class="header-isi"><h2 style="margin: 5px 0 5px 0;color: rgb(203, 43, 122);"><?php echo $q['judul_catalog']; ?></h2></div>
		<div class="gambar-isi"><a target="_blank" href="gambar/<?php echo $q['gambar']; ?>"><img style="width: 100%; height: 400px;" src="gambar/<?php echo $q['gambar']; ?>"></a></div>
		<div class="keterangan-isi">
			<a class="btn" href="index.php?detail=<?php echo $q['id_catalog']; ?>">Lihat Detail</a> <a class="btn1" href="index.php?pemesanan=<?php echo $q['id_catalog']; ?>">Pesan Sekarang</a>
		</div>
		</div>
		</div>

		<?php } } ?>

		<?php
		//Menampilkan Form Kritik dan Saran
		if (!empty($_GET['page']) and $_GET['page']=="saran"){ ?>
	<!-- Form Kritik dan Saran -->
	<h3>Kritik dan Saran</h3>
	<form action="#" method="POST">
		<label>Nama Lengkap</label><br>
		<input type="text" name="nama"><br>
		<label>Alamat Email</label><br>
		<input type="email" name="email"><br>
		<label>Judul Kritik / Saran</label><br>
		<input type="text" name="judul"><br>
		<label>Isi Kritik / Saran</label><br>
		<textarea name="saran"></textarea><br>
		<input type="submit" class="btn2" name="simpan_saran" value="Kirim">
	</form>
	<!-- Akhir Form Kritik dan Saran -->
	<?php } ?>


	<?php
	//Menampilkan Form Input Catalog
	if (!empty($_GET['page']) and $_GET['page']=="catalog"){ ?>
	<!-- Form Catalog -->
	<h3>Catalog</h3>
		<form action="#" method="POST" enctype="multipart/form-data">
			<label>Judul Catalog</label><br>
			<input type="text" name="judul"><br>
			<label>Jenis Bahan</label><br>
			<input type="text" name="jenis_bahan"><br>
			<label>Ukuran</label><br>
			<input type="text" name="ukuran" placeholder="S,M,L,XL"><br>
			<label>Harga</label><br>
			<input type="text" name="harga"><br>
			<label>Gambar</label><br>
			<input type="file" name="gambar"><br>
			<label>Keterangan</label><br>
			<textarea name="keterangan" maxlength="100"></textarea><br>
			<input type="submit" class="btn2" name="simpan_catalog" value="Simpan">
		</form>
		<br><br>
		<!-- Menampilkan Data Catalog -->
		<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Catalog</th>
			<th style="text-align: center;">Judul Catalog</th>
			<th style="text-align: center;">Jenis Bahan</th>
			<th style="text-align: center;">Ukuran</th>
			<th style="text-align: center;">Harga</th>
			<th style="text-align: center;">Gambar</th>
			<th style="text-align: center;">Keterangan</th>
			<th style="text-align: center;">Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$query=$con->prepare("select * from catalog order by id_catalog desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_catalog']; ?></td>
				<td><?php echo $q['judul_catalog']; ?></td>
				<td><?php echo $q['jenis_bahan']; ?></td>
				<td style="text-align: center;"><?php echo $q['ukuran']; ?></td>
				<td style="text-align: right;"><?php echo $q['harga']; ?></td>
				<td><img style="width: 60px; height: 80px;" src="gambar/<?php echo $q['gambar']; ?>"/></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td><a class="btn3" href="index.php?hapus_catalog=<?php echo $q['id_catalog']; ?>">Hapus</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<!-- Akhir Form Catalog -->
	<?php } ?>


	<?php
	//Menampilkan Form Pembayaran pesanan
	if (!empty($_GET['page']) and $_GET['page']=="pembayaran"){ ?>
	<h3>Pembayaran Pesanan</h3>
	<form action="#" method="POST">
		<label>Id Pemesanan</label><br>
		<input type="text" <?php if (!empty($_GET['token'])){ echo 'value='.$_GET['token'].' readonly=readonly'; } ?> name="id_pemesanan"><br>
		<label>Nama Rekening</label><br>
		<input type="text" name="nama_rek"><br>
		<label>Nomor Rekening</label><br>
		<input type="text" name="no_rek"><br>
		<label>Jumlah Transfer</label><br>
		<input type="text" name="jumlah"><br>
		<label>Tanggal Transfer</label><br>
		<input type="text" name="tgl"><br>
		<label>Keterangan</label><br>
		<textarea name="keterangan"></textarea><br>
		<input type="submit" class="btn2" name="kirim_pembayaran" value="Kirim">
	</form>
	<?php } ?>

	<?php
	//Menampilkan data pembayaran pada halaman admin
	if (!empty($_GET['page']) and $_GET['page']=="data_pembayaran"){ ?>
	<h3>Data Pembayaran</h3>
		<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Pembayaran</th>
			<th style="text-align: center;">Id Pesanan</th>
			<th>Nama Rekening</th>
			<th>Nomor Rekening</th>
			<th style="text-align: center;">Jumlah Transfer</th>
			<th style="text-align: center;">Tanggal Transfer</th>
			<th>Keterangan</th>
			<th style="text-align: center;">Status</th>
			<th style="text-align: center;">Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$query=$con->prepare("select * from pembayaran order by id_pembayaran desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_pembayaran']; ?></td>
				<td style="text-align: center;"><a target="_blank" href="cetak_pemesanan.php?cetak_pemesanan=<?php echo $q['id_pemesanan']; ?>"><?php echo $q['id_pemesanan']; ?></td>
				<td><?php echo $q['nama_rek']; ?></td>
				<td><?php echo $q['no_rek']; ?></td>
				<td style="text-align: right;"><?php echo $q['jml_transfer']; ?></td>
				<td style="text-align: center;"><?php echo $q['tgl_transfer']; ?></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				<td>
					<?php if ($q['status']=="Menunggu Persetujuan"){ ?>
						<a class="btn3" href="index.php?setujui_pembayaran=<?php echo $q['id_pembayaran']; ?>">Setujui</a>
						<a class="btn3" href="index.php?tolak_pembayaran=<?php echo $q['id_pembayaran']; ?>">Tolak</a>
						<?php } ?> <a class="btn3" margin-top: 5px;" href="index.php?hapus_pembayaran=<?php echo $q['id_pembayaran']; ?>">Hapus</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>

	<?php
	//Menampilkan data kritik dan saran pada halaman admin
	if (!empty($_GET['page']) and $_GET['page']=="data_saran"){ ?>
	<h3>Kritik dan Saran</h3>
		<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Saran</th>
			<th style="text-align: center;">Nama</th>
			<th style="text-align: center;">Email</th>
			<th style="text-align: center;">Judul Saran</th>
			<th style="text-align: center;">Isi Saran</th>
			<th style="text-align: center;">Date</th>
			<th style="text-align: center;">Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$query=$con->prepare("select * from saran order by id_saran desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_saran']; ?></td>
				<td><?php echo $q['nama']; ?></td>
				<td><?php echo $q['email']; ?></td>
				<td><?php echo $q['judul']; ?></td>
				<td><?php echo $q['saran']; ?></td>
				<td style="text-align: center;"><?php echo $q['date']; ?></td>
				<td><a class="btn3" href="index.php?hapus_saran=<?php echo $q['id_saran']; ?>">Hapus</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>

	<?php
	//Menampilkan detail catalog
	if (!empty($_GET['detail'])){
		$id_catalog=$_GET['detail'];
		$query=$con->prepare("select * from catalog where id_catalog=:id_catalog");
		$query->BindParam(":id_catalog",$id_catalog);
		$query->execute();
		$query=$query->fetch();
		?>
	<h2>Detail Catalog</h2>
	<div class="img-detail"><a href="gambar/<?php echo $query['gambar']; ?>"><img style="width: 100%;" src="gambar/<?php echo $query['gambar']; ?>"/></a></div>
	<div class="detail">
	<h3><?php echo $query['judul_catalog']; ?></h3>
	<p>Jenis Bahan : <?php echo $query['jenis_bahan']; ?></p>
	<p>Ukuran : <?php echo $query['ukuran']; ?></p>
	<p>Harga : <?php echo number_format($query['harga'],0,".","."); ?> (Belum termasuk Ongkos Kirim, Silahkan cek Ongkos Kirim <a style="color: red;" href="index.php?page=cek_ongkir"> DISINI</a> )</p>
	<p>Keterangan : <?php echo $query['keterangan']; ?></p>
	<a class="btn1" href="index.php?pemesanan=<?php echo $query['id_catalog']; ?>">Pesan Sekarang</a>
	</div>
	<?php } ?>

	<?php
	//Menampilkan halaman tentang
	if (!empty($_GET['page']) and $_GET['page']=="tentang"){
		?>
		<div style="font-size: 22px;">
		<h3>Tentang Rumah Jahit Rifqa</h3>
		<h4>Siapa Kami</h4>
		<p>Rumah Jahit Rifqa adalah penjahit busana online yang hadir untuk menjawab kebutuhan berbusana keluarga anda. kebaya, baju kerja, blouse, gamis,  apapun kebutuhan busana anda, kami siap mewujudkannya, dengan standar kualitas jahitan yang tinggi dan mendetail untuk setiap aspek busana anda. Kami dedikasikan seluruh kemampuan terbaik kami untuk menghasilkan jahitan berkualitas demi kepuasan anda.</p>
		<h4>Awalnya</h4>
		<p>Rumah Jahit Rifqa dimulai pada tahun 2004, dengan personil satu orang, ibu Refni, seorang ibu rumah tangga yang pada awalnya mengerjakan semuanya seorang diri, seperti menjahit, membuat pola, memotong bahan, mengukur badan, finishing dll.</p>
		<img src="img1.png"/>
		<p>Keinginan untuk menjadi penjahit busana wanita muslimah sendiri mulai muncul di saat dirinya mengandung putri ketiganya (Rifqa), dilatar belakangi oleh susahnya mencari busana wanita muslimah yang nyaman, jahitan dan material yang bagus tapi dengan harga yang terjangkau untuk seorang istri pegawai biasa.</p><p>Sebenarnya, baju yang diimpikannya itu tersedia, tetapi harganya tidak sesuai dengan kemampuannya, mungkin karena busana muslimah itu adalah busana dengan branded yang terkenal, dan satu hal yang penting yang dialaminya adalah, baju-baju tersebut tidak ada yang sesuai ukurannya dengan ukuran badannya. Oleh karena itu itulah muncul keinginan kuat untuk membuat busana sendiri, menjadi seorang penjahit.</p>
		<p>Dengan bekal kemampuan menjahit yang telah dimiliki sejak gadis , kemudian diputuskannya untuk memperdalam kemampuannya dalam menjahit dengan mengikuti kursus menjahit tingkat dasar sampai tingkat menengah.</p> <p>Kemudian dibuatlah situs blog sederhana rumahjahitrifqa sebagai sarana promosi secara online. Tidak hanya hasil jahitan customer saja yang dipublikasikan di blog rumahjahitrifqa.
		</p>
		<img src="img2.png"/>
		<p>Misi RJR adalah membantu anda para wanita muslimah, memiliki busana yang fungsional, nyaman, enak dipakai, halus jahitannya dengan harga yang terjangkau.</p>
		</div>
		<?php
	}
	?>

	<?php
	//Menampilkan halaman cek ongkos kirim
	if (!empty($_GET['page']) and $_GET['page']=="cek_ongkir"){ ?>

		<div data-theme="light" id="rajaongkir-widget"></div>
		<script type="text/javascript" src="//rajaongkir.com/script/widget.js"></script>
	<?php } ?>

	<?php
	//Menampilkan Halaman contact
	if (!empty($_GET['page']) and $_GET['page']=="contact"){ ?>
	<div style="font-size: 22px;">
			<h3>Contact</h3>
			<h4>Rumah Jahit Rifqa Tailor</h4>
			<p>Alamat : Simpang Anjuang Jorong Batu Balantai Kecamatan Canduang Kabupaten Agam</p>
			<p>Telpon / HP / WA : 085767720388</p>
			<p>BBM : 4A3AS353</p>
			<p>Email : rumahjahitrifqa@gmail.com</p>
			<p>Nama Rekening : Merri Andani</p>
			<p>Nomor Rekening : 00910101925756 (BRI)</p>
			</div>
	<?php } ?>

	<?php
	//Menampilkan form testimoni dan data testimoni
	if (!empty($_GET['page']) and $_GET['page']=="testimoni"){ ?>
	<h3>Testimoni</h3>
	* Katakan sesuatu tentang pelayanan dan kinerja kami.<br><br>
		<form action="#" method="POST">
			<label>Nama Lengkap</label><br>
			<input type="text" name="nama" maxlength="30"><br>
			<label>Isi Testimoni</label><br>
			<textarea name="isi" maxlength="300"></textarea><br>
			<input type="submit" class="btn2" name="simpan_testimoni" value="Kirim">
		</form>
		<br>
		<h3>Pendapat orang-orang tentang hasil kinerja kami</h3><hr>
		<?php
		$query=$con->prepare("select * from testimoni where status<>'Tidak Tampil' order by date desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $query) { ?>
			<div class=""><h5 style="margin: 0;"><?php echo $query['nama']; ?><small> <?php echo $query['date']; ?></small></h5></div>
			<div class=""><p style="margin: 3px; color: #555; font-size: 20px; text-indent: 10px;"><?php echo $query['isi']; ?></p></div>
		<?php } } ?>

		<?php
		//Menampilkan data testimoni di halaman admin
		if (!empty($_GET['page']) and $_GET['page']=="data_testimoni"){ ?>
		<h3>Testimoni</h3>
			<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Testimoni</th>
			<th style="text-align: center;">Nama Lengkap</th>
			<th style="text-align: center;">Isi Testimoni</th>
			<th style="text-align: center;">Tanggal Kirim</th>
			<th style="text-align: center;">Status</th>
			<th style="text-align: center;">Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$query=$con->prepare("select * from testimoni order by date desc");
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_testimoni']; ?></td>
				<td><?php echo $q['nama']; ?></td>
				<td><?php echo $q['isi']; ?></td>
				<td><?php echo $q['date']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				<td><?php if ($q['status']=="Tidak Tampil"){ ?> <a class="btn3" href="index.php?update_testimoni=<?php echo $q['id_testimoni']; ?>">Tampilkan</a> <?php }else{ ?> <a class="btn3" href="index.php?update_testimoni=<?php echo $q['id_testimoni']; ?>">Sembunyikan</a> <?php } ?>
				<a class="btn3" href="index.php?hapus_testimoni=<?php echo $q['id_testimoni']; ?>">Hapus</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
		<?php } ?>

		<?php
		//Menampilkan form cek pemesanan
		if (!empty($_GET['page']) and $_GET['page']=="cek_pemesanan"){ ?>
		<h3>Cek Pemesanan</h3>
		<form action="#" method="POST">
		<label>Masukkan No Telpon / HP / WA</label>
		<input type="text" name="hp">
		<input type="submit" class="btn2" name="cek_pemesanan" value="Cek">
		</form>

		<?php } ?>

		<?php
		//Menampilkan hasil cek pemesanan berdasarkan nomor contact pemesan
		if (isset($_POST['cek_pemesanan'])){ ?>
		<h3>Data Pemesanan Anda</h3>
		Keterangan Angka pada kolom <b>Status</b> 
		<ol>
			<li>Menunggu Pembayaran</li>
			<li>Menunggu Persetujuan Pembayaran</li>
			<li>Pembayaran Ditolak</li>
			<li>Persiapan Pengerjaan (Pembayaran Telah Disetujui)</li>
			<li>Sedang Dikerjakan</li>
			<li>Pengerjaan Selesai dan Persiapan Pengiriman (Pada tahap ini kami akan menghubungi anda ke nomor kontak yang telah anda berikan)</li>
			<li>Telah Dikirim</li>
			<li>Jika Pesanan Telah Diterima</li>
		</ol>
			<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Pemesanan</th>
			<th>Nama Pemesan</th>
			<th style="text-align: center;">Telpon / HP</th>
			<th>Alamat</th>
			<th style="text-align: center;">Catalog Dipilih</th>
			<th>File Upload</th>
			<th style="text-align: center;">Ukuran</th>
			<th style="text-align: center;">Tgl Pengambilan</th>
			<th>Keterangan</th>
			<th style="text-align: center;">Status</th>
			<th>Aksi</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$hp=$_POST['hp'];
		$query=$con->prepare("select * from pemesanan where telpon=:hp order by id_pemesanan desc");
		$query->BindParam(":hp",$hp);
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_pemesanan']; ?></td>
				<td><?php echo $q['nama']; ?></td>
				<td style="text-align: center;"><?php echo $q['telpon']; ?></td>
				<td><?php echo $q['alamat']; ?></td>
				<td style="text-align: center;"><?php if ($q['id_catalog']<>"0"){ ?><a target="_blank" href="index.php?detail=<?php echo $q['id_catalog']; ?>">Lihat Catalog</a><?php }else{ echo "Tidak Ada / Desain Sendiri"; } ?></td>
				<td><?php if (!empty($q['file'])){ ?><a href="gambar/<?php echo $q['file']; ?>">Download</a><?php }else{ echo "Tidak Ada"; } ?></td>
				<td style="text-align: center;"><?php echo $q['ukuran']; ?></td>
				<td style="text-align: center;"><?php echo $q['tgl_pengambilan']; ?></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				<td>
				<?php if ($q['status']=="7"){ ?>
				<a class="btn3" target="_blank" href="index.php?pesanan_diterima=<?php echo $q['id_pemesanan']; ?>">Pesanan Diterima</a>
				<?php } ?>
				<?php if ($q['status']=="1" or $q['status']=="3"){ ?>
				<a class="btn3" target="_blank" href="index.php?page=pembayaran&token=<?php echo $q['id_pemesanan']; ?>">Bayar</a>
				<?php } ?>
				<a class="btn3" target="_blank" href="cetak_pemesanan.php?cetak_pemesanan=<?php echo $q['id_pemesanan']; ?>">Cetak</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
		<?php } ?>

		<?php
		//Halaman form laporan pemesanan
		if (!empty($_GET['page']) and $_GET['page']=="frm_lap_pemesanan"){ ?>
		<h3>Laporan Pemesanan</h3>
		<form action="laporan_pemesanan.php" method="POST">
			<h4>Berdasarkan Status</h4>
			<select name="status">
				<option value="">Pilih Status</option>
				<option value="1">Menunggu Pembayaran</option>
				<option value="2">Menunggu Persetujuan Pembayaran</option>
				<option value="4">Persiapan Pengerjaan</option>
				<option value="5">Sedang Dikerjakan</option>
				<option value="6">Pengerjaan Selesai</option>
				<option value="7">Telah Dikirim</option>
				<option value="8">Telah Diterima</option>
			</select>
			<input type="submit" class="btn2" name="lap_pemesanan_status" value="Tampilkan">
		</form>
<br>
		<form action="laporan_pemesanan.php" method="POST">
		<h4>Berdasarkan Tanggal</h4>
			Tanggal Awal 
			<select name="tgl1">
			<option value="">Tgl</option>
				<?php $tgl=1; while ($tgl<=31){ ?><option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option><?php $tgl++; } ?>
			</select>
			<select name="bln1">
				<option value="">Bln</option>
				<option value="01">Jan</option>
				<option value="02">Feb</option>
				<option value="03">Mar</option>
				<option value="04">Apr</option>
				<option value="05">Mei</option>
				<option value="06">Jun</option>
				<option value="07">Jul</option>
				<option value="08">Agu</option>
				<option value="09">Sep</option>
				<option value="10">Okt</option>
				<option value="11">Nov</option>
				<option value="12">Des</option>
			</select>
			<select name="thn1">
			<option value="">Thn</option>
				<?php $thn=date('Y'); while ($thn<=2025){ ?><option value="<?php echo $thn; ?>"><?php echo $thn; ?></option><?php $thn++; } ?>
			</select>
			Tanggal Akhir
			<select name="tgl2">
			<option value="">Tgl</option>
				<?php $tgl=1; while ($tgl<=31){ ?><option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option><?php $tgl++; } ?>
			</select>
			<select name="bln2">
				<option value="">Bln</option>
				<option value="01">Jan</option>
				<option value="02">Feb</option>
				<option value="03">Mar</option>
				<option value="04">Apr</option>
				<option value="05">Mei</option>
				<option value="06">Jun</option>
				<option value="07">Jul</option>
				<option value="08">Agu</option>
				<option value="09">Sep</option>
				<option value="10">Okt</option>
				<option value="11">Nov</option>
				<option value="12">Des</option>
			</select>
			<select name="thn2">
			<option value="">Thn</option>
				<?php $thn=date('Y'); while ($thn<=2025){ ?><option value="<?php echo $thn; ?>"><?php echo $thn; ?></option><?php $thn++; } ?>
			</select>
			<input type="submit" class="btn2" name="lap_pemesanan_tgl" value="Tampilkan">
		</form>

		<form action="laporan_pemesanan.php" method="POST">
				<h4>Tampilkan Semua</h4>
				<input type="submit" class="btn2" name="tampilkan_semua" value="Tampilkan Semua">
			</form>
		<?php } ?>

		<?php
		if (!empty($_GET['page']) and $_GET['page']=="frm_lap_pembayaran"){ ?>
		<h3>Laporan Pembayaran</h3>	
			<form action="laporan_pembayaran.php" method="POST">
				<h4>Berdasarkan Status Bayar</h4>
				<select name="status" required="" style="padding: 5px;">
					<option value="">Pilih Status</option>
					<option value="Disetujui">Disetujui</option>
					<option value="Ditolak">Ditolak</option>
				</select>
				<input type="submit" class="btn2" name="lap_pembayaran_status" value="Tampilkan">
			</form>

			<form action="laporan_pembayaran.php" method="POST">
				<h4>Tampilkan Semua</h4>
				<input type="submit" class="btn2" name="tampilkan_semua" value="Tampilkan Semua">
			</form>
		<?php } ?>
		
	</div>
	<!-- Akhir Class isi -->
</div>
<div class="sidebar" style="margin-top: 10px;">
	<?php
	//Menampilkan menu admin jika admin telah login
	if (!empty($_SESSION['username'])){ ?>
	<div class="aside">
	<h3 style="margin: 5px;color: rgb(0, 246, 255);">Menu Admin</h3>
		<ul>
		<li><a href="index.php?page=catalog">Input Catalog</a></li>
		<li><a href="index.php?page=data_saran">Data Kritik & Saran</a></li>
		<li><a href="index.php?page=data_testimoni">Data Testimoni</a></li>
		<li><a href="index.php?page=data_pemesanan">Data Pemesanan</a></li>
		<li><a href="index.php?page=data_pembayaran">Data Pembayaran</a></li>
		</ul>
		<h3 style="margin: 5px;color: rgb(0, 246, 255);">Laporan</h3>
		<ul>
		<li><a target="_blank" href="laporan_testimoni.php">Laporan Testimoni</a></li>
		<li><a target="_blank" href="laporan_saran.php">Laporan Kritik & Saran</a></li>
		<li><a href="index.php?page=frm_lap_pemesanan">Laporan Pemesanan</a></li>
		<li><a href="index.php?page=frm_lap_pembayaran">Laporan Pembayaran</a></li>
		<li><a href="index.php?keluar=true">Logout</a></li>
	</ul>
	</div>
	<?php } ?>
	<?php
	//Menampilkan form login jika admin tidak login
	if (empty($_SESSION['username'])){ ?>
	<div class="aside">
	<h3 style="margin: 5px;">Login</h3>
	<div style="margin-left: 15px;">
	<form action="#" method="POST">
		<label>Username</label><br>
		<input type="text" name="username" maxlength="30"><br>
		<label>Password</label><br>
		<input type="password" name="password" maxlength="30"><br>
		<input type="submit" class="btn2" name="login" value="Login">
	</form>
		</div>
		<?php } ?>

	</div>
</div>
<div class="footer">
	<p style="margin: 0; padding: 12px 16px; text-align: center;">Copyright &copy; Rumah Jahit Rifqa - <?php echo date('Y'); ?></p>
</div>
</body>
</html>