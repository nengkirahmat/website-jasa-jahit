<!DOCTYPE html>
<html>
<head>
	<title>Rumah Jahit Rifqa | Laporan Kritik dan Saran</title>
</head>
<body onload="window.print();">
<center>
	<h1>Rumah Jahit Rifqa</h1>
	<h2>Laporan Kritik dan Saran</h2>
</center>
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
		include "koneksi.php";
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
				<td><a href="index.php?hapus_saran=<?php echo $q['id_saran']; ?>">Hapus</a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</body>
</html>