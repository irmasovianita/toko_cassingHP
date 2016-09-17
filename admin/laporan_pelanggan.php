<?php
include_once "../library/inc.sesadmin.php";   // Validasi halaman harus Login
include_once "../library/inc.connection.php"; // Membuka koneksi
include_once "../library/inc.library.php";    // Membuka librari peringah fungsi

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 	= 50;
$hal	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pelanggan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Data Pelanggan</title>
</head>
<body>
<h2>LAPORAN DATA PELANGGAN</h2>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Pelanggan </strong></td>
    <td width="212" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></td>
    <td width="58" bgcolor="#CCCCCC"><strong>Kelamin</strong></td>
    <td width="84" bgcolor="#CCCCCC"><strong>No. Telefon </strong></td>
    <td width="124" bgcolor="#CCCCCC"><strong> E-Mail </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Username</strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['email']; ?></td>
    <td><?php echo $myData['username']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jml; ?></strong></td>
    <td colspan="4" align="right"><strong>Halaman ke :
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pelanggan&hal=$list[$h]'>$h</a> ";
	}
	?>    
      </strong></td>
  </tr>
</table>
</body>
</html>
