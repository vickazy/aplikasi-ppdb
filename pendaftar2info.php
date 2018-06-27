<?php

// Global variable for table object
$pendaftar2 = NULL;

//
// Table class for pendaftar2
//
class cpendaftar2 extends cTable {
	var $id_pendaftar;
	var $nama_ruang;
	var $nomor_pendaftaran;
	var $nomor_peserta_ujian_sdmi;
	var $sekolah_asal;
	var $nama_lengkap;
	var $nik;
	var $nisn;
	var $tempat_lahir;
	var $tanggal_lahir;
	var $jenis_kelamin;
	var $agama;
	var $alamat;
	var $kecamatan;
	var $zona;
	var $n_ind;
	var $n_mat;
	var $n_ipa;
	var $jumlah_nilai_usum;
	var $bonus_prestasi;
	var $nama_prestasi;
	var $jumlah_bonus_prestasi;
	var $kepemilikan_ijasah_mda;
	var $nilai_mda;
	var $nilai_akhir;
	var $nama_ayah;
	var $nama_ibu;
	var $nama_wali;
	var $status;
	var $persyaratan;
	var $catatan;
	var $keterangan;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pendaftar2';
		$this->TableName = 'pendaftar2';
		$this->TableType = 'LINKTABLE';

		// Update Table
		$this->UpdateTable = "`pendaftar`";
		$this->DBID = 'pepedebe1';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id_pendaftar
		$this->id_pendaftar = new cField('pendaftar2', 'pendaftar2', 'x_id_pendaftar', 'id_pendaftar', '`id_pendaftar`', '`id_pendaftar`', 3, -1, FALSE, '`id_pendaftar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_pendaftar->Sortable = TRUE; // Allow sort
		$this->id_pendaftar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_pendaftar'] = &$this->id_pendaftar;

		// nama_ruang
		$this->nama_ruang = new cField('pendaftar2', 'pendaftar2', 'x_nama_ruang', 'nama_ruang', '`nama_ruang`', '`nama_ruang`', 200, -1, FALSE, '`nama_ruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_ruang->Sortable = TRUE; // Allow sort
		$this->nama_ruang->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_ruang->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_ruang'] = &$this->nama_ruang;

		// nomor_pendaftaran
		$this->nomor_pendaftaran = new cField('pendaftar2', 'pendaftar2', 'x_nomor_pendaftaran', 'nomor_pendaftaran', '`nomor_pendaftaran`', '`nomor_pendaftaran`', 200, -1, FALSE, '`nomor_pendaftaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nomor_pendaftaran->Sortable = TRUE; // Allow sort
		$this->nomor_pendaftaran->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nomor_pendaftaran->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nomor_pendaftaran'] = &$this->nomor_pendaftaran;

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi = new cField('pendaftar2', 'pendaftar2', 'x_nomor_peserta_ujian_sdmi', 'nomor_peserta_ujian_sdmi', '`nomor_peserta_ujian_sdmi`', '`nomor_peserta_ujian_sdmi`', 200, -1, FALSE, '`nomor_peserta_ujian_sdmi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomor_peserta_ujian_sdmi->Sortable = TRUE; // Allow sort
		$this->fields['nomor_peserta_ujian_sdmi'] = &$this->nomor_peserta_ujian_sdmi;

		// sekolah_asal
		$this->sekolah_asal = new cField('pendaftar2', 'pendaftar2', 'x_sekolah_asal', 'sekolah_asal', '`sekolah_asal`', '`sekolah_asal`', 200, -1, FALSE, '`sekolah_asal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sekolah_asal->Sortable = TRUE; // Allow sort
		$this->fields['sekolah_asal'] = &$this->sekolah_asal;

		// nama_lengkap
		$this->nama_lengkap = new cField('pendaftar2', 'pendaftar2', 'x_nama_lengkap', 'nama_lengkap', '`nama_lengkap`', '`nama_lengkap`', 200, -1, FALSE, '`nama_lengkap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_lengkap->Sortable = TRUE; // Allow sort
		$this->fields['nama_lengkap'] = &$this->nama_lengkap;

		// nik
		$this->nik = new cField('pendaftar2', 'pendaftar2', 'x_nik', 'nik', '`nik`', '`nik`', 200, -1, FALSE, '`nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nik->Sortable = TRUE; // Allow sort
		$this->fields['nik'] = &$this->nik;

		// nisn
		$this->nisn = new cField('pendaftar2', 'pendaftar2', 'x_nisn', 'nisn', '`nisn`', '`nisn`', 200, -1, FALSE, '`nisn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nisn->Sortable = TRUE; // Allow sort
		$this->fields['nisn'] = &$this->nisn;

		// tempat_lahir
		$this->tempat_lahir = new cField('pendaftar2', 'pendaftar2', 'x_tempat_lahir', 'tempat_lahir', '`tempat_lahir`', '`tempat_lahir`', 200, -1, FALSE, '`tempat_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tempat_lahir->Sortable = TRUE; // Allow sort
		$this->fields['tempat_lahir'] = &$this->tempat_lahir;

		// tanggal_lahir
		$this->tanggal_lahir = new cField('pendaftar2', 'pendaftar2', 'x_tanggal_lahir', 'tanggal_lahir', '`tanggal_lahir`', '`tanggal_lahir`', 200, 7, FALSE, '`tanggal_lahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_lahir->Sortable = TRUE; // Allow sort
		$this->tanggal_lahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tanggal_lahir'] = &$this->tanggal_lahir;

		// jenis_kelamin
		$this->jenis_kelamin = new cField('pendaftar2', 'pendaftar2', 'x_jenis_kelamin', 'jenis_kelamin', '`jenis_kelamin`', '`jenis_kelamin`', 200, -1, FALSE, '`jenis_kelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->jenis_kelamin->Sortable = TRUE; // Allow sort
		$this->jenis_kelamin->OptionCount = 2;
		$this->fields['jenis_kelamin'] = &$this->jenis_kelamin;

		// agama
		$this->agama = new cField('pendaftar2', 'pendaftar2', 'x_agama', 'agama', '`agama`', '`agama`', 200, -1, FALSE, '`agama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->agama->Sortable = TRUE; // Allow sort
		$this->agama->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->agama->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->agama->OptionCount = 6;
		$this->fields['agama'] = &$this->agama;

		// alamat
		$this->alamat = new cField('pendaftar2', 'pendaftar2', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 201, -1, FALSE, '`alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat->Sortable = TRUE; // Allow sort
		$this->fields['alamat'] = &$this->alamat;

		// kecamatan
		$this->kecamatan = new cField('pendaftar2', 'pendaftar2', 'x_kecamatan', 'kecamatan', '`kecamatan`', '`kecamatan`', 200, -1, FALSE, '`kecamatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kecamatan->Sortable = TRUE; // Allow sort
		$this->kecamatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kecamatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kecamatan'] = &$this->kecamatan;

		// zona
		$this->zona = new cField('pendaftar2', 'pendaftar2', 'x_zona', 'zona', '`zona`', '`zona`', 200, -1, FALSE, '`zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zona->Sortable = TRUE; // Allow sort
		$this->fields['zona'] = &$this->zona;

		// n_ind
		$this->n_ind = new cField('pendaftar2', 'pendaftar2', 'x_n_ind', 'n_ind', '`n_ind`', '`n_ind`', 200, -1, FALSE, '`n_ind`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_ind->Sortable = TRUE; // Allow sort
		$this->fields['n_ind'] = &$this->n_ind;

		// n_mat
		$this->n_mat = new cField('pendaftar2', 'pendaftar2', 'x_n_mat', 'n_mat', '`n_mat`', '`n_mat`', 200, -1, FALSE, '`n_mat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_mat->Sortable = TRUE; // Allow sort
		$this->fields['n_mat'] = &$this->n_mat;

		// n_ipa
		$this->n_ipa = new cField('pendaftar2', 'pendaftar2', 'x_n_ipa', 'n_ipa', '`n_ipa`', '`n_ipa`', 200, -1, FALSE, '`n_ipa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_ipa->Sortable = TRUE; // Allow sort
		$this->fields['n_ipa'] = &$this->n_ipa;

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum = new cField('pendaftar2', 'pendaftar2', 'x_jumlah_nilai_usum', 'jumlah_nilai_usum', '`jumlah_nilai_usum`', '`jumlah_nilai_usum`', 200, -1, FALSE, '`jumlah_nilai_usum`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_nilai_usum->Sortable = TRUE; // Allow sort
		$this->fields['jumlah_nilai_usum'] = &$this->jumlah_nilai_usum;

		// bonus_prestasi
		$this->bonus_prestasi = new cField('pendaftar2', 'pendaftar2', 'x_bonus_prestasi', 'bonus_prestasi', '`bonus_prestasi`', '`bonus_prestasi`', 200, -1, FALSE, '`bonus_prestasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->bonus_prestasi->Sortable = TRUE; // Allow sort
		$this->bonus_prestasi->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->bonus_prestasi->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['bonus_prestasi'] = &$this->bonus_prestasi;

		// nama_prestasi
		$this->nama_prestasi = new cField('pendaftar2', 'pendaftar2', 'x_nama_prestasi', 'nama_prestasi', '`nama_prestasi`', '`nama_prestasi`', 200, -1, FALSE, '`nama_prestasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_prestasi->Sortable = TRUE; // Allow sort
		$this->fields['nama_prestasi'] = &$this->nama_prestasi;

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi = new cField('pendaftar2', 'pendaftar2', 'x_jumlah_bonus_prestasi', 'jumlah_bonus_prestasi', '`jumlah_bonus_prestasi`', '`jumlah_bonus_prestasi`', 200, -1, FALSE, '`jumlah_bonus_prestasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->jumlah_bonus_prestasi->Sortable = TRUE; // Allow sort
		$this->fields['jumlah_bonus_prestasi'] = &$this->jumlah_bonus_prestasi;

		// kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda = new cField('pendaftar2', 'pendaftar2', 'x_kepemilikan_ijasah_mda', 'kepemilikan_ijasah_mda', '`kepemilikan_ijasah_mda`', '`kepemilikan_ijasah_mda`', 200, -1, FALSE, '`kepemilikan_ijasah_mda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->kepemilikan_ijasah_mda->Sortable = TRUE; // Allow sort
		$this->fields['kepemilikan_ijasah_mda'] = &$this->kepemilikan_ijasah_mda;

		// nilai_mda
		$this->nilai_mda = new cField('pendaftar2', 'pendaftar2', 'x_nilai_mda', 'nilai_mda', '`nilai_mda`', '`nilai_mda`', 200, -1, FALSE, '`nilai_mda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->nilai_mda->Sortable = TRUE; // Allow sort
		$this->fields['nilai_mda'] = &$this->nilai_mda;

		// nilai_akhir
		$this->nilai_akhir = new cField('pendaftar2', 'pendaftar2', 'x_nilai_akhir', 'nilai_akhir', '`nilai_akhir`', '`nilai_akhir`', 200, -1, FALSE, '`nilai_akhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nilai_akhir->Sortable = TRUE; // Allow sort
		$this->fields['nilai_akhir'] = &$this->nilai_akhir;

		// nama_ayah
		$this->nama_ayah = new cField('pendaftar2', 'pendaftar2', 'x_nama_ayah', 'nama_ayah', '`nama_ayah`', '`nama_ayah`', 200, -1, FALSE, '`nama_ayah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_ayah->Sortable = TRUE; // Allow sort
		$this->fields['nama_ayah'] = &$this->nama_ayah;

		// nama_ibu
		$this->nama_ibu = new cField('pendaftar2', 'pendaftar2', 'x_nama_ibu', 'nama_ibu', '`nama_ibu`', '`nama_ibu`', 200, -1, FALSE, '`nama_ibu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_ibu->Sortable = TRUE; // Allow sort
		$this->fields['nama_ibu'] = &$this->nama_ibu;

		// nama_wali
		$this->nama_wali = new cField('pendaftar2', 'pendaftar2', 'x_nama_wali', 'nama_wali', '`nama_wali`', '`nama_wali`', 200, -1, FALSE, '`nama_wali`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_wali->Sortable = TRUE; // Allow sort
		$this->fields['nama_wali'] = &$this->nama_wali;

		// status
		$this->status = new cField('pendaftar2', 'pendaftar2', 'x_status', 'status', '`status`', '`status`', 200, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->fields['status'] = &$this->status;

		// persyaratan
		$this->persyaratan = new cField('pendaftar2', 'pendaftar2', 'x_persyaratan', 'persyaratan', '`persyaratan`', '`persyaratan`', 200, -1, FALSE, '`persyaratan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->persyaratan->Sortable = TRUE; // Allow sort
		$this->persyaratan->OptionCount = 2;
		$this->fields['persyaratan'] = &$this->persyaratan;

		// catatan
		$this->catatan = new cField('pendaftar2', 'pendaftar2', 'x_catatan', 'catatan', '`catatan`', '`catatan`', 201, -1, FALSE, '`catatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->catatan->Sortable = TRUE; // Allow sort
		$this->fields['catatan'] = &$this->catatan;

		// keterangan
		$this->keterangan = new cField('pendaftar2', 'pendaftar2', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $this->LeftColumnClass);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pendaftar`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		global $Security;

		// Add User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$sSql = $this->ListSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id_pendaftar->setDbValue($conn->Insert_ID());
			$rs['id_pendaftar'] = $this->id_pendaftar->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id_pendaftar', $rs))
				ew_AddFilter($where, ew_QuotedName('id_pendaftar', $this->DBID) . '=' . ew_QuotedValue($rs['id_pendaftar'], $this->id_pendaftar->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id_pendaftar` = @id_pendaftar@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_pendaftar->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id_pendaftar->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id_pendaftar@", ew_AdjustSql($this->id_pendaftar->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "pendaftar2list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "pendaftar2view.php")
			return $Language->Phrase("View");
		elseif ($pageName == "pendaftar2edit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "pendaftar2add.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "pendaftar2list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pendaftar2view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pendaftar2view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pendaftar2add.php?" . $this->UrlParm($parm);
		else
			$url = "pendaftar2add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pendaftar2edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pendaftar2add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pendaftar2delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_pendaftar:" . ew_VarToJson($this->id_pendaftar->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_pendaftar->CurrentValue)) {
			$sUrl .= "id_pendaftar=" . urlencode($this->id_pendaftar->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id_pendaftar"]))
				$arKeys[] = $_POST["id_pendaftar"];
			elseif (isset($_GET["id_pendaftar"]))
				$arKeys[] = $_GET["id_pendaftar"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id_pendaftar->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id_pendaftar->setDbValue($rs->fields('id_pendaftar'));
		$this->nama_ruang->setDbValue($rs->fields('nama_ruang'));
		$this->nomor_pendaftaran->setDbValue($rs->fields('nomor_pendaftaran'));
		$this->nomor_peserta_ujian_sdmi->setDbValue($rs->fields('nomor_peserta_ujian_sdmi'));
		$this->sekolah_asal->setDbValue($rs->fields('sekolah_asal'));
		$this->nama_lengkap->setDbValue($rs->fields('nama_lengkap'));
		$this->nik->setDbValue($rs->fields('nik'));
		$this->nisn->setDbValue($rs->fields('nisn'));
		$this->tempat_lahir->setDbValue($rs->fields('tempat_lahir'));
		$this->tanggal_lahir->setDbValue($rs->fields('tanggal_lahir'));
		$this->jenis_kelamin->setDbValue($rs->fields('jenis_kelamin'));
		$this->agama->setDbValue($rs->fields('agama'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->kecamatan->setDbValue($rs->fields('kecamatan'));
		$this->zona->setDbValue($rs->fields('zona'));
		$this->n_ind->setDbValue($rs->fields('n_ind'));
		$this->n_mat->setDbValue($rs->fields('n_mat'));
		$this->n_ipa->setDbValue($rs->fields('n_ipa'));
		$this->jumlah_nilai_usum->setDbValue($rs->fields('jumlah_nilai_usum'));
		$this->bonus_prestasi->setDbValue($rs->fields('bonus_prestasi'));
		$this->nama_prestasi->setDbValue($rs->fields('nama_prestasi'));
		$this->jumlah_bonus_prestasi->setDbValue($rs->fields('jumlah_bonus_prestasi'));
		$this->kepemilikan_ijasah_mda->setDbValue($rs->fields('kepemilikan_ijasah_mda'));
		$this->nilai_mda->setDbValue($rs->fields('nilai_mda'));
		$this->nilai_akhir->setDbValue($rs->fields('nilai_akhir'));
		$this->nama_ayah->setDbValue($rs->fields('nama_ayah'));
		$this->nama_ibu->setDbValue($rs->fields('nama_ibu'));
		$this->nama_wali->setDbValue($rs->fields('nama_wali'));
		$this->status->setDbValue($rs->fields('status'));
		$this->persyaratan->setDbValue($rs->fields('persyaratan'));
		$this->catatan->setDbValue($rs->fields('catatan'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id_pendaftar
		// nama_ruang
		// nomor_pendaftaran
		// nomor_peserta_ujian_sdmi
		// sekolah_asal
		// nama_lengkap
		// nik
		// nisn
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// agama
		// alamat
		// kecamatan
		// zona
		// n_ind
		// n_mat
		// n_ipa
		// jumlah_nilai_usum
		// bonus_prestasi
		// nama_prestasi
		// jumlah_bonus_prestasi
		// kepemilikan_ijasah_mda
		// nilai_mda
		// nilai_akhir
		// nama_ayah
		// nama_ibu
		// nama_wali
		// status
		// persyaratan
		// catatan
		// keterangan
		// id_pendaftar

		$this->id_pendaftar->ViewValue = $this->id_pendaftar->CurrentValue;
		$this->id_pendaftar->ViewCustomAttributes = "";

		// nama_ruang
		if (strval($this->nama_ruang->CurrentValue) <> "") {
			$sFilterWrk = "`nama_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
		$sWhereWrk = "";
		$this->nama_ruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_ruang->ViewValue = $this->nama_ruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_ruang->ViewValue = $this->nama_ruang->CurrentValue;
			}
		} else {
			$this->nama_ruang->ViewValue = NULL;
		}
		$this->nama_ruang->ViewCustomAttributes = "";

		// nomor_pendaftaran
		if (strval($this->nomor_pendaftaran->CurrentValue) <> "") {
			$sFilterWrk = "`nomor_pendaftaran`" . ew_SearchString("=", $this->nomor_pendaftaran->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nomor_pendaftaran`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
		$sWhereWrk = "";
		$this->nomor_pendaftaran->LookupFilters = array("dx1" => '`nomor_pendaftaran`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nomor_pendaftaran->ViewValue = $this->nomor_pendaftaran->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomor_pendaftaran->ViewValue = $this->nomor_pendaftaran->CurrentValue;
			}
		} else {
			$this->nomor_pendaftaran->ViewValue = NULL;
		}
		$this->nomor_pendaftaran->ViewCustomAttributes = "";

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
			$sFilterWrk = "`nopes`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nopes`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
		$sWhereWrk = "";
		$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
			}
		} else {
			$this->nomor_peserta_ujian_sdmi->ViewValue = NULL;
		}
		$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

		// sekolah_asal
		$this->sekolah_asal->ViewValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->ViewCustomAttributes = "";

		// nama_lengkap
		$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

		// nisn
		$this->nisn->ViewValue = $this->nisn->CurrentValue;
		$this->nisn->ViewCustomAttributes = "";

		// tempat_lahir
		$this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->ViewCustomAttributes = "";

		// tanggal_lahir
		$this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->ViewValue = ew_FormatDateTime($this->tanggal_lahir->ViewValue, 7);
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// jenis_kelamin
		if (strval($this->jenis_kelamin->CurrentValue) <> "") {
			$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->OptionCaption($this->jenis_kelamin->CurrentValue);
		} else {
			$this->jenis_kelamin->ViewValue = NULL;
		}
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// agama
		if (strval($this->agama->CurrentValue) <> "") {
			$this->agama->ViewValue = $this->agama->OptionCaption($this->agama->CurrentValue);
		} else {
			$this->agama->ViewValue = NULL;
		}
		$this->agama->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// kecamatan
		if (strval($this->kecamatan->CurrentValue) <> "") {
			$sFilterWrk = "`id_kec`" . ew_SearchString("=", $this->kecamatan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_kec`, `nama_kec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kecamatan`";
		$sWhereWrk = "";
		$this->kecamatan->LookupFilters = array("dx1" => '`nama_kec`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kecamatan, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kecamatan->ViewValue = $this->kecamatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kecamatan->ViewValue = $this->kecamatan->CurrentValue;
			}
		} else {
			$this->kecamatan->ViewValue = NULL;
		}
		$this->kecamatan->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->ViewCustomAttributes = "";

		// n_ind
		$this->n_ind->ViewValue = $this->n_ind->CurrentValue;
		$this->n_ind->ViewValue = ew_FormatNumber($this->n_ind->ViewValue, 1, 0, 0, 0);
		$this->n_ind->ViewCustomAttributes = "";

		// n_mat
		$this->n_mat->ViewValue = $this->n_mat->CurrentValue;
		$this->n_mat->ViewValue = ew_FormatNumber($this->n_mat->ViewValue, 1, 0, 0, 0);
		$this->n_mat->ViewCustomAttributes = "";

		// n_ipa
		$this->n_ipa->ViewValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->ViewValue = ew_FormatNumber($this->n_ipa->ViewValue, 1, 0, 0, 0);
		$this->n_ipa->ViewCustomAttributes = "";

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum->ViewValue = $this->jumlah_nilai_usum->CurrentValue;
		$this->jumlah_nilai_usum->ViewValue = ew_FormatNumber($this->jumlah_nilai_usum->ViewValue, 1, 0, 0, 0);
		$this->jumlah_nilai_usum->ViewCustomAttributes = "";

		// bonus_prestasi
		if (strval($this->bonus_prestasi->CurrentValue) <> "") {
			$sFilterWrk = "`id_bonus`" . ew_SearchString("=", $this->bonus_prestasi->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_bonus`, `bonus` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bonus`";
		$sWhereWrk = "";
		$this->bonus_prestasi->LookupFilters = array("dx1" => '`bonus`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bonus_prestasi, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bonus_prestasi->ViewValue = $this->bonus_prestasi->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bonus_prestasi->ViewValue = $this->bonus_prestasi->CurrentValue;
			}
		} else {
			$this->bonus_prestasi->ViewValue = NULL;
		}
		$this->bonus_prestasi->ViewCustomAttributes = "";

		// nama_prestasi
		$this->nama_prestasi->ViewValue = $this->nama_prestasi->CurrentValue;
		$this->nama_prestasi->ViewCustomAttributes = "";

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->ViewValue = $this->jumlah_bonus_prestasi->CurrentValue;
		$this->jumlah_bonus_prestasi->ViewValue = ew_FormatNumber($this->jumlah_bonus_prestasi->ViewValue, 1, 0, 0, 0);
		$this->jumlah_bonus_prestasi->ViewCustomAttributes = "";

		// kepemilikan_ijasah_mda
		if (strval($this->kepemilikan_ijasah_mda->CurrentValue) <> "") {
			$sFilterWrk = "`id_mda`" . ew_SearchString("=", $this->kepemilikan_ijasah_mda->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_mda`, `mda` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `mda`";
		$sWhereWrk = "";
		$this->kepemilikan_ijasah_mda->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kepemilikan_ijasah_mda, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kepemilikan_ijasah_mda->ViewValue = $this->kepemilikan_ijasah_mda->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kepemilikan_ijasah_mda->ViewValue = $this->kepemilikan_ijasah_mda->CurrentValue;
			}
		} else {
			$this->kepemilikan_ijasah_mda->ViewValue = NULL;
		}
		$this->kepemilikan_ijasah_mda->ViewCustomAttributes = "";

		// nilai_mda
		$this->nilai_mda->ViewValue = $this->nilai_mda->CurrentValue;
		$this->nilai_mda->ViewValue = ew_FormatNumber($this->nilai_mda->ViewValue, 1, 0, 0, 0);
		$this->nilai_mda->ViewCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->ViewValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->ViewValue = ew_FormatNumber($this->nilai_akhir->ViewValue, 1, 0, 0, 0);
		$this->nilai_akhir->ViewCustomAttributes = "";

		// nama_ayah
		$this->nama_ayah->ViewValue = $this->nama_ayah->CurrentValue;
		$this->nama_ayah->ViewCustomAttributes = "";

		// nama_ibu
		$this->nama_ibu->ViewValue = $this->nama_ibu->CurrentValue;
		$this->nama_ibu->ViewCustomAttributes = "";

		// nama_wali
		$this->nama_wali->ViewValue = $this->nama_wali->CurrentValue;
		$this->nama_wali->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// persyaratan
		if (strval($this->persyaratan->CurrentValue) <> "") {
			$this->persyaratan->ViewValue = $this->persyaratan->OptionCaption($this->persyaratan->CurrentValue);
		} else {
			$this->persyaratan->ViewValue = NULL;
		}
		$this->persyaratan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// id_pendaftar
		$this->id_pendaftar->LinkCustomAttributes = "";
		$this->id_pendaftar->HrefValue = "";
		$this->id_pendaftar->TooltipValue = "";

		// nama_ruang
		$this->nama_ruang->LinkCustomAttributes = "";
		$this->nama_ruang->HrefValue = "";
		$this->nama_ruang->TooltipValue = "";

		// nomor_pendaftaran
		$this->nomor_pendaftaran->LinkCustomAttributes = "";
		$this->nomor_pendaftaran->HrefValue = "";
		$this->nomor_pendaftaran->TooltipValue = "";

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->LinkCustomAttributes = "";
		$this->nomor_peserta_ujian_sdmi->HrefValue = "";
		$this->nomor_peserta_ujian_sdmi->TooltipValue = "";

		// sekolah_asal
		$this->sekolah_asal->LinkCustomAttributes = "";
		$this->sekolah_asal->HrefValue = "";
		$this->sekolah_asal->TooltipValue = "";

		// nama_lengkap
		$this->nama_lengkap->LinkCustomAttributes = "";
		$this->nama_lengkap->HrefValue = "";
		$this->nama_lengkap->TooltipValue = "";

		// nik
		$this->nik->LinkCustomAttributes = "";
		$this->nik->HrefValue = "";
		$this->nik->TooltipValue = "";

		// nisn
		$this->nisn->LinkCustomAttributes = "";
		$this->nisn->HrefValue = "";
		$this->nisn->TooltipValue = "";

		// tempat_lahir
		$this->tempat_lahir->LinkCustomAttributes = "";
		$this->tempat_lahir->HrefValue = "";
		$this->tempat_lahir->TooltipValue = "";

		// tanggal_lahir
		$this->tanggal_lahir->LinkCustomAttributes = "";
		$this->tanggal_lahir->HrefValue = "";
		$this->tanggal_lahir->TooltipValue = "";

		// jenis_kelamin
		$this->jenis_kelamin->LinkCustomAttributes = "";
		$this->jenis_kelamin->HrefValue = "";
		$this->jenis_kelamin->TooltipValue = "";

		// agama
		$this->agama->LinkCustomAttributes = "";
		$this->agama->HrefValue = "";
		$this->agama->TooltipValue = "";

		// alamat
		$this->alamat->LinkCustomAttributes = "";
		$this->alamat->HrefValue = "";
		$this->alamat->TooltipValue = "";

		// kecamatan
		$this->kecamatan->LinkCustomAttributes = "";
		$this->kecamatan->HrefValue = "";
		$this->kecamatan->TooltipValue = "";

		// zona
		$this->zona->LinkCustomAttributes = "";
		$this->zona->HrefValue = "";
		$this->zona->TooltipValue = "";

		// n_ind
		$this->n_ind->LinkCustomAttributes = "";
		$this->n_ind->HrefValue = "";
		$this->n_ind->TooltipValue = "";

		// n_mat
		$this->n_mat->LinkCustomAttributes = "";
		$this->n_mat->HrefValue = "";
		$this->n_mat->TooltipValue = "";

		// n_ipa
		$this->n_ipa->LinkCustomAttributes = "";
		$this->n_ipa->HrefValue = "";
		$this->n_ipa->TooltipValue = "";

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum->LinkCustomAttributes = "";
		$this->jumlah_nilai_usum->HrefValue = "";
		$this->jumlah_nilai_usum->TooltipValue = "";

		// bonus_prestasi
		$this->bonus_prestasi->LinkCustomAttributes = "";
		$this->bonus_prestasi->HrefValue = "";
		$this->bonus_prestasi->TooltipValue = "";

		// nama_prestasi
		$this->nama_prestasi->LinkCustomAttributes = "";
		$this->nama_prestasi->HrefValue = "";
		$this->nama_prestasi->TooltipValue = "";

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->LinkCustomAttributes = "";
		$this->jumlah_bonus_prestasi->HrefValue = "";
		$this->jumlah_bonus_prestasi->TooltipValue = "";

		// kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda->LinkCustomAttributes = "";
		$this->kepemilikan_ijasah_mda->HrefValue = "";
		$this->kepemilikan_ijasah_mda->TooltipValue = "";

		// nilai_mda
		$this->nilai_mda->LinkCustomAttributes = "";
		$this->nilai_mda->HrefValue = "";
		$this->nilai_mda->TooltipValue = "";

		// nilai_akhir
		$this->nilai_akhir->LinkCustomAttributes = "";
		$this->nilai_akhir->HrefValue = "";
		$this->nilai_akhir->TooltipValue = "";

		// nama_ayah
		$this->nama_ayah->LinkCustomAttributes = "";
		$this->nama_ayah->HrefValue = "";
		$this->nama_ayah->TooltipValue = "";

		// nama_ibu
		$this->nama_ibu->LinkCustomAttributes = "";
		$this->nama_ibu->HrefValue = "";
		$this->nama_ibu->TooltipValue = "";

		// nama_wali
		$this->nama_wali->LinkCustomAttributes = "";
		$this->nama_wali->HrefValue = "";
		$this->nama_wali->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// persyaratan
		$this->persyaratan->LinkCustomAttributes = "";
		$this->persyaratan->HrefValue = "";
		$this->persyaratan->TooltipValue = "";

		// catatan
		$this->catatan->LinkCustomAttributes = "";
		$this->catatan->HrefValue = "";
		$this->catatan->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_pendaftar
		$this->id_pendaftar->EditAttrs["class"] = "form-control";
		$this->id_pendaftar->EditCustomAttributes = "";
		$this->id_pendaftar->EditValue = $this->id_pendaftar->CurrentValue;
		$this->id_pendaftar->ViewCustomAttributes = "";

		// nama_ruang
		$this->nama_ruang->EditAttrs["class"] = "form-control";
		$this->nama_ruang->EditCustomAttributes = "";
		if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("info")) { // Non system admin
		} else {
		}

		// nomor_pendaftaran
		$this->nomor_pendaftaran->EditAttrs["class"] = "form-control";
		$this->nomor_pendaftaran->EditCustomAttributes = "";

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->EditAttrs["class"] = "form-control";
		$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";
		$this->nomor_peserta_ujian_sdmi->EditValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		$this->nomor_peserta_ujian_sdmi->PlaceHolder = ew_RemoveHtml($this->nomor_peserta_ujian_sdmi->FldCaption());

		// sekolah_asal
		$this->sekolah_asal->EditAttrs["class"] = "form-control";
		$this->sekolah_asal->EditCustomAttributes = "";
		$this->sekolah_asal->EditValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->PlaceHolder = ew_RemoveHtml($this->sekolah_asal->FldCaption());

		// nama_lengkap
		$this->nama_lengkap->EditAttrs["class"] = "form-control";
		$this->nama_lengkap->EditCustomAttributes = "";
		$this->nama_lengkap->EditValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->PlaceHolder = ew_RemoveHtml($this->nama_lengkap->FldCaption());

		// nik
		$this->nik->EditAttrs["class"] = "form-control";
		$this->nik->EditCustomAttributes = "";
		$this->nik->EditValue = $this->nik->CurrentValue;
		$this->nik->PlaceHolder = ew_RemoveHtml($this->nik->FldCaption());

		// nisn
		$this->nisn->EditAttrs["class"] = "form-control";
		$this->nisn->EditCustomAttributes = "";
		$this->nisn->EditValue = $this->nisn->CurrentValue;
		$this->nisn->PlaceHolder = ew_RemoveHtml($this->nisn->FldCaption());

		// tempat_lahir
		$this->tempat_lahir->EditAttrs["class"] = "form-control";
		$this->tempat_lahir->EditCustomAttributes = "";
		$this->tempat_lahir->EditValue = $this->tempat_lahir->CurrentValue;
		$this->tempat_lahir->PlaceHolder = ew_RemoveHtml($this->tempat_lahir->FldCaption());

		// tanggal_lahir
		$this->tanggal_lahir->EditAttrs["class"] = "form-control";
		$this->tanggal_lahir->EditCustomAttributes = "";
		$this->tanggal_lahir->EditValue = $this->tanggal_lahir->CurrentValue;
		$this->tanggal_lahir->PlaceHolder = ew_RemoveHtml($this->tanggal_lahir->FldCaption());

		// jenis_kelamin
		$this->jenis_kelamin->EditCustomAttributes = "";
		$this->jenis_kelamin->EditValue = $this->jenis_kelamin->Options(FALSE);

		// agama
		$this->agama->EditAttrs["class"] = "form-control";
		$this->agama->EditCustomAttributes = "";
		$this->agama->EditValue = $this->agama->Options(TRUE);

		// alamat
		$this->alamat->EditAttrs["class"] = "form-control";
		$this->alamat->EditCustomAttributes = "";
		$this->alamat->EditValue = $this->alamat->CurrentValue;
		$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

		// kecamatan
		$this->kecamatan->EditAttrs["class"] = "form-control";
		$this->kecamatan->EditCustomAttributes = "";

		// zona
		$this->zona->EditAttrs["class"] = "form-control";
		$this->zona->EditCustomAttributes = "";
		$this->zona->EditValue = $this->zona->CurrentValue;
		$this->zona->PlaceHolder = ew_RemoveHtml($this->zona->FldCaption());

		// n_ind
		$this->n_ind->EditAttrs["class"] = "form-control";
		$this->n_ind->EditCustomAttributes = "";
		$this->n_ind->EditValue = $this->n_ind->CurrentValue;
		$this->n_ind->EditValue = ew_FormatNumber($this->n_ind->EditValue, 1, 0, 0, 0);
		$this->n_ind->ViewCustomAttributes = "";

		// n_mat
		$this->n_mat->EditAttrs["class"] = "form-control";
		$this->n_mat->EditCustomAttributes = "";
		$this->n_mat->EditValue = $this->n_mat->CurrentValue;
		$this->n_mat->EditValue = ew_FormatNumber($this->n_mat->EditValue, 1, 0, 0, 0);
		$this->n_mat->ViewCustomAttributes = "";

		// n_ipa
		$this->n_ipa->EditAttrs["class"] = "form-control";
		$this->n_ipa->EditCustomAttributes = "";
		$this->n_ipa->EditValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->EditValue = ew_FormatNumber($this->n_ipa->EditValue, 1, 0, 0, 0);
		$this->n_ipa->ViewCustomAttributes = "";

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum->EditAttrs["class"] = "form-control";
		$this->jumlah_nilai_usum->EditCustomAttributes = "";
		$this->jumlah_nilai_usum->EditValue = $this->jumlah_nilai_usum->CurrentValue;
		$this->jumlah_nilai_usum->EditValue = ew_FormatNumber($this->jumlah_nilai_usum->EditValue, 1, 0, 0, 0);
		$this->jumlah_nilai_usum->ViewCustomAttributes = "";

		// bonus_prestasi
		$this->bonus_prestasi->EditAttrs["class"] = "form-control";
		$this->bonus_prestasi->EditCustomAttributes = "";

		// nama_prestasi
		$this->nama_prestasi->EditAttrs["class"] = "form-control";
		$this->nama_prestasi->EditCustomAttributes = "";
		$this->nama_prestasi->EditValue = $this->nama_prestasi->CurrentValue;
		$this->nama_prestasi->PlaceHolder = ew_RemoveHtml($this->nama_prestasi->FldCaption());

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->EditAttrs["class"] = "form-control";
		$this->jumlah_bonus_prestasi->EditCustomAttributes = "";

		// kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda->EditCustomAttributes = "";

		// nilai_mda
		$this->nilai_mda->EditAttrs["class"] = "form-control";
		$this->nilai_mda->EditCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->EditAttrs["class"] = "form-control";
		$this->nilai_akhir->EditCustomAttributes = "";
		$this->nilai_akhir->EditValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->PlaceHolder = ew_RemoveHtml($this->nilai_akhir->FldCaption());

		// nama_ayah
		$this->nama_ayah->EditAttrs["class"] = "form-control";
		$this->nama_ayah->EditCustomAttributes = "";
		$this->nama_ayah->EditValue = $this->nama_ayah->CurrentValue;
		$this->nama_ayah->PlaceHolder = ew_RemoveHtml($this->nama_ayah->FldCaption());

		// nama_ibu
		$this->nama_ibu->EditAttrs["class"] = "form-control";
		$this->nama_ibu->EditCustomAttributes = "";
		$this->nama_ibu->EditValue = $this->nama_ibu->CurrentValue;
		$this->nama_ibu->PlaceHolder = ew_RemoveHtml($this->nama_ibu->FldCaption());

		// nama_wali
		$this->nama_wali->EditAttrs["class"] = "form-control";
		$this->nama_wali->EditCustomAttributes = "";
		$this->nama_wali->EditValue = $this->nama_wali->CurrentValue;
		$this->nama_wali->PlaceHolder = ew_RemoveHtml($this->nama_wali->FldCaption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->CurrentValue;
		$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

		// persyaratan
		$this->persyaratan->EditCustomAttributes = "";
		$this->persyaratan->EditValue = $this->persyaratan->Options(FALSE);

		// catatan
		$this->catatan->EditAttrs["class"] = "form-control";
		$this->catatan->EditCustomAttributes = "";
		$this->catatan->EditValue = $this->catatan->CurrentValue;
		$this->catatan->PlaceHolder = ew_RemoveHtml($this->catatan->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			$this->nama_lengkap->Count++; // Increment count
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->nama_lengkap->CurrentValue = $this->nama_lengkap->Count;
			$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
			$this->nama_lengkap->ViewCustomAttributes = "";
			$this->nama_lengkap->HrefValue = ""; // Clear href value

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id_pendaftar->Exportable) $Doc->ExportCaption($this->id_pendaftar);
					if ($this->nama_ruang->Exportable) $Doc->ExportCaption($this->nama_ruang);
					if ($this->nomor_pendaftaran->Exportable) $Doc->ExportCaption($this->nomor_pendaftaran);
					if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportCaption($this->nomor_peserta_ujian_sdmi);
					if ($this->sekolah_asal->Exportable) $Doc->ExportCaption($this->sekolah_asal);
					if ($this->nama_lengkap->Exportable) $Doc->ExportCaption($this->nama_lengkap);
					if ($this->nik->Exportable) $Doc->ExportCaption($this->nik);
					if ($this->nisn->Exportable) $Doc->ExportCaption($this->nisn);
					if ($this->tempat_lahir->Exportable) $Doc->ExportCaption($this->tempat_lahir);
					if ($this->tanggal_lahir->Exportable) $Doc->ExportCaption($this->tanggal_lahir);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->agama->Exportable) $Doc->ExportCaption($this->agama);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->kecamatan->Exportable) $Doc->ExportCaption($this->kecamatan);
					if ($this->zona->Exportable) $Doc->ExportCaption($this->zona);
					if ($this->n_ind->Exportable) $Doc->ExportCaption($this->n_ind);
					if ($this->n_mat->Exportable) $Doc->ExportCaption($this->n_mat);
					if ($this->n_ipa->Exportable) $Doc->ExportCaption($this->n_ipa);
					if ($this->jumlah_nilai_usum->Exportable) $Doc->ExportCaption($this->jumlah_nilai_usum);
					if ($this->bonus_prestasi->Exportable) $Doc->ExportCaption($this->bonus_prestasi);
					if ($this->nama_prestasi->Exportable) $Doc->ExportCaption($this->nama_prestasi);
					if ($this->jumlah_bonus_prestasi->Exportable) $Doc->ExportCaption($this->jumlah_bonus_prestasi);
					if ($this->kepemilikan_ijasah_mda->Exportable) $Doc->ExportCaption($this->kepemilikan_ijasah_mda);
					if ($this->nilai_mda->Exportable) $Doc->ExportCaption($this->nilai_mda);
					if ($this->nilai_akhir->Exportable) $Doc->ExportCaption($this->nilai_akhir);
					if ($this->nama_ayah->Exportable) $Doc->ExportCaption($this->nama_ayah);
					if ($this->nama_ibu->Exportable) $Doc->ExportCaption($this->nama_ibu);
					if ($this->nama_wali->Exportable) $Doc->ExportCaption($this->nama_wali);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->persyaratan->Exportable) $Doc->ExportCaption($this->persyaratan);
					if ($this->catatan->Exportable) $Doc->ExportCaption($this->catatan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
				} else {
					if ($this->id_pendaftar->Exportable) $Doc->ExportCaption($this->id_pendaftar);
					if ($this->nama_ruang->Exportable) $Doc->ExportCaption($this->nama_ruang);
					if ($this->nomor_pendaftaran->Exportable) $Doc->ExportCaption($this->nomor_pendaftaran);
					if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportCaption($this->nomor_peserta_ujian_sdmi);
					if ($this->sekolah_asal->Exportable) $Doc->ExportCaption($this->sekolah_asal);
					if ($this->nama_lengkap->Exportable) $Doc->ExportCaption($this->nama_lengkap);
					if ($this->nik->Exportable) $Doc->ExportCaption($this->nik);
					if ($this->nisn->Exportable) $Doc->ExportCaption($this->nisn);
					if ($this->tempat_lahir->Exportable) $Doc->ExportCaption($this->tempat_lahir);
					if ($this->tanggal_lahir->Exportable) $Doc->ExportCaption($this->tanggal_lahir);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->agama->Exportable) $Doc->ExportCaption($this->agama);
					if ($this->kecamatan->Exportable) $Doc->ExportCaption($this->kecamatan);
					if ($this->zona->Exportable) $Doc->ExportCaption($this->zona);
					if ($this->n_ind->Exportable) $Doc->ExportCaption($this->n_ind);
					if ($this->n_mat->Exportable) $Doc->ExportCaption($this->n_mat);
					if ($this->n_ipa->Exportable) $Doc->ExportCaption($this->n_ipa);
					if ($this->jumlah_nilai_usum->Exportable) $Doc->ExportCaption($this->jumlah_nilai_usum);
					if ($this->bonus_prestasi->Exportable) $Doc->ExportCaption($this->bonus_prestasi);
					if ($this->nama_prestasi->Exportable) $Doc->ExportCaption($this->nama_prestasi);
					if ($this->jumlah_bonus_prestasi->Exportable) $Doc->ExportCaption($this->jumlah_bonus_prestasi);
					if ($this->kepemilikan_ijasah_mda->Exportable) $Doc->ExportCaption($this->kepemilikan_ijasah_mda);
					if ($this->nilai_mda->Exportable) $Doc->ExportCaption($this->nilai_mda);
					if ($this->nilai_akhir->Exportable) $Doc->ExportCaption($this->nilai_akhir);
					if ($this->nama_ayah->Exportable) $Doc->ExportCaption($this->nama_ayah);
					if ($this->nama_ibu->Exportable) $Doc->ExportCaption($this->nama_ibu);
					if ($this->nama_wali->Exportable) $Doc->ExportCaption($this->nama_wali);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->persyaratan->Exportable) $Doc->ExportCaption($this->persyaratan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);
				$this->AggregateListRowValues(); // Aggregate row values

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id_pendaftar->Exportable) $Doc->ExportField($this->id_pendaftar);
						if ($this->nama_ruang->Exportable) $Doc->ExportField($this->nama_ruang);
						if ($this->nomor_pendaftaran->Exportable) $Doc->ExportField($this->nomor_pendaftaran);
						if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportField($this->nomor_peserta_ujian_sdmi);
						if ($this->sekolah_asal->Exportable) $Doc->ExportField($this->sekolah_asal);
						if ($this->nama_lengkap->Exportable) $Doc->ExportField($this->nama_lengkap);
						if ($this->nik->Exportable) $Doc->ExportField($this->nik);
						if ($this->nisn->Exportable) $Doc->ExportField($this->nisn);
						if ($this->tempat_lahir->Exportable) $Doc->ExportField($this->tempat_lahir);
						if ($this->tanggal_lahir->Exportable) $Doc->ExportField($this->tanggal_lahir);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->agama->Exportable) $Doc->ExportField($this->agama);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->kecamatan->Exportable) $Doc->ExportField($this->kecamatan);
						if ($this->zona->Exportable) $Doc->ExportField($this->zona);
						if ($this->n_ind->Exportable) $Doc->ExportField($this->n_ind);
						if ($this->n_mat->Exportable) $Doc->ExportField($this->n_mat);
						if ($this->n_ipa->Exportable) $Doc->ExportField($this->n_ipa);
						if ($this->jumlah_nilai_usum->Exportable) $Doc->ExportField($this->jumlah_nilai_usum);
						if ($this->bonus_prestasi->Exportable) $Doc->ExportField($this->bonus_prestasi);
						if ($this->nama_prestasi->Exportable) $Doc->ExportField($this->nama_prestasi);
						if ($this->jumlah_bonus_prestasi->Exportable) $Doc->ExportField($this->jumlah_bonus_prestasi);
						if ($this->kepemilikan_ijasah_mda->Exportable) $Doc->ExportField($this->kepemilikan_ijasah_mda);
						if ($this->nilai_mda->Exportable) $Doc->ExportField($this->nilai_mda);
						if ($this->nilai_akhir->Exportable) $Doc->ExportField($this->nilai_akhir);
						if ($this->nama_ayah->Exportable) $Doc->ExportField($this->nama_ayah);
						if ($this->nama_ibu->Exportable) $Doc->ExportField($this->nama_ibu);
						if ($this->nama_wali->Exportable) $Doc->ExportField($this->nama_wali);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->persyaratan->Exportable) $Doc->ExportField($this->persyaratan);
						if ($this->catatan->Exportable) $Doc->ExportField($this->catatan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
					} else {
						if ($this->id_pendaftar->Exportable) $Doc->ExportField($this->id_pendaftar);
						if ($this->nama_ruang->Exportable) $Doc->ExportField($this->nama_ruang);
						if ($this->nomor_pendaftaran->Exportable) $Doc->ExportField($this->nomor_pendaftaran);
						if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportField($this->nomor_peserta_ujian_sdmi);
						if ($this->sekolah_asal->Exportable) $Doc->ExportField($this->sekolah_asal);
						if ($this->nama_lengkap->Exportable) $Doc->ExportField($this->nama_lengkap);
						if ($this->nik->Exportable) $Doc->ExportField($this->nik);
						if ($this->nisn->Exportable) $Doc->ExportField($this->nisn);
						if ($this->tempat_lahir->Exportable) $Doc->ExportField($this->tempat_lahir);
						if ($this->tanggal_lahir->Exportable) $Doc->ExportField($this->tanggal_lahir);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->agama->Exportable) $Doc->ExportField($this->agama);
						if ($this->kecamatan->Exportable) $Doc->ExportField($this->kecamatan);
						if ($this->zona->Exportable) $Doc->ExportField($this->zona);
						if ($this->n_ind->Exportable) $Doc->ExportField($this->n_ind);
						if ($this->n_mat->Exportable) $Doc->ExportField($this->n_mat);
						if ($this->n_ipa->Exportable) $Doc->ExportField($this->n_ipa);
						if ($this->jumlah_nilai_usum->Exportable) $Doc->ExportField($this->jumlah_nilai_usum);
						if ($this->bonus_prestasi->Exportable) $Doc->ExportField($this->bonus_prestasi);
						if ($this->nama_prestasi->Exportable) $Doc->ExportField($this->nama_prestasi);
						if ($this->jumlah_bonus_prestasi->Exportable) $Doc->ExportField($this->jumlah_bonus_prestasi);
						if ($this->kepemilikan_ijasah_mda->Exportable) $Doc->ExportField($this->kepemilikan_ijasah_mda);
						if ($this->nilai_mda->Exportable) $Doc->ExportField($this->nilai_mda);
						if ($this->nilai_akhir->Exportable) $Doc->ExportField($this->nilai_akhir);
						if ($this->nama_ayah->Exportable) $Doc->ExportField($this->nama_ayah);
						if ($this->nama_ibu->Exportable) $Doc->ExportField($this->nama_ibu);
						if ($this->nama_wali->Exportable) $Doc->ExportField($this->nama_wali);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->persyaratan->Exportable) $Doc->ExportField($this->persyaratan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}

		// Export aggregates (horizontal format only)
		if ($Doc->Horizontal) {
			$this->RowType = EW_ROWTYPE_AGGREGATE;
			$this->ResetAttrs();
			$this->AggregateListRow();
			if (!$Doc->ExportCustom) {
				$Doc->BeginExportRow(-1);
				if ($this->id_pendaftar->Exportable) $Doc->ExportAggregate($this->id_pendaftar, '');
				if ($this->nama_ruang->Exportable) $Doc->ExportAggregate($this->nama_ruang, '');
				if ($this->nomor_pendaftaran->Exportable) $Doc->ExportAggregate($this->nomor_pendaftaran, '');
				if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportAggregate($this->nomor_peserta_ujian_sdmi, '');
				if ($this->sekolah_asal->Exportable) $Doc->ExportAggregate($this->sekolah_asal, '');
				if ($this->nama_lengkap->Exportable) $Doc->ExportAggregate($this->nama_lengkap, 'COUNT');
				if ($this->nik->Exportable) $Doc->ExportAggregate($this->nik, '');
				if ($this->nisn->Exportable) $Doc->ExportAggregate($this->nisn, '');
				if ($this->tempat_lahir->Exportable) $Doc->ExportAggregate($this->tempat_lahir, '');
				if ($this->tanggal_lahir->Exportable) $Doc->ExportAggregate($this->tanggal_lahir, '');
				if ($this->jenis_kelamin->Exportable) $Doc->ExportAggregate($this->jenis_kelamin, '');
				if ($this->agama->Exportable) $Doc->ExportAggregate($this->agama, '');
				if ($this->kecamatan->Exportable) $Doc->ExportAggregate($this->kecamatan, '');
				if ($this->zona->Exportable) $Doc->ExportAggregate($this->zona, '');
				if ($this->n_ind->Exportable) $Doc->ExportAggregate($this->n_ind, '');
				if ($this->n_mat->Exportable) $Doc->ExportAggregate($this->n_mat, '');
				if ($this->n_ipa->Exportable) $Doc->ExportAggregate($this->n_ipa, '');
				if ($this->jumlah_nilai_usum->Exportable) $Doc->ExportAggregate($this->jumlah_nilai_usum, '');
				if ($this->bonus_prestasi->Exportable) $Doc->ExportAggregate($this->bonus_prestasi, '');
				if ($this->nama_prestasi->Exportable) $Doc->ExportAggregate($this->nama_prestasi, '');
				if ($this->jumlah_bonus_prestasi->Exportable) $Doc->ExportAggregate($this->jumlah_bonus_prestasi, '');
				if ($this->kepemilikan_ijasah_mda->Exportable) $Doc->ExportAggregate($this->kepemilikan_ijasah_mda, '');
				if ($this->nilai_mda->Exportable) $Doc->ExportAggregate($this->nilai_mda, '');
				if ($this->nilai_akhir->Exportable) $Doc->ExportAggregate($this->nilai_akhir, '');
				if ($this->nama_ayah->Exportable) $Doc->ExportAggregate($this->nama_ayah, '');
				if ($this->nama_ibu->Exportable) $Doc->ExportAggregate($this->nama_ibu, '');
				if ($this->nama_wali->Exportable) $Doc->ExportAggregate($this->nama_wali, '');
				if ($this->status->Exportable) $Doc->ExportAggregate($this->status, '');
				if ($this->persyaratan->Exportable) $Doc->ExportAggregate($this->persyaratan, '');
				if ($this->keterangan->Exportable) $Doc->ExportAggregate($this->keterangan, '');
				$Doc->EndExportRow();
			}
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`nama_ruang` IN (' . $sFilterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $UserTableConn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `pendaftar`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $UserTableConn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType, EW_USER_TABLE_DBID);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_kecamatan$/', $id)) {
			$conn = &Conn('');
			$sSqlWrk = "SELECT `prioritas` AS FIELD0 FROM `kecamatan`";
			$sWhereWrk = "(`id_kec` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->kecamatan->LookupFilters = array("dx1" => '`nama_kec`');
			$this->Lookup_Selecting($this->kecamatan, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->zona->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->zona->AutoFillOriginalValue) ? $this->zona->CurrentValue : $this->zona->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_bonus_prestasi$/', $id)) {
			$conn = &Conn('');
			$sSqlWrk = "SELECT `nilai` AS FIELD0 FROM `bonus`";
			$sWhereWrk = "(`id_bonus` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->bonus_prestasi->LookupFilters = array("dx1" => '`bonus`');
			$this->Lookup_Selecting($this->bonus_prestasi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->jumlah_bonus_prestasi->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = $this->jumlah_bonus_prestasi->CurrentValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_kepemilikan_ijasah_mda$/', $id)) {
			$conn = &Conn('');
			$sSqlWrk = "SELECT `nilai` AS FIELD0 FROM `mda`";
			$sWhereWrk = "(`id_mda` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->kepemilikan_ijasah_mda->LookupFilters = array();
			$this->Lookup_Selecting($this->kepemilikan_ijasah_mda, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nilai_mda->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = $this->nilai_mda->CurrentValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
