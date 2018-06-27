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

$db_pd_list = NULL; // Initialize page object first

class cdb_pd_list extends cdb_pd {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'db_pd';

	// Page object name
	var $PageObjName = 'db_pd_list';

	// Grid form hidden field names
	var $FormName = 'fdb_pdlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "db_pdadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "db_pddelete.php";
		$this->MultiUpdateUrl = "db_pdupdate.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fdb_pdlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index2.php"));
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
		// Get export parameters

		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->id_pd->SetVisibility();
		$this->id_pd->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nopes->SetVisibility();
		$this->nm_pes->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 10;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetupSortOrder();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 10; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id_pd->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_pd->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id_pd); // id_pd
			$this->UpdateSort($this->nopes); // nopes
			$this->UpdateSort($this->nm_pes); // nm_pes
			$this->UpdateSort($this->asal_sek); // asal_sek
			$this->UpdateSort($this->n_ind); // n_ind
			$this->UpdateSort($this->n_mat); // n_mat
			$this->UpdateSort($this->n_ipa); // n_ipa
			$this->UpdateSort($this->n_jml); // n_jml
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id_pd->setSort("");
				$this->nopes->setSort("");
				$this->nm_pes->setSort("");
				$this->asal_sek->setSort("");
				$this->n_ind->setSort("");
				$this->n_mat->setSort("");
				$this->n_ipa->setSort("");
				$this->n_jml->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id_pd->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdb_pdlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdb_pdlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdb_pdlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
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
		$this->nisn->setDbValue($row['nisn']);
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
		$row['nisn'] = NULL;
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
		$this->nisn->DbValue = $row['nisn'];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_pd")) <> "")
			$this->id_pd->CurrentValue = $this->getKey("id_pd"); // id_pd
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_db_pd\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_db_pd',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdb_pdlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($db_pd_list)) $db_pd_list = new cdb_pd_list();

// Page init
$db_pd_list->Page_Init();

// Page main
$db_pd_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$db_pd_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($db_pd->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdb_pdlist = new ew_Form("fdb_pdlist", "list");
fdb_pdlist.FormKeyCountName = '<?php echo $db_pd_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdb_pdlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdb_pdlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($db_pd->Export == "") { ?>
<div class="ewToolbar">
<?php if ($db_pd_list->TotalRecs > 0 && $db_pd_list->ExportOptions->Visible()) { ?>
<?php $db_pd_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $db_pd_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($db_pd_list->TotalRecs <= 0)
			$db_pd_list->TotalRecs = $db_pd->ListRecordCount();
	} else {
		if (!$db_pd_list->Recordset && ($db_pd_list->Recordset = $db_pd_list->LoadRecordset()))
			$db_pd_list->TotalRecs = $db_pd_list->Recordset->RecordCount();
	}
	$db_pd_list->StartRec = 1;
	if ($db_pd_list->DisplayRecs <= 0 || ($db_pd->Export <> "" && $db_pd->ExportAll)) // Display all records
		$db_pd_list->DisplayRecs = $db_pd_list->TotalRecs;
	if (!($db_pd->Export <> "" && $db_pd->ExportAll))
		$db_pd_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$db_pd_list->Recordset = $db_pd_list->LoadRecordset($db_pd_list->StartRec-1, $db_pd_list->DisplayRecs);

	// Set no record found message
	if ($db_pd->CurrentAction == "" && $db_pd_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$db_pd_list->setWarningMessage(ew_DeniedMsg());
		if ($db_pd_list->SearchWhere == "0=101")
			$db_pd_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$db_pd_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$db_pd_list->RenderOtherOptions();
?>
<?php $db_pd_list->ShowPageHeader(); ?>
<?php
$db_pd_list->ShowMessage();
?>
<?php if ($db_pd_list->TotalRecs > 0 || $db_pd->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($db_pd_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> db_pd">
<?php if ($db_pd->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($db_pd->CurrentAction <> "gridadd" && $db_pd->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($db_pd_list->Pager)) $db_pd_list->Pager = new cPrevNextPager($db_pd_list->StartRec, $db_pd_list->DisplayRecs, $db_pd_list->TotalRecs, $db_pd_list->AutoHidePager) ?>
<?php if ($db_pd_list->Pager->RecordCount > 0 && $db_pd_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($db_pd_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($db_pd_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $db_pd_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($db_pd_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($db_pd_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $db_pd_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $db_pd_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $db_pd_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $db_pd_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($db_pd_list->TotalRecs > 0 && (!$db_pd_list->AutoHidePageSizeSelector || $db_pd_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="db_pd">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($db_pd_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($db_pd_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($db_pd_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($db_pd_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($db_pd->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($db_pd_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdb_pdlist" id="fdb_pdlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($db_pd_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $db_pd_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="db_pd">
<div id="gmp_db_pd" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($db_pd_list->TotalRecs > 0 || $db_pd->CurrentAction == "gridedit") { ?>
<table id="tbl_db_pdlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$db_pd_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$db_pd_list->RenderListOptions();

// Render list options (header, left)
$db_pd_list->ListOptions->Render("header", "left");
?>
<?php if ($db_pd->id_pd->Visible) { // id_pd ?>
	<?php if ($db_pd->SortUrl($db_pd->id_pd) == "") { ?>
		<th data-name="id_pd" class="<?php echo $db_pd->id_pd->HeaderCellClass() ?>"><div id="elh_db_pd_id_pd" class="db_pd_id_pd"><div class="ewTableHeaderCaption"><?php echo $db_pd->id_pd->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_pd" class="<?php echo $db_pd->id_pd->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->id_pd) ?>',1);"><div id="elh_db_pd_id_pd" class="db_pd_id_pd">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->id_pd->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->id_pd->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->id_pd->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->nopes->Visible) { // nopes ?>
	<?php if ($db_pd->SortUrl($db_pd->nopes) == "") { ?>
		<th data-name="nopes" class="<?php echo $db_pd->nopes->HeaderCellClass() ?>"><div id="elh_db_pd_nopes" class="db_pd_nopes"><div class="ewTableHeaderCaption"><?php echo $db_pd->nopes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nopes" class="<?php echo $db_pd->nopes->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->nopes) ?>',1);"><div id="elh_db_pd_nopes" class="db_pd_nopes">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->nopes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->nopes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->nopes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->nm_pes->Visible) { // nm_pes ?>
	<?php if ($db_pd->SortUrl($db_pd->nm_pes) == "") { ?>
		<th data-name="nm_pes" class="<?php echo $db_pd->nm_pes->HeaderCellClass() ?>"><div id="elh_db_pd_nm_pes" class="db_pd_nm_pes"><div class="ewTableHeaderCaption"><?php echo $db_pd->nm_pes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nm_pes" class="<?php echo $db_pd->nm_pes->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->nm_pes) ?>',1);"><div id="elh_db_pd_nm_pes" class="db_pd_nm_pes">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->nm_pes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->nm_pes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->nm_pes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->asal_sek->Visible) { // asal_sek ?>
	<?php if ($db_pd->SortUrl($db_pd->asal_sek) == "") { ?>
		<th data-name="asal_sek" class="<?php echo $db_pd->asal_sek->HeaderCellClass() ?>"><div id="elh_db_pd_asal_sek" class="db_pd_asal_sek"><div class="ewTableHeaderCaption"><?php echo $db_pd->asal_sek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="asal_sek" class="<?php echo $db_pd->asal_sek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->asal_sek) ?>',1);"><div id="elh_db_pd_asal_sek" class="db_pd_asal_sek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->asal_sek->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->asal_sek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->asal_sek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->n_ind->Visible) { // n_ind ?>
	<?php if ($db_pd->SortUrl($db_pd->n_ind) == "") { ?>
		<th data-name="n_ind" class="<?php echo $db_pd->n_ind->HeaderCellClass() ?>"><div id="elh_db_pd_n_ind" class="db_pd_n_ind"><div class="ewTableHeaderCaption"><?php echo $db_pd->n_ind->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="n_ind" class="<?php echo $db_pd->n_ind->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->n_ind) ?>',1);"><div id="elh_db_pd_n_ind" class="db_pd_n_ind">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->n_ind->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->n_ind->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->n_ind->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->n_mat->Visible) { // n_mat ?>
	<?php if ($db_pd->SortUrl($db_pd->n_mat) == "") { ?>
		<th data-name="n_mat" class="<?php echo $db_pd->n_mat->HeaderCellClass() ?>"><div id="elh_db_pd_n_mat" class="db_pd_n_mat"><div class="ewTableHeaderCaption"><?php echo $db_pd->n_mat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="n_mat" class="<?php echo $db_pd->n_mat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->n_mat) ?>',1);"><div id="elh_db_pd_n_mat" class="db_pd_n_mat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->n_mat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->n_mat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->n_mat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->n_ipa->Visible) { // n_ipa ?>
	<?php if ($db_pd->SortUrl($db_pd->n_ipa) == "") { ?>
		<th data-name="n_ipa" class="<?php echo $db_pd->n_ipa->HeaderCellClass() ?>"><div id="elh_db_pd_n_ipa" class="db_pd_n_ipa"><div class="ewTableHeaderCaption"><?php echo $db_pd->n_ipa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="n_ipa" class="<?php echo $db_pd->n_ipa->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->n_ipa) ?>',1);"><div id="elh_db_pd_n_ipa" class="db_pd_n_ipa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->n_ipa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->n_ipa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->n_ipa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($db_pd->n_jml->Visible) { // n_jml ?>
	<?php if ($db_pd->SortUrl($db_pd->n_jml) == "") { ?>
		<th data-name="n_jml" class="<?php echo $db_pd->n_jml->HeaderCellClass() ?>"><div id="elh_db_pd_n_jml" class="db_pd_n_jml"><div class="ewTableHeaderCaption"><?php echo $db_pd->n_jml->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="n_jml" class="<?php echo $db_pd->n_jml->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $db_pd->SortUrl($db_pd->n_jml) ?>',1);"><div id="elh_db_pd_n_jml" class="db_pd_n_jml">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $db_pd->n_jml->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($db_pd->n_jml->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($db_pd->n_jml->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$db_pd_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($db_pd->ExportAll && $db_pd->Export <> "") {
	$db_pd_list->StopRec = $db_pd_list->TotalRecs;
} else {

	// Set the last record to display
	if ($db_pd_list->TotalRecs > $db_pd_list->StartRec + $db_pd_list->DisplayRecs - 1)
		$db_pd_list->StopRec = $db_pd_list->StartRec + $db_pd_list->DisplayRecs - 1;
	else
		$db_pd_list->StopRec = $db_pd_list->TotalRecs;
}
$db_pd_list->RecCnt = $db_pd_list->StartRec - 1;
if ($db_pd_list->Recordset && !$db_pd_list->Recordset->EOF) {
	$db_pd_list->Recordset->MoveFirst();
	$bSelectLimit = $db_pd_list->UseSelectLimit;
	if (!$bSelectLimit && $db_pd_list->StartRec > 1)
		$db_pd_list->Recordset->Move($db_pd_list->StartRec - 1);
} elseif (!$db_pd->AllowAddDeleteRow && $db_pd_list->StopRec == 0) {
	$db_pd_list->StopRec = $db_pd->GridAddRowCount;
}

// Initialize aggregate
$db_pd->RowType = EW_ROWTYPE_AGGREGATEINIT;
$db_pd->ResetAttrs();
$db_pd_list->RenderRow();
while ($db_pd_list->RecCnt < $db_pd_list->StopRec) {
	$db_pd_list->RecCnt++;
	if (intval($db_pd_list->RecCnt) >= intval($db_pd_list->StartRec)) {
		$db_pd_list->RowCnt++;

		// Set up key count
		$db_pd_list->KeyCount = $db_pd_list->RowIndex;

		// Init row class and style
		$db_pd->ResetAttrs();
		$db_pd->CssClass = "";
		if ($db_pd->CurrentAction == "gridadd") {
		} else {
			$db_pd_list->LoadRowValues($db_pd_list->Recordset); // Load row values
		}
		$db_pd->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$db_pd->RowAttrs = array_merge($db_pd->RowAttrs, array('data-rowindex'=>$db_pd_list->RowCnt, 'id'=>'r' . $db_pd_list->RowCnt . '_db_pd', 'data-rowtype'=>$db_pd->RowType));

		// Render row
		$db_pd_list->RenderRow();

		// Render list options
		$db_pd_list->RenderListOptions();
?>
	<tr<?php echo $db_pd->RowAttributes() ?>>
<?php

// Render list options (body, left)
$db_pd_list->ListOptions->Render("body", "left", $db_pd_list->RowCnt);
?>
	<?php if ($db_pd->id_pd->Visible) { // id_pd ?>
		<td data-name="id_pd"<?php echo $db_pd->id_pd->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_id_pd" class="db_pd_id_pd">
<span<?php echo $db_pd->id_pd->ViewAttributes() ?>>
<?php echo $db_pd->id_pd->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->nopes->Visible) { // nopes ?>
		<td data-name="nopes"<?php echo $db_pd->nopes->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_nopes" class="db_pd_nopes">
<span<?php echo $db_pd->nopes->ViewAttributes() ?>>
<?php echo $db_pd->nopes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->nm_pes->Visible) { // nm_pes ?>
		<td data-name="nm_pes"<?php echo $db_pd->nm_pes->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_nm_pes" class="db_pd_nm_pes">
<span<?php echo $db_pd->nm_pes->ViewAttributes() ?>>
<?php echo $db_pd->nm_pes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->asal_sek->Visible) { // asal_sek ?>
		<td data-name="asal_sek"<?php echo $db_pd->asal_sek->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_asal_sek" class="db_pd_asal_sek">
<span<?php echo $db_pd->asal_sek->ViewAttributes() ?>>
<?php echo $db_pd->asal_sek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->n_ind->Visible) { // n_ind ?>
		<td data-name="n_ind"<?php echo $db_pd->n_ind->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_n_ind" class="db_pd_n_ind">
<span<?php echo $db_pd->n_ind->ViewAttributes() ?>>
<?php echo $db_pd->n_ind->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->n_mat->Visible) { // n_mat ?>
		<td data-name="n_mat"<?php echo $db_pd->n_mat->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_n_mat" class="db_pd_n_mat">
<span<?php echo $db_pd->n_mat->ViewAttributes() ?>>
<?php echo $db_pd->n_mat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->n_ipa->Visible) { // n_ipa ?>
		<td data-name="n_ipa"<?php echo $db_pd->n_ipa->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_n_ipa" class="db_pd_n_ipa">
<span<?php echo $db_pd->n_ipa->ViewAttributes() ?>>
<?php echo $db_pd->n_ipa->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($db_pd->n_jml->Visible) { // n_jml ?>
		<td data-name="n_jml"<?php echo $db_pd->n_jml->CellAttributes() ?>>
<span id="el<?php echo $db_pd_list->RowCnt ?>_db_pd_n_jml" class="db_pd_n_jml">
<span<?php echo $db_pd->n_jml->ViewAttributes() ?>>
<?php echo $db_pd->n_jml->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$db_pd_list->ListOptions->Render("body", "right", $db_pd_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($db_pd->CurrentAction <> "gridadd")
		$db_pd_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($db_pd->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($db_pd_list->Recordset)
	$db_pd_list->Recordset->Close();
?>
<?php if ($db_pd->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($db_pd->CurrentAction <> "gridadd" && $db_pd->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($db_pd_list->Pager)) $db_pd_list->Pager = new cPrevNextPager($db_pd_list->StartRec, $db_pd_list->DisplayRecs, $db_pd_list->TotalRecs, $db_pd_list->AutoHidePager) ?>
<?php if ($db_pd_list->Pager->RecordCount > 0 && $db_pd_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($db_pd_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($db_pd_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $db_pd_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($db_pd_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($db_pd_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $db_pd_list->PageUrl() ?>start=<?php echo $db_pd_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $db_pd_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $db_pd_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $db_pd_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $db_pd_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($db_pd_list->TotalRecs > 0 && (!$db_pd_list->AutoHidePageSizeSelector || $db_pd_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="db_pd">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($db_pd_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($db_pd_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($db_pd_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($db_pd_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($db_pd->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($db_pd_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($db_pd_list->TotalRecs == 0 && $db_pd->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($db_pd_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($db_pd->Export == "") { ?>
<script type="text/javascript">
fdb_pdlist.Init();
</script>
<?php } ?>
<?php
$db_pd_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($db_pd->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$db_pd_list->Page_Terminate();
?>
