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

if ((isset($_GET['id_pegawai'])) && ($_GET['id_pegawai'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pegawai WHERE id_pegawai=%s",
                       GetSQLValueString($_GET['id_pegawai'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());

  $deleteGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
 <script>
 alert('Data Berhasil Dihapus');
 </script>
 <meta http-equiv="refresh" content="0;url=index.php?page=pegawai" />
 <?php
}

$colname_ptgs = "-1";
if (isset($_GET['id_pegawai'])) {
  $colname_ptgs = $_GET['id_pegawai'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_ptgs = sprintf("SELECT * FROM pegawai WHERE id_pegawai = %s", GetSQLValueString($colname_ptgs, "int"));
$ptgs = mysql_query($query_ptgs, $koneksi) or die(mysql_error());
$row_ptgs = mysql_fetch_assoc($ptgs);
$totalRows_ptgs = mysql_num_rows($ptgs);
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
mysql_free_result($ptgs);
?>
