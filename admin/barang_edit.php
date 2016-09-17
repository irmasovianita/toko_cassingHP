<?php 
//validasi : halaman ini hanya boleh diakses oleh user yang sudah login
include_once"../library/inc.sesadmin.php";
include_once"../library/inc.library.php";
include_once"../library/inc.connection.php";

//tombol simpan diklik
if(isset($_POST['btnSimpan'])){
	#baca variabel form
	$txtNama = $_POST['txtNama'];
	$txtNama = ucwords (strtolower($txtNama));
	$txtHrgModal = $_POST['txtHrgModal'];
	$txtHrgJual = $_POST['txtHrgJual'];
	$txtStok = $_POST['txtStok'];
	$txtKeterangan = $_POST['txtKeterangan'];
	$cmbKategori = $_POST['cmbKategori'];
	
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[]= "Data <b> Nama Barang </b> tidak boleh kosong !";
		}
	if(trim($txtHrgModal)=="" or ! is_numeric(trim($txtHrgModal))){
		$pesanError[]= "Data <b> Harga Modal (Rp) </b> tidak boleh kosong !";
		}
	if(trim($txtHrgJual)=="" or ! is_numeric(trim($txtHrgJual))){
		$pesanError[]= "Data <b> Harga Jual (Rp) </b> tidak boleh kosong !";
		}
	if(trim($txtStok)=="" or ! is_numeric(trim($txtStok))){
		$pesanError[]= "Data <b> Stok</b> tidak boleh kosong !";
		}
	if(trim($txtKeterangan)==""){
		$pesanError[]= "Data <b> Keterangan</b> tidak boleh kosong !";
		}
	if(trim($cmbKategori)=="KOSONG"){
		$pesanError[]= "Data <b> Kategori</b> belum dipilih !";
		}
	
	//menampilkan pesan error jika ditemukan di skrip validasi
	if(count($pesanError)>=1){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/web icon/png/button14.png'> <br><hr>";
		$noPesan=0;
		foreach($pesanError as $indeks=>$pesan_tampil){
			$noPesan++;
			}
		echo "</div> <br>";
		}
		else{
			//Membaca kode dari form
			$Kode = $_POST['txtKode'];
			//mengkopy file gambar
			if(trim($_FILES['namaFile']['name'])==""){
				$nama_file = $_POST['txtNamaFileH'];
				}else{
					if(file_exists("../img-barang/".$_POST['txtNamaFileH'])){
						unlink("../img-barang/".$_POST['txtNamaFileH']);
						}
						//mengkopy file gambar baru ditambahkan
				$nama_file = $_FILES['namaFile']['name'];
				$nama_file = stripslashes($nama_file);
				$nama_file = str_replace("'","",$nama_file);
				$nama_file = $Kode.".".$nama_file;
				copy($_FILES['namaFile']['tmp_name'], "../img-barang/".$nama_file);
					}
			
			
			// Simpan hasil perubahan data
		$mySql	= "UPDATE barang SET
					nm_barang	= '$txtNama',
					harga_modal = '$txtHrgModal',
					harga_jual 	= '$txtHrgJual',
					stok 		= '$txtStok',
					keterangan 	= '$txtKeterangan',
					file_gambar	= '$nama_file',
					kd_kategori = '$cmbKategori' WHERE kd_barang = '$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		if($myQry){
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
				}
			}
	}
	
	//mengambil data barang dari database
	$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
	$mySql = "select * from barang where kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query ambil data barang salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	
	//memasukkan data yang diambil dari database ke form input
	 $dataKode = $myData['kd_barang'];
	 $dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	 $dataHrgModal = isset($_POST['txtHrgModal']) ? $_POST['txtHrgModal'] : $myData['harga_modal'];
	 $dataHrgJual = isset($_POST['txtHrgJual']) ? $_POST['txtHrgJual'] : $myData['harga_jual'];
	 $dataStok = isset($_POST['txtStok']) ? $_POST['txtStok'] : $myData['stok'];
	 $dataKeterangan = isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
	 $dataKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];

?>

<form name="frmadd" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" target="_self" enctype="multipart/form-data">
<table calss="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
  <tbody>
    <tr>
      <th colspan="3" scope="col">TAMBAH DATA BARANG</th>
    </tr>
    <tr>
      <td width="138">Kode</td>
      <td width="10">:</td>
      <td width="480">
      <input name="textfield" type="text" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td>Nama Barang</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="200"></td>
    </tr>
    <tr>
      <td>Harga Modal (Rp)</td>
      <td>:</td>
      <td><input name="txtHrgModal" type="text" id="txtHrgModal" value="<?php echo $dataHrgModal; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>Harga Jual (Rp)</td>
      <td>:</td>
      <td><input name="txtHrgJual" type="text" id="txtHrgJual" value="<?php echo $dataHrgJual; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>Jumlah Stok</td>
      <td>:</td>
      <td><input name="txtStok" type="text" id="txtStok" value="<?php echo $dataStok; ?>" size="10" maxlength="4"></td>
    </tr>
    <tr>
      <td>File Gambar</td>
      <td>:</td>
      <td><label for="namaFile"></label>
      <input type="file" name="namaFile" id="namaFile" size="50">
      <input name="txtNamaFileH" type="hidden" id="txtNamaFileH" value="<?php echo $myData['file_gambar']; ?>"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><label for="txtKeterangan"></label>
      <textarea name="txtKeterangan" id="txtKeterangan" cols="70" rows="6"><?php echo $dataKeterangan;?></textarea></td>
    </tr>
    <tr>
      <td>Kategori</td>
      <td>:</td>
      <td><select name="cmbKategori" >
      <option value="KOSONG">...</option>
      <?php 
	  $mySql = "select * from kategori order by nm_kategori";
	  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	  while($myData = mysql_fetch_array($myQry)){
		  if($myData['kd_kategori']==$dataKategori){
			  $cek= " selected";
			  }else{
				  $cek="";
				  }
			echo "<option value='$myData[kd_kategori]' $cek> $myData[nm_kategori]";
		  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="submit" value="SIMPAN DATA"></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</form>
