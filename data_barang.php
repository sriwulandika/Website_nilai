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
  $insertSQL = sprintf("INSERT INTO barang (kode_barang, nama_barang, stok) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString($_POST['stok'], "text"));

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
 <meta http-equiv="refresh" content="0;url=index.php?page=data_barang" />
 <?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_bj = "SELECT * FROM barang";
$bj = mysql_query($query_bj, $koneksi) or die(mysql_error());
$row_bj = mysql_fetch_assoc($bj);
$totalRows_bj = mysql_num_rows($bj);

?>
 
<h2>Data Barang</h2>


<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="12%" height="35">Kode Barang</td>
      <td width="1%">:</td>
      <td width="87%">
      <input class="form-control" type="text" name="kode_barang" id="kode_barang" /></td>
    </tr>
    <tr>
      <td height="37">Nama Barang</td>
      <td>:</td>
      <td>
      <input class="form-control" name="nama_barang" type="text" id="nama_barang" size="30" /></td>
    </tr>
    <tr>
      <td height="37">Stok</td>
      <td>:</td>
      <td>
         <input class="form-control" name="stok" type="text" id="stok" size="30" /></td>
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
<P></P>
 <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
              <tr>
                  <th width="5%">No</th>
                  <th width="15%">Kode Barang</th>
                  <th width="31%">Nama Barang</th>
                  <th width="15%">Stok</th></tr>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
                <td><?php echo $no++; ?></td>
              <td><?php echo $row_bj['kode_barang']; ?></td>
              <td><?php echo $row_bj['nama_barang']; ?></td>
              <td><?php echo $row_bj['Stok']; ?></td>
              </tr>
              <?php } while ($row_bj = mysql_fetch_assoc($bj)); ?></tbody>
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
