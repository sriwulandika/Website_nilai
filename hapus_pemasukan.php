<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_GET['kd_brg_masuk'])) && ($_GET['kd_brg_masuk'] != "")) {
  $bjm=mysql_query("select * from barang_masuk where kd_brg_masuk='$_GET[kd_brg_masuk]'");
  $tbjm=mysql_fetch_array($bjm);
  
  $bj=mysql_query("select * from barang where kode_barang='$tbjm[kode_barang]'");
  $tbj=mysql_fetch_array($bj);
 
  $deleteSQL = sprintf("DELETE FROM barang_masuk WHERE kd_brg_masuk=%s",
                       GetSQLValueString($_GET['kd_brg_masuk'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());

mysql_query("Update barang set Stok=$tbj[Stok]-$tbjm[jml_brg_masuk] where kode_barang='$tbj[kode_barang]'");

  $deleteGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
<script>
alert('Data Berhasil Dihapus');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=data_pemasukan" />
<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>