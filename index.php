<!DOCTYPE HTML>
<html>
<head>
<title>PPDB</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="assets/css/boot.css">
<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="assets/css/style_common.css">
<link rel="stylesheet" type="text/css" href="assets/css/style1.css">
<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic'>
<script src="assets/js/modernizr.custom.69142.js"></script>
<script src="assets/js/jquery-1.10.1.min.js"></script>
<script src="assets/js/bootstrap.min.js" ></script>

<style type="text/css">

.push_button {
	position: relative;
	width:220px;
	height:40px;
	text-align:center;
	color:#FFF;
	text-decoration:none;
	line-height:43px;
	font-family:'Oswald', Helvetica;
	display: block;
	margin: 30px;
}
.push_button:before {
	background:#f0f0f0;
	background-image:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#D0D0D0), to(#f0f0f0));
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF; 
	-moz-box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF; 
	box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF;
	
	position: absolute;
	content: "";
	left: -6px; right: -6px;
	top: -6px; bottom: -10px;
	z-index: -1;
}

.push_button:active {
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset;
	top:5px;
}
.push_button:active:before{
	top: -11px;
	bottom: -5px;
	content: "";
}

.red {
	text-shadow:-1px -1px 0 #A84155;
	background: #D25068;
	border:1px solid #D25068;
	
	background-image:-webkit-linear-gradient(top, #F66C7B, #D25068);
	background-image:-moz-linear-gradient(top, #F66C7B, #D25068);
	background-image:-ms-linear-gradient(top, #F66C7B, #D25068);
	background-image:-o-linear-gradient(top, #F66C7B, #D25068);
	background-image:linear-gradient(to bottom, #F66C7B, #D25068);
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
	-moz-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
	box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
}

.red:hover {
	background: #F66C7B;
	background-image:-webkit-linear-gradient(top, #D25068, #F66C7B);
	background-image:-moz-linear-gradient(top, #D25068, #F66C7B);
	background-image:-ms-linear-gradient(top, #D25068, #F66C7B);
	background-image:-o-linear-gradient(top, #D25068, #F66C7B);
	background-image:linear-gradient(top, #D25068, #F66C7B);
}

.blue {
	text-shadow:-1px -1px 0 #2C7982;
	background: #3EACBA;
	border:1px solid #379AA4;
	background-image:-webkit-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-moz-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-ms-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-o-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:linear-gradient(top, #48C6D4, #3EACBA);
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
	-moz-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
	box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
}

.blue:hover {
	background: #48C6D4;
	background-image:-webkit-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-moz-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-ms-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-o-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:linear-gradient(top, #3EACBA, #48C6D4);
}

</style>

</head>
<body>
<div id="page-top" class="index">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        <a class="navbar-brand page-scroll" href="#page-top">PPDB</a></div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a class="page-scroll" href="#page-top">Home</a></li>
          <li><a class="page-scroll" href="#services">Login</a></li>          
          <li><a class="page-scroll" href="#about">Zonasi</a></li>
        </ul>
      </div>
    </div><!-- /.container-fluid -->
  </nav>
  <!-- Header -->
  <header style="background-image:url(assets/img/3218_Computer-power-abstract-binary-code.jpg)">
    <div class="container">
      <div class="intro-text">
        <!--<div class="intro-heading">Selamat Datang</div>-->
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
		<br>
		<br>
       <!-- <a href="#services" class="page-scroll btn btn-primary">Login</a></div> -->
    </div>
  </header>
</div>
<!-- ===== services ===== -->
<section id="services">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading" style="color:#3680C1">Login</h2>
        <h3 class="section-subheading text-muted">Silahkan Login</h3>
      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-6">
        <div align="center"><a href="login.php" class="push_button red">Login Admin</a>        
        </div>
        <p class="text-muted">Login Administrator</p>
        <p class="text-muted">Pengaturan Aplikasi PPDB dan Cetak Rekap, Jurnal, dan Pengumuman PPDB</p>
      </div>
      <div class="col-md-6">
        <div align="center"><a href="login.php" class="push_button blue">Login Ruang</a>        
        </div>
        <p class="text-muted">Login Ruang</p>
        <p class="text-muted">Menginputkan Data Pendaftar sesuai dengan Ruang Pendaftaran</p>
      </div>
    </div>
  </div>
</section>
<!-- ===== Team Section ===== -->
<!-- About Section -->
<section id="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading" style="color:#3680C1">Zonasi</h2>
        <h3 class="section-subheading text-muted">Tabel Zonasi Aplikasi PPDB SMP Kab Tegal</h3>
        <body>
          <embed src="assets/img/zonasi.png" width="75%" </embed>
        </body>
      </div>
    </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- ===== Team Section ===== -->
<!-- ===== Contact Us ===== -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4 col-md-offset-">
        <ul class="list-inline social-buttons">
          <li><a href="http://web.facebook.com/azis.imam.7"><i class="fa fa-facebook"></i></a></li>
          <li><a href="http://www.facebook.com/ainunnaiem"><i class="fa fa-facebook"></i></a></li>
          <li><a href="http://www.facebook.com/efanaliefan"><i class="fa fa-facebook"></i></a></li>
        </ul>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h5 style="color:#3680C1">Support By</h5>
        <h5 style="color:#3680C1">Dinas Pendidikan dan Kebudayaan</h5>
        <h5 style="color:#3680C1">MKKS Kabupaten Tegal</h5>
        <h5 style="color:#3680C1">KKOP SMP Kabupaten Tegal</h5>
        <br>
        <h4 style="color:#3680C1">Copyright &copy; 2018 All Rights Reserved</h4>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</footer>
</body>
</html>

