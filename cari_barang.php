<?php require_once('Connections/koneksi.php'); ?>
<?php
error_reporting(0);
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
if ($_POST) {
$cari=$_POST['cari'];
mysql_select_db($database_koneksi, $koneksi);
$query_pers = "select * from barang WHERE nama_barang='$cari' or kode_barang='$cari'";
$pers = mysql_query($query_pers, $koneksi) or die(mysql_error());
$row_pers = mysql_fetch_assoc($pers);
$totalRows_pers = mysql_num_rows($pers);
}
?>
<h4>SILAHKAN LAKUKAN PENCARIAN BARANG DI SINI</h4>
<form name="form1" method="post" action="">
Cari  :
  <label for="field"></label>
  <label for="cari"></label>
  <input type="text" name="cari" id="cari">
  <input type="submit" name="button" id="button" value="Cari">
</form>
<p style="text-align: right;"></button> <a href="export_barang.php"><button  class="btn btn-success"><i class="fa fa-file-excel-o"></i> Cetak Excel</button> </p>


<div class="box-body">
          <table class="table table-bordered table-striped">
                <thead>
              <tr>
              <th width="5%">No</th>
              <th width="15%">Kode Barang</th>
              <th width="31%">Nama Barang</th>
              <th width="15%">Stok</th>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row_pers['kode_barang']; ?></td>
                <td><?php echo $row_pers['nama_barang']; ?></td>
                <td><?php echo $row_pers['Stok']; ?></td>
              </tr>
                 <?php } while ($row_pers = mysql_fetch_assoc($pers)); ?>
          </table>
</div>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    text-align: left;
    padding: 1px;
}

th {
    background-color: #a52a2a;
    color: white;
    text-align: center;
}
</style>





<?php
mysql_free_result($pers);
?>
