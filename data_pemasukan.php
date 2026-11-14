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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$bj=mysql_query("select * from barang where kode_barang='$_POST[kode_barang]'");
$tbj=mysql_fetch_array($bj);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO barang_masuk (kode_barang, id_pegawai, tgl_brg_masuk, bulan_masuk,ket_brg_masuk,jml_brg_masuk) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['id_pegawai'], "text"),
                       GetSQLValueString($_POST['tgl_brg_masuk'], "date"),
                       GetSQLValueString($_POST['bulan_masuk'], "text"),
                       GetSQLValueString($_POST['ket_brg_masuk'], "text"),
                       GetSQLValueString($_POST['jml_brg_masuk'], "int"));
  mysql_query("Update barang set Stok=$tbj[Stok]+$_POST[jml_brg_masuk] where kode_barang='$_POST[kode_barang]'");

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
	<script type="text/javascript">
	alert('Penyimpanan Berhasil');
	</script>
	<meta http-equiv="refresh" content="0;url=index.php?page=data_pemasukan">
<?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_bjmsk = "select barang_masuk.*,barang.nama_barang,pegawai.nama_pegawai from barang_masuk inner join barang on barang.kode_barang=barang_masuk.kode_barang inner join pegawai on pegawai.id_pegawai=barang_masuk.id_pegawai";
$bjmsk = mysql_query($query_bjmsk, $koneksi) or die(mysql_error());
$row_bjmsk = mysql_fetch_assoc($bjmsk);
$totalRows_bjmsk = mysql_num_rows($bjmsk);

mysql_select_db($database_koneksi, $koneksi);
$query_bju = "SELECT * FROM barang";
$bju = mysql_query($query_bju, $koneksi) or die(mysql_error());
$row_bju = mysql_fetch_assoc($bju);
$totalRows_bju = mysql_num_rows($bju);

mysql_select_db($database_koneksi, $koneksi);
$query_ptgs = "SELECT * FROM `pegawai` ORDER BY `pegawai`.`nama_pegawai` ASC";
$ptgs = mysql_query($query_ptgs, $koneksi) or die(mysql_error());
$row_ptgs = mysql_fetch_assoc($ptgs);
$totalRows_ptgs = mysql_num_rows($ptgs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2>Data Barang Masuk</h2>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table>
   <tr>
      <td width="148" height="34">Barang</td>
      <td width="10">:</td>
      <td width="638">
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
      <td height="26">Pegawai Penerima</td>
      <td>:</td>
      <td>
        <select name="id_pegawai" id="id_pegawai">
        <?php
do {  
?>

          <option value="<?php echo $row_ptgs['id_pegawai']; ?>"<?php if (!(strcmp($row_ptgs['id_pegawai'], $row_ptgs['id_pegawai']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ptgs['nama_pegawai']; ?></option>
          <?php
} while ($row_ptgs = mysql_fetch_assoc($ptgs));
  $rows = mysql_num_rows($ptgs);
  if($rows > 0) {
      mysql_data_seek($ptgs, 0);
    $row_ptgs = mysql_fetch_assoc($ptgs);
  }
?>      </select></td>
    </tr>
    <tr>
      <td height="47">Tanggal Barang Masuk</td>
      <td>:</td>
      <td>
      <input type="date" name="tgl_brg_masuk" id="tgl_brg_masuk" /></td>
    </tr>
    <tr>
      <tr>
      <td height="47">Bulan Masuk Barang</td>
      <td>:</td>
      <td>
       <select name="bulan_masuk" id="bulan_masuk">
        <option value="">Pilih Bulan</option>
        <option value="Januari">Januari</option>
        <option value="Februari">Februari</option>
        <option value="Maret">Maret</option>
        <option value="April">April</option>
        <option value="Mei">Mei</option>
        <option value="Juni">Juni</option>
        <option value="Juli">Juli</option>
        <option value="Agustus">Agustus</option>
        <option value="September">September</option>
        <option value="Oktober">Oktober</option>
        <option value="November">November</option>
        <option value="Desember">Desember</option>
      </select> </td>
    </tr>
    <tr>
      <tr>
      <td height="47">Tahun Masuk</td>
      <td>:</td>
      <td>
       <input type="number" name="tahun_masuk" id="tahun_masuk" /></td>
      </select> </td>
    </tr>
    <tr>
      <td height="31">Jumlah Barang Masuk</td>
      <td>:</td>
      <td>
      <input type="number" name="jml_brg_masuk" id="jml_brg_masuk" /></td>
    </tr>
    <tr>
      <td height="31">Keterangan/Kondisi Barang</td>
      <td>:</td>
      <td>
      <textarea class="form-control" type="text" name="ket_brg_masuk" id="ket_brg_masuk"/></textarea></td>
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
<p></p>



 <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
             <tr>
    <th width="24">No</th>
    <th width="129">Nama Barang</th>
    <th width="155">Tanggal Barang Masuk</th>
    <th width="154">Jumlah Barang</th>
    <th width="160">Pegawai Penerima</th>
    <th width="192">Keterangan</th>
    <th width="103">Aksi</th>
  </tr> </thead><tbody>
  <?php $no=1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_bjmsk['nama_barang']; ?></td>
      <td><?php echo $row_bjmsk['tgl_brg_masuk']; ?></td>
      <td><?php echo $row_bjmsk['jml_brg_masuk']; ?></td>
      <td><?php echo $row_bjmsk['nama_pegawai']; ?></td>
      <td><?php echo $row_bjmsk['ket_brg_masuk']; ?></td>
      <td><a href="?page=hapus_pemasukan&kd_brg_masuk=<?php echo $row_bjmsk['kd_brg_masuk']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_bjmsk = mysql_fetch_assoc($bjmsk)); ?>
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
mysql_free_result($bjmsk);

mysql_free_result($bju);

mysql_free_result($ptgs);
?>
