<?php
    include 'koneksi.php';
    $sekolah = mysqli_query($koneksi, "SELECT * from sekolah");
    foreach ($sekolah as $row){
    ?>
<style type="text/css">
<!--
.style2 {
  font-size: large;
  font-weight: bold;
}
-->
</style>



<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><span class="style2">Pendaftar Cabut Berkas</span> </td>
    <td width="12%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%">Nama Sekolah </td>
    <td width="25%">: <strong><?php echo $row['nama_sekolah']; ?></strong></td>
    <td>Daya Tampung </td>
    <td>: <strong><?php echo $row['daya_tampung']; ?></strong> Peserta Didik </td>
  </tr>
  <tr>
    <td>Tahun</td>
    <td>: <strong><?php echo $row['thn_pelajaran']; ?></strong></td>
    <td>Zona 1 </td>
    <td>: <strong><?php echo round($row['zona1']); ?></strong> Peserta Didik</td>
  </tr>
  <tr>
    <td>Tanggal Cetak </td>
    <td>: <strong>
      <?php
 $tgl=date('d-m-Y');
 echo $tgl;
?>
    </strong></td>
    <td>Zona 2 </td>
    <td>: <strong><?php echo round($row['zona2']); ?></strong> Peserta Didik</td>
  </tr>
  <tr>
    <td>Jumlah Rombel</td>
    <td>: <strong><?php echo $row['jumlah_rombel']; ?></strong> Rombel </td>
    <td>Zona 3 </td>
    <td>: <strong><?php echo round($row['zona3']); ?></strong> Peserta Didik</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
}
?>