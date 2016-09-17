<table width="700" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <td align="right"><h1>
      DATA PROVINSI </h1></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <<td colspan="2" align="right"><a href="?open=Provinsi-Add" target="_self"><img src="../images/btn_add_data.png" alt="Tambah Data Provinsi" border="0" /></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width="701" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th width="51" scope="col">No</th>
      <th width="281" scope="col">Nama Provinsi</th>
      <th width="229" scope="col">Biaya Kirim</th>
      <th colspan="2" scope="col">Tools</th>
    </tr>
    <?php
	include_once "../library/inc.connection.php";
	$mySql = "select * from provinsi order by nm_provinsi ASC";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
	$nomor=0;
	while ($myData = mysql_fetch_array($myQry)){
		$nomor++;
		$Kode = $myData['kd_provinsi'];
	?>
    <tr>
      <td><?php  echo $nomor; ?></td>
      <td><?php  echo $myData['nm_provinsi'];?></td>
      <td><?php  echo format_angka($myData['biaya_kirim']);?></td>
      <td width="54"><a href="?open=Provinsi-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      <td width="50"><a href="?open=Provinsi-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PROVINSI INI ...?')">Delete</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
