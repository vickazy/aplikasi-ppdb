<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(56, "mi_dashboard", $Language->MenuPhrase("56", "MenuText"), "dashboardlist.php", -1, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}dashboard'), FALSE, FALSE, "glyphicon glyphicon-home");
$RootMenu->AddMenuItem(20, "mci_Input_Data", $Language->MenuPhrase("20", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-th-list");
$RootMenu->AddMenuItem(4, "mi_pendaftar", $Language->MenuPhrase("4", "MenuText"), "pendaftarlist.php", 20, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}pendaftar'), FALSE, FALSE, "glyphicon glyphicon-pencil");
$RootMenu->AddMenuItem(11, "mi_pendaftar2", $Language->MenuPhrase("11", "MenuText"), "pendaftar2list.php", 20, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}pendaftar2'), FALSE, FALSE, "glyphicon glyphicon-pencil");
$RootMenu->AddMenuItem(55, "mci_Status_Pendaftar", $Language->MenuPhrase("55", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-th-list");
$RootMenu->AddMenuItem(37, "mi_pendaftar_cabut_berkas", $Language->MenuPhrase("37", "MenuText"), "pendaftar_cabut_berkaslist.php", 55, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}pendaftar_cabut_berkas'), FALSE, FALSE, "glyphicon glyphicon-edit");
$RootMenu->AddMenuItem(23, "mi_pendaftar_diterima", $Language->MenuPhrase("23", "MenuText"), "pendaftar_diterimalist.php", 55, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}pendaftar_diterima'), FALSE, FALSE, "glyphicon glyphicon-edit");
$RootMenu->AddMenuItem(21, "mci_Cetak", $Language->MenuPhrase("21", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(36, "mi_rekap", $Language->MenuPhrase("36", "MenuText"), "rekaplist.php", 21, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}rekap'), FALSE, FALSE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(81, "mi_mengundurkan_diri", $Language->MenuPhrase("81", "MenuText"), "mengundurkan_dirilist.php", 21, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}mengundurkan diri'), FALSE, FALSE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(24, "mi_jurnal", $Language->MenuPhrase("24", "MenuText"), "jurnallist.php", 21, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}jurnal'), FALSE, FALSE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(25, "mi_pengumuman", $Language->MenuPhrase("25", "MenuText"), "pengumumanlist.php", 21, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}pengumuman'), FALSE, FALSE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(80, "mi_rekap_data", $Language->MenuPhrase("80", "MenuText"), "rekap_datalist.php", 21, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}rekap_data'), FALSE, FALSE, "glyphicon glyphicon-print");
$RootMenu->AddMenuItem(9, "mci_Setting", $Language->MenuPhrase("9", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(6, "mi_sekolah", $Language->MenuPhrase("6", "MenuText"), "sekolahlist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}sekolah'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(79, "mci_Nomor_Pendaftaran", $Language->MenuPhrase("79", "MenuText"), "", 9, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(38, "mi_no_pendaftaran", $Language->MenuPhrase("38", "MenuText"), "no_pendaftaranlist.php", 79, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}no_pendaftaran'), FALSE, FALSE, "glyphicon glyphicon-th-list");
$RootMenu->AddMenuItem(3, "mi_no_dftr", $Language->MenuPhrase("3", "MenuText"), "no_dftrlist.php", 79, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}no_dftr'), FALSE, FALSE, "glyphicon glyphicon-edit");
$RootMenu->AddMenuItem(5, "mi_ruang", $Language->MenuPhrase("5", "MenuText"), "ruanglist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}ruang'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(1, "mi_kecamatan", $Language->MenuPhrase("1", "MenuText"), "kecamatanlist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}kecamatan'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(7, "mi_bonus", $Language->MenuPhrase("7", "MenuText"), "bonuslist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}bonus'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(10, "mi_mda", $Language->MenuPhrase("10", "MenuText"), "mdalist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}mda'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(8, "mi_db_pd", $Language->MenuPhrase("8", "MenuText"), "db_pdlist.php", 9, "", AllowListMenu('{27E315CC-B02A-4AE4-92E7-B346521044C4}db_pd'), FALSE, FALSE, "glyphicon glyphicon-wrench");
$RootMenu->AddMenuItem(78, "mci_Keluar", $Language->MenuPhrase("78", "MenuText"), "logout.php", -1, "", IsLoggedIn(), FALSE, TRUE, "glyphicon glyphicon-log-out");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
