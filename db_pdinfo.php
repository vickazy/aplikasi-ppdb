<?php

// Global variable for table object
$db_pd = NULL;

//
// Table class for db_pd
//
class cdb_pd extends cTable {
	var $id_pd;
	var $nopes;
	var $nm_pes;
	var $nisn;
	var $tgl_lhr;
	var $tgl;
	var $bln;
	var $thn;
	var $sex;
	var $nm_ortu;
	var $asal_sek;
	var $n_ind;
	var $n_mat;
	var $n_ipa;
	var $n_jml;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'db_pd';
		$this->TableName = 'db_pd';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`db_pd`";
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

		// id_pd
		$this->id_pd = new cField('db_pd', 'db_pd', 'x_id_pd', 'id_pd', '`id_pd`', '`id_pd`', 3, -1, FALSE, '`id_pd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_pd->Sortable = TRUE; // Allow sort
		$this->id_pd->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_pd'] = &$this->id_pd;

		// nopes
		$this->nopes = new cField('db_pd', 'db_pd', 'x_nopes', 'nopes', '`nopes`', '`nopes`', 200, -1, FALSE, '`nopes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nopes->Sortable = TRUE; // Allow sort
		$this->fields['nopes'] = &$this->nopes;

		// nm_pes
		$this->nm_pes = new cField('db_pd', 'db_pd', 'x_nm_pes', 'nm_pes', '`nm_pes`', '`nm_pes`', 200, -1, FALSE, '`nm_pes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nm_pes->Sortable = TRUE; // Allow sort
		$this->fields['nm_pes'] = &$this->nm_pes;

		// nisn
		$this->nisn = new cField('db_pd', 'db_pd', 'x_nisn', 'nisn', '`nisn`', '`nisn`', 200, -1, FALSE, '`nisn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nisn->Sortable = TRUE; // Allow sort
		$this->fields['nisn'] = &$this->nisn;

		// tgl_lhr
		$this->tgl_lhr = new cField('db_pd', 'db_pd', 'x_tgl_lhr', 'tgl_lhr', '`tgl_lhr`', '`tgl_lhr`', 200, -1, FALSE, '`tgl_lhr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_lhr->Sortable = TRUE; // Allow sort
		$this->fields['tgl_lhr'] = &$this->tgl_lhr;

		// tgl
		$this->tgl = new cField('db_pd', 'db_pd', 'x_tgl', 'tgl', '`tgl`', '`tgl`', 200, -1, FALSE, '`tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl->Sortable = TRUE; // Allow sort
		$this->fields['tgl'] = &$this->tgl;

		// bln
		$this->bln = new cField('db_pd', 'db_pd', 'x_bln', 'bln', '`bln`', '`bln`', 200, -1, FALSE, '`bln`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bln->Sortable = TRUE; // Allow sort
		$this->fields['bln'] = &$this->bln;

		// thn
		$this->thn = new cField('db_pd', 'db_pd', 'x_thn', 'thn', '`thn`', '`thn`', 200, -1, FALSE, '`thn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->thn->Sortable = TRUE; // Allow sort
		$this->fields['thn'] = &$this->thn;

		// sex
		$this->sex = new cField('db_pd', 'db_pd', 'x_sex', 'sex', '`sex`', '`sex`', 200, -1, FALSE, '`sex`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sex->Sortable = TRUE; // Allow sort
		$this->fields['sex'] = &$this->sex;

		// nm_ortu
		$this->nm_ortu = new cField('db_pd', 'db_pd', 'x_nm_ortu', 'nm_ortu', '`nm_ortu`', '`nm_ortu`', 200, -1, FALSE, '`nm_ortu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nm_ortu->Sortable = TRUE; // Allow sort
		$this->fields['nm_ortu'] = &$this->nm_ortu;

		// asal_sek
		$this->asal_sek = new cField('db_pd', 'db_pd', 'x_asal_sek', 'asal_sek', '`asal_sek`', '`asal_sek`', 200, -1, FALSE, '`asal_sek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->asal_sek->Sortable = TRUE; // Allow sort
		$this->asal_sek->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asal_sek'] = &$this->asal_sek;

		// n_ind
		$this->n_ind = new cField('db_pd', 'db_pd', 'x_n_ind', 'n_ind', '`n_ind`', '`n_ind`', 200, -1, FALSE, '`n_ind`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_ind->Sortable = TRUE; // Allow sort
		$this->n_ind->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['n_ind'] = &$this->n_ind;

		// n_mat
		$this->n_mat = new cField('db_pd', 'db_pd', 'x_n_mat', 'n_mat', '`n_mat`', '`n_mat`', 200, -1, FALSE, '`n_mat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_mat->Sortable = TRUE; // Allow sort
		$this->n_mat->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['n_mat'] = &$this->n_mat;

		// n_ipa
		$this->n_ipa = new cField('db_pd', 'db_pd', 'x_n_ipa', 'n_ipa', '`n_ipa`', '`n_ipa`', 200, -1, FALSE, '`n_ipa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_ipa->Sortable = TRUE; // Allow sort
		$this->n_ipa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['n_ipa'] = &$this->n_ipa;

		// n_jml
		$this->n_jml = new cField('db_pd', 'db_pd', 'x_n_jml', 'n_jml', '`n_jml`', '`n_jml`', 200, -1, FALSE, '`n_jml`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->n_jml->Sortable = TRUE; // Allow sort
		$this->n_jml->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['n_jml'] = &$this->n_jml;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`db_pd`";
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
			$this->id_pd->setDbValue($conn->Insert_ID());
			$rs['id_pd'] = $this->id_pd->DbValue;
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
			if (array_key_exists('id_pd', $rs))
				ew_AddFilter($where, ew_QuotedName('id_pd', $this->DBID) . '=' . ew_QuotedValue($rs['id_pd'], $this->id_pd->FldDataType, $this->DBID));
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
		return "`id_pd` = @id_pd@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_pd->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id_pd->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id_pd@", ew_AdjustSql($this->id_pd->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "db_pdlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "db_pdview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "db_pdedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "db_pdadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "db_pdlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("db_pdview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("db_pdview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "db_pdadd.php?" . $this->UrlParm($parm);
		else
			$url = "db_pdadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("db_pdedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("db_pdadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("db_pddelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_pd:" . ew_VarToJson($this->id_pd->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_pd->CurrentValue)) {
			$sUrl .= "id_pd=" . urlencode($this->id_pd->CurrentValue);
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
			if ($isPost && isset($_POST["id_pd"]))
				$arKeys[] = $_POST["id_pd"];
			elseif (isset($_GET["id_pd"]))
				$arKeys[] = $_GET["id_pd"];
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
			$this->id_pd->CurrentValue = $key;
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
		$this->id_pd->setDbValue($rs->fields('id_pd'));
		$this->nopes->setDbValue($rs->fields('nopes'));
		$this->nm_pes->setDbValue($rs->fields('nm_pes'));
		$this->nisn->setDbValue($rs->fields('nisn'));
		$this->tgl_lhr->setDbValue($rs->fields('tgl_lhr'));
		$this->tgl->setDbValue($rs->fields('tgl'));
		$this->bln->setDbValue($rs->fields('bln'));
		$this->thn->setDbValue($rs->fields('thn'));
		$this->sex->setDbValue($rs->fields('sex'));
		$this->nm_ortu->setDbValue($rs->fields('nm_ortu'));
		$this->asal_sek->setDbValue($rs->fields('asal_sek'));
		$this->n_ind->setDbValue($rs->fields('n_ind'));
		$this->n_mat->setDbValue($rs->fields('n_mat'));
		$this->n_ipa->setDbValue($rs->fields('n_ipa'));
		$this->n_jml->setDbValue($rs->fields('n_jml'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id_pd
		// nopes
		// nm_pes
		// nisn
		// tgl_lhr
		// tgl
		// bln
		// thn
		// sex
		// nm_ortu
		// asal_sek
		// n_ind
		// n_mat
		// n_ipa
		// n_jml
		// id_pd

		$this->id_pd->ViewValue = $this->id_pd->CurrentValue;
		$this->id_pd->ViewCustomAttributes = "";

		// nopes
		$this->nopes->ViewValue = $this->nopes->CurrentValue;
		$this->nopes->ViewCustomAttributes = "";

		// nm_pes
		$this->nm_pes->ViewValue = $this->nm_pes->CurrentValue;
		$this->nm_pes->ViewCustomAttributes = "";

		// nisn
		$this->nisn->ViewValue = $this->nisn->CurrentValue;
		$this->nisn->ViewCustomAttributes = "";

		// tgl_lhr
		$this->tgl_lhr->ViewValue = $this->tgl_lhr->CurrentValue;
		$this->tgl_lhr->ViewCustomAttributes = "";

		// tgl
		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewCustomAttributes = "";

		// bln
		$this->bln->ViewValue = $this->bln->CurrentValue;
		$this->bln->ViewCustomAttributes = "";

		// thn
		$this->thn->ViewValue = $this->thn->CurrentValue;
		$this->thn->ViewCustomAttributes = "";

		// sex
		$this->sex->ViewValue = $this->sex->CurrentValue;
		$this->sex->ViewCustomAttributes = "";

		// nm_ortu
		$this->nm_ortu->ViewValue = $this->nm_ortu->CurrentValue;
		$this->nm_ortu->ViewCustomAttributes = "";

		// asal_sek
		$this->asal_sek->ViewValue = $this->asal_sek->CurrentValue;
		$this->asal_sek->ViewCustomAttributes = "";

		// n_ind
		$this->n_ind->ViewValue = $this->n_ind->CurrentValue;
		$this->n_ind->ViewValue = ew_FormatNumber($this->n_ind->ViewValue, 1, -2, -2, -2);
		$this->n_ind->ViewCustomAttributes = "";

		// n_mat
		$this->n_mat->ViewValue = $this->n_mat->CurrentValue;
		$this->n_mat->ViewValue = ew_FormatNumber($this->n_mat->ViewValue, 1, -2, -2, -2);
		$this->n_mat->ViewCustomAttributes = "";

		// n_ipa
		$this->n_ipa->ViewValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->ViewValue = ew_FormatNumber($this->n_ipa->ViewValue, 1, -2, -2, -2);
		$this->n_ipa->ViewCustomAttributes = "";

		// n_jml
		$this->n_jml->ViewValue = $this->n_jml->CurrentValue;
		$this->n_jml->ViewValue = ew_FormatNumber($this->n_jml->ViewValue, 1, -2, -2, -2);
		$this->n_jml->ViewCustomAttributes = "";

		// id_pd
		$this->id_pd->LinkCustomAttributes = "";
		$this->id_pd->HrefValue = "";
		$this->id_pd->TooltipValue = "";

		// nopes
		$this->nopes->LinkCustomAttributes = "";
		$this->nopes->HrefValue = "";
		$this->nopes->TooltipValue = "";

		// nm_pes
		$this->nm_pes->LinkCustomAttributes = "";
		$this->nm_pes->HrefValue = "";
		$this->nm_pes->TooltipValue = "";

		// nisn
		$this->nisn->LinkCustomAttributes = "";
		$this->nisn->HrefValue = "";
		$this->nisn->TooltipValue = "";

		// tgl_lhr
		$this->tgl_lhr->LinkCustomAttributes = "";
		$this->tgl_lhr->HrefValue = "";
		$this->tgl_lhr->TooltipValue = "";

		// tgl
		$this->tgl->LinkCustomAttributes = "";
		$this->tgl->HrefValue = "";
		$this->tgl->TooltipValue = "";

		// bln
		$this->bln->LinkCustomAttributes = "";
		$this->bln->HrefValue = "";
		$this->bln->TooltipValue = "";

		// thn
		$this->thn->LinkCustomAttributes = "";
		$this->thn->HrefValue = "";
		$this->thn->TooltipValue = "";

		// sex
		$this->sex->LinkCustomAttributes = "";
		$this->sex->HrefValue = "";
		$this->sex->TooltipValue = "";

		// nm_ortu
		$this->nm_ortu->LinkCustomAttributes = "";
		$this->nm_ortu->HrefValue = "";
		$this->nm_ortu->TooltipValue = "";

		// asal_sek
		$this->asal_sek->LinkCustomAttributes = "";
		$this->asal_sek->HrefValue = "";
		$this->asal_sek->TooltipValue = "";

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

		// n_jml
		$this->n_jml->LinkCustomAttributes = "";
		$this->n_jml->HrefValue = "";
		$this->n_jml->TooltipValue = "";

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

		// id_pd
		$this->id_pd->EditAttrs["class"] = "form-control";
		$this->id_pd->EditCustomAttributes = "";
		$this->id_pd->EditValue = $this->id_pd->CurrentValue;
		$this->id_pd->ViewCustomAttributes = "";

		// nopes
		$this->nopes->EditAttrs["class"] = "form-control";
		$this->nopes->EditCustomAttributes = "";
		$this->nopes->EditValue = $this->nopes->CurrentValue;
		$this->nopes->PlaceHolder = ew_RemoveHtml($this->nopes->FldCaption());

		// nm_pes
		$this->nm_pes->EditAttrs["class"] = "form-control";
		$this->nm_pes->EditCustomAttributes = "";
		$this->nm_pes->EditValue = $this->nm_pes->CurrentValue;
		$this->nm_pes->PlaceHolder = ew_RemoveHtml($this->nm_pes->FldCaption());

		// nisn
		$this->nisn->EditAttrs["class"] = "form-control";
		$this->nisn->EditCustomAttributes = "";
		$this->nisn->EditValue = $this->nisn->CurrentValue;
		$this->nisn->PlaceHolder = ew_RemoveHtml($this->nisn->FldCaption());

		// tgl_lhr
		$this->tgl_lhr->EditAttrs["class"] = "form-control";
		$this->tgl_lhr->EditCustomAttributes = "";
		$this->tgl_lhr->EditValue = $this->tgl_lhr->CurrentValue;
		$this->tgl_lhr->PlaceHolder = ew_RemoveHtml($this->tgl_lhr->FldCaption());

		// tgl
		$this->tgl->EditAttrs["class"] = "form-control";
		$this->tgl->EditCustomAttributes = "";
		$this->tgl->EditValue = $this->tgl->CurrentValue;
		$this->tgl->PlaceHolder = ew_RemoveHtml($this->tgl->FldCaption());

		// bln
		$this->bln->EditAttrs["class"] = "form-control";
		$this->bln->EditCustomAttributes = "";
		$this->bln->EditValue = $this->bln->CurrentValue;
		$this->bln->PlaceHolder = ew_RemoveHtml($this->bln->FldCaption());

		// thn
		$this->thn->EditAttrs["class"] = "form-control";
		$this->thn->EditCustomAttributes = "";
		$this->thn->EditValue = $this->thn->CurrentValue;
		$this->thn->PlaceHolder = ew_RemoveHtml($this->thn->FldCaption());

		// sex
		$this->sex->EditAttrs["class"] = "form-control";
		$this->sex->EditCustomAttributes = "";
		$this->sex->EditValue = $this->sex->CurrentValue;
		$this->sex->PlaceHolder = ew_RemoveHtml($this->sex->FldCaption());

		// nm_ortu
		$this->nm_ortu->EditAttrs["class"] = "form-control";
		$this->nm_ortu->EditCustomAttributes = "";
		$this->nm_ortu->EditValue = $this->nm_ortu->CurrentValue;
		$this->nm_ortu->PlaceHolder = ew_RemoveHtml($this->nm_ortu->FldCaption());

		// asal_sek
		$this->asal_sek->EditAttrs["class"] = "form-control";
		$this->asal_sek->EditCustomAttributes = "";
		$this->asal_sek->EditValue = $this->asal_sek->CurrentValue;
		$this->asal_sek->PlaceHolder = ew_RemoveHtml($this->asal_sek->FldCaption());

		// n_ind
		$this->n_ind->EditAttrs["class"] = "form-control";
		$this->n_ind->EditCustomAttributes = "";
		$this->n_ind->EditValue = $this->n_ind->CurrentValue;
		$this->n_ind->PlaceHolder = ew_RemoveHtml($this->n_ind->FldCaption());

		// n_mat
		$this->n_mat->EditAttrs["class"] = "form-control";
		$this->n_mat->EditCustomAttributes = "";
		$this->n_mat->EditValue = $this->n_mat->CurrentValue;
		$this->n_mat->PlaceHolder = ew_RemoveHtml($this->n_mat->FldCaption());

		// n_ipa
		$this->n_ipa->EditAttrs["class"] = "form-control";
		$this->n_ipa->EditCustomAttributes = "";
		$this->n_ipa->EditValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->PlaceHolder = ew_RemoveHtml($this->n_ipa->FldCaption());

		// n_jml
		$this->n_jml->EditAttrs["class"] = "form-control";
		$this->n_jml->EditCustomAttributes = "";
		$this->n_jml->EditValue = $this->n_jml->CurrentValue;
		$this->n_jml->PlaceHolder = ew_RemoveHtml($this->n_jml->FldCaption());

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
					if ($this->id_pd->Exportable) $Doc->ExportCaption($this->id_pd);
					if ($this->nopes->Exportable) $Doc->ExportCaption($this->nopes);
					if ($this->nm_pes->Exportable) $Doc->ExportCaption($this->nm_pes);
					if ($this->nisn->Exportable) $Doc->ExportCaption($this->nisn);
					if ($this->asal_sek->Exportable) $Doc->ExportCaption($this->asal_sek);
					if ($this->n_ind->Exportable) $Doc->ExportCaption($this->n_ind);
					if ($this->n_mat->Exportable) $Doc->ExportCaption($this->n_mat);
					if ($this->n_ipa->Exportable) $Doc->ExportCaption($this->n_ipa);
					if ($this->n_jml->Exportable) $Doc->ExportCaption($this->n_jml);
				} else {
					if ($this->id_pd->Exportable) $Doc->ExportCaption($this->id_pd);
					if ($this->nopes->Exportable) $Doc->ExportCaption($this->nopes);
					if ($this->nm_pes->Exportable) $Doc->ExportCaption($this->nm_pes);
					if ($this->nisn->Exportable) $Doc->ExportCaption($this->nisn);
					if ($this->tgl_lhr->Exportable) $Doc->ExportCaption($this->tgl_lhr);
					if ($this->tgl->Exportable) $Doc->ExportCaption($this->tgl);
					if ($this->bln->Exportable) $Doc->ExportCaption($this->bln);
					if ($this->thn->Exportable) $Doc->ExportCaption($this->thn);
					if ($this->sex->Exportable) $Doc->ExportCaption($this->sex);
					if ($this->nm_ortu->Exportable) $Doc->ExportCaption($this->nm_ortu);
					if ($this->asal_sek->Exportable) $Doc->ExportCaption($this->asal_sek);
					if ($this->n_ind->Exportable) $Doc->ExportCaption($this->n_ind);
					if ($this->n_mat->Exportable) $Doc->ExportCaption($this->n_mat);
					if ($this->n_ipa->Exportable) $Doc->ExportCaption($this->n_ipa);
					if ($this->n_jml->Exportable) $Doc->ExportCaption($this->n_jml);
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
						if ($this->id_pd->Exportable) $Doc->ExportField($this->id_pd);
						if ($this->nopes->Exportable) $Doc->ExportField($this->nopes);
						if ($this->nm_pes->Exportable) $Doc->ExportField($this->nm_pes);
						if ($this->nisn->Exportable) $Doc->ExportField($this->nisn);
						if ($this->asal_sek->Exportable) $Doc->ExportField($this->asal_sek);
						if ($this->n_ind->Exportable) $Doc->ExportField($this->n_ind);
						if ($this->n_mat->Exportable) $Doc->ExportField($this->n_mat);
						if ($this->n_ipa->Exportable) $Doc->ExportField($this->n_ipa);
						if ($this->n_jml->Exportable) $Doc->ExportField($this->n_jml);
					} else {
						if ($this->id_pd->Exportable) $Doc->ExportField($this->id_pd);
						if ($this->nopes->Exportable) $Doc->ExportField($this->nopes);
						if ($this->nm_pes->Exportable) $Doc->ExportField($this->nm_pes);
						if ($this->nisn->Exportable) $Doc->ExportField($this->nisn);
						if ($this->tgl_lhr->Exportable) $Doc->ExportField($this->tgl_lhr);
						if ($this->tgl->Exportable) $Doc->ExportField($this->tgl);
						if ($this->bln->Exportable) $Doc->ExportField($this->bln);
						if ($this->thn->Exportable) $Doc->ExportField($this->thn);
						if ($this->sex->Exportable) $Doc->ExportField($this->sex);
						if ($this->nm_ortu->Exportable) $Doc->ExportField($this->nm_ortu);
						if ($this->asal_sek->Exportable) $Doc->ExportField($this->asal_sek);
						if ($this->n_ind->Exportable) $Doc->ExportField($this->n_ind);
						if ($this->n_mat->Exportable) $Doc->ExportField($this->n_mat);
						if ($this->n_ipa->Exportable) $Doc->ExportField($this->n_ipa);
						if ($this->n_jml->Exportable) $Doc->ExportField($this->n_jml);
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
