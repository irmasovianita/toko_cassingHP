<?php 
include_once"../library/inc.sesadmin.php";
if(empty($_GET['Kode'])){
	echo "<b>Data yang dihapus tidak ada</b>";
	}else{
		//hapus data sesuai kode yang dikirim url
		$Kode = $_GET['Kode'];
		$mySql = "delete from kategori where kd_kategori='$Kode'";
		$myQry = mysql_query($mySQl, $koneksidb) or die ("Error Hapus Data".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
			}
		}
?>