<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membaca Kategori yang dipilih
$kodeKategori= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : 'SEMUA';
$dataKategori= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKategori;

// Membuat SQL Filter data
if(trim($dataKategori)=="SEMUA") {
	$filterSql = ""; 
}
else {
	$filterSql = "WHERE kd_kategori='$dataKategori'";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang $filterSql";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah	 = mysql_num_rows($pageQry);
$maksData = ceil($jumlah/$baris);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Data Barang</title>
</head>
<body>
<h2>LAPORAN DATA BARANG</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="450" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>KATEGORI  BARANG </strong></td>
    </tr>
    <tr>
      <td width="108"><strong>Pilih Kategori </strong></td>
      <td width="3">:</td>
      <td width="317"><strong>
		<select name="cmbKategori">
		<option value="SEMUA">....</option>
		<?php
		$bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		while ($bacaData = mysql_fetch_array($bacaQry)) {
			if ($bacaData['kd_kategori']== $dataKategori) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bacaData[kd_kategori]' $cek> $bacaData[nm_kategori] </option>";
		}
		?>
		</select>
        <input name="btnTampil" type="submit" value="Tampilkan" />
      </strong></td>
    </tr>
  </table>
</form>


<table width="750" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="27" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="389" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="40" bgcolor="#CCCCCC"><strong>Stok</strong></td>
    <td width="91" bgcolor="#CCCCCC"><strong>H Modal(Rp) </strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>H Jual(Rp) </strong></td>
  </tr>
	<?php	
	$mySql = "SELECT * FROM barang $filterSql ORDER BY kd_barang ASC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['stok']; ?></td>
    <td><?php echo format_angka($myData['harga_modal']); ?></td>
    <td><?php echo format_angka($myData['harga_jual']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data : <?php echo $jumlah; ?></strong></td>
    <td colspan="3" align="right">
	<strong>Halaman ke :
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
	$list[$h] = $baris * $h - $baris;
	echo " <a href='?open=Laporan-Barang&hal=$list[$h]&kodeKat=$dataKategori'>$h</a> ";
	}
	?></strong>
</td>
  </tr>
</table>
</body>
</html>
