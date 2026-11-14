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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO barang_rusak (kode_barang, ket_rusak, letak_brg_rusak) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['ket_rusak'], "text"),
                       GetSQLValueString($_POST['letak_brg_rusak'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  ?>
 <script>
 alert('Data Berhasil Disimpan');
 </script>
 <meta http-equiv="refresh" content="0;url=index.php?page=data_brg_rusak" />
 <?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_bj = "select barang_rusak.kd_brg_rusak, barang.kode_barang,barang.nama_barang, barang_rusak.ket_rusak, barang_rusak.letak_brg_rusak from barang_rusak inner join barang on barang.kode_barang=barang_rusak.kode_barang";
$bj = mysql_query($query_bj, $koneksi) or die(mysql_error());
$row_bj = mysql_fetch_assoc($bj);
$totalRows_bj = mysql_num_rows($bj);

mysql_select_db($database_koneksi, $koneksi);
$query_bju = "SELECT * FROM barang";
$bju = mysql_query($query_bju, $koneksi) or die(mysql_error());
$row_bju = mysql_fetch_assoc($bju);
$totalRows_bju = mysql_num_rows($bju);

?>
 
<h2>Data Barang Rusak</h2>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="12%" height="35">Kode Barang</td>
      <td width="1%">:</td>
      <td width="87%">
      <select name="kode_barang" id="kode_barang">
        <?php
do {  
?>
          <option value="<?php echo $row_bju['kode_barang']; ?>"<?php if (!(strcmp($row_bju['kode_barang'], $row_bju['kode_barang']))) {echo "selected=\"selected\"";} ?>><?php echo $row_bju['kode_barang']; ?> : <?php echo $row_bju['nama_barang']; ?></option>
          <?php
} while ($row_bju = mysql_fetch_assoc($bju));
  $rows = mysql_num_rows($bju);
  if($rows > 0) {
      mysql_data_seek($bju, 0);
    $row_bju = mysql_fetch_assoc($bju);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td height="37">Letak Barang Rusak</td>
      <td>:</td>
      <td>
      <input class="form-control" name="letak_brg_rusak" type="text" id="letak_brg_rusak" size="30" /></td>
    </tr>
    <tr>
      <td height="37">Keterangan Kerusakan</td>
      <td>:</td>
      <td>
         <input class="form-control" name="ket_rusak" type="text" id="ket_rusak" size="30" /></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input class="btn btn-info" type="submit" name="button" id="button" value="Simpan" />
      <input class="btn btn-danger" type="reset" name="button2" id="button2" value="Batal" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p style="text-align: right;"><a href="cetak_brg_rusak.php"><i class="fa fa-paperclip"> Download PDF</i></a></p>
<P></P>
<div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
              <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Barang</th>
            <th width="31%">Peletakan Barang Rusak</th>
            <th width="21%">Keterangan Kerusakan</th>
            <th width="13%">Aksi</th>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $row_bj['nama_barang']; ?></td>
              <td><?php echo $row_bj['letak_brg_rusak']; ?></td>
              <td><?php echo $row_bj['ket_rusak']; ?></td>
               <td align="center" >
                   <a href="?page=edit_data_brg_rusak&kd_brg_rusak=<?php echo $row_bj['kd_brg_rusak']; ?>"><button type="button" class="btn btn-warning"><i class="fa fa-fw fa-edit"></i> Ubah</button>
                    </a><a href="hapus_data_brg_rusak.php?kd_brg_rusak=<?php echo $row_bj['kd_brg_rusak']; ?>">
                    <button type="button" class="btn btn-danger" onClick="return confirm('Apakah Anda Ingin Menghapus Data Ini ?')"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                    </a></td>
              </tr>
                 <?php } while ($row_bj = mysql_fetch_assoc($bj)); ?>
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
<p>&nbsp;</p>
<?php
mysql_free_result($bj);
?>
