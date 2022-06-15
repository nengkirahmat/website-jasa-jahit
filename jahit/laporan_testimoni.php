<!DOCTYPE html>
<html>
<head>
	<title>Rumah Jahit Rifqa | Laporan Testimoni</title>
</head>
<body onload="window.print();">
<center>
<h1>Rumah Jahit Rifqa</h1>
<h2>Laporan Testimoni</h2>
</center>
			<table border="1" style="width: 100%; border: 1px; border-style: solid; padding: 0; margin: 0">
		<thead>
		<tr>
			<th style="text-align: center;">Id Testimoni</th>
			<th style="text-align: center;">Nama Lengkap</th>
			<th style="text-align: center;">Isi Testimoni</th>
			<th style="text-align: center;">Tanggal Kirim</th>
			<th style="text-align: center;">Status</th>
		</tr>
		</thead>
		<tbody>
		<?php
		include "koneksi.php";
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
				
			</tr>
		<?php } ?>
		</tbody>
	</table>
</body>
</html>