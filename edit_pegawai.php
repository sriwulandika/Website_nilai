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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pegawai SET nama_pegawai=%s, nip=%s, jabatan=%s WHERE id_pegawai=%s",
                       GetSQLValueString($_POST['nama_pegawai'], "text"),
                       GetSQLValueString($_POST['nip'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['id_pegawai'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 ?>
 <script>
 alert('Data Berhasil Diubah');
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
<h2>Data Petugas</h2>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="11%" height="39">NIP
      <input name="id_pegawai" type="hidden" id="id_pegawai" value="<?php echo $row_ptgs['id_pegawai']; ?>" /></td>
      <td width="1%">:</td>
      <td width="88%">
      <input name="nip" type="text" class="form-control" id="nip" value="<?php echo $row_ptgs['nip']; ?>"></td>
    </tr>
    <tr>
      <td height="45">Nama Pegawai</td>
      <td>:</td>
      <td>
      <input name="nama_pegawai" type="text" class="form-control" id="nama_pegawai" value="<?php echo $row_ptgs['nama_pegawai']; ?>" size="50"></td>
    </tr>
    <tr>
      <td height="43">Jabatan</td>
      <td>:</td>
      <td>
        <input name="jabatan" type="text" class="form-control" id="jabatan" value="<?php echo $row_ptgs['jabatan']; ?>" size="50"></td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input class="btn btn-info" type="submit" name="button" id="button" value="Simpan">
      <input class="btn btn-danger" type="submit" name="button2" id="button2" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="MM_update" value="form1" />
</form>
<?php
mysql_free_result($ptgs);
?>
