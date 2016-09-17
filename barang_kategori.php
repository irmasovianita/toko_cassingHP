
<?php 
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Membaca Kode filter Kategori
if(isset($_GET['Kode'])) {
	// Membaca Kode dari URL
	$Kode	= $_GET['Kode'];
	
	if (trim($_GET['Kode']) == "") {
		$filterSql = " ";
	}
	else {
		$filterSql = "WHERE barang.kd_kategori='$Kode'";
	}
}

# Membaca data kategori
$infoSql = "SELECT * FROM kategori  WHERE kd_kategori='$Kode'";
$infoQry = mysql_query($infoSql, $koneksidb) or die ("Query salah".mysql_error());
$infoData= mysql_fetch_array($infoQry);


#nomor halaman (paging)
$baris = 10;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql = "select * from barang $filterSql order by kd_barang desc";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging".mysql_error());
$jml = mysql_num_rows($pageQry);
$maks = ceil($jml/$baris);
$mulai = $baris * ($hal-1);
?>


<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <td colspan="2" align="center" bgcolor="#cccccc">KOLEKSI BARANG <?php echo strtoupper($infoData['nm_kategori']); ?></td>
    </tr>
    <?php 
	//menampilkan daftar barang
	$barangSql = "select barang.*, kategori.nm_kategori from barang left join kategori on barang.kd_kategori = kategori.kd_kategori $filterSql order by barang.kd_barang asc limit $mulai, $baris";
	$barangQry = mysql_query($barangSql, $koneksidb) or die ("Gagal Query".mysql_error()); 
$nomor = 0;
while ($barangData = mysql_fetch_array($barangQry)) {
	$nomor++;
	$KodeBarang = $barangData['kd_barang'];
	$KodeKategori = $barangData['kd_kategori'];
	
	// Membaca file gambar
	if ($barangData['file_gambar']=="") {
		$fileGambar = "noimage.jpg";
	}
	else {
		$fileGambar	= $barangData['file_gambar'];
	}
	?>
    <tr>
      <td width="24%"><a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>"><img src="img-barang/<?php echo $fileGambar; ?>" width="100" border="0"> </a> <br>
      <div class='harga'>Rp. <?php echo format_angka($barangData['harga_jual']); ?> </div><br>
    <a href="?open=Barang-Beli&Kode=<?php echo $KodeBarang; ?>" class="button orange small"> <strong>Beli</strong></a> </td>
    <td width="76%">
	  <a href="?open=Barang-Lihat&Kode=<?php echo $KodeBarang; ?>">
      <div class='judul'> <?php echo $barangData['nm_barang']; ?> </div>
      </a>
      
	  <p><?php echo substr($barangData['keterangan'], 0, 200); ?> ....</p>
      <p><strong>Stok :</strong> <?php echo $barangData['stok']; ?> </p>
    <strong>Kategori :</strong> <a href="?open=Kategori-Barang&Kode=<?php echo $KodeKategori; ?>"> <?php echo $barangData['nm_kategori']; ?> </a> </td>
  </tr>
<?php } ?>
    <tr>
    <td colspan="2" align="center" bgcolor="#F5F5F5">
	<b>Halaman:
    <?php
	for ($h = 1; $h <= $maks; $h++) {
			echo "[  <a href='?open=Barang-Kategori&Kode=$KodeKategori&hal=$h'>$h</a> ]";
	}
	?>
    </b></td>
  </tr>
  </tbody>
</table>
