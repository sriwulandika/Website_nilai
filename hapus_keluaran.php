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

if ((isset($_GET['kd_brg_keluar'])) && ($_GET['kd_brg_keluar'] != "")) {
  $bjklr=mysql_query("select * from barang_keluar where kd_brg_keluar='$_GET[kd_brg_keluar]'");
  $tbjklr=mysql_fetch_array($bjklr);
  
  $bj=mysql_query("select * from barang where kode_barang='$tbjklr[kode_barang]'");
  $tbj=mysql_fetch_array($bj);

  $deleteSQL = sprintf("DELETE FROM barang_keluar WHERE kd_brg_keluar=%s",
                       GetSQLValueString($_GET['kd_brg_keluar'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());
  mysql_query("Update barang set Stok=$tbj[Stok]+$tbjklr[jml_brg_keluar] where kode_barang='$tbj[kode_barang]'");

  $deleteGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
<script>
alert('Data Berhasil Dihapus');
</script>
<meta http-equiv="refresh" content="0;url=index.php?page=data_pengeluaran" />
<?php
}

$colname_bjklr = "-1";
if (isset($_GET['kd_brg_keluar'])) {
  $colname_bjklr = $_GET['kd_brg_keluar'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_bjklr = sprintf("SELECT * FROM barang_keluar WHERE kd_brg_keluar = %s", GetSQLValueString($colname_bjklr, "int"));
$bjklr = mysql_query($query_bjklr, $koneksi) or die(mysql_error());
$row_bjklr = mysql_fetch_assoc($bjklr);
$totalRows_bjklr = mysql_num_rows($bjklr);
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
<?php
mysql_free_result($bjklr);
?>
