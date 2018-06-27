<?php
include_once "koneksi.php";

$sekolah = mysqli_query($koneksi, "SELECT * from sekolah");
    foreach ($sekolah as $row){


$cabutberkas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * from pendaftar WHERE status='Cabut Berkas'"));
$pendaftar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * from pendaftar"));
$daftar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * from pendaftar WHERE status='Terdaftar'"));
$diterima = mysqli_num_rows(mysqli_query($koneksi, "SELECT * from pendaftar WHERE keterangan='Diterima'"));

?>

<style type="text/css">
    /* .info-box
=================================================================== */
.info-box {
  min-height: 140px;
  margin-bottom: 30px;
  padding: 20px;
  color: white;
  -webkit-box-shadow: inset 0 0 1px 1px rgba(255, 255, 255, 0.35), 0 3px 1px -1px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: inset 0 0 1px 1px rgba(255, 255, 255, 0.35), 0 3px 1px -1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 0 1px 1px rgba(255, 255, 255, 0.35), 0 3px 1px -1px rgba(0, 0, 0, 0.1);
}
.info-box i {
  display: block;
  height: 100px;
  font-size: 60px;
  line-height: 100px;
  width: 100px;
  float: left;
  text-align: center;
  margin-right: 20px;
  padding-right: 20px;
  color: rgba(255, 255, 255, 0.75);
}
.info-box .count {
  margin-top: 20px;
  font-size: 34px;
  font-weight: 700;
}
.info-box .title {
  font-size: 12px;
  text-transform: uppercase;
  font-weight: 600;
}
.info-box .desc {
  margin-top: 10px;
  font-size: 12px;
}
.info-box.danger {
  background: #ff5454;
  border: 1px solid #ff2121;
}
.info-box.warning {
  background: #fabb3d;
  border: 1px solid #f9aa0b;
}
.info-box.primary {
  background: #20a8d8;
  border: 1px solid #1985ac;
}
.info-box.info {
  background: #67c2ef;
  border: 1px solid #39afea;
}
.info-box.success {
  background: #79c447;
  border: 1px solid #61a434;
}
/*----------------  color------------------------*/
.dark-heading-bg {
  background: #4c4f53;
  border: 1px solid #4c4f53;
}
.main-bg {
  background: #e6e8ea;
}
.white-bg {
  color : #768399;
  background : #fff;
  background-color : #fff;
}
.red-bg {
  color : #fff;
  background : #d95043;
  background-color : #d95043;
}
.blue-bg {
  color : #fff;
  background : #57889c;
  background-color : #57889c;
}
.green-bg {
  color : #fff;
  background : #26c281;
  background-color : #26c281;
}
.greenLight-bg {
  color: #71843f;
  background: #71843f;
  background-color: #71843f;
}
.yellow-bg {
  color : #fff;
  background : #fc6;
  background-color : #fc6;
}
.orange-bg {
  color : #fff;
  background : #f4b162;
  background-color : #f4b162;
}
.purple-bg {
  color : #fff;
  background : #af91e1;
  background-color : #af91e1;
}
.pink-bg {
  color : #fff;
  background : #f78db8;
  background-color : #f78db8;
}
.lime-bg {
  color : #fff;
  background : #a8db43;
  background-color : #a8db43;
}
.magenta-bg {
  color : #fff;
  background : #e65097;
  background-color : #e65097;
}
.teal-bg {
  color : #fff;
  background : #97d3c5;
  background-color : #97d3c5;
}
.brown-bg {
  color : #fff;
  background : #d1b993;
  background-color : #d1b993;
}
.gray-bg {
  color : #768399;
  background : #e4e9eb;
  background-color : #e4e9eb;
}
.dark-bg {
  color : #fff;
  background : #1a2732;
  background-color : #1a2732;
}
.facebook-bg {
  color: #fff;
  background: #3b5998;
  background-color : #3b5998;
}
.twitter-bg {
  color: #fff;
  background: #00aced;
  background-color : #00aced; 
}
.linkedin-bg {
  color: #fff;
  background: #4875b4;
  background-color : #4875b4;  
}
</style>


<div align="center"><strong><h1>Selamat Datang <?php echo $row['nama_sekolah']; ?></h1></strong></div>
<div align="center"><h2>Aplikasi Pendaftaran Peserta Didik Baru SMP Kabupaten Tegal</h2></div>
<br>
          <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div align="center" class="inner">
              <h3><?php echo $pendaftar; ?></h3>

              <p>Pendaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="pendaftarlist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

          <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div align="center" class="inner">
              <h3><?php echo $daftar; ?></h3>

              <p>Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="jurnallist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
                        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div align="center" class="inner">
              <h3><?php echo $cabutberkas; ?></h3>

              <p>Cabut Berkas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="pendaftar_cabut_berkaslist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
                        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div align="center" class="inner">
              <h3><?php echo $diterima; ?></h3>

              <p>Diterima</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="pendaftar_diterimalist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        



<?php
}
?>


