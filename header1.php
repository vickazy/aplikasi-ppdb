
<!DOCTYPE html>
<html>
<head>
	<title>PPDB</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="bootstrap3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="adminlte/css/AdminLTE.css">
<link rel="stylesheet" type="text/css" href="adminlte/css/font-awesome.min.css"><!-- Optional font -->
<link rel="stylesheet" type="text/css" href="phpcss/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="phpcss/jquery.fileupload-ui.css">
<link rel="stylesheet" type="text/css" href="colorbox/colorbox.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="phpcss/pepedebe.css">
<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="jquery/jquery.ui.widget.js"></script>
<script type="text/javascript" src="jquery/jquery.storageapi.min.js"></script>
<script type="text/javascript" src="bootstrap3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="adminlte/js/adminlte.js"></script>
<script type="text/javascript" src="jquery/jquery.fileDownload.min.js"></script>
<script type="text/javascript" src="jquery/load-image.all.min.js"></script>
<script type="text/javascript" src="jquery/jqueryfileupload.min.js"></script>
<script type="text/javascript" src="phpjs/typeahead.jquery.js"></script>
<script type="text/javascript" src="colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="phpjs/mobile-detect.min.js"></script>
<script type="text/javascript" src="moment/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="phpcss/bootstrap-datetimepicker.css">
<script type="text/javascript" src="phpjs/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="phpjs/ewdatetimepicker.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "id";
var EW_DATE_SEPARATOR = "/"; // Date separator
var EW_TIME_SEPARATOR = "."; // Time separator
var EW_DATE_FORMAT = "dd-mm-yyyy"; // Default date format
var EW_DATE_FORMAT_ID = 14; // Default date format ID
var EW_DECIMAL_POINT = ",";
var EW_THOUSANDS_SEP = ".";
var EW_SESSION_TIMEOUT = 0; // Session timeout time (seconds)
var EW_SESSION_TIMEOUT_COUNTDOWN = 60; // Count down time to session timeout (seconds)
var EW_SESSION_KEEP_ALIVE_INTERVAL = 0; // Keep alive interval (seconds)
var EW_RELATIVE_PATH = ""; // Relative path
var EW_SESSION_URL = EW_RELATIVE_PATH + "ewsession14.php"; // Session URL
var EW_IS_LOGGEDIN = false; // Is logged in
var EW_IS_SYS_ADMIN = false; // Is sys admin
var EW_CURRENT_USER_NAME = ""; // Current user name
var EW_IS_AUTOLOGIN = false; // Is logged in with option "Auto login until I logout explicitly"
var EW_TIMEOUT_URL = EW_RELATIVE_PATH + "logout.php"; // Timeout URL
var EW_LOOKUP_FILE_NAME = "ewlookup14.php"; // Lookup file name
var EW_LOOKUP_FILTER_VALUE_SEPARATOR = ","; // Lookup filter value separator
var EW_MODAL_LOOKUP_FILE_NAME = "ewmodallookup14.php"; // Modal lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = 10; // Auto-Suggest max entries
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "ewupload14.php"; // Upload URL
var EW_UPLOAD_TYPE = "POST"; // Upload type
var EW_UPLOAD_THUMBNAIL_WIDTH = 200; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = 0; // Upload thumbnail height
var EW_MULTIPLE_UPLOAD_SEPARATOR = ","; // Upload multiple separator
var EW_USE_COLORBOX = true;
var EW_USE_JAVASCRIPT_MESSAGE = false;
var EW_MOBILE_DETECT = new MobileDetect(window.navigator.userAgent);
var EW_IS_MOBILE = !!EW_MOBILE_DETECT.mobile();
var EW_PROJECT_STYLESHEET_FILENAME = "phpcss/pepedebe.css"; // Project style sheet
var EW_PDF_STYLESHEET_FILENAME = "phpcss/ewpdf.css"; // PDF style sheet
var EW_TOKEN = "etIheJmZJLhl3F66xTxSxA..";
var EW_CSS_FLIP = false;
var EW_LAZY_LOAD = true;
var EW_RESET_HEIGHT = true;
var EW_DEBUG_ENABLED = false;
var EW_CONFIRM_CANCEL = true;
var EW_SEARCH_FILTER_OPTION = "Client";
</script>
<script type="text/javascript" src="phpjs/jsrender.min.js"></script>
<script type="text/javascript">
$.views.settings.debugMode(EW_DEBUG_ENABLED);
</script>
<script type="text/javascript" src="phpjs/ewp14.js"></script>
<script type="text/javascript" src="jquery/jquery.ewjtable.js"></script>
<script type="text/javascript">
var ewLanguage = new ew_Language({"addbtn":"Tambah","cancelbtn":"Batal","clickrecaptcha":"Silahkan klik reCAPTCHA","closebtn":"Tutup","confirm":"Konfirmasikan","confirmsavemessage":"Anda yakin ingin menyimpan data?","confirmbtn":"Konfirmasikan","confirmcancel":"Anda ingin membatalkan?","lightboxtitle":" ","lightboxcurrent":"gambar {current} dari {total}","lightboxprevious":"mundur","lightboxnext":"maju","lightboxclose":"tutup","lightboxxhrerror":"Konten ini gagal dimuat.","lightboximgerror":"Gambar ini gagal dimuat.","countselected":"%s terpilih","currentpassword":"Kata Sandi saat ini: ","deleteconfirmmsg":"Anda yakin ingin menghapus record ini?","deletefilterconfirm":"Hapus penyaringan %s?","editbtn":"Ubah","enterfiltername":"Masukkan nama berkas","enternewpassword":"Masukkan kata sandi baru","enteroldpassword":"Masukkan kata sandi lama","enterpassword":"Masukkan kata sandi","enterpwd":"Masukkan kata sandi","enterusername":"Masukkan nama pengguna","entervalidatecode":"Masukkan kode validasi seperti yang ditampilkan","entersenderemail":"Masukkan email pengirim","enterpropersenderemail":"Melebihi jumlah maksimum email pengirim atau alamat email tidak benar","enterrecipientemail":"Masukkan email penerima","enterproperrecipientemail":"Melebihi jumlah maksimum email penerima atau alamat email tidak benar","enterproperccemail":"Melebihi jumlah maksimum email tembusan (cc) atau alamat email tidak benar","enterproperbccemail":"Melebihi jumlah maksimum email tembusan buta (bcc) atau alamat email tidak benar","entersubject":"Masukkan subjek","enteruid":"Please enter user ID","entervalidemail":"Masukkan Alamat Email yang valid","exporting":"Sedang mengekspor, mohon tunggu...","exporttoemailtext":"Email","failedtoexport":"Gagal Mengekspor","filtername":"Nama penyaringan","overwritebtn":"Timpa","incorrectemail":"Email tidak benar","incorrectfield":"Ruas tidak benar","incorrectfloat":"Angka desimal tidak benar","incorrectguid":"GUID tidak benar","incorrectinteger":"Nilai integer tidak benar","incorrectphone":"Nomor telepon tidak benar","incorrectregexp":"Ekspresi reguler tidak cocok","incorrectrange":"Angka harus di antara %1 dan %2","incorrectssn":"Nomor keamanan sosial tidak benar","incorrectzip":"Kodepos tidak benar","insertfailed":"Penambahan gagal","invalidrecord":"Record tidak valid! Kunci bernilai null","loading":"Sedang memuat...","maxfilesize":"Ukuran maksimum berkas (%s bytes) terlampaui.","messageok":"OK","mismatchpassword":"Kata Sandi tidak cocok","more":"Lagi","next":"Maju","noaddrecord":"Tidak ada record yang ditambahkan","nofieldselected":"Tidak ada ruas yang dipilih untuk diperbarui","norecord":"Tidak ada record ditemukan","norecordselected":"Tidak ada record yang dipilih","of":"dari","page":"Halaman","passwordstrength":"Kekuatan: %p","passwordtoosimple":"Kata Sandi Anda terlalu sederhana","permissionaddcopy":"Tambah/Salin","permissiondelete":"Hapus","permissionedit":"Ubah","permissionlistsearchview":"Daftar/Cari/Tampilan","permissionlist":"Daftar","permissionsearch":"Cari","permissionview":"Tampilan","pleaseselect":"Silahkan pilih","pleasewait":"Silahkan tunggu...","prev":"Mundur","quicksearchauto":"Otomatis","quicksearchautoshort":"","quicksearchall":"Semua kata kunci","quicksearchallshort":"Semua","quicksearchany":"Kata Kunci apapun","quicksearchanyshort":"Apapun","quicksearchexact":"Persis Sama","quicksearchexactshort":"Cocok","record":"Record","recordsperpage":"Ukuran halaman","reloadbtn":"Muat Ulang","search":"Cari","searchbtn":"Cari","selectbtn":"Pilih","sendemailsuccess":"Email telah barhasil dikirim","sessionwillexpire":"Sesi Anda akan habis dalam %s detik. Klik OK untuk melanjutkan sesi Anda.","sessionexpired":"Sesi Anda telah habis.","updatebtn":"Perbarui","uploading":"Sedang mengunggah...","uploadstart":"Mulai","uploadcancel":"Batalkan","uploaddelete":"Hapus","uploadoverwrite":"Timpa berkas yang lama?","uploaderrmsgmaxfilesize":"Berkas terlalu besar","uploaderrmsgminfilesize":"Berkas terlalu kecil","uploaderrmsgacceptfiletypes":"Tipe berkas tidak diijinkan","uploaderrmsgmaxnumberoffiles":"Jumlah maksimum berkas telah terlampaui","uploaderrmsgmaxfilelength":"Total panjang nama berkas melebihi panjang ruas","useradministrator":"Administrator","useranonymous":"Anonymous","userdefault":"Default","userleveladministratorname":"Nama Level Pengguna untuk level pengguna -1 harus 'Administrator'","userlevelanonymousname":"Nama Level Pengguna untuk level pengguna -2 harus 'Anonymous'","userlevelidinteger":"ID Level Pengguna haruslah integer","userleveldefaultname":"Nama Level Pengguna untuk level 0 harus 'Default'","userlevelidincorrect":"ID Level Pengguna yang ditentukan haruslah lebih besar dari 0","userlevelnameincorrect":"Nama Level Pengguna yang ditentukan tidak boleh sama dengan 'Administrator' atau 'Default'","valuenotexist":"Nilai tidak ada","wrongfiletype":"Tipe berkas tidak diijinkan.","tableorview":"Tabel"});var ewVar = {"languages":{"languages":[]},"login":{"isLoggedIn":false,"currentUserName":"","logoutUrl":"logout.php","logoutText":"Logout","loginUrl":"login.php","loginText":"Login","canLogin":true,"canLogout":false}};
</script>
<script type="text/javascript" src="phpjs/userfn14.js"></script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"><link rel="icon" type="image/x-icon" href="favicon.ico">
<meta name="generator" content="PHPMaker v2018.0.2">
</head>
<body class="hold-transition skin-blue" dir="ltr">
<div>
	<!-- Main Header -->
	<!-- Left side column, contains the logo and sidebar -->
	
	<!-- Content Wrapper. Contains page content -->
	
<div id="ewTooltip"></div>
<script type="text/javascript">
jQuery.get("phpjs/userevt14.js");
</script>
<script type="text/javascript">

// Write your global startup script here
// document.write("page loaded");

</script>
</body>
</html>
