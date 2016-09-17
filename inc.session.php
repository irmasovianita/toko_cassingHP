<?php 
if(empty($_SESSION['SES_PELANGGAN'])){
	echo "<center>";
	echo "<br><br> <b> Maaf Akses Anda Ditolak! </b> <br>
	Anda belum melakukan login, untuk mengakses halaman ini anda diharuskan melakukan login terlebih dahulu. Apabila belum memiliki account, silahkan daftar disini <br> [ <a href='?open=Pelanggan-Baru' target='_self'>Pendaftaran Baru</a>]";
	echo "<center>";
	exit;
	}
?>