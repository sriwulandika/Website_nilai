<?php
date_default_timezone_set('Asia/Jakarta');
if(!ISSET($_POST['filter'])){
  ?>
  <?php
  require 'config2.php';
  $query = mysqli_query($conn, "SELECT * FROM `v_pengeluaran` ORDER BY `tgl_brg_keluar` ASC") or die(mysqli_error());
  $no=1;
  while($fetch = mysqli_fetch_array($query)){
    ?>
    <tr><td width="10"><?php echo $no++; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($fetch['tgl_brg_keluar']))?></td>
                  <td><?php echo $row_fetch['kode_barang']; ?></td>
                   <td><?php echo $row_fetch['nama_barang']; ?></td>
                  <td><?php echo $row_fetch['Stok']; ?></td>
                    <td><?php echo $row_fetch['jml_brg_keluar']; ?></td>
                    <td><?php echo $row_fetch['ket_brg_keluar']; ?></td>
                    <td><?php echo $row_fetch['letak_brg']; ?></td>
                    <td><?php echo $row_fetch['nama_pegawai']; ?></td>
</tr> <?php
  
}
  ?>
 <tfoot>
  <tr><td align="center" valign="top" colspan="2"><b>TOTAL</td><td></td>
  <td></td>
  <td></td><td valign="top"><b><?php echo $jumlahnya; ?></td>
  <td align="center"><b></td><td  valign="top"><b> Rp. <?php echo $harganya; 
}?>,-</td></tr>
<?php
if(ISSET($_POST['filter'])){
  require 'config2.php';
  $tanggal = $_POST['tgl_brg_keluar'];
  $query = mysqli_query($conn, "SELECT * FROM `v_penjualan` WHERE MONTH(tgl_brg_keluar) = '$tanggal' ORDER BY `tgl_brg_keluar` ASC") or die(mysqli_error($conn));
  $no=1;
  while($fetch = mysqli_fetch_array($query)) {

    ?>
    <tr><td width="10"><?php echo $no++; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($fetch['tgl_brg_keluar']))?></td>
                   <td><?php echo $row_fetch['kode_barang']; ?></td>
                   <td><?php echo $row_fetch['nama_barang']; ?></td>
                       <td><?php echo $row_fetch['Stok']; ?></td>

                    <td><?php echo $row_fetch['jml_brg_keluar']; ?></td>
                    <td><?php echo $row_fetch['ket_brg_keluar']; ?></td>
                    <td><?php echo $row_fetch['letak_brg']; ?></td>
                    <td><?php echo $row_fetch['nama_pegawai']; ?></td>
    <?php   
  }

?>


                <tfoot>
  <tr><td align="center" valign="top" colspan="2"><b>TOTAL</td><td></td>
  <td></td>
  <td></td><td valign="top"><b><?php echo $jumlahnya; ?></td>
  <td align="center"><b></td><td  valign="top"><b> Rp. <?php echo $harganya; 
}?>,-</td></tr>










