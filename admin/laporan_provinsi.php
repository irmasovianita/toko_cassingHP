<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Data Provinsi</title>
</head>
<body>
<h2>LAPORAN DATA PROVINSI</h2>
<table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="30" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="468" bgcolor="#CCCCCC"><strong>Nama Provinsi </strong></td>
    <td width="130" align="right" bgcolor="#CCCCCC"><strong>Biaya Kirim (Rp) </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM provinsi ORDER BY nm_provinsi ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['nm_provinsi']; ?> </td>
    <td align="right"> <?php echo format_angka($myData['biaya_kirim']); ?> </td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
