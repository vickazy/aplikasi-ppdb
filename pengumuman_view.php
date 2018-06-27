<?php
    include 'koneksi.php';
    $sekolah = mysqli_query($koneksi, "SELECT * from sekolah");
    foreach ($sekolah as $row){
    ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><div align="center">
      <h2>Pengumuman PPDB <?php echo $row['nama_sekolah']; ?></h2>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><h2 align="center">Tahun Pelajaran <?php echo $row['thn_pelajaran']; ?></h2>    </td>
  </tr>
  <tr>
    <td><div align="center"><?php echo "<div class='col-lg-6'><h5>"."Jumlah Rombel : " .$row['jumlah_rombel']."</h5></div>"; ?></div></td>
    <td><div align="center"><?php echo "<div class='col-lg-6'><h5>"."Daya Tampung : " .$row['daya_tampung']."</h5></div>"; ?></div></td>
    <td><div align="center"><?php echo "<div class='col-lg-6'><h5>"."Zona 1 : " .round($row['zona1'])."</h5></div>"; ?></div></td>
    <td><div align="center"><?php echo "<div class='col-lg-6'><h5>"."Zona 2 : " .round($row['zona2'])."</h5></div>"; ?></div></td>
  </tr>
</table>
<?php
}
?>
<table width="100%" border="1" cellspacing="3" cellpadding="3">
  <tr>
    <td><div align="center"><strong>Nomor</strong></div></td>
    <td><div align="center"><strong>No Daftar </strong></div></td>
    <td><div align="center"><strong>Ruang</strong></div></td>
    <td><div align="center"><strong>No Ujian SD </strong></div></td>
    <td><div align="center"><strong>Sekolah Asal </strong></div></td>
    <td><div align="center"><strong>Nama</strong></div></td>
    <td><div align="center"><strong>Zona</strong></div></td>
    <td><div align="center"><strong>Nilai Akhir </strong></div></td>
    <td><div align="center"><strong>Persyaratan</strong></div></td>
    <td><div align="center"><strong>Keterangan</strong></div></td>
  </tr>
    <?php
	$no = 0;
    $sekolah = mysqli_query($koneksi, "SELECT * from pendaftar where keterangan='Diterima' order by zona, nilai_akhir desc");
    foreach ($sekolah as $row){
	$no++; ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $row['nomor_pendaftaran']; ?></td>
    <td><?php echo $row['nama_ruang']; ?></td>
    <td><?php echo $row['nomor_peserta_ujian_sdmi']; ?></td>
    <td><?php echo $row['sekolah_asal']; ?></td>
    <td><?php echo $row['nama_lengkap']; ?></td>
    <td><?php echo $row['zona']; ?></td>
    <td><?php echo $row['nilai_akhir']; ?></td>
    <td><?php echo $row['persyaratan']; ?></td>
    <td><?php echo $row['keterangan']; ?></td>
  </tr>
  	<?php
	}
	?>
</table>
<p><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><span class="style1">
      <?php
 $tgl=date('d-m-Y');
 echo "<h5>"."Tanggal : ".$tgl."</h5>";
?>
    </span></td>
    <td><div align="center">
      <p class="style2">TTD</p>
      <p class="style3">Panitia PPDB </p>
    </div></td>
  </tr>
</table></p>
