<?php

// Global variable for table object
$rekap_data = NULL;

//
// Table class for rekap_data
//
class crekap_data extends cTable {
	var $L;
	var $P;
	var $jumlah_jk;
	var $SD;
	var $MI;
	var $jumlah_sa;
	var $daya_tampung;
	var $jumlah_rombel;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'rekap_data';
		$this->TableName = 'rekap_data';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`rekap_data`";
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

		// L
		$this->L = new cField('rekap_data', 'rekap_data', 'x_L', 'L', '`L`', '`L`', 131, -1, FALSE, '`L`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->L->Sortable = TRUE; // Allow sort
		$this->L->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['L'] = &$this->L;

		// P
		$this->P = new cField('rekap_data', 'rekap_data', 'x_P', 'P', '`P`', '`P`', 131, -1, FALSE, '`P`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->P->Sortable = TRUE; // Allow sort
		$this->P->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['P'] = &$this->P;

		// jumlah jk
		$this->jumlah_jk = new cField('rekap_data', 'rekap_data', 'x_jumlah_jk', 'jumlah jk', '`jumlah jk`', '`jumlah jk`', 20, -1, FALSE, '`jumlah jk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_jk->Sortable = TRUE; // Allow sort
		$this->jumlah_jk->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah jk'] = &$this->jumlah_jk;

		// SD
		$this->SD = new cField('rekap_data', 'rekap_data', 'x_SD', 'SD', '`SD`', '`SD`', 131, -1, FALSE, '`SD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SD->Sortable = TRUE; // Allow sort
		$this->SD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['SD'] = &$this->SD;

		// MI
		$this->MI = new cField('rekap_data', 'rekap_data', 'x_MI', 'MI', '`MI`', '`MI`', 131, -1, FALSE, '`MI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MI->Sortable = TRUE; // Allow sort
		$this->MI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['MI'] = &$this->MI;

		// jumlah sa
		$this->jumlah_sa = new cField('rekap_data', 'rekap_data', 'x_jumlah_sa', 'jumlah sa', '`jumlah sa`', '`jumlah sa`', 20, -1, FALSE, '`jumlah sa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_sa->Sortable = TRUE; // Allow sort
		$this->jumlah_sa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah sa'] = &$this->jumlah_sa;

		// daya_tampung
		$this->daya_tampung = new cField('rekap_data', 'rekap_data', 'x_daya_tampung', 'daya_tampung', '`daya_tampung`', '`daya_tampung`', 3, -1, FALSE, '`daya_tampung`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->daya_tampung->Sortable = TRUE; // Allow sort
		$this->daya_tampung->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['daya_tampung'] = &$this->daya_tampung;

		// jumlah_rombel
		$this->jumlah_rombel = new cField('rekap_data', 'rekap_data', 'x_jumlah_rombel', 'jumlah_rombel', '`jumlah_rombel`', '`jumlah_rombel`', 3, -1, FALSE, '`jumlah_rombel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_rombel->Sortable = TRUE; // Allow sort
		$this->jumlah_rombel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah_rombel'] = &$this->jumlah_rombel;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`rekap_data`";
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
			return "rekap_datalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "rekap_dataview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "rekap_dataedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "rekap_dataadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "rekap_datalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("rekap_dataview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("rekap_dataview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "rekap_dataadd.php?" . $this->UrlParm($parm);
		else
			$url = "rekap_dataadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("rekap_dataedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("rekap_dataadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("rekap_datadelete.php", $this->UrlParm());
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
		$this->L->setDbValue($rs->fields('L'));
		$this->P->setDbValue($rs->fields('P'));
		$this->jumlah_jk->setDbValue($rs->fields('jumlah jk'));
		$this->SD->setDbValue($rs->fields('SD'));
		$this->MI->setDbValue($rs->fields('MI'));
		$this->jumlah_sa->setDbValue($rs->fields('jumlah sa'));
		$this->daya_tampung->setDbValue($rs->fields('daya_tampung'));
		$this->jumlah_rombel->setDbValue($rs->fields('jumlah_rombel'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// L
		// P
		// jumlah jk
		// SD
		// MI
		// jumlah sa
		// daya_tampung
		// jumlah_rombel
		// L

		$this->L->ViewValue = $this->L->CurrentValue;
		$this->L->CellCssStyle .= "text-align: center;";
		$this->L->ViewCustomAttributes = "";

		// P
		$this->P->ViewValue = $this->P->CurrentValue;
		$this->P->CellCssStyle .= "text-align: center;";
		$this->P->ViewCustomAttributes = "";

		// jumlah jk
		$this->jumlah_jk->ViewValue = $this->jumlah_jk->CurrentValue;
		$this->jumlah_jk->CellCssStyle .= "text-align: center;";
		$this->jumlah_jk->ViewCustomAttributes = "";

		// SD
		$this->SD->ViewValue = $this->SD->CurrentValue;
		$this->SD->CellCssStyle .= "text-align: center;";
		$this->SD->ViewCustomAttributes = "";

		// MI
		$this->MI->ViewValue = $this->MI->CurrentValue;
		$this->MI->CellCssStyle .= "text-align: center;";
		$this->MI->ViewCustomAttributes = "";

		// jumlah sa
		$this->jumlah_sa->ViewValue = $this->jumlah_sa->CurrentValue;
		$this->jumlah_sa->CellCssStyle .= "text-align: center;";
		$this->jumlah_sa->ViewCustomAttributes = "";

		// daya_tampung
		$this->daya_tampung->ViewValue = $this->daya_tampung->CurrentValue;
		$this->daya_tampung->CellCssStyle .= "text-align: center;";
		$this->daya_tampung->ViewCustomAttributes = "";

		// jumlah_rombel
		$this->jumlah_rombel->ViewValue = $this->jumlah_rombel->CurrentValue;
		$this->jumlah_rombel->CellCssStyle .= "text-align: center;";
		$this->jumlah_rombel->ViewCustomAttributes = "";

		// L
		$this->L->LinkCustomAttributes = "";
		$this->L->HrefValue = "";
		$this->L->TooltipValue = "";

		// P
		$this->P->LinkCustomAttributes = "";
		$this->P->HrefValue = "";
		$this->P->TooltipValue = "";

		// jumlah jk
		$this->jumlah_jk->LinkCustomAttributes = "";
		$this->jumlah_jk->HrefValue = "";
		$this->jumlah_jk->TooltipValue = "";

		// SD
		$this->SD->LinkCustomAttributes = "";
		$this->SD->HrefValue = "";
		$this->SD->TooltipValue = "";

		// MI
		$this->MI->LinkCustomAttributes = "";
		$this->MI->HrefValue = "";
		$this->MI->TooltipValue = "";

		// jumlah sa
		$this->jumlah_sa->LinkCustomAttributes = "";
		$this->jumlah_sa->HrefValue = "";
		$this->jumlah_sa->TooltipValue = "";

		// daya_tampung
		$this->daya_tampung->LinkCustomAttributes = "";
		$this->daya_tampung->HrefValue = "";
		$this->daya_tampung->TooltipValue = "";

		// jumlah_rombel
		$this->jumlah_rombel->LinkCustomAttributes = "";
		$this->jumlah_rombel->HrefValue = "";
		$this->jumlah_rombel->TooltipValue = "";

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

		// L
		$this->L->EditAttrs["class"] = "form-control";
		$this->L->EditCustomAttributes = "";
		$this->L->EditValue = $this->L->CurrentValue;
		$this->L->PlaceHolder = ew_RemoveHtml($this->L->FldCaption());
		if (strval($this->L->EditValue) <> "" && is_numeric($this->L->EditValue)) $this->L->EditValue = ew_FormatNumber($this->L->EditValue, -2, -1, -2, 0);

		// P
		$this->P->EditAttrs["class"] = "form-control";
		$this->P->EditCustomAttributes = "";
		$this->P->EditValue = $this->P->CurrentValue;
		$this->P->PlaceHolder = ew_RemoveHtml($this->P->FldCaption());
		if (strval($this->P->EditValue) <> "" && is_numeric($this->P->EditValue)) $this->P->EditValue = ew_FormatNumber($this->P->EditValue, -2, -1, -2, 0);

		// jumlah jk
		$this->jumlah_jk->EditAttrs["class"] = "form-control";
		$this->jumlah_jk->EditCustomAttributes = "";
		$this->jumlah_jk->EditValue = $this->jumlah_jk->CurrentValue;
		$this->jumlah_jk->PlaceHolder = ew_RemoveHtml($this->jumlah_jk->FldCaption());

		// SD
		$this->SD->EditAttrs["class"] = "form-control";
		$this->SD->EditCustomAttributes = "";
		$this->SD->EditValue = $this->SD->CurrentValue;
		$this->SD->PlaceHolder = ew_RemoveHtml($this->SD->FldCaption());
		if (strval($this->SD->EditValue) <> "" && is_numeric($this->SD->EditValue)) $this->SD->EditValue = ew_FormatNumber($this->SD->EditValue, -2, -1, -2, 0);

		// MI
		$this->MI->EditAttrs["class"] = "form-control";
		$this->MI->EditCustomAttributes = "";
		$this->MI->EditValue = $this->MI->CurrentValue;
		$this->MI->PlaceHolder = ew_RemoveHtml($this->MI->FldCaption());
		if (strval($this->MI->EditValue) <> "" && is_numeric($this->MI->EditValue)) $this->MI->EditValue = ew_FormatNumber($this->MI->EditValue, -2, -1, -2, 0);

		// jumlah sa
		$this->jumlah_sa->EditAttrs["class"] = "form-control";
		$this->jumlah_sa->EditCustomAttributes = "";
		$this->jumlah_sa->EditValue = $this->jumlah_sa->CurrentValue;
		$this->jumlah_sa->PlaceHolder = ew_RemoveHtml($this->jumlah_sa->FldCaption());

		// daya_tampung
		$this->daya_tampung->EditAttrs["class"] = "form-control";
		$this->daya_tampung->EditCustomAttributes = "";
		$this->daya_tampung->EditValue = $this->daya_tampung->CurrentValue;
		$this->daya_tampung->PlaceHolder = ew_RemoveHtml($this->daya_tampung->FldCaption());

		// jumlah_rombel
		$this->jumlah_rombel->EditAttrs["class"] = "form-control";
		$this->jumlah_rombel->EditCustomAttributes = "";
		$this->jumlah_rombel->EditValue = $this->jumlah_rombel->CurrentValue;
		$this->jumlah_rombel->PlaceHolder = ew_RemoveHtml($this->jumlah_rombel->FldCaption());

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
					if ($this->L->Exportable) $Doc->ExportCaption($this->L);
					if ($this->P->Exportable) $Doc->ExportCaption($this->P);
					if ($this->jumlah_jk->Exportable) $Doc->ExportCaption($this->jumlah_jk);
					if ($this->SD->Exportable) $Doc->ExportCaption($this->SD);
					if ($this->MI->Exportable) $Doc->ExportCaption($this->MI);
					if ($this->jumlah_sa->Exportable) $Doc->ExportCaption($this->jumlah_sa);
					if ($this->daya_tampung->Exportable) $Doc->ExportCaption($this->daya_tampung);
					if ($this->jumlah_rombel->Exportable) $Doc->ExportCaption($this->jumlah_rombel);
				} else {
					if ($this->L->Exportable) $Doc->ExportCaption($this->L);
					if ($this->P->Exportable) $Doc->ExportCaption($this->P);
					if ($this->jumlah_jk->Exportable) $Doc->ExportCaption($this->jumlah_jk);
					if ($this->SD->Exportable) $Doc->ExportCaption($this->SD);
					if ($this->MI->Exportable) $Doc->ExportCaption($this->MI);
					if ($this->jumlah_sa->Exportable) $Doc->ExportCaption($this->jumlah_sa);
					if ($this->daya_tampung->Exportable) $Doc->ExportCaption($this->daya_tampung);
					if ($this->jumlah_rombel->Exportable) $Doc->ExportCaption($this->jumlah_rombel);
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
						if ($this->L->Exportable) $Doc->ExportField($this->L);
						if ($this->P->Exportable) $Doc->ExportField($this->P);
						if ($this->jumlah_jk->Exportable) $Doc->ExportField($this->jumlah_jk);
						if ($this->SD->Exportable) $Doc->ExportField($this->SD);
						if ($this->MI->Exportable) $Doc->ExportField($this->MI);
						if ($this->jumlah_sa->Exportable) $Doc->ExportField($this->jumlah_sa);
						if ($this->daya_tampung->Exportable) $Doc->ExportField($this->daya_tampung);
						if ($this->jumlah_rombel->Exportable) $Doc->ExportField($this->jumlah_rombel);
					} else {
						if ($this->L->Exportable) $Doc->ExportField($this->L);
						if ($this->P->Exportable) $Doc->ExportField($this->P);
						if ($this->jumlah_jk->Exportable) $Doc->ExportField($this->jumlah_jk);
						if ($this->SD->Exportable) $Doc->ExportField($this->SD);
						if ($this->MI->Exportable) $Doc->ExportField($this->MI);
						if ($this->jumlah_sa->Exportable) $Doc->ExportField($this->jumlah_sa);
						if ($this->daya_tampung->Exportable) $Doc->ExportField($this->daya_tampung);
						if ($this->jumlah_rombel->Exportable) $Doc->ExportField($this->jumlah_rombel);
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
