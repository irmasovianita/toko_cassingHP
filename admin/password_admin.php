<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
//membaca data login untuk diedit
$mySql = "Select * from admin";
$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah :".mysql_error());
$myData = mysql_fetch_array($myQry);

#Tombol simpan diklik
if(isset($_POST['btnSimpan'])){
	
	
//baca Variabel form
$txtPassLama = $_POST['txtPassLama'];
$txtPassBaru = $_POST['txtPassBaru'];

$pesanError = array();

if (trim($txtPassLama)==""){
	$pesanError[] = "Data <b> Password Lama </b> belum diisi !";
	}
	
if (trim($txtPassBaru)==""){
	$pesanError[] = "Data <b> Password Baru </b> belum diisi !";
	}
	
//Validasi Password Lama (harus benar)
$sqlCek = "select * from admin where username='admin' and password='". md5($txtPassLama)."'";
$qryCek = mysql_query($sqlCek, $koneksidb) or die ("Query periksa password salah : ".mysql_error());
if(mysql_num_rows($qryCek)<1){
	$pesanError[] = "Maaf, <b> Password Anda Salah </b>... silahkan ulangi";
	}
	
if (count($pesanError)>=1){
	echo "<div class='mssgBox'>";
	echo "<img src='../images/web icon/png/button14.png'> <br><hr>";
	$noPesan=0;
	foreach ($pesanError as $index=>$pesan_tampil){
		$noPesan++;
	echo "&nbsp; $noPesan. $pesan_tampil <br>";
	}
	echo "</div> <br>";
		}else{
			#Simpan ke database
			$mySql = "Update admin set password = '".md5($txtPassBaru)."'";
			$myQry = mysql_query($mySql, $koneksidb);
			if($myQry){
				echo "<meta http-equiv='refresh content='0; url=?page=Logout&info=Password Berhasil Diganti'>";
				}
			}
}
?>


<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" target="_self">
<table class="table-list" width="708" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th colspan="3" scope="col">Ganti Password Admin</th>
      </tr>
    <tr>
      <td width="139">Username</td>
      <td width="15">:</td>
      <td width="532"><strong><?php echo $myData['username']; ?></strong></td>
    </tr>
    <tr>
      <td>Password Lama</td>
      <td>:</td>
      <td>
        <input name="txtPassLama" type="password" id="password" size="40" maxlength="30"></td>
    </tr>
    <tr>
      <td>Password Baru</td>
      <td>:</td>
      <td>
        <input name="txtPassBaru" type="password" id="password2" size="40" maxlength="30"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan"></td>
    </tr>
  </tbody>
</table>

</form>
