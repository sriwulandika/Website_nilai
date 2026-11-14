<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SMP YPK | Pematangsiantar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>  <center><h3>LAPORAN BARANG MASUK</h3>
 <h2><b>SMP YP KELUARGA PEMATANG SIANTAR <?php echo date('Y'); ?></b></h2></center>
  <table id="example1" class="table table-bordered table-striped" border="2">
  <thead>
                <tr>
                   <th width="24">No</th>
                  <th width="129">Nama Barang</th>
                  <th width="155">Tanggal Barang Masuk</th>
                  <th width="154">Jumlah Barang</th>
                  <th width="160">Pegawai Penerima</th>
                  <th width="192">Keterangan</th>
                  <th width="192">Stok</th>
                </tr></thead>

                <tbody>
              
                <?php
date_default_timezone_set('Asia/Jakarta');
if(!ISSET($_POST['filter'])){
  ?>
  <?php
  require 'config2.php';
  $query = mysqli_query($conn, "SELECT * FROM `v_pemasukan` ORDER BY `tgl_brg_masuk` ASC") or die(mysqli_error());
  $no=1.;
  while($fetch = mysqli_fetch_array($query)){
    ?>
   
    <tr><td width="10" align="center"><?php echo $no++; ?></td>

                  <td><?php echo $fetch['nama_barang']; ?></td>
                   <td><?php echo $fetch['tgl_brg_masuk']; ?></td>
                   <td><?php echo $fetch['jml_brg_masuk']; ?></td>
                       <td><?php echo $fetch['nama_pegawai']; ?></td>
                   <td><?php echo $fetch['ket_brg_masuk']; ?></td>
               
                    <td><?php echo $fetch['Stok']; ?></td> 
</tr> <?php
  
}
  ?>

  <?php
}

?>
                </tbody>
               
<table id="example1" class="table table-bordered table-hover">
  <tr><td width="65%"colspan="7"></td><td> Pematangsiantar, <?php echo date('d-M-Y'); ?>
<br />Hormat Saya<br /><b>Staff Sapras</b></td></tr>
<tr><td height="100" valign="bottom" colspan="7"></td><td><b><u><br /><u>(..............................)</u></u></b></td></tr></table>
</body>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>