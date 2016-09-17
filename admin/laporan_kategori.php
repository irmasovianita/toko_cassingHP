<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Data Kategori</title>
</head>
<body>
<h2> LAPORAN DATA KATEGORI </h2>
<table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="30" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="498" bgcolor="#CCCCCC"><strong>Nama Kategori</strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategori']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
  </tr>
	<?php } ?>
</table>
</body>
</html>
