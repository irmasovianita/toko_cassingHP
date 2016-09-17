<table width="700" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th align="right"><h1>DATA KATEGORI</h1></th>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><a href="?open=Kategori-Add"  target="_self"><img src="../images/btn_add_data.png" width="134" height="36" alt=""/></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width="700" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th width="53" scope="col">No</th>
      <th width="498" scope="col">Nama Kategori</th>
      <th colspan="2" scope="col">Tools</th>
    </tr>
    <?php 
	include_once '../library/inc.connection.php';
	$mySql= "select * from kategori order by nm_kategori asc";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
	$nomor = 0;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
		$Kode = $myData ['kd_kategori'];
	?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $myData['nm_kategori']; ?></td>
      <td width="62"><a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      <td width="58"><a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA KATEGORI INI ... ?')">Delete</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
