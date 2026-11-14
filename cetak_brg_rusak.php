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
$query_pndk = "select barang_rusak.kd_brg_rusak, barang.kode_barang,barang.nama_barang, barang_rusak.ket_rusak, barang_rusak.letak_brg_rusak from barang_rusak inner join barang on barang.kode_barang=barang_rusak.kode_barang";
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
  <td colspan="9"><p style="text-align: center;">Data Barang Rusak</p>
  <p style="text-align:center;">SMP Yayasan Perguruan Keluarga Pematang Siantar</p></td>
  </tr>
  <tr>
    <td width="21" align="center">No</td>
    <td width="82" align="center">Nama Barang</td>
    <td width="123" align="center">Peletakan Barang Rusak</th>
    <td width="119" align="center">Keterangan Kerusakan</td>
  </tr>
    <?php $no=1; do { ?>
      <tr>
        <td align="center"><?php echo $no++; ?></td>
        <td><?php echo $row_pndk['nama_barang']; ?></td>
        <td><?php echo $row_pndk['letak_brg_rusak']; ?></td>
        <td><?php echo $row_pndk['ket_rusak']; ?></td>
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

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #fd5f00;
    color: white;
}
</style>
</body>
<?php
mysql_free_result($pndk);
?>
