<?php
include_once '../library/inc.sesadmin.php';
//periksa data kode pada url
if(empty($_GET['Kode'])){
	echo "<b> Data yang dihapus tidak ada </b>";
	}else{
		// hapus data sesuai yang dikirim di url
		$Kode = $_GET['Kode'];
		$mySql = "delete from provinsi where kd_provinsi='$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Error hapus data!".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Provinsi_Data'>";
			}
		}
?>