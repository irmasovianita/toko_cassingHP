<?php
include_once "../library/inc.sesadmin.php";   // Validasi, mengakses halaman harus Login
include_once "../library/inc.connection.php"; // Membuka koneksi
include_once "../library/inc.library.php";    // Membuka librari peringah fungsi

# Deklarasi variabel
$filterSql	= ""; 
$startTgl	= ""; 

# Filter data berdasarkan Tanggal
$tanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$filterSql	= "AND tgl_pemesanan = '".InggrisTgl($tanggal)."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Pemesanan Lunas per Tanggal</title>
</head>
<body>
<h2>LAPORAN PEMESANAN LUNAS PER TANGGAL</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
  <table width="500" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="133"><strong>Tanggal Transaksi</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="340"><input name="txtTanggal" type="text" class="tcal"  value="<?php echo $tanggal; ?>" size="22" />
        <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="61" bgcolor="#CCCCCC"><b>Tanggal</b></td>
    <td width="106" bgcolor="#CCCCCC"><b>No. Pemesanan </b> </td>
    <td width="70" bgcolor="#CCCCCC"><strong>Kode Plg </strong></td>
    <td width="191" bgcolor="#CCCCCC"><strong>Nama Pelanggan </strong></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><strong>Total Brg  </strong></td>
    <td width="125" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td width="37" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	// Deklrasi variabel angka
	$totalBayar 	= 0;
	$totalBiayaKirim	= 0;
	$totItemBarang	= 0;
	$totOmset		= 0;

	// Menampilkan Semua Pemesanan yang sudah Lunas, dengan filter terpilih
	$mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan, provinsi.biaya_kirim FROM pemesanan 
				LEFT JOIN pelanggan ON pemesanan.kd_pelanggan = pelanggan.kd_pelanggan
				LEFT JOIN provinsi ON pemesanan.kd_provinsi = provinsi.kd_provinsi
				WHERE pemesanan.status_bayar='Lunas' 
				$filterSql ORDER BY pemesanan.no_pemesanan";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		// Membaca Kode pemesanan/ Nomor transaksi
		$Kode = $myData['no_pemesanan'];  
		
		# SUB SKRIP & SQL	
		
		// MENGHITUNG TOTAL BAYAR, TOTAL JUMLAH BARANG dengan perintah SQL
		$my2Sql	= "SELECT SUM(harga * jumlah) As total_bayar,
					SUM(jumlah) As total_barang 
					FROM pemesanan_item WHERE no_pemesanan='$Kode'";
		$my2Qry = @mysql_query($my2Sql, $koneksidb) or die ("Gagal query".mysql_error());
		$my2Data =mysql_fetch_array($my2Qry);
		
		// Menghitung Total Bayar
		$totalBiayaKirim= $myData['biaya_kirim'] * $my2Data['total_barang'];
		$totalBayar 	= $my2Data['total_bayar'] + $totalBiayaKirim;

		// MENJUMLAH TOTAL SEMUA DATA YANG TAMPIL (Dari baris pertama sampai terakhir)
		$totItemBarang	= $totItemBarang + $my2Data['total_barang'];
		$totOmset		= $totOmset + $totalBayar;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
    <td><?php echo $myData['no_pemesanan']; ?></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td align="right"><?php echo $my2Data['total_barang']; ?></td>
    <td align="right"><?php echo format_angka($totalBayar); ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong> TOTAL : </strong></td>
    <td align="right"> <strong><?php echo format_angka($totItemBarang); ?></strong> </td>
    <td align="right"> <strong> Rp. <?php echo format_angka($totOmset); ?> </strong> </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
