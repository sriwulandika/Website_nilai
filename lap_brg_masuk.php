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
$query_pndk = "select barang_masuk.*,barang.nama_barang,pegawai.nama_pegawai from barang_masuk inner join barang on barang.kode_barang=barang_masuk.kode_barang inner join pegawai on pegawai.id_pegawai=barang_masuk.id_pegawai";
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
  <td colspan="9"><p style="text-align:center;"><img src="images/amik.png"></p><p style="text-align: center;">Data Kinerja Akademik Dosen AMIK Tunas Bangsa Pematangsiantar</p>
  <p style="text-align:center;">Pada Bidang Pendidikan</p></td>
  </tr>
   <tr>
    <th width="24">No</th>
    <th width="129">Nama Barang</th>
    <th width="155">Tanggal Barang Masuk</th>
    <th width="154">Jumlah Barang</th>
    <th width="160">Pegawai Penerima</th>
    <th width="192">Keterangan</th>
  </tr>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_pndk['nama_barang']; ?></td>
      <td><?php echo $row_pndk['tgl_brg_masuk']; ?></td>
      <td><?php echo $row_pndk['jml_brg_masuk']; ?></td>
      <td><?php echo $row_pndk['nama_pegawai']; ?></td>
      <td><?php echo $row_pndk['ket_brg_masuk']; ?></td>
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
