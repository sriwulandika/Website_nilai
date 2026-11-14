<?php
    mysql_connect ("localhost","root","");
    mysql_select_db ("db_sarana_ypk");
?>
<?php 
    // fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
     
    // membuat nama file ekspor "export-to-excel.xls"
    header("Content-Disposition: attachment; filename=export-to-excel.xls");
     
    // tambahkan table
    include 'cetak_pemasukan.php';
?>
