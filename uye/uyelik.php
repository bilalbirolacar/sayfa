<?php ob_start();
/*
www.celalyurtcu.com
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Yeni �yelik</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p><a href="index.php">Anasayfa</a></p>
<p>&nbsp;</p>
<form name="uye_form" method="post" action="uyelik.php">
  <table width="300" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td>&nbsp;</td>
    <td class="giris_td"><img src="images/uye_kart.png" width="48" height="48" /></td>
  </tr>
  <tr>
    <td>Kullan�c� ad�:</td>
    <td><input type="text" name="kullanici_adi" /> <font color="#FF0000">*</font></td>
  </tr>
  <tr>
    <td>�ifre:</td>
    <td><input type="password" name="parola" /> <font color="#FF0000">*</font></td>
  </tr>
    <tr>
    <td>�ifre Tekrar:</td>
    <td><input type="password" name="parolatekrar" /> <font color="#FF0000">*</font></td>
  </tr>
    <tr>
    <td>E-Posta:</td>
    <td><input type="text" name="eposta" /> <font color="#FF0000">*</font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="�ye Ol" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
</form>

<?php

if($_SERVER['REQUEST_METHOD'] == "POST")
{

include("baglanti.php");

$kullanici_adi = $_POST["kullanici_adi"];
$parola = $_POST["parola"];
$parolatekrar = $_POST["parolatekrar"];
$eposta = $_POST["eposta"];
$button = $_POST["button"];
$tarih = date("y-m-d");


if($kullanici_adi=="" or $parola=="" or $parolatekrar=="" or $eposta=="")
{
	echo "<center><img src=images/hata.gif border=0 /> L�tfen t�m alanlar� eksiksiz doldurun!</center>";
	header("Refresh: 2; url=uyelik.php");
	return;
}
elseif($parola != $parolatekrar)
{
	echo "<center><img src=images/hata.gif border=0 /> Parola ve Parola Tekrar alanlar� ayn� olmal�!</center>";
	header("Refresh: 2; url=uyelik.php");
	return;	
}

function checkmail($eposta){
  return filter_var($eposta, FILTER_VALIDATE_EMAIL);
}

if(!checkmail($eposta))
{
	echo "<center><img src=images/hata.gif border=0 /> Yazd���n�z e-posta adresi ge�ersiz!</center>";
	header("Refresh: 2; url=uyelik.php");
	return;	
}

$isim_kontrol = mysql_query("select * from uyeler where kullanici_adi='".$kullanici_adi."'") or die (mysql_error());

$uye_varmi = mysql_num_rows($isim_kontrol);
if($uye_varmi > 0)
{
	echo "<center><img src=images/hata.gif border=0 /> Kullan�c� ad� ba�ka bir �ye taraf�ndan kullan�l�yor!</center>";
	header("Refresh: 2; url=uyelik.php");
	return;		
}

$eposta_kontrol = mysql_query("select * from uyeler where eposta='".$eposta."'") or die (mysql_error());

$eposta_varmi = mysql_num_rows($eposta_kontrol);
if($eposta_varmi > 0)
{
	echo "<center><img src=images/hata.gif border=0 /> E-Posta ba�ka bir �ye taraf�ndan kullan�l�yor!</center>";
	header("Refresh: 2; url=uyelik.php");
	return;		
}

$yenikayit = "INSERT INTO uyeler (kullanici_adi, parola, eposta, tarih)values('".$kullanici_adi."', '".md5(md5($parola))."', '".$eposta."', '$tarih')";

$sorgu = mysql_query($yenikayit);

echo "<center><img src=images/ok.gif border=0 /> Kay�t i�lemi tamamland�, l�tfen bekleyiniz.</center>";

header("Refresh: 2; url= index.php");


mysql_close();
}


ob_end_flush();
?>

</body>
</html>