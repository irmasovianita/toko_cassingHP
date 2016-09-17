<?php
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.library.php";

# MEMBACA TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
# Baca Variabel
$txtNama=$_POST['txtNama'];
$txtNama= str_replace("'","&acute;",$txtNama);

$txtBiaya	=$_POST['txtBiaya'];
$txtBiaya 	= str_replace("'","&acute;",$txtBiaya);

	// Validasi form
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Provinsi</b> masih kosong !";	
	}
	if (trim($txtBiaya)=="" or ! is_numeric(trim($txtBiaya))) {
		$pesanError[] = "Data <b>Biaya Kirim (Rp)</b> tidak boleh kosong, dan harus diisi angka !";		
	}

	// Validasi Nama Provinsi, tidak boleh ada yang kembar (namanya sama)
	$cekSql	= "SELECT * FROM provinsi WHERE nm_provinsi='$txtNama'";
	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Provinsi <b> $txtNama </b> sudah dimasukan";
	}

	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$kodeBaru	= buatKode("provinsi", "P");
		$mySql	= "INSERT INTO provinsi (kd_provinsi, nm_provinsi, biaya_kirim)	VALUES ('$kodeBaru', '$txtNama', '$txtBiaya')";
		$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Provinsi-Add'>";
		}
	}	
}

// Membuat nilai data pada form input
$dataKode	= buatKode("provinsi", "P");
$dataNama 	= isset($_POST['txtNama']) ?  $_POST['txtNama'] : '';
$dataBiaya	= isset($_POST['txtBiaya']) ?  $_POST['txtBiaya'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><strong>TAMBAH DATA PROVINSI</strong> </th>
    </tr>
    <tr>
      <td width="184"><strong>Kode</strong></td>
      <td width="3"><strong>:</strong></td>
      <td width="441"><input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Nama Provinsi </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Biaya Kirim (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtBiaya" type="text" value="<?php echo $dataBiaya; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></td>
    </tr>
  </table>
</form>
