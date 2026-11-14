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

mysql_select_db($database_koneksi, $koneksi);
$query_pndk = "select bajumasuk.*,baju.Nama_Baju,baju.stok,petugas.Nama_Petugas from bajumasuk inner join baju on baju.Kode_Baju=bajumasuk.Kode_Baju inner join petugas on petugas.Id_Petugas=bajumasuk.Id_Petugas";
$pndk = mysql_query($query_pndk, $koneksi) or die(mysql_error());
$row_pndk = mysql_fetch_assoc($pndk);
$totalRows_pndk = mysql_num_rows($pndk);
?>
<head>
</head>
<body onLoad="print()">
<table align="center">
<tr>


<table width="100" border="1">
  <tr>
  <td colspan="9"><p style="text-align:center;"><img src="img/yayasankartini.png"></p><H4><p style="text-align: center;">DATA BAJU MASUK</p>
  <p style="text-align:center;">TK.KARTINI HANDAYANI PEMATANGSIANTAR</p></H4></td>
  </tr>
  <tr>
    <th width="62">No</th>
    <th width="147">Baju</th>
    <th width="133">Petugas</th>
    <th width="114">Tanggal Baju Masuk</th>
    <th width="114">Jumlah Baju Masuk</th>
    <th width="62">Stok</th>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td align="center"><?php echo $no++; ?></td>
      <td><?php echo $row_pndk['Nama_Baju']; ?></td>
      <td><?php echo $row_pndk['Nama_Petugas']; ?></td>
      <td><?php echo $row_pndk['Tgl_Bajumasuk']; ?></td>
      <td><?php echo $row_pndk['Jmlh_Bajumasuk']; ?></td>
      <td><?php echo $row_pndk['stok']; ?></td>
    </tr>
      <?php } while ($row_pndk = mysql_fetch_assoc($pndk)); ?>
    
</table>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}


</style>
</body>
<?php
mysql_free_result($pndk);
?>
