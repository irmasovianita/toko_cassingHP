<?php

//membuat nilai data pada form input
#baca variabel form
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin = isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : 'Laki-Laki';
$dataEmail = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
$dataNnoTelepon = isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataUsername = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';

// tombol daftar diklik
if(isset($_POST['btnDaftar'])){
    //baca variabel form
    $txtNama = $_POST['txtNama'];
    $txtNama = str_replace("'","&acute;",$txtNama);
    $cmbKelamin = $_POST['cmbKelamin'];
    $txtEmail = $_POST['txtEmail'];
    $txtNoTelepon = $_POST['txtNoTelepon'];
    $txtUsername = $_POST['txtUsername'];
    $txtPassword_1 = $_POST['txtPassword_1'];
    $txtPassword_2 = $_POST['txtPassword_2'];
    
    //deklarasi pesan error untuk menyimpan pesan validasi
    $pesanError = array();
    
    if(trim($txtNama)==""){
        $pesanError[] = "Data <b> Nama Pelanggan </b> masih kosong";
    }
    if(trim($cmbKelamin)==""){
        $pesanError[] = "Data <b> Jenis Kelamin </b> belum dipilih";
    }
    if(trim($txtNoTelepon)==""){
        $pesanError[] = "Data <b> No Telepon </b> masih kosong";
    }
    if(trim($txtEmail)==""){
        $pesanError[] = "Data <b> Alamat Email </b> masih kosong";
    }
    if(trim($txtUsername)==""){
        $pesanError[] = "Data <b> username </b> masih kosong";
    }
    if(trim($txtPassword_1)==""){
        $pesanError[] = "Data <b> Password </b> masih kosong";
    }
    if(trim($txtNama)!= trim($txtPassword_2)){
        $pesanError[] = "Data <b> Password ke 2 </b> tidak sama dengan sebelumnya";
    }
    
    //validasi username
    $sqlCek = "select * from pelanggan where username='$txtUsername'";
    $qryCek = mysql_query($sqlCek, $koneksidb) or die ("Gagal cek");
    $adaCek= mysql_num_rows($qryCek);
    if($adaCek>=1){
        $pesanError[] = "Errrrrroooorrrrr....!!!, User <b> $txtUsername </b> sudah ada yang menggunakan.";
    }
    
    if(count($pesanError)>=1){
        echo "<div class='mssgBox'>";
        echo "<img src='images/attention.png'> <br><hr>";
        $noPesan=0;
        foreach ($pesanError as $indeks=>$pesan_tampil){
            $noPesan++;
            echo "&nbsp; $noPesan. $pesan_tampil<br>";
        }
    echo "</div> <br>"
    }else{
        #simpan ke database
        
        //simpan data dari form ke database
        $kodeBaru = buatKode("pelanggan", "P");
        $tanggal = date('Y-m-d');
        $mySql = "insert into pelanggan (kd_pelanggan, nm_pelanggan, kelamin, email, no_telepon, username, password, tgl_daftar) values
        ('$kodeBaru', '$txtNama', '$cmbKelamin', '$txtEmail', '$txtNoTelepon', '$txtUsername', MD5('$txtPassword_1'), $tanggal)";
        
        $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
        if($myQry){
            echo "<meta http-equiv='refresh' content='0; url='?open=Pelanggan-Baru&Aksi=Sukses'>";
        }
        exit;
    }
    
}

#konfirmasi jika penyimpanan sukses
if(isset($_GET['Aksi']) and $_GET['Aksi']=="Sukses"){
    echo "<br><br><center> <b>SELAMAT, PENDAFTARAN ANDA BERHASIL</b><br> sekarang anda dapat login untuk melakukan pemesanan </center>";
    echo "<meta http-equiv='refresh' content='2; url='?open=Barang'>";
    
    exit;
}
?>
