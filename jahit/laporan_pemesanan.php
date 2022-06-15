<!DOCTYPE html>
<html>
<head>
	<title>Rumah Jahit Rifqa | Laporan Pemesanan</title>
</head>
<body onload="window.print();">
<center>
<h1>Rumah Jahit Rifqa</h1>
<h2>Laporan Pemesanan Jahitan</h2>
</center>
		<table border="1" style="border: 1px; padding: 0; margin: 0; border-style: solid; width: 100%;">
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
		</tr>
		</thead>
		<tbody>
		<?php
		include "koneksi.php";
		if (isset($_POST['lap_pemesanan_status'])){
		$status=$_POST['status'];
		$query=$con->prepare("select * from pemesanan where status='$status' order by id_pemesanan desc");
		}
		if (isset($_POST['lap_pemesanan_tgl'])){
		$tgl1=$_POST['thn1'].'-'.$_POST['bln1'].'-'.$_POST['tgl1'];
		$tgl2=$_POST['thn2'].'-'.$_POST['bln2'].'-'.$_POST['tgl2'];
		$query=$con->prepare("select * from pemesanan where (date between '$tgl1' and '$tgl2') order by id_pemesanan desc");
		}
		if (isset($_POST['tampilkan_semua'])){
		$query=$con->prepare("select * from pemesanan order by id_pemesanan desc");	
		}
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_pemesanan']; ?></td>
				<td><?php echo $q['nama']; ?></td>
				<td style="text-align: center;"><?php echo $q['telpon']; ?></td>
				<td><?php echo $q['alamat']; ?></td>
				<td style="text-align: center;"><?php echo $q['id_catalog']; ?></td>
				<td style="text-align: center;"><?php if (!empty($q['file'])){ ?><a href="gambar/<?php echo $q['file']; ?>">Download</a><?php }else{ echo "Tidak Ada"; } ?></td>
				<td style="text-align: center;"><?php echo $q['ukuran']; ?></td>
				<td style="text-align: center;"><?php echo $q['tgl_pengambilan']; ?></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				
			</tr>
		<?php } ?>
		</tbody>
	</table>
</body>
</html>