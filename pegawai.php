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
  $insertSQL = sprintf("INSERT INTO pegawai (nip, nama_pegawai, jabatan) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nip'], "text"),
                       GetSQLValueString($_POST['nama_pegawai'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"));

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
 <meta http-equiv="refresh" content="0;url=index.php?page=pegawai" />
 <?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_ptgs = "SELECT * FROM pegawai ";
$ptgs = mysql_query($query_ptgs, $koneksi) or die(mysql_error());
$row_ptgs = mysql_fetch_assoc($ptgs);
$totalRows_ptgs = mysql_num_rows($ptgs);
?>
<h2>Data Pegawai dan Guru SMP YP Keluarga</h2>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0">
    <tr>
      <td width="11%" height="32">NIP/NUPTK</td>
      <td width="1%">:</td>
      <td width="88%">
      <input class="form-control" type="text" name="nip" id="nip"></td>
    </tr>
    <tr>
      <td height="39">Nama Pegawai</td>
      <td>:</td>
      <td>
      <input class="form-control" name="nama_pegawai" type="text" id="nama_pegawai" size="30"></td>
    </tr>
    <tr>
      <td height="33">Jabatan</td>
      <td>:</td>
      <td>
        <input class="form-control" type="text" name="jabatan" id="jabatan"></td>
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
      <input class="btn btn-danger" type="reset" name="button2" id="button2" value="Batal"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
              <tr>
                <th width="5%">No</th>
                <th width="17%">NIP</th>
                <th width="34%">Nama Pegawai</th>
                <th width="31%">Jabatan</th>
                <th width="13%">Aksi</th>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $row_ptgs['nip']; ?></td>
              <td><?php echo $row_ptgs['nama_pegawai']; ?></td>
              <td><?php echo $row_ptgs['jabatan']; ?></td>
               <td align="center" >
                    <a href="?page=edit_pegawai&id_pegawai=<?php echo $row_ptgs['id_pegawai']; ?>"><button type="button" class="btn btn-warning"><i class="fa fa-fw fa-edit"></i> Ubah</button>
                    </a><a href="hapus_pegawai.php?id_pegawai=<?php echo $row_ptgs['id_pegawai']; ?>">
                    <button type="button" class="btn btn-danger" onClick="return confirm('Apakah Anda Ingin Menghapus Data Ini ?')"><i class="fa fa-fw fa-trash"></i> Hapus</button>
                    </a></td>
              </tr>
              <?php } while ($row_ptgs = mysql_fetch_assoc($ptgs)); ?>
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
    text-align: left;
}
</style>
<?php
mysql_free_result($ptgs);
?>
