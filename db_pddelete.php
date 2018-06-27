<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "db_pdinfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$db_pd_delete = NULL; // Initialize page object first

class cdb_pd_delete extends cdb_pd {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'db_pd';

	// Page object name
	var $PageObjName = 'db_pd_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (db_pd)
		if (!isset($GLOBALS["db_pd"]) || get_class($GLOBALS["db_pd"]) == "cdb_pd") {
			$GLOBALS["db_pd"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["db_pd"];
		}

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'db_pd', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (ruang)
		if (!isset($UserTable)) {
			$UserTable = new cruang();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("db_pdlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_pd->SetVisibility();
		$this->id_pd->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nopes->SetVisibility();
		$this->nm_pes->SetVisibility();
		$this->sex->SetVisibility();
		$this->nm_ortu->SetVisibility();
		$this->asal_sek->SetVisibility();
		$this->n_ind->SetVisibility();
		$this->n_mat->SetVisibility();
		$this->n_ipa->SetVisibility();
		$this->n_jml->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $db_pd;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($db_pd);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("db_pdlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in db_pd class, db_pdinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("db_pdlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id_pd->setDbValue($row['id_pd']);
		$this->nopes->setDbValue($row['nopes']);
		$this->nm_pes->setDbValue($row['nm_pes']);
		$this->tmp_lhr->setDbValue($row['tmp_lhr']);
		$this->tgl_lhr->setDbValue($row['tgl_lhr']);
		$this->tgl->setDbValue($row['tgl']);
		$this->bln->setDbValue($row['bln']);
		$this->thn->setDbValue($row['thn']);
		$this->sex->setDbValue($row['sex']);
		$this->nm_ortu->setDbValue($row['nm_ortu']);
		$this->asal_sek->setDbValue($row['asal_sek']);
		$this->n_ind->setDbValue($row['n_ind']);
		$this->n_mat->setDbValue($row['n_mat']);
		$this->n_ipa->setDbValue($row['n_ipa']);
		$this->n_jml->setDbValue($row['n_jml']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id_pd'] = NULL;
		$row['nopes'] = NULL;
		$row['nm_pes'] = NULL;
		$row['tmp_lhr'] = NULL;
		$row['tgl_lhr'] = NULL;
		$row['tgl'] = NULL;
		$row['bln'] = NULL;
		$row['thn'] = NULL;
		$row['sex'] = NULL;
		$row['nm_ortu'] = NULL;
		$row['asal_sek'] = NULL;
		$row['n_ind'] = NULL;
		$row['n_mat'] = NULL;
		$row['n_ipa'] = NULL;
		$row['n_jml'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_pd->DbValue = $row['id_pd'];
		$this->nopes->DbValue = $row['nopes'];
		$this->nm_pes->DbValue = $row['nm_pes'];
		$this->tmp_lhr->DbValue = $row['tmp_lhr'];
		$this->tgl_lhr->DbValue = $row['tgl_lhr'];
		$this->tgl->DbValue = $row['tgl'];
		$this->bln->DbValue = $row['bln'];
		$this->thn->DbValue = $row['thn'];
		$this->sex->DbValue = $row['sex'];
		$this->nm_ortu->DbValue = $row['nm_ortu'];
		$this->asal_sek->DbValue = $row['asal_sek'];
		$this->n_ind->DbValue = $row['n_ind'];
		$this->n_mat->DbValue = $row['n_mat'];
		$this->n_ipa->DbValue = $row['n_ipa'];
		$this->n_jml->DbValue = $row['n_jml'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_pd
		// nopes
		// nm_pes
		// tmp_lhr
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_pd
		$this->id_pd->ViewValue = $this->id_pd->CurrentValue;
		$this->id_pd->ViewCustomAttributes = "";

		// nopes
		$this->nopes->ViewValue = $this->nopes->CurrentValue;
		$this->nopes->ViewCustomAttributes = "";

		// nm_pes
		$this->nm_pes->ViewValue = $this->nm_pes->CurrentValue;
		$this->nm_pes->ViewCustomAttributes = "";

		// tmp_lhr
		$this->tmp_lhr->ViewValue = $this->tmp_lhr->CurrentValue;
		$this->tmp_lhr->ViewCustomAttributes = "";

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
		$this->n_ind->ViewCustomAttributes = "";

		// n_mat
		$this->n_mat->ViewValue = $this->n_mat->CurrentValue;
		$this->n_mat->ViewCustomAttributes = "";

		// n_ipa
		$this->n_ipa->ViewValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->ViewCustomAttributes = "";

		// n_jml
		$this->n_jml->ViewValue = $this->n_jml->CurrentValue;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id_pd'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("db_pdlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($db_pd_delete)) $db_pd_delete = new cdb_pd_delete();

// Page init
$db_pd_delete->Page_Init();

// Page main
$db_pd_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$db_pd_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdb_pddelete = new ew_Form("fdb_pddelete", "delete");

// Form_CustomValidate event
fdb_pddelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdb_pddelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $db_pd_delete->ShowPageHeader(); ?>
<?php
$db_pd_delete->ShowMessage();
?>
<form name="fdb_pddelete" id="fdb_pddelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($db_pd_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $db_pd_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="db_pd">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($db_pd_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($db_pd->id_pd->Visible) { // id_pd ?>
		<th class="<?php echo $db_pd->id_pd->HeaderCellClass() ?>"><span id="elh_db_pd_id_pd" class="db_pd_id_pd"><?php echo $db_pd->id_pd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->nopes->Visible) { // nopes ?>
		<th class="<?php echo $db_pd->nopes->HeaderCellClass() ?>"><span id="elh_db_pd_nopes" class="db_pd_nopes"><?php echo $db_pd->nopes->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->nm_pes->Visible) { // nm_pes ?>
		<th class="<?php echo $db_pd->nm_pes->HeaderCellClass() ?>"><span id="elh_db_pd_nm_pes" class="db_pd_nm_pes"><?php echo $db_pd->nm_pes->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->sex->Visible) { // sex ?>
		<th class="<?php echo $db_pd->sex->HeaderCellClass() ?>"><span id="elh_db_pd_sex" class="db_pd_sex"><?php echo $db_pd->sex->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->nm_ortu->Visible) { // nm_ortu ?>
		<th class="<?php echo $db_pd->nm_ortu->HeaderCellClass() ?>"><span id="elh_db_pd_nm_ortu" class="db_pd_nm_ortu"><?php echo $db_pd->nm_ortu->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->asal_sek->Visible) { // asal_sek ?>
		<th class="<?php echo $db_pd->asal_sek->HeaderCellClass() ?>"><span id="elh_db_pd_asal_sek" class="db_pd_asal_sek"><?php echo $db_pd->asal_sek->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->n_ind->Visible) { // n_ind ?>
		<th class="<?php echo $db_pd->n_ind->HeaderCellClass() ?>"><span id="elh_db_pd_n_ind" class="db_pd_n_ind"><?php echo $db_pd->n_ind->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->n_mat->Visible) { // n_mat ?>
		<th class="<?php echo $db_pd->n_mat->HeaderCellClass() ?>"><span id="elh_db_pd_n_mat" class="db_pd_n_mat"><?php echo $db_pd->n_mat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->n_ipa->Visible) { // n_ipa ?>
		<th class="<?php echo $db_pd->n_ipa->HeaderCellClass() ?>"><span id="elh_db_pd_n_ipa" class="db_pd_n_ipa"><?php echo $db_pd->n_ipa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($db_pd->n_jml->Visible) { // n_jml ?>
		<th class="<?php echo $db_pd->n_jml->HeaderCellClass() ?>"><span id="elh_db_pd_n_jml" class="db_pd_n_jml"><?php echo $db_pd->n_jml->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$db_pd_delete->RecCnt = 0;
$i = 0;
while (!$db_pd_delete->Recordset->EOF) {
	$db_pd_delete->RecCnt++;
	$db_pd_delete->RowCnt++;

	// Set row properties
	$db_pd->ResetAttrs();
	$db_pd->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$db_pd_delete->LoadRowValues($db_pd_delete->Recordset);

	// Render row
	$db_pd_delete->RenderRow();
?>
	<tr<?php echo $db_pd->RowAttributes() ?>>
<?php if ($db_pd->id_pd->Visible) { // id_pd ?>
		<td<?php echo $db_pd->id_pd->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_id_pd" class="db_pd_id_pd">
<span<?php echo $db_pd->id_pd->ViewAttributes() ?>>
<?php echo $db_pd->id_pd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->nopes->Visible) { // nopes ?>
		<td<?php echo $db_pd->nopes->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_nopes" class="db_pd_nopes">
<span<?php echo $db_pd->nopes->ViewAttributes() ?>>
<?php echo $db_pd->nopes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->nm_pes->Visible) { // nm_pes ?>
		<td<?php echo $db_pd->nm_pes->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_nm_pes" class="db_pd_nm_pes">
<span<?php echo $db_pd->nm_pes->ViewAttributes() ?>>
<?php echo $db_pd->nm_pes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->sex->Visible) { // sex ?>
		<td<?php echo $db_pd->sex->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_sex" class="db_pd_sex">
<span<?php echo $db_pd->sex->ViewAttributes() ?>>
<?php echo $db_pd->sex->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->nm_ortu->Visible) { // nm_ortu ?>
		<td<?php echo $db_pd->nm_ortu->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_nm_ortu" class="db_pd_nm_ortu">
<span<?php echo $db_pd->nm_ortu->ViewAttributes() ?>>
<?php echo $db_pd->nm_ortu->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->asal_sek->Visible) { // asal_sek ?>
		<td<?php echo $db_pd->asal_sek->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_asal_sek" class="db_pd_asal_sek">
<span<?php echo $db_pd->asal_sek->ViewAttributes() ?>>
<?php echo $db_pd->asal_sek->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->n_ind->Visible) { // n_ind ?>
		<td<?php echo $db_pd->n_ind->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_n_ind" class="db_pd_n_ind">
<span<?php echo $db_pd->n_ind->ViewAttributes() ?>>
<?php echo $db_pd->n_ind->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->n_mat->Visible) { // n_mat ?>
		<td<?php echo $db_pd->n_mat->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_n_mat" class="db_pd_n_mat">
<span<?php echo $db_pd->n_mat->ViewAttributes() ?>>
<?php echo $db_pd->n_mat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->n_ipa->Visible) { // n_ipa ?>
		<td<?php echo $db_pd->n_ipa->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_n_ipa" class="db_pd_n_ipa">
<span<?php echo $db_pd->n_ipa->ViewAttributes() ?>>
<?php echo $db_pd->n_ipa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($db_pd->n_jml->Visible) { // n_jml ?>
		<td<?php echo $db_pd->n_jml->CellAttributes() ?>>
<span id="el<?php echo $db_pd_delete->RowCnt ?>_db_pd_n_jml" class="db_pd_n_jml">
<span<?php echo $db_pd->n_jml->ViewAttributes() ?>>
<?php echo $db_pd->n_jml->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$db_pd_delete->Recordset->MoveNext();
}
$db_pd_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $db_pd_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdb_pddelete.Init();
</script>
<?php
$db_pd_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$db_pd_delete->Page_Terminate();
?>
