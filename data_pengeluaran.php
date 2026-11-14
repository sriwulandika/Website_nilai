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
  $insertSQL = sprintf("INSERT INTO barang_keluar (kode_barang, tgl_brg_keluar,bulan_keluar, tahun_keluar, jml_brg_keluar, letak_brg, ket_brg_keluar, id_pegawai) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['tgl_brg_keluar'], "date"),
                        GetSQLValueString($_POST['bulan_keluar'], "text"),
                        GetSQLValueString($_POST['tahun_keluar'], "text"),
                        GetSQLValueString($_POST['jml_brg_keluar'], "int"),
                        GetSQLValueString($_POST['letak_brg'], "text"), 
                         GetSQLValueString($_POST['ket_brg_keluar'], "text"),
                      GetSQLValueString($_POST['id_pegawai'], "text"));
  mysql_query("Update barang set Stok=$tbj[Stok]-$_POST[jml_brg_keluar] where kode_barang='$_POST[kode_barang]'");

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
	<meta http-equiv="refresh" content="0;url=index.php?page=data_pengeluaran">
<?php
}

mysql_select_db($database_koneksi, $koneksi);
$query_bjklr = "select barang_keluar.*,barang.nama_barang,pegawai.nama_pegawai from barang_keluar inner join barang on barang.kode_barang=barang_keluar.kode_barang inner
 join pegawai on pegawai.id_pegawai=barang_keluar.id_pegawai";
$bjklr = mysql_query($query_bjklr, $koneksi) or die(mysql_error());
$row_bjklr = mysql_fetch_assoc($bjklr);
$totalRows_bjklr = mysql_num_rows($bjklr);

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
<h2>Data Barang Keluar</h2>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table>
    <tr>
      <td width="133" height="26">Nama Barang</td>
      <td width="13">:</td>
      <td width="422">
        <select name="kode_barang" id="kode_barang">
        <?php
do {  
?>
          <option value="<?php echo $row_bju['kode_barang']; ?>"<?php if (!(strcmp($row_bju['kode_barang'], $row_bju['Kode_Baju']))) {echo "selected=\"selected\"";} ?>><?php echo $row_bju['kode_barang']; ?> : <?php echo $row_bju['nama_barang']; ?></option>
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
      <td height="28">Pegawai yang menerima</td>
      <td>:</td>
      <td>
        <select name="id_pegawai" id="id_pegawai">
        <option>-</option>

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
      <td height="48">Tanggal Barang Keluar</td>
      <td>:</td>
      <td>
      <input type="date" name="tgl_brg_keluar" id="tgl_brg_keluar" /></td>
    </tr>
     <tr>
      <td height="47">Bulan Masuk Barang</td>
      <td>:</td>
      <td>
       <select name="bulan_keluar" id="bulan_keluar">
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
      <td height="47">Tahun Keluar</td>
      <td>:</td>
      <td>
       <input type="number" name="tahun_keluar" id="tahun_keluar" /></td>
      </select> </td>
    </tr>
    <tr>
      <td height="32">Jumlah Barang Keluar</td>
      <td>:</td>
      <td>
      <input type="number" name="jml_brg_keluar" id="jml_brg_keluar" /></td>
    </tr>
     <tr>
      <td height="48">Keterangan Barang Keluar</td>
      <td>:</td>
      <td>
      <textarea class="form-control" type="text" name="ket_brg_keluar" id="ket_brg_keluar" /></textarea> </td>
    </tr>
    <tr>
      <td height="48">Letak Barang</td>
      <td>:</td>
      <td>
      <input type="text" name="letak_brg" id="letak_brg" /></td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input  class="btn btn-info" type="submit" name="button" id="button" value="Simpan" />
      <input  class="btn btn-danger" type="reset" name="button2" id="button2" value="Batal" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p></p>



 <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
                <thead>
              <tr>
                   <th width="29">No</th>
                  <th width="159">Nama Barang</th>
                  <th width="154">Tanggal Barang Keluar</th>
                  <th width="181">Jumlah Barang Keluar</th>
                  <th width="163">Keterangan Barang Keluar</th>
                  <th width="163">Penempatan Barang </th>
                   <th width="163">Pegawai Penerima Barang</th>
                   <th width="163">Aksi</th></tr>
            </thead><tbody>
            <?php $no=1; do { ?>
              <tr>
               <td><?php echo $no++; ?></td>
              <td><?php echo $row_bjklr['nama_barang']; ?></td>
              <td><?php echo $row_bjklr['tgl_brg_keluar']; ?></td>
              <td><?php echo $row_bjklr['jml_brg_keluar']; ?></td>
              <td><?php echo $row_bjklr['ket_brg_keluar']; ?></td>
              <td><?php echo $row_bjklr['letak_brg']; ?></td>
              <td><?php echo $row_bjklr['nama_pegawai']; ?></td>
             <td><a href="?page=hapus_keluaran&kd_brg_keluar=<?php echo $row_bjklr['kd_brg_keluar']; ?>">Hapus</a></td>
              </tr>
              <?php } while ($row_bjklr = mysql_fetch_assoc($bjklr)); ?></tbody>
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

