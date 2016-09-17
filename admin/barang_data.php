<?php 
include_once "../library/inc.sesadmin.php";   // Validasi, mengakses halaman harus Login
include_once "../library/inc.connection.php"; // Membuka koneksi
include_once "../library/inc.library.php";    // Membuka librari peringah fungsi

//paging
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql= "select * from barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging".mysql_error());
$jumlah = mysql_num_rows($pageQry);
$maksData = ceil($jumlah/$baris);
?>

<table width="700" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th colspan="2" align="right"><h1>DATA BARANG</h1></th>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="right"><a href="?open=Barang-Add"><img src="../images/btn_add_data.png" width="134" height="36" alt=""/></a></td>
    </tr>
    <tr>
      <td colspan="2"><table width="696" border="0" cellspacing="1" cellpadding="3">
        <tbody>
          <tr>
            <th width="33" scope="col">No</th>
            <th width="51" scope="col">Kode</th>
            <th width="250" scope="col">Nama Barang</th>
            <th width="72" scope="col">Stok</th>
            <th width="123" scope="col">Harga(Rp)</th>
            <th colspan="2" scope="col">Tools</th>
            </tr>
            <?php 
			$mySql = "select * from barang order by kd_barang asc limit $hal, $baris";
			$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
			$nomor = $hal;
			while ($myData = mysql_fetch_array($myQry)){
				$nomor++;
				$Kode = $myData['kd_barang'];
				
			?>
          <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $myData['kd_barang']; ?></td>
            <td><?php echo $myData['nm_barang']; ?></td>
            <td><?php echo $myData['stok']; ?></td>
            <td><?php echo format_angka($myData['harga_jual']); ?></td>
            <td width="62"><a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
            <td width="55"><a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick= "return confirm('ANDA YAKIN AKAN MWNGHAPUS DATA BARANG INI ... ?')">Delete</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>Jumlah Data : <?php $jumlah?></td>
      <td>Halaman ke : 
	  <?php for($h =1; $h<=$maksData; $h++){
		  $list[$h] = $baris * $h - $baris;
		  echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
		  }
		  ?>
          </td>
    </tr>
  </tbody>
</table>
