<!DOCTYPE html>
<html>
<head>
	<title>Rumah Jahit Rifqa | Laporan Pembayaran</title>
</head>
<body onload="window.print();">
<center>
<h1>Rumah Jahit Rifqa</h1>
<h2>Laporan Pembayaran Jahitan</h2>
</center>
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
		</tr>
		</thead>
		<tbody>
		<?php
		include "koneksi.php";
		if (isset($_POST['lap_pembayaran_status'])){
			$status=$_POST['status'];
			$query=$con->prepare("select * from pembayaran where status='$status' order by id_pembayaran desc");
		}
		if (isset($_POST['tampilkan_semua'])){
		$query=$con->prepare("select * from pembayaran order by id_pembayaran desc");
		}
		$query->execute();
		$query=$query->fetchAll();
		foreach ($query as $q){
		?>
			<tr>
				<td style="text-align: center;"><?php echo $q['id_pembayaran']; ?></td>
				<td style="text-align: center;"><?php echo $q['id_pemesanan']; ?></td>
				<td><?php echo $q['nama_rek']; ?></td>
				<td><?php echo $q['no_rek']; ?></td>
				<td style="text-align: right;">Rp.<?php echo number_format($q['jml_transfer'],0,".","."); ?></td>
				<td style="text-align: center;"><?php echo $q['tgl_transfer']; ?></td>
				<td><?php echo $q['keterangan']; ?></td>
				<td style="text-align: center;"><?php echo $q['status']; ?></td>
				
			</tr>
		<?php } ?>
		</tbody>
	</table>
</body>
</html>