<?php 
//validasi : hanya untuk yang sudah login 
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.library.php";
include_once "../library/inc.connection.php";


//tombol simpan diklik
if(isset($_post['btnSimpan'])){
	//simpan data
	#baca Variabel
	$txtNama = $_POST['txtNama'];
	$txtNama = str_replace("'","&acute;",$txtNama);
	
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data <b> Nama Kategori </b>tidak boleh kosong !";
		}
		
	//cek nama yang sama
	$txtNamaLama = $_POST['txtNamaLama'];
	$cekSql = "select * from kategori where nm_kategori='$txtNama' and not (nm_kategori='$txtNamaLama')";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Query salah".mysql_error());
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Kategori <b> $txtNama </b>sudah ada, ganti dengan nama yang berbeda";
		}
	
	if(count($pesanError)>=1){
		echo "<div class ='mssgBox'>";
		echo "<img src='../images/web icon/png/cancel22.png'> <br><hr>";
		$noPesan=0;
		foreach($pesanError as $indeks=>$pesan_tampil){
			$noPesan++;
		echo "&nbsp; $noPesan. $pesan_tampil<br>";
			}
		echo "</div> <br>";
		} else{
			#simpan ke database
			//membuat kode kategori baru
			$kodeBaru = buatKode("kategori", "K");
			$mySql = "update kategori set nm_kategori='$txtNama' where kd_kategori ='$Kode'";
			$myQry = mysql_query($mySql) or die ("Query Sala".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Add'>";
				}
			exit;
			}
	}

//MEMBAACA DATA DARI FORM/ DATABASE, UNTUK DITAMPILKAN KEMBALI PADA FORM
$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];	
$mySql = "select * from kategori where kd_kategori='$Kode'";
$myQr = mysql_query($mySql, $koneksidb) or die ("Query ambil data salah".mysql_error());
$myData = mysql_fetch_array($myQr);

//memasukkan data ke variable, untuk dibaca di form input
$dataKode = $myData['kd_kategori'];
$dataKategori = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_kategori'];

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" target="_self"></form>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th colspan="3" scope="col">UBAH DATA KATEGORI</th>
    </tr>
    <tr>
      <td width="133">Kode</td>
      <td width="8">:</td>
      <td width="487">
      <input name="textfield" type="text" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly/>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $datKode;?>"></td>
    </tr>
    <tr>
      <td>Nama Kategori</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" id="txtNama" value="<?php echo $dataKategori; ?>" size="70" maxlength="100">
      <input name="txtNamaLama" type="hidden" id="txtNamaLama" value="<?php  echo $myData['nm_kategori']; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Simpan"></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
