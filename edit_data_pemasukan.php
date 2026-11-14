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
  $updateSQL = sprintf("UPDATE barang_masuk SET kode_barang=%s, id_pegawai=%s, tgl_brg_masuk=%s, jml_brg_masuk=%s, ket_brg_masuk=%s  WHERE kd_brg_masuk=%s",
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['id_pegawai'], "text"),
                       GetSQLValueString($_POST['tgl_brg_masuk'], "date"),
                       GetSQLValueString($_POST['jml_brg_masuk'], "int"),
                        GetSQLValueString($_POST['ket_brg_masuk'], "text"),
                       GetSQLValueString($_POST['kd_brg_masuk'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
	<script type="text/javascript">
	alert('Penyimpanan Berhasil');
	</script>
	<meta http-equiv="refresh" content="0;url=index.php?page=data_pemasukan">
<?php
}

$colname_bjmsk = "-1";
if (isset($_GET['kd_brg_masuk'])) {
  $colname_bjmsk = $_GET['kd_brg_masuk'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_bjmsk = sprintf("select barang_masuk.*,barang.nama_barang,pegawai.nama_pegawai from barang_masuk inner join barang on barang.kode_barang=barang_masuk.kode_barang inner join pegawai on pegawai.id_pegawai=barang_masuk.id_pegawai WHERE kd_brg_masuk = %s", GetSQLValueString($colname_bjmsk, "int"));
$bjmsk = mysql_query($query_bjmsk, $koneksi) or die(mysql_error());
$row_bjmsk = mysql_fetch_assoc($bjmsk);
$totalRows_bjmsk = mysql_num_rows($bjmsk);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>Data Baju Masuk</p>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="455" border="0">
    <tr>
      <td width="136">Barang
      <input name="kd_brg_masuk" type="hidden" id="kd_brg_masuk" value="<?php echo $row_bjmsk['kd_brg_masuk']; ?>" /></td>
      <td width="30">:</td>
      <td width="275"><label for="kode_barang"></label>
        <select name="kode_barang" id="kode_barang">
        <option value="<?php echo $row_bjmsk['kode_barang']; ?>"> <?php echo $row_bjmsk['kode_barang']; ?>: <?php echo $row_bjmsk['nama_barang']; ?></option>
   <?php 

  $tampil=mysql_query("SELECT * FROM barang ORDER BY nama_barang");
   if(mysql_num_rows($tampil)>0){ ?>
     <?php
        $no = 1;
        while($query_bjmsk = mysql_fetch_array($tampil)){
       ?>
        <option value="<?php echo $query_bjmsk['kode_barang']; ?>"><?php echo $query_bjmsk['kode_barang']; ?> - <?php echo $query_bjmsk['nama_barang']; ?></option>
        <?php
          $no++; }
        }
        ?>
      </select></td>
    </tr>
    <tr>
      <td>Pegawai</td>
      <td>:</td>
      <td><label for="id_pegawai"></label>
            <select name="id_pegawai" id="id_pegawai">
      <option value="<?php echo $row_bjmsk['id_pegawai']; ?>"> <?php echo $row_bjmsk['id_pegawai']; ?>: <?php echo $row_bjmsk['nama_pegawai']; ?></option>
   <?php 

  $tampil=mysql_query("SELECT * FROM pegawai ORDER BY nama_pegawai");
   if(mysql_num_rows($tampil)>0){ ?>
     <?php
        $no = 1;
        while($query_bjmsk = mysql_fetch_array($tampil)){
       ?>
        <option value="<?php echo $query_bjmsk['id_pegawai']; ?>"><?php echo $query_bjmsk['id_pegawai']; ?> - <?php echo $query_bjmsk['nama_pegawai']; ?></option>
        <?php
          $no++; }
        }
        ?>
        </select></td>
    </tr>
    <tr>
      <td>Tanggal Barang Masuk</td>
      <td>:</td>
      <td><label for="tgl_brg_masuk"></label>
      <input name="tgl_brg_masuk" type="date" id="tg" value="<?php echo $row_bjmsk['tgl_brg_masuk']; ?>" /></td>
    </tr>
    <tr>
      <td>Jumlah Baju Masuk</td>
      <td>:</td>
      <td><label for="jml_brg_masuk"></label>
      <input name="jml_brg_masuk" type="text" id="jml_brg_masuk" value="<?php echo $row_bjmsk['jml_brg_masuk']; ?>" /></td>
    </tr>
    <tr>
      <td>Keterangan Barang Masuk</td>
      <td>:</td>
      <td><label for="ket_brg_masuk"></label>
      <input name="ket_brg_masuk" type="text" id="ket_brg_masuk" value="<?php echo $row_bjmsk['ket_brg_masuk']; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Edit" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($bjmsk);
?>
