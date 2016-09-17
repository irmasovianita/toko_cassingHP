<?php
//membuka koneksi database
include_once "../library/inc.connection.php";
#baca tombol login ketika diklik
if(isset($_POST['btnLogin'])){
    //baca variabel form
    $txtUsername = $_POST['txtUsername'];
    $txtUsername = str_replace("'","&acute;",$txtUsername);
    $txtPassword = $_POST['txtPassword'];
    $txtPassword = str_replace("'","&acute;",$txtPassword);
    // validasi form
    
    $pesanError = array();
    if (trim($txtUsername)==""){
        $pesanError[] = "Data <b> Username </b> tidak boleh kosong !";
    }
    if (trim($txtPassword)==""){
        $pesanError[] = "Data <b> Password </b> tidak boleh kosong !";
    }
    #jika pesan error message ditemukan
    if(count($pesanError)>=1){
        echo "<div align='left'";
        echo "<img src='../images/web icon/caution7.png'> <br><hr>";
        $noPesan=0;
        foreach($pesanError as $index=>$pesan_tampil){
            $noPesan++;
        echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
        }
        echo "</div> <br>";
        
        //panggil file login
        include"login.php";
    }else{ 
	$loginSql = "select * from admin where username='".$txtUsername."' and password='".md5($txtPassword)."'";
        $loginQry = mysql_query($loginSql, $koneksidb) or die ("Query salah : ".mysql_error());
        if (mysql_num_rows($loginQry)>=1){
            //jika berhasil login
            $_SESSION['SES_ADMIN'] = $txtUsername;
            echo "<meta http-equiv='refresh' content='0; url=?open=Home'>";
        }else{
            //jika gagal login
            echo "<meta http-equiv='refresh' content='0; url=?open=Login'>";
        }
        
    }
    
}
else{
    echo "<meta htto-equiv='refresh' content='0; url=?open=Login'>";
}
?>