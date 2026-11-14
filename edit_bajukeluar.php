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
  $updateSQL = sprintf("UPDATE bajukeluar SET Kode_Baju=%s, Id_Petugas=%s, Tgl_Bajukeluar=%s, Jmlh_Bajukeluar=%s WHERE Id_Bajukeluar=%s",
                       GetSQLValueString($_POST['Kode_Baju'], "text"),
                       GetSQLValueString($_POST['Id_Petugas'], "text"),
                       GetSQLValueString($_POST['Tgl_Bajukeluar'], "date"),
					   GetSQLValueString($_POST['Jmlh_Bajukeluar'], "int"),
                       GetSQLValueString($_POST['Id_Bajukeluar'], "int"));

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
	<meta http-equiv="refresh" content="0;url=index.php?page=bajukeluar">
<?php
}

$colname_bjkluar = "-1";
if (isset($_GET['Id_Bajukeluar'])) {
  $colname_bjkluar = $_GET['Id_Bajukeluar'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_bjkluar = sprintf("select bajukeluar.*,baju.Nama_Baju,petugas.Nama_Petugas from bajukeluar inner join baju on baju.Kode_Baju=bajukeluar.Kode_Baju inner join petugas on petugas.Id_Petugas=bajukeluar.Id_Petugas WHERE Id_Bajukeluar = %s", GetSQLValueString($colname_bjkluar, "int"));
$bjkluar = mysql_query($query_bjkluar, $koneksi) or die(mysql_error());
$row_bjkluar = mysql_fetch_assoc($bjkluar);
$totalRows_bjkluar = mysql_num_rows($bjkluar);
?>

<p>Edit Baju Keluar</p>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="395" border="0">
    <tr>
      <td width="139">Baju      
      <input name="Id_Bajukeluar" type="hidden" id="Id_Bajukeluar" value="<?php echo $row_bjkluar['Id_Bajukeluar']; ?>"></td>
      <td width="22">:</td>
      <td width="220"><label for="Kode_Baju"></label>
        <select name="Kode_Baju" id="Kode_Baju">
        <option value="<?php echo $row_bjkluar['Kode_Baju']; ?>"> <?php echo $row_bjkluar['Kode_Baju']; ?>: <?php echo $row_bjkluar['Nama_Baju']; ?></option>
   <?php 

  $tampil=mysql_query("SELECT * FROM baju ORDER BY Nama_Baju");
   if(mysql_num_rows($tampil)>0){ ?>
     <?php
        $no = 1;
        while($query_bjkluar = mysql_fetch_array($tampil)){
       ?>
        <option value="<?php echo $query_bjkluar['Kode_Baju']; ?>"><?php echo $query_bjkluar['Kode_Baju']; ?> - <?php echo $query_bjkluar['Nama_Baju']; ?></option>
        <?php
          $no++; }
        }
        ?>
      </select></td>
    </tr>
    <tr>
      <td>Petugas</td>
      <td>:</td>
      <td><label for="Id_Petugas"></label>
        <select name="Id_Petugas" id="Id_Petugas">
      <option value="<?php echo $row_bjkluar['Id_Petugas']; ?>"> <?php echo $row_bjkluar['Id_Petugas']; ?>: <?php echo $row_bjkluar['Nama_Petugas']; ?></option>
   <?php 

  $tampil=mysql_query("SELECT * FROM petugas ORDER BY Nama_Petugas");
   if(mysql_num_rows($tampil)>0){ ?>
     <?php
        $no = 1;
        while($query_bjkluar = mysql_fetch_array($tampil)){
       ?>
        <option value="<?php echo $query_bjkluar['Id_Petugas']; ?>"><?php echo $query_bjkluar['Id_Petugas']; ?> - <?php echo $query_bjkluar['Nama_Petugas']; ?></option>
        <?php
          $no++; }
        }
        ?>
        </select></td>
    </tr>
    <tr>
      <td>Tanggal Baju Keluar</td>
      <td>:</td>
      <td><label for="Tgl_Bajukeluar"></label>
      <input name="Tgl_Bajukeluar" type="date" id="Tgl_Bajukeluar" value="<?php echo $row_bjkluar['Tgl_Bajukeluar']; ?>"></td>
    </tr>
    <tr>
      <td>Jumlah Baju Keluar</td>
      <td>:</td>
      <td><label for="Jmlh_Bajukeluar"></label>
      <input readonly="readonly" name="Jmlh_Bajukeluar" type="text" id="Jmlh_Bajukeluar" value="<?php echo $row_bjkluar['Jmlh_Bajukeluar']; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Edit"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($bjkluar);
?>
