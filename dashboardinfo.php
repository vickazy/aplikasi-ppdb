<?php

// Global variable for table object
$dashboard = NULL;

//
// Table class for dashboard
//
class cdashboard extends cTable {
	var $id;
	var $kode_sek;
	var $nama_sekolah;
	var $kepsek;
	var $nip_ks;
	var $jumlah_rombel;
	var $daya_tampung;
	var $zona1;
	var $zona2;
	var $zona3;
	var $thn_pelajaran;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'dashboard';
		$this->TableName = 'dashboard';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`dashboard`";
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

		// id
		$this->id = new cField('dashboard', 'dashboard', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// kode_sek
		$this->kode_sek = new cField('dashboard', 'dashboard', 'x_kode_sek', 'kode_sek', '`kode_sek`', '`kode_sek`', 200, -1, FALSE, '`kode_sek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_sek->Sortable = TRUE; // Allow sort
		$this->fields['kode_sek'] = &$this->kode_sek;

		// nama_sekolah
		$this->nama_sekolah = new cField('dashboard', 'dashboard', 'x_nama_sekolah', 'nama_sekolah', '`nama_sekolah`', '`nama_sekolah`', 200, -1, FALSE, '`nama_sekolah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_sekolah->Sortable = TRUE; // Allow sort
		$this->fields['nama_sekolah'] = &$this->nama_sekolah;

		// kepsek
		$this->kepsek = new cField('dashboard', 'dashboard', 'x_kepsek', 'kepsek', '`kepsek`', '`kepsek`', 200, -1, FALSE, '`kepsek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kepsek->Sortable = TRUE; // Allow sort
		$this->fields['kepsek'] = &$this->kepsek;

		// nip_ks
		$this->nip_ks = new cField('dashboard', 'dashboard', 'x_nip_ks', 'nip_ks', '`nip_ks`', '`nip_ks`', 200, -1, FALSE, '`nip_ks`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_ks->Sortable = TRUE; // Allow sort
		$this->fields['nip_ks'] = &$this->nip_ks;

		// jumlah_rombel
		$this->jumlah_rombel = new cField('dashboard', 'dashboard', 'x_jumlah_rombel', 'jumlah_rombel', '`jumlah_rombel`', '`jumlah_rombel`', 3, -1, FALSE, '`jumlah_rombel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_rombel->Sortable = TRUE; // Allow sort
		$this->jumlah_rombel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah_rombel'] = &$this->jumlah_rombel;

		// daya_tampung
		$this->daya_tampung = new cField('dashboard', 'dashboard', 'x_daya_tampung', 'daya_tampung', '`daya_tampung`', '`daya_tampung`', 3, -1, FALSE, '`daya_tampung`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->daya_tampung->Sortable = TRUE; // Allow sort
		$this->daya_tampung->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['daya_tampung'] = &$this->daya_tampung;

		// zona1
		$this->zona1 = new cField('dashboard', 'dashboard', 'x_zona1', 'zona1', '`zona1`', '`zona1`', 200, -1, FALSE, '`zona1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zona1->Sortable = TRUE; // Allow sort
		$this->fields['zona1'] = &$this->zona1;

		// zona2
		$this->zona2 = new cField('dashboard', 'dashboard', 'x_zona2', 'zona2', '`zona2`', '`zona2`', 200, -1, FALSE, '`zona2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zona2->Sortable = TRUE; // Allow sort
		$this->fields['zona2'] = &$this->zona2;

		// zona3
		$this->zona3 = new cField('dashboard', 'dashboard', 'x_zona3', 'zona3', '`zona3`', '`zona3`', 200, -1, FALSE, '`zona3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zona3->Sortable = TRUE; // Allow sort
		$this->fields['zona3'] = &$this->zona3;

		// thn_pelajaran
		$this->thn_pelajaran = new cField('dashboard', 'dashboard', 'x_thn_pelajaran', 'thn_pelajaran', '`thn_pelajaran`', '`thn_pelajaran`', 200, -1, FALSE, '`thn_pelajaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->thn_pelajaran->Sortable = TRUE; // Allow sort
		$this->fields['thn_pelajaran'] = &$this->thn_pelajaran;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`dashboard`";
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
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
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
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
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
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "dashboardlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "dashboardview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "dashboardedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "dashboardadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "dashboardlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("dashboardview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("dashboardview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "dashboardadd.php?" . $this->UrlParm($parm);
		else
			$url = "dashboardadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("dashboardedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("dashboardadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("dashboarddelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
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
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
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
			$this->id->CurrentValue = $key;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->kode_sek->setDbValue($rs->fields('kode_sek'));
		$this->nama_sekolah->setDbValue($rs->fields('nama_sekolah'));
		$this->kepsek->setDbValue($rs->fields('kepsek'));
		$this->nip_ks->setDbValue($rs->fields('nip_ks'));
		$this->jumlah_rombel->setDbValue($rs->fields('jumlah_rombel'));
		$this->daya_tampung->setDbValue($rs->fields('daya_tampung'));
		$this->zona1->setDbValue($rs->fields('zona1'));
		$this->zona2->setDbValue($rs->fields('zona2'));
		$this->zona3->setDbValue($rs->fields('zona3'));
		$this->thn_pelajaran->setDbValue($rs->fields('thn_pelajaran'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// kode_sek
		// nama_sekolah
		// kepsek
		// nip_ks
		// jumlah_rombel
		// daya_tampung
		// zona1
		// zona2
		// zona3
		// thn_pelajaran
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kode_sek
		$this->kode_sek->ViewValue = $this->kode_sek->CurrentValue;
		$this->kode_sek->CellCssStyle .= "text-align: center;";
		$this->kode_sek->ViewCustomAttributes = "";

		// nama_sekolah
		$this->nama_sekolah->ViewValue = $this->nama_sekolah->CurrentValue;
		$this->nama_sekolah->CssStyle = "font-weight: bold;";
		$this->nama_sekolah->CellCssStyle .= "text-align: center;";
		$this->nama_sekolah->ViewCustomAttributes = "";

		// kepsek
		$this->kepsek->ViewValue = $this->kepsek->CurrentValue;
		$this->kepsek->CellCssStyle .= "text-align: center;";
		$this->kepsek->ViewCustomAttributes = "";

		// nip_ks
		$this->nip_ks->ViewValue = $this->nip_ks->CurrentValue;
		$this->nip_ks->CellCssStyle .= "text-align: center;";
		$this->nip_ks->ViewCustomAttributes = "";

		// jumlah_rombel
		$this->jumlah_rombel->ViewValue = $this->jumlah_rombel->CurrentValue;
		$this->jumlah_rombel->CellCssStyle .= "text-align: center;";
		$this->jumlah_rombel->ViewCustomAttributes = "";

		// daya_tampung
		$this->daya_tampung->ViewValue = $this->daya_tampung->CurrentValue;
		$this->daya_tampung->CssStyle = "font-weight: bold;";
		$this->daya_tampung->CellCssStyle .= "text-align: center;";
		$this->daya_tampung->ViewCustomAttributes = "";

		// zona1
		$this->zona1->ViewValue = $this->zona1->CurrentValue;
		$this->zona1->ViewValue = ew_FormatNumber($this->zona1->ViewValue, 0, -2, -2, -2);
		$this->zona1->CellCssStyle .= "text-align: center;";
		$this->zona1->ViewCustomAttributes = "";

		// zona2
		$this->zona2->ViewValue = $this->zona2->CurrentValue;
		$this->zona2->ViewValue = ew_FormatNumber($this->zona2->ViewValue, 0, -2, -2, -2);
		$this->zona2->CellCssStyle .= "text-align: center;";
		$this->zona2->ViewCustomAttributes = "";

		// zona3
		$this->zona3->ViewValue = $this->zona3->CurrentValue;
		$this->zona3->ViewValue = ew_FormatNumber($this->zona3->ViewValue, 0, -2, -2, -2);
		$this->zona3->CellCssStyle .= "text-align: center;";
		$this->zona3->ViewCustomAttributes = "";

		// thn_pelajaran
		$this->thn_pelajaran->ViewValue = $this->thn_pelajaran->CurrentValue;
		$this->thn_pelajaran->CellCssStyle .= "text-align: center;";
		$this->thn_pelajaran->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// kode_sek
		$this->kode_sek->LinkCustomAttributes = "";
		$this->kode_sek->HrefValue = "";
		$this->kode_sek->TooltipValue = "";

		// nama_sekolah
		$this->nama_sekolah->LinkCustomAttributes = "";
		$this->nama_sekolah->HrefValue = "";
		$this->nama_sekolah->TooltipValue = "";

		// kepsek
		$this->kepsek->LinkCustomAttributes = "";
		$this->kepsek->HrefValue = "";
		$this->kepsek->TooltipValue = "";

		// nip_ks
		$this->nip_ks->LinkCustomAttributes = "";
		$this->nip_ks->HrefValue = "";
		$this->nip_ks->TooltipValue = "";

		// jumlah_rombel
		$this->jumlah_rombel->LinkCustomAttributes = "";
		$this->jumlah_rombel->HrefValue = "";
		$this->jumlah_rombel->TooltipValue = "";

		// daya_tampung
		$this->daya_tampung->LinkCustomAttributes = "";
		$this->daya_tampung->HrefValue = "";
		$this->daya_tampung->TooltipValue = "";

		// zona1
		$this->zona1->LinkCustomAttributes = "";
		$this->zona1->HrefValue = "";
		$this->zona1->TooltipValue = "";

		// zona2
		$this->zona2->LinkCustomAttributes = "";
		$this->zona2->HrefValue = "";
		$this->zona2->TooltipValue = "";

		// zona3
		$this->zona3->LinkCustomAttributes = "";
		$this->zona3->HrefValue = "";
		$this->zona3->TooltipValue = "";

		// thn_pelajaran
		$this->thn_pelajaran->LinkCustomAttributes = "";
		$this->thn_pelajaran->HrefValue = "";
		$this->thn_pelajaran->TooltipValue = "";

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

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kode_sek
		$this->kode_sek->EditAttrs["class"] = "form-control";
		$this->kode_sek->EditCustomAttributes = "";
		$this->kode_sek->EditValue = $this->kode_sek->CurrentValue;
		$this->kode_sek->PlaceHolder = ew_RemoveHtml($this->kode_sek->FldCaption());

		// nama_sekolah
		$this->nama_sekolah->EditAttrs["class"] = "form-control";
		$this->nama_sekolah->EditCustomAttributes = "";
		$this->nama_sekolah->EditValue = $this->nama_sekolah->CurrentValue;
		$this->nama_sekolah->PlaceHolder = ew_RemoveHtml($this->nama_sekolah->FldCaption());

		// kepsek
		$this->kepsek->EditAttrs["class"] = "form-control";
		$this->kepsek->EditCustomAttributes = "";
		$this->kepsek->EditValue = $this->kepsek->CurrentValue;
		$this->kepsek->PlaceHolder = ew_RemoveHtml($this->kepsek->FldCaption());

		// nip_ks
		$this->nip_ks->EditAttrs["class"] = "form-control";
		$this->nip_ks->EditCustomAttributes = "";
		$this->nip_ks->EditValue = $this->nip_ks->CurrentValue;
		$this->nip_ks->PlaceHolder = ew_RemoveHtml($this->nip_ks->FldCaption());

		// jumlah_rombel
		$this->jumlah_rombel->EditAttrs["class"] = "form-control";
		$this->jumlah_rombel->EditCustomAttributes = "";
		$this->jumlah_rombel->EditValue = $this->jumlah_rombel->CurrentValue;
		$this->jumlah_rombel->PlaceHolder = ew_RemoveHtml($this->jumlah_rombel->FldCaption());

		// daya_tampung
		$this->daya_tampung->EditAttrs["class"] = "form-control";
		$this->daya_tampung->EditCustomAttributes = "";
		$this->daya_tampung->EditValue = $this->daya_tampung->CurrentValue;
		$this->daya_tampung->PlaceHolder = ew_RemoveHtml($this->daya_tampung->FldCaption());

		// zona1
		$this->zona1->EditAttrs["class"] = "form-control";
		$this->zona1->EditCustomAttributes = "";
		$this->zona1->EditValue = $this->zona1->CurrentValue;
		$this->zona1->PlaceHolder = ew_RemoveHtml($this->zona1->FldCaption());

		// zona2
		$this->zona2->EditAttrs["class"] = "form-control";
		$this->zona2->EditCustomAttributes = "";
		$this->zona2->EditValue = $this->zona2->CurrentValue;
		$this->zona2->PlaceHolder = ew_RemoveHtml($this->zona2->FldCaption());

		// zona3
		$this->zona3->EditAttrs["class"] = "form-control";
		$this->zona3->EditCustomAttributes = "";
		$this->zona3->EditValue = $this->zona3->CurrentValue;
		$this->zona3->PlaceHolder = ew_RemoveHtml($this->zona3->FldCaption());

		// thn_pelajaran
		$this->thn_pelajaran->EditAttrs["class"] = "form-control";
		$this->thn_pelajaran->EditCustomAttributes = "";
		$this->thn_pelajaran->EditValue = $this->thn_pelajaran->CurrentValue;
		$this->thn_pelajaran->PlaceHolder = ew_RemoveHtml($this->thn_pelajaran->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

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
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kode_sek->Exportable) $Doc->ExportCaption($this->kode_sek);
					if ($this->nama_sekolah->Exportable) $Doc->ExportCaption($this->nama_sekolah);
					if ($this->kepsek->Exportable) $Doc->ExportCaption($this->kepsek);
					if ($this->nip_ks->Exportable) $Doc->ExportCaption($this->nip_ks);
					if ($this->jumlah_rombel->Exportable) $Doc->ExportCaption($this->jumlah_rombel);
					if ($this->daya_tampung->Exportable) $Doc->ExportCaption($this->daya_tampung);
					if ($this->zona1->Exportable) $Doc->ExportCaption($this->zona1);
					if ($this->zona2->Exportable) $Doc->ExportCaption($this->zona2);
					if ($this->zona3->Exportable) $Doc->ExportCaption($this->zona3);
					if ($this->thn_pelajaran->Exportable) $Doc->ExportCaption($this->thn_pelajaran);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kode_sek->Exportable) $Doc->ExportCaption($this->kode_sek);
					if ($this->nama_sekolah->Exportable) $Doc->ExportCaption($this->nama_sekolah);
					if ($this->kepsek->Exportable) $Doc->ExportCaption($this->kepsek);
					if ($this->nip_ks->Exportable) $Doc->ExportCaption($this->nip_ks);
					if ($this->jumlah_rombel->Exportable) $Doc->ExportCaption($this->jumlah_rombel);
					if ($this->daya_tampung->Exportable) $Doc->ExportCaption($this->daya_tampung);
					if ($this->zona1->Exportable) $Doc->ExportCaption($this->zona1);
					if ($this->zona2->Exportable) $Doc->ExportCaption($this->zona2);
					if ($this->zona3->Exportable) $Doc->ExportCaption($this->zona3);
					if ($this->thn_pelajaran->Exportable) $Doc->ExportCaption($this->thn_pelajaran);
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

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kode_sek->Exportable) $Doc->ExportField($this->kode_sek);
						if ($this->nama_sekolah->Exportable) $Doc->ExportField($this->nama_sekolah);
						if ($this->kepsek->Exportable) $Doc->ExportField($this->kepsek);
						if ($this->nip_ks->Exportable) $Doc->ExportField($this->nip_ks);
						if ($this->jumlah_rombel->Exportable) $Doc->ExportField($this->jumlah_rombel);
						if ($this->daya_tampung->Exportable) $Doc->ExportField($this->daya_tampung);
						if ($this->zona1->Exportable) $Doc->ExportField($this->zona1);
						if ($this->zona2->Exportable) $Doc->ExportField($this->zona2);
						if ($this->zona3->Exportable) $Doc->ExportField($this->zona3);
						if ($this->thn_pelajaran->Exportable) $Doc->ExportField($this->thn_pelajaran);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kode_sek->Exportable) $Doc->ExportField($this->kode_sek);
						if ($this->nama_sekolah->Exportable) $Doc->ExportField($this->nama_sekolah);
						if ($this->kepsek->Exportable) $Doc->ExportField($this->kepsek);
						if ($this->nip_ks->Exportable) $Doc->ExportField($this->nip_ks);
						if ($this->jumlah_rombel->Exportable) $Doc->ExportField($this->jumlah_rombel);
						if ($this->daya_tampung->Exportable) $Doc->ExportField($this->daya_tampung);
						if ($this->zona1->Exportable) $Doc->ExportField($this->zona1);
						if ($this->zona2->Exportable) $Doc->ExportField($this->zona2);
						if ($this->zona3->Exportable) $Doc->ExportField($this->zona3);
						if ($this->thn_pelajaran->Exportable) $Doc->ExportField($this->thn_pelajaran);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

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
