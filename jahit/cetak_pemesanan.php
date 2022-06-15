<!DOCTYPE html>
<html>
<head>
	<title>Rumah Jahit Rifqa | Cetak Pemesanan</title>
</head>
<body onload="window.print();">
	<table cellpadding="10px" align="center" border="1">
		<thead>
			<tr>
				<th colspan="2">Rumah Jahit Rifqa | Faktur Pemesanan Jahitan</th>
			</tr>
		</thead>
		<tbody>
		<?php
		include "koneksi.php";
		$id_pemesanan=$_GET['cetak_pemesanan'];
		$query=$con->prepare("select * from pemesanan where id_pemesanan=:id_pemesanan");
		$query->BindParam(":id_pemesanan",$id_pemesanan);
		$query->execute();
		$q=$query->fetch();
		?>
			<tr>
				<td>Id Pemesanan</td><td><?php echo $q['id_pemesanan']; ?></td></tr>
				<tr><td>Nama Pemesan</td><td><?php echo $q['nama']; ?></td></tr>
				<tr><td>Telpon / HP / WA</td><td><?php echo $q['telpon']; ?></td></tr>
				<tr><td>Alamat</td><td><?php echo $q['alamat']; ?></td></tr>
				<?php if ($q['id_catalog']=="0"){}else{ ?>
				<tr><td>Id Catalog</td><td><?php echo $q['id_catalog']; ?></td></tr>
				<?php } ?>
				<tr><td>Ukuran</td><td><?php echo $q['ukuran']; ?></td></tr>
				<tr><td>Tanggal Pengambilan</td><td><?php echo $q['tgl_pengambilan']; ?></td></tr>
				<tr><td>Keterangan</td><td><?php echo $q['keterangan']; ?></td></tr>
				<tr><td>Status</td><td><?php echo $q['status']; ?></td></tr>
				<tr><td>Tanggal Pemesanan</td><td><?php echo $q['date']; ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>