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
$query_pers = "select barang_keluar.*,barang.stok,barang.nama_barang,pegawai.nama_pegawai from barang_keluar inner join barang on barang.kode_barang=barang_keluar.kode_barang inner
 join pegawai on pegawai.id_pegawai=barang_keluar.id_pegawai WHERE bulan_keluar like '%$cari%' OR tahun_keluar like '%$cari%' ORDER BY tgl_brg_keluar ASC";
$pers = mysql_query($query_pers, $koneksi) or die(mysql_error());
$row_pers = mysql_fetch_assoc($pers);
$totalRows_pers = mysql_num_rows($pers);
}
?>
<h4>DATA BARANG KELUAR</h4>
<form name="form1" method="post" action="">
Cari  :
  <label for="cari"></label>
  <input type="text" name="cari" id="cari">
  <input type="submit" name="button" id="button" class="btn btn-success" value="Cari">
</form>
     <br style="clear:both;"/></a><br/>
<button  class="btn btn-warning"  onclick="printContent('div1')"><i class="fa fa-file-pdf-o"></i>  Cetak PDF</button> <a href="export_pengeluaran.php"><button  class="btn btn-success"><i class="fa fa-file-excel-o"></i> Cetak Excel</button> 
    <br style="clear:both;"/></a>
    <script>
function printContent(el){
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script><div id="div1">
<div class="box-body">
          <table  class="table table-bordered table-striped">
                <thead>
              <tr>
                <th width="29">No</th>
                <th width="159">Nama Barang</th>
                <th width="154">Tanggal Barang Keluar</th>
                <th width="181">Jumlah Barang Keluar</th>
                <th width="163">Keterangan Barang Keluar</th>
                <th width="163">Penempatan Barang </th>
                 <th width="163">Pegawai Penerima Barang</th>
                 <th width="163">Stok</th>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
              <td><?php echo $no++; ?></td>
      <td><?php echo $row_pers['nama_barang']; ?></td>
      <td><?php echo $row_pers['tgl_brg_keluar']; ?></td>
      <td><?php echo $row_pers['jml_brg_keluar']; ?></td>
      <td><?php echo $row_pers['ket_brg_keluar']; ?></td>
      <td><?php echo $row_pers['letak_brg']; ?></td>
      <td><?php echo $row_pers['nama_pegawai']; ?></td>
       <td><?php echo $row_pers['Stok']; ?></td>  
              </tr>
              <?php } while ($row_pers = mysql_fetch_assoc($pers)); ?></tbody>
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
