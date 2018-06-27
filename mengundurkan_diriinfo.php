<?php

// Global variable for table object
$mengundurkan_diri = NULL;

//
// Table class for mengundurkan diri
//
class cmengundurkan_diri extends cTable {
	var $nomor_pendaftaran;
	var $nama_ruang;
	var $nomor_peserta_ujian_sdmi;
	var $sekolah_asal;
	var $nama_lengkap;
	var $jenis_kelamin;
	var $zona;
	var $nilai_akhir;
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
		$this->TableVar = 'mengundurkan_diri';
		$this->TableName = 'mengundurkan diri';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`mengundurkan diri`";
		$this->DBID = 'DB';
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

		// nomor_pendaftaran
		$this->nomor_pendaftaran = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_nomor_pendaftaran', 'nomor_pendaftaran', '`nomor_pendaftaran`', '`nomor_pendaftaran`', 200, -1, FALSE, '`nomor_pendaftaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nomor_pendaftaran->Sortable = TRUE; // Allow sort
		$this->nomor_pendaftaran->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nomor_pendaftaran->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nomor_pendaftaran'] = &$this->nomor_pendaftaran;

		// nama_ruang
		$this->nama_ruang = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_nama_ruang', 'nama_ruang', '`nama_ruang`', '`nama_ruang`', 200, -1, FALSE, '`nama_ruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_ruang->Sortable = TRUE; // Allow sort
		$this->nama_ruang->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_ruang->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_ruang'] = &$this->nama_ruang;

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_nomor_peserta_ujian_sdmi', 'nomor_peserta_ujian_sdmi', '`nomor_peserta_ujian_sdmi`', '`nomor_peserta_ujian_sdmi`', 200, -1, FALSE, '`EV__nomor_peserta_ujian_sdmi`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->nomor_peserta_ujian_sdmi->Sortable = TRUE; // Allow sort
		$this->nomor_peserta_ujian_sdmi->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nomor_peserta_ujian_sdmi->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nomor_peserta_ujian_sdmi'] = &$this->nomor_peserta_ujian_sdmi;

		// sekolah_asal
		$this->sekolah_asal = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_sekolah_asal', 'sekolah_asal', '`sekolah_asal`', '`sekolah_asal`', 200, -1, FALSE, '`sekolah_asal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sekolah_asal->Sortable = TRUE; // Allow sort
		$this->fields['sekolah_asal'] = &$this->sekolah_asal;

		// nama_lengkap
		$this->nama_lengkap = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_nama_lengkap', 'nama_lengkap', '`nama_lengkap`', '`nama_lengkap`', 200, -1, FALSE, '`nama_lengkap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_lengkap->Sortable = TRUE; // Allow sort
		$this->fields['nama_lengkap'] = &$this->nama_lengkap;

		// jenis_kelamin
		$this->jenis_kelamin = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_jenis_kelamin', 'jenis_kelamin', '`jenis_kelamin`', '`jenis_kelamin`', 200, -1, FALSE, '`jenis_kelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->jenis_kelamin->Sortable = TRUE; // Allow sort
		$this->jenis_kelamin->OptionCount = 2;
		$this->fields['jenis_kelamin'] = &$this->jenis_kelamin;

		// zona
		$this->zona = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_zona', 'zona', '`zona`', '`zona`', 200, -1, FALSE, '`zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zona->Sortable = TRUE; // Allow sort
		$this->fields['zona'] = &$this->zona;

		// nilai_akhir
		$this->nilai_akhir = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_nilai_akhir', 'nilai_akhir', '`nilai_akhir`', '`nilai_akhir`', 200, -1, FALSE, '`nilai_akhir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nilai_akhir->Sortable = TRUE; // Allow sort
		$this->fields['nilai_akhir'] = &$this->nilai_akhir;

		// status
		$this->status = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_status', 'status', '`status`', '`status`', 200, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->fields['status'] = &$this->status;

		// persyaratan
		$this->persyaratan = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_persyaratan', 'persyaratan', '`persyaratan`', '`persyaratan`', 200, -1, FALSE, '`persyaratan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->persyaratan->Sortable = TRUE; // Allow sort
		$this->persyaratan->OptionCount = 2;
		$this->fields['persyaratan'] = &$this->persyaratan;

		// catatan
		$this->catatan = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_catatan', 'catatan', '`catatan`', '`catatan`', 201, -1, FALSE, '`catatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->catatan->Sortable = TRUE; // Allow sort
		$this->fields['catatan'] = &$this->catatan;

		// keterangan
		$this->keterangan = new cField('mengundurkan_diri', 'mengundurkan diri', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`mengundurkan diri`";
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
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT DISTINCT `nopes` FROM `db_pd` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`nopes` = `mengundurkan diri`.`nomor_peserta_ujian_sdmi` LIMIT 1) AS `EV__nomor_peserta_ujian_sdmi` FROM `mengundurkan diri`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
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
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
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
		if ($this->UseVirtualFields()) {
			$sSelect = $this->getSqlSelectList();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		} else {
			$sSelect = $this->getSqlSelect();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		}
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->UseSessionForListSQL ? $this->getSessionWhere() : $this->CurrentFilter;
		$sOrderBy = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->BasicSearch->getKeyword() <> "")
			return TRUE;
		if ($this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchValue <> "" ||
			$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->nomor_peserta_ujian_sdmi->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->nomor_peserta_ujian_sdmi->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "mengundurkan_dirilist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "mengundurkan_diriview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "mengundurkan_diriedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "mengundurkan_diriadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "mengundurkan_dirilist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("mengundurkan_diriview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("mengundurkan_diriview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "mengundurkan_diriadd.php?" . $this->UrlParm($parm);
		else
			$url = "mengundurkan_diriadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("mengundurkan_diriedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("mengundurkan_diriadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("mengundurkan_diridelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->nomor_pendaftaran->setDbValue($rs->fields('nomor_pendaftaran'));
		$this->nama_ruang->setDbValue($rs->fields('nama_ruang'));
		$this->nomor_peserta_ujian_sdmi->setDbValue($rs->fields('nomor_peserta_ujian_sdmi'));
		$this->sekolah_asal->setDbValue($rs->fields('sekolah_asal'));
		$this->nama_lengkap->setDbValue($rs->fields('nama_lengkap'));
		$this->jenis_kelamin->setDbValue($rs->fields('jenis_kelamin'));
		$this->zona->setDbValue($rs->fields('zona'));
		$this->nilai_akhir->setDbValue($rs->fields('nilai_akhir'));
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
		// nomor_pendaftaran
		// nama_ruang
		// nomor_peserta_ujian_sdmi
		// sekolah_asal
		// nama_lengkap
		// jenis_kelamin
		// zona
		// nilai_akhir
		// status
		// persyaratan
		// catatan
		// keterangan
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

		// nomor_peserta_ujian_sdmi
		if ($this->nomor_peserta_ujian_sdmi->VirtualValue <> "") {
			$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->VirtualValue;
		} else {
		if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
			$sFilterWrk = "`nopes`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT DISTINCT `nopes`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
		$sWhereWrk = "";
		$this->nomor_peserta_ujian_sdmi->LookupFilters = array("dx1" => '`nopes`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nopes` ASC";
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
		}
		$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

		// sekolah_asal
		$this->sekolah_asal->ViewValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->ViewCustomAttributes = "";

		// nama_lengkap
		$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->ViewCustomAttributes = "";

		// jenis_kelamin
		if (strval($this->jenis_kelamin->CurrentValue) <> "") {
			$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->OptionCaption($this->jenis_kelamin->CurrentValue);
		} else {
			$this->jenis_kelamin->ViewValue = NULL;
		}
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->CellCssStyle .= "text-align: center;";
		$this->zona->ViewCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->ViewValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->ViewValue = ew_FormatNumber($this->nilai_akhir->ViewValue, 1, -1, -2, -2);
		$this->nilai_akhir->CellCssStyle .= "text-align: center;";
		$this->nilai_akhir->ViewCustomAttributes = "";

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

		// nomor_pendaftaran
		$this->nomor_pendaftaran->LinkCustomAttributes = "";
		$this->nomor_pendaftaran->HrefValue = "";
		$this->nomor_pendaftaran->TooltipValue = "";

		// nama_ruang
		$this->nama_ruang->LinkCustomAttributes = "";
		$this->nama_ruang->HrefValue = "";
		$this->nama_ruang->TooltipValue = "";

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->LinkCustomAttributes = "";
		$this->nomor_peserta_ujian_sdmi->HrefValue = "";
		$this->nomor_peserta_ujian_sdmi->TooltipValue = "";
		if ($this->Export == "")
			$this->nomor_peserta_ujian_sdmi->ViewValue = $this->HighlightValue($this->nomor_peserta_ujian_sdmi);

		// sekolah_asal
		$this->sekolah_asal->LinkCustomAttributes = "";
		$this->sekolah_asal->HrefValue = "";
		$this->sekolah_asal->TooltipValue = "";

		// nama_lengkap
		$this->nama_lengkap->LinkCustomAttributes = "";
		$this->nama_lengkap->HrefValue = "";
		$this->nama_lengkap->TooltipValue = "";

		// jenis_kelamin
		$this->jenis_kelamin->LinkCustomAttributes = "";
		$this->jenis_kelamin->HrefValue = "";
		$this->jenis_kelamin->TooltipValue = "";

		// zona
		$this->zona->LinkCustomAttributes = "";
		$this->zona->HrefValue = "";
		$this->zona->TooltipValue = "";

		// nilai_akhir
		$this->nilai_akhir->LinkCustomAttributes = "";
		$this->nilai_akhir->HrefValue = "";
		$this->nilai_akhir->TooltipValue = "";

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

		// nomor_pendaftaran
		$this->nomor_pendaftaran->EditAttrs["class"] = "form-control";
		$this->nomor_pendaftaran->EditCustomAttributes = "";

		// nama_ruang
		$this->nama_ruang->EditAttrs["class"] = "form-control";
		$this->nama_ruang->EditCustomAttributes = "";

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->EditAttrs["class"] = "form-control";
		$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";

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

		// jenis_kelamin
		$this->jenis_kelamin->EditCustomAttributes = "";
		$this->jenis_kelamin->EditValue = $this->jenis_kelamin->Options(FALSE);

		// zona
		$this->zona->EditAttrs["class"] = "form-control";
		$this->zona->EditCustomAttributes = "";
		$this->zona->EditValue = $this->zona->CurrentValue;
		$this->zona->PlaceHolder = ew_RemoveHtml($this->zona->FldCaption());

		// nilai_akhir
		$this->nilai_akhir->EditAttrs["class"] = "form-control";
		$this->nilai_akhir->EditCustomAttributes = "";
		$this->nilai_akhir->EditValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->PlaceHolder = ew_RemoveHtml($this->nilai_akhir->FldCaption());

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
					if ($this->nomor_pendaftaran->Exportable) $Doc->ExportCaption($this->nomor_pendaftaran);
					if ($this->nama_ruang->Exportable) $Doc->ExportCaption($this->nama_ruang);
					if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportCaption($this->nomor_peserta_ujian_sdmi);
					if ($this->sekolah_asal->Exportable) $Doc->ExportCaption($this->sekolah_asal);
					if ($this->nama_lengkap->Exportable) $Doc->ExportCaption($this->nama_lengkap);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->zona->Exportable) $Doc->ExportCaption($this->zona);
					if ($this->nilai_akhir->Exportable) $Doc->ExportCaption($this->nilai_akhir);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->persyaratan->Exportable) $Doc->ExportCaption($this->persyaratan);
					if ($this->catatan->Exportable) $Doc->ExportCaption($this->catatan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
				} else {
					if ($this->nomor_pendaftaran->Exportable) $Doc->ExportCaption($this->nomor_pendaftaran);
					if ($this->nama_ruang->Exportable) $Doc->ExportCaption($this->nama_ruang);
					if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportCaption($this->nomor_peserta_ujian_sdmi);
					if ($this->sekolah_asal->Exportable) $Doc->ExportCaption($this->sekolah_asal);
					if ($this->nama_lengkap->Exportable) $Doc->ExportCaption($this->nama_lengkap);
					if ($this->jenis_kelamin->Exportable) $Doc->ExportCaption($this->jenis_kelamin);
					if ($this->zona->Exportable) $Doc->ExportCaption($this->zona);
					if ($this->nilai_akhir->Exportable) $Doc->ExportCaption($this->nilai_akhir);
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
						if ($this->nomor_pendaftaran->Exportable) $Doc->ExportField($this->nomor_pendaftaran);
						if ($this->nama_ruang->Exportable) $Doc->ExportField($this->nama_ruang);
						if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportField($this->nomor_peserta_ujian_sdmi);
						if ($this->sekolah_asal->Exportable) $Doc->ExportField($this->sekolah_asal);
						if ($this->nama_lengkap->Exportable) $Doc->ExportField($this->nama_lengkap);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->zona->Exportable) $Doc->ExportField($this->zona);
						if ($this->nilai_akhir->Exportable) $Doc->ExportField($this->nilai_akhir);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->persyaratan->Exportable) $Doc->ExportField($this->persyaratan);
						if ($this->catatan->Exportable) $Doc->ExportField($this->catatan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
					} else {
						if ($this->nomor_pendaftaran->Exportable) $Doc->ExportField($this->nomor_pendaftaran);
						if ($this->nama_ruang->Exportable) $Doc->ExportField($this->nama_ruang);
						if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportField($this->nomor_peserta_ujian_sdmi);
						if ($this->sekolah_asal->Exportable) $Doc->ExportField($this->sekolah_asal);
						if ($this->nama_lengkap->Exportable) $Doc->ExportField($this->nama_lengkap);
						if ($this->jenis_kelamin->Exportable) $Doc->ExportField($this->jenis_kelamin);
						if ($this->zona->Exportable) $Doc->ExportField($this->zona);
						if ($this->nilai_akhir->Exportable) $Doc->ExportField($this->nilai_akhir);
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
				if ($this->nomor_pendaftaran->Exportable) $Doc->ExportAggregate($this->nomor_pendaftaran, '');
				if ($this->nama_ruang->Exportable) $Doc->ExportAggregate($this->nama_ruang, '');
				if ($this->nomor_peserta_ujian_sdmi->Exportable) $Doc->ExportAggregate($this->nomor_peserta_ujian_sdmi, '');
				if ($this->sekolah_asal->Exportable) $Doc->ExportAggregate($this->sekolah_asal, '');
				if ($this->nama_lengkap->Exportable) $Doc->ExportAggregate($this->nama_lengkap, 'COUNT');
				if ($this->jenis_kelamin->Exportable) $Doc->ExportAggregate($this->jenis_kelamin, '');
				if ($this->zona->Exportable) $Doc->ExportAggregate($this->zona, '');
				if ($this->nilai_akhir->Exportable) $Doc->ExportAggregate($this->nilai_akhir, '');
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

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_nomor_peserta_ujian_sdmi$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `asal_sek` AS FIELD0, `nm_pes` AS FIELD1 FROM `db_pd`";
			$sWhereWrk = "(`nopes` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array("dx1" => '`nopes`');
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nopes` ASC";
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->sekolah_asal->setDbValue($rs->fields[0]);
					$this->nama_lengkap->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->sekolah_asal->AutoFillOriginalValue) ? $this->sekolah_asal->CurrentValue : $this->sekolah_asal->EditValue;
					$ar[] = ($this->nama_lengkap->AutoFillOriginalValue) ? $this->nama_lengkap->CurrentValue : $this->nama_lengkap->EditValue;
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
