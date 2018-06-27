<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendaftar2info.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "no_pendaftaraninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendaftar2_list = NULL; // Initialize page object first

class cpendaftar2_list extends cpendaftar2 {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'pendaftar2';

	// Page object name
	var $PageObjName = 'pendaftar2_list';

	// Grid form hidden field names
	var $FormName = 'fpendaftar2list';
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

		// Table object (pendaftar2)
		if (!isset($GLOBALS["pendaftar2"]) || get_class($GLOBALS["pendaftar2"]) == "cpendaftar2") {
			$GLOBALS["pendaftar2"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendaftar2"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pendaftar2add.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pendaftar2delete.php";
		$this->MultiUpdateUrl = "pendaftar2update.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendaftar2', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpendaftar2listsrch";

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
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate();
			}
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
		$this->nama_ruang->SetVisibility();
		$this->nomor_pendaftaran->SetVisibility();
		$this->nomor_peserta_ujian_sdmi->SetVisibility();
		$this->sekolah_asal->SetVisibility();
		$this->nama_lengkap->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->zona->SetVisibility();
		$this->nilai_akhir->SetVisibility();
		$this->status->SetVisibility();
		$this->persyaratan->SetVisibility();
		$this->catatan->SetVisibility();

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
		global $EW_EXPORT, $pendaftar2;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendaftar2);
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

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
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

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

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
			$this->id_pendaftar->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_pendaftar->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fpendaftar2listsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id_pendaftar->AdvancedSearch->ToJson(), ","); // Field id_pendaftar
		$sFilterList = ew_Concat($sFilterList, $this->nama_ruang->AdvancedSearch->ToJson(), ","); // Field nama_ruang
		$sFilterList = ew_Concat($sFilterList, $this->nomor_pendaftaran->AdvancedSearch->ToJson(), ","); // Field nomor_pendaftaran
		$sFilterList = ew_Concat($sFilterList, $this->nomor_peserta_ujian_sdmi->AdvancedSearch->ToJson(), ","); // Field nomor_peserta_ujian_sdmi
		$sFilterList = ew_Concat($sFilterList, $this->sekolah_asal->AdvancedSearch->ToJson(), ","); // Field sekolah_asal
		$sFilterList = ew_Concat($sFilterList, $this->nama_lengkap->AdvancedSearch->ToJson(), ","); // Field nama_lengkap
		$sFilterList = ew_Concat($sFilterList, $this->nik->AdvancedSearch->ToJson(), ","); // Field nik
		$sFilterList = ew_Concat($sFilterList, $this->nisn->AdvancedSearch->ToJson(), ","); // Field nisn
		$sFilterList = ew_Concat($sFilterList, $this->tempat_lahir->AdvancedSearch->ToJson(), ","); // Field tempat_lahir
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_lahir->AdvancedSearch->ToJson(), ","); // Field tanggal_lahir
		$sFilterList = ew_Concat($sFilterList, $this->jenis_kelamin->AdvancedSearch->ToJson(), ","); // Field jenis_kelamin
		$sFilterList = ew_Concat($sFilterList, $this->agama->AdvancedSearch->ToJson(), ","); // Field agama
		$sFilterList = ew_Concat($sFilterList, $this->alamat->AdvancedSearch->ToJson(), ","); // Field alamat
		$sFilterList = ew_Concat($sFilterList, $this->kecamatan->AdvancedSearch->ToJson(), ","); // Field kecamatan
		$sFilterList = ew_Concat($sFilterList, $this->zona->AdvancedSearch->ToJson(), ","); // Field zona
		$sFilterList = ew_Concat($sFilterList, $this->n_ind->AdvancedSearch->ToJson(), ","); // Field n_ind
		$sFilterList = ew_Concat($sFilterList, $this->n_mat->AdvancedSearch->ToJson(), ","); // Field n_mat
		$sFilterList = ew_Concat($sFilterList, $this->n_ipa->AdvancedSearch->ToJson(), ","); // Field n_ipa
		$sFilterList = ew_Concat($sFilterList, $this->jumlah_nilai_usum->AdvancedSearch->ToJson(), ","); // Field jumlah_nilai_usum
		$sFilterList = ew_Concat($sFilterList, $this->bonus_prestasi->AdvancedSearch->ToJson(), ","); // Field bonus_prestasi
		$sFilterList = ew_Concat($sFilterList, $this->nama_prestasi->AdvancedSearch->ToJson(), ","); // Field nama_prestasi
		$sFilterList = ew_Concat($sFilterList, $this->jumlah_bonus_prestasi->AdvancedSearch->ToJson(), ","); // Field jumlah_bonus_prestasi
		$sFilterList = ew_Concat($sFilterList, $this->kepemilikan_ijasah_mda->AdvancedSearch->ToJson(), ","); // Field kepemilikan_ijasah_mda
		$sFilterList = ew_Concat($sFilterList, $this->nilai_mda->AdvancedSearch->ToJson(), ","); // Field nilai_mda
		$sFilterList = ew_Concat($sFilterList, $this->nilai_akhir->AdvancedSearch->ToJson(), ","); // Field nilai_akhir
		$sFilterList = ew_Concat($sFilterList, $this->nama_ayah->AdvancedSearch->ToJson(), ","); // Field nama_ayah
		$sFilterList = ew_Concat($sFilterList, $this->nama_ibu->AdvancedSearch->ToJson(), ","); // Field nama_ibu
		$sFilterList = ew_Concat($sFilterList, $this->nama_wali->AdvancedSearch->ToJson(), ","); // Field nama_wali
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->persyaratan->AdvancedSearch->ToJson(), ","); // Field persyaratan
		$sFilterList = ew_Concat($sFilterList, $this->catatan->AdvancedSearch->ToJson(), ","); // Field catatan
		$sFilterList = ew_Concat($sFilterList, $this->keterangan->AdvancedSearch->ToJson(), ","); // Field keterangan
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpendaftar2listsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id_pendaftar
		$this->id_pendaftar->AdvancedSearch->SearchValue = @$filter["x_id_pendaftar"];
		$this->id_pendaftar->AdvancedSearch->SearchOperator = @$filter["z_id_pendaftar"];
		$this->id_pendaftar->AdvancedSearch->SearchCondition = @$filter["v_id_pendaftar"];
		$this->id_pendaftar->AdvancedSearch->SearchValue2 = @$filter["y_id_pendaftar"];
		$this->id_pendaftar->AdvancedSearch->SearchOperator2 = @$filter["w_id_pendaftar"];
		$this->id_pendaftar->AdvancedSearch->Save();

		// Field nama_ruang
		$this->nama_ruang->AdvancedSearch->SearchValue = @$filter["x_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchOperator = @$filter["z_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchCondition = @$filter["v_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchValue2 = @$filter["y_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchOperator2 = @$filter["w_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->Save();

		// Field nomor_pendaftaran
		$this->nomor_pendaftaran->AdvancedSearch->SearchValue = @$filter["x_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchOperator = @$filter["z_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchCondition = @$filter["v_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchValue2 = @$filter["y_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchOperator2 = @$filter["w_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->Save();

		// Field nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchValue = @$filter["x_nomor_peserta_ujian_sdmi"];
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchOperator = @$filter["z_nomor_peserta_ujian_sdmi"];
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchCondition = @$filter["v_nomor_peserta_ujian_sdmi"];
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchValue2 = @$filter["y_nomor_peserta_ujian_sdmi"];
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->SearchOperator2 = @$filter["w_nomor_peserta_ujian_sdmi"];
		$this->nomor_peserta_ujian_sdmi->AdvancedSearch->Save();

		// Field sekolah_asal
		$this->sekolah_asal->AdvancedSearch->SearchValue = @$filter["x_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchOperator = @$filter["z_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchCondition = @$filter["v_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchValue2 = @$filter["y_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchOperator2 = @$filter["w_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->Save();

		// Field nama_lengkap
		$this->nama_lengkap->AdvancedSearch->SearchValue = @$filter["x_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchOperator = @$filter["z_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchCondition = @$filter["v_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchValue2 = @$filter["y_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchOperator2 = @$filter["w_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->Save();

		// Field nik
		$this->nik->AdvancedSearch->SearchValue = @$filter["x_nik"];
		$this->nik->AdvancedSearch->SearchOperator = @$filter["z_nik"];
		$this->nik->AdvancedSearch->SearchCondition = @$filter["v_nik"];
		$this->nik->AdvancedSearch->SearchValue2 = @$filter["y_nik"];
		$this->nik->AdvancedSearch->SearchOperator2 = @$filter["w_nik"];
		$this->nik->AdvancedSearch->Save();

		// Field nisn
		$this->nisn->AdvancedSearch->SearchValue = @$filter["x_nisn"];
		$this->nisn->AdvancedSearch->SearchOperator = @$filter["z_nisn"];
		$this->nisn->AdvancedSearch->SearchCondition = @$filter["v_nisn"];
		$this->nisn->AdvancedSearch->SearchValue2 = @$filter["y_nisn"];
		$this->nisn->AdvancedSearch->SearchOperator2 = @$filter["w_nisn"];
		$this->nisn->AdvancedSearch->Save();

		// Field tempat_lahir
		$this->tempat_lahir->AdvancedSearch->SearchValue = @$filter["x_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchOperator = @$filter["z_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchCondition = @$filter["v_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tempat_lahir"];
		$this->tempat_lahir->AdvancedSearch->Save();

		// Field tanggal_lahir
		$this->tanggal_lahir->AdvancedSearch->SearchValue = @$filter["x_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchOperator = @$filter["z_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchCondition = @$filter["v_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_lahir"];
		$this->tanggal_lahir->AdvancedSearch->Save();

		// Field jenis_kelamin
		$this->jenis_kelamin->AdvancedSearch->SearchValue = @$filter["x_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator = @$filter["z_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchCondition = @$filter["v_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchValue2 = @$filter["y_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->Save();

		// Field agama
		$this->agama->AdvancedSearch->SearchValue = @$filter["x_agama"];
		$this->agama->AdvancedSearch->SearchOperator = @$filter["z_agama"];
		$this->agama->AdvancedSearch->SearchCondition = @$filter["v_agama"];
		$this->agama->AdvancedSearch->SearchValue2 = @$filter["y_agama"];
		$this->agama->AdvancedSearch->SearchOperator2 = @$filter["w_agama"];
		$this->agama->AdvancedSearch->Save();

		// Field alamat
		$this->alamat->AdvancedSearch->SearchValue = @$filter["x_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator = @$filter["z_alamat"];
		$this->alamat->AdvancedSearch->SearchCondition = @$filter["v_alamat"];
		$this->alamat->AdvancedSearch->SearchValue2 = @$filter["y_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator2 = @$filter["w_alamat"];
		$this->alamat->AdvancedSearch->Save();

		// Field kecamatan
		$this->kecamatan->AdvancedSearch->SearchValue = @$filter["x_kecamatan"];
		$this->kecamatan->AdvancedSearch->SearchOperator = @$filter["z_kecamatan"];
		$this->kecamatan->AdvancedSearch->SearchCondition = @$filter["v_kecamatan"];
		$this->kecamatan->AdvancedSearch->SearchValue2 = @$filter["y_kecamatan"];
		$this->kecamatan->AdvancedSearch->SearchOperator2 = @$filter["w_kecamatan"];
		$this->kecamatan->AdvancedSearch->Save();

		// Field zona
		$this->zona->AdvancedSearch->SearchValue = @$filter["x_zona"];
		$this->zona->AdvancedSearch->SearchOperator = @$filter["z_zona"];
		$this->zona->AdvancedSearch->SearchCondition = @$filter["v_zona"];
		$this->zona->AdvancedSearch->SearchValue2 = @$filter["y_zona"];
		$this->zona->AdvancedSearch->SearchOperator2 = @$filter["w_zona"];
		$this->zona->AdvancedSearch->Save();

		// Field n_ind
		$this->n_ind->AdvancedSearch->SearchValue = @$filter["x_n_ind"];
		$this->n_ind->AdvancedSearch->SearchOperator = @$filter["z_n_ind"];
		$this->n_ind->AdvancedSearch->SearchCondition = @$filter["v_n_ind"];
		$this->n_ind->AdvancedSearch->SearchValue2 = @$filter["y_n_ind"];
		$this->n_ind->AdvancedSearch->SearchOperator2 = @$filter["w_n_ind"];
		$this->n_ind->AdvancedSearch->Save();

		// Field n_mat
		$this->n_mat->AdvancedSearch->SearchValue = @$filter["x_n_mat"];
		$this->n_mat->AdvancedSearch->SearchOperator = @$filter["z_n_mat"];
		$this->n_mat->AdvancedSearch->SearchCondition = @$filter["v_n_mat"];
		$this->n_mat->AdvancedSearch->SearchValue2 = @$filter["y_n_mat"];
		$this->n_mat->AdvancedSearch->SearchOperator2 = @$filter["w_n_mat"];
		$this->n_mat->AdvancedSearch->Save();

		// Field n_ipa
		$this->n_ipa->AdvancedSearch->SearchValue = @$filter["x_n_ipa"];
		$this->n_ipa->AdvancedSearch->SearchOperator = @$filter["z_n_ipa"];
		$this->n_ipa->AdvancedSearch->SearchCondition = @$filter["v_n_ipa"];
		$this->n_ipa->AdvancedSearch->SearchValue2 = @$filter["y_n_ipa"];
		$this->n_ipa->AdvancedSearch->SearchOperator2 = @$filter["w_n_ipa"];
		$this->n_ipa->AdvancedSearch->Save();

		// Field jumlah_nilai_usum
		$this->jumlah_nilai_usum->AdvancedSearch->SearchValue = @$filter["x_jumlah_nilai_usum"];
		$this->jumlah_nilai_usum->AdvancedSearch->SearchOperator = @$filter["z_jumlah_nilai_usum"];
		$this->jumlah_nilai_usum->AdvancedSearch->SearchCondition = @$filter["v_jumlah_nilai_usum"];
		$this->jumlah_nilai_usum->AdvancedSearch->SearchValue2 = @$filter["y_jumlah_nilai_usum"];
		$this->jumlah_nilai_usum->AdvancedSearch->SearchOperator2 = @$filter["w_jumlah_nilai_usum"];
		$this->jumlah_nilai_usum->AdvancedSearch->Save();

		// Field bonus_prestasi
		$this->bonus_prestasi->AdvancedSearch->SearchValue = @$filter["x_bonus_prestasi"];
		$this->bonus_prestasi->AdvancedSearch->SearchOperator = @$filter["z_bonus_prestasi"];
		$this->bonus_prestasi->AdvancedSearch->SearchCondition = @$filter["v_bonus_prestasi"];
		$this->bonus_prestasi->AdvancedSearch->SearchValue2 = @$filter["y_bonus_prestasi"];
		$this->bonus_prestasi->AdvancedSearch->SearchOperator2 = @$filter["w_bonus_prestasi"];
		$this->bonus_prestasi->AdvancedSearch->Save();

		// Field nama_prestasi
		$this->nama_prestasi->AdvancedSearch->SearchValue = @$filter["x_nama_prestasi"];
		$this->nama_prestasi->AdvancedSearch->SearchOperator = @$filter["z_nama_prestasi"];
		$this->nama_prestasi->AdvancedSearch->SearchCondition = @$filter["v_nama_prestasi"];
		$this->nama_prestasi->AdvancedSearch->SearchValue2 = @$filter["y_nama_prestasi"];
		$this->nama_prestasi->AdvancedSearch->SearchOperator2 = @$filter["w_nama_prestasi"];
		$this->nama_prestasi->AdvancedSearch->Save();

		// Field jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->AdvancedSearch->SearchValue = @$filter["x_jumlah_bonus_prestasi"];
		$this->jumlah_bonus_prestasi->AdvancedSearch->SearchOperator = @$filter["z_jumlah_bonus_prestasi"];
		$this->jumlah_bonus_prestasi->AdvancedSearch->SearchCondition = @$filter["v_jumlah_bonus_prestasi"];
		$this->jumlah_bonus_prestasi->AdvancedSearch->SearchValue2 = @$filter["y_jumlah_bonus_prestasi"];
		$this->jumlah_bonus_prestasi->AdvancedSearch->SearchOperator2 = @$filter["w_jumlah_bonus_prestasi"];
		$this->jumlah_bonus_prestasi->AdvancedSearch->Save();

		// Field kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda->AdvancedSearch->SearchValue = @$filter["x_kepemilikan_ijasah_mda"];
		$this->kepemilikan_ijasah_mda->AdvancedSearch->SearchOperator = @$filter["z_kepemilikan_ijasah_mda"];
		$this->kepemilikan_ijasah_mda->AdvancedSearch->SearchCondition = @$filter["v_kepemilikan_ijasah_mda"];
		$this->kepemilikan_ijasah_mda->AdvancedSearch->SearchValue2 = @$filter["y_kepemilikan_ijasah_mda"];
		$this->kepemilikan_ijasah_mda->AdvancedSearch->SearchOperator2 = @$filter["w_kepemilikan_ijasah_mda"];
		$this->kepemilikan_ijasah_mda->AdvancedSearch->Save();

		// Field nilai_mda
		$this->nilai_mda->AdvancedSearch->SearchValue = @$filter["x_nilai_mda"];
		$this->nilai_mda->AdvancedSearch->SearchOperator = @$filter["z_nilai_mda"];
		$this->nilai_mda->AdvancedSearch->SearchCondition = @$filter["v_nilai_mda"];
		$this->nilai_mda->AdvancedSearch->SearchValue2 = @$filter["y_nilai_mda"];
		$this->nilai_mda->AdvancedSearch->SearchOperator2 = @$filter["w_nilai_mda"];
		$this->nilai_mda->AdvancedSearch->Save();

		// Field nilai_akhir
		$this->nilai_akhir->AdvancedSearch->SearchValue = @$filter["x_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchOperator = @$filter["z_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchCondition = @$filter["v_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchValue2 = @$filter["y_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchOperator2 = @$filter["w_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->Save();

		// Field nama_ayah
		$this->nama_ayah->AdvancedSearch->SearchValue = @$filter["x_nama_ayah"];
		$this->nama_ayah->AdvancedSearch->SearchOperator = @$filter["z_nama_ayah"];
		$this->nama_ayah->AdvancedSearch->SearchCondition = @$filter["v_nama_ayah"];
		$this->nama_ayah->AdvancedSearch->SearchValue2 = @$filter["y_nama_ayah"];
		$this->nama_ayah->AdvancedSearch->SearchOperator2 = @$filter["w_nama_ayah"];
		$this->nama_ayah->AdvancedSearch->Save();

		// Field nama_ibu
		$this->nama_ibu->AdvancedSearch->SearchValue = @$filter["x_nama_ibu"];
		$this->nama_ibu->AdvancedSearch->SearchOperator = @$filter["z_nama_ibu"];
		$this->nama_ibu->AdvancedSearch->SearchCondition = @$filter["v_nama_ibu"];
		$this->nama_ibu->AdvancedSearch->SearchValue2 = @$filter["y_nama_ibu"];
		$this->nama_ibu->AdvancedSearch->SearchOperator2 = @$filter["w_nama_ibu"];
		$this->nama_ibu->AdvancedSearch->Save();

		// Field nama_wali
		$this->nama_wali->AdvancedSearch->SearchValue = @$filter["x_nama_wali"];
		$this->nama_wali->AdvancedSearch->SearchOperator = @$filter["z_nama_wali"];
		$this->nama_wali->AdvancedSearch->SearchCondition = @$filter["v_nama_wali"];
		$this->nama_wali->AdvancedSearch->SearchValue2 = @$filter["y_nama_wali"];
		$this->nama_wali->AdvancedSearch->SearchOperator2 = @$filter["w_nama_wali"];
		$this->nama_wali->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field persyaratan
		$this->persyaratan->AdvancedSearch->SearchValue = @$filter["x_persyaratan"];
		$this->persyaratan->AdvancedSearch->SearchOperator = @$filter["z_persyaratan"];
		$this->persyaratan->AdvancedSearch->SearchCondition = @$filter["v_persyaratan"];
		$this->persyaratan->AdvancedSearch->SearchValue2 = @$filter["y_persyaratan"];
		$this->persyaratan->AdvancedSearch->SearchOperator2 = @$filter["w_persyaratan"];
		$this->persyaratan->AdvancedSearch->Save();

		// Field catatan
		$this->catatan->AdvancedSearch->SearchValue = @$filter["x_catatan"];
		$this->catatan->AdvancedSearch->SearchOperator = @$filter["z_catatan"];
		$this->catatan->AdvancedSearch->SearchCondition = @$filter["v_catatan"];
		$this->catatan->AdvancedSearch->SearchValue2 = @$filter["y_catatan"];
		$this->catatan->AdvancedSearch->SearchOperator2 = @$filter["w_catatan"];
		$this->catatan->AdvancedSearch->Save();

		// Field keterangan
		$this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
		$this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
		$this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
		$this->keterangan->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ruang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_peserta_ujian_sdmi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->sekolah_asal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lengkap, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nik, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nisn, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tempat_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jenis_kelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->agama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kecamatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->zona, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jumlah_nilai_usum, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bonus_prestasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_prestasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jumlah_bonus_prestasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kepemilikan_ijasah_mda, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nilai_mda, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nilai_akhir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ayah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ibu, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_wali, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->persyaratan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->catatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keterangan, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->nama_ruang); // nama_ruang
			$this->UpdateSort($this->nomor_pendaftaran); // nomor_pendaftaran
			$this->UpdateSort($this->nomor_peserta_ujian_sdmi); // nomor_peserta_ujian_sdmi
			$this->UpdateSort($this->sekolah_asal); // sekolah_asal
			$this->UpdateSort($this->nama_lengkap); // nama_lengkap
			$this->UpdateSort($this->jenis_kelamin); // jenis_kelamin
			$this->UpdateSort($this->zona); // zona
			$this->UpdateSort($this->nilai_akhir); // nilai_akhir
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->persyaratan); // persyaratan
			$this->UpdateSort($this->catatan); // catatan
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->nama_ruang->setSort("");
				$this->nomor_pendaftaran->setSort("");
				$this->nomor_peserta_ujian_sdmi->setSort("");
				$this->sekolah_asal->setSort("");
				$this->nama_lengkap->setSort("");
				$this->jenis_kelamin->setSort("");
				$this->zona->setSort("");
				$this->nilai_akhir->setSort("");
				$this->status->setSort("");
				$this->persyaratan->setSort("");
				$this->catatan->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
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
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
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

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView() && $this->ShowOptionLink('view')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id_pendaftar->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fpendaftar2list,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpendaftar2listsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpendaftar2listsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpendaftar2list}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpendaftar2listsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->id_pendaftar->setDbValue($row['id_pendaftar']);
		$this->nama_ruang->setDbValue($row['nama_ruang']);
		$this->nomor_pendaftaran->setDbValue($row['nomor_pendaftaran']);
		$this->nomor_peserta_ujian_sdmi->setDbValue($row['nomor_peserta_ujian_sdmi']);
		$this->sekolah_asal->setDbValue($row['sekolah_asal']);
		$this->nama_lengkap->setDbValue($row['nama_lengkap']);
		$this->nik->setDbValue($row['nik']);
		$this->nisn->setDbValue($row['nisn']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->agama->setDbValue($row['agama']);
		$this->alamat->setDbValue($row['alamat']);
		$this->kecamatan->setDbValue($row['kecamatan']);
		$this->zona->setDbValue($row['zona']);
		$this->n_ind->setDbValue($row['n_ind']);
		$this->n_mat->setDbValue($row['n_mat']);
		$this->n_ipa->setDbValue($row['n_ipa']);
		$this->jumlah_nilai_usum->setDbValue($row['jumlah_nilai_usum']);
		$this->bonus_prestasi->setDbValue($row['bonus_prestasi']);
		$this->nama_prestasi->setDbValue($row['nama_prestasi']);
		$this->jumlah_bonus_prestasi->setDbValue($row['jumlah_bonus_prestasi']);
		$this->kepemilikan_ijasah_mda->setDbValue($row['kepemilikan_ijasah_mda']);
		$this->nilai_mda->setDbValue($row['nilai_mda']);
		$this->nilai_akhir->setDbValue($row['nilai_akhir']);
		$this->nama_ayah->setDbValue($row['nama_ayah']);
		$this->nama_ibu->setDbValue($row['nama_ibu']);
		$this->nama_wali->setDbValue($row['nama_wali']);
		$this->status->setDbValue($row['status']);
		$this->persyaratan->setDbValue($row['persyaratan']);
		$this->catatan->setDbValue($row['catatan']);
		$this->keterangan->setDbValue($row['keterangan']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id_pendaftar'] = NULL;
		$row['nama_ruang'] = NULL;
		$row['nomor_pendaftaran'] = NULL;
		$row['nomor_peserta_ujian_sdmi'] = NULL;
		$row['sekolah_asal'] = NULL;
		$row['nama_lengkap'] = NULL;
		$row['nik'] = NULL;
		$row['nisn'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['agama'] = NULL;
		$row['alamat'] = NULL;
		$row['kecamatan'] = NULL;
		$row['zona'] = NULL;
		$row['n_ind'] = NULL;
		$row['n_mat'] = NULL;
		$row['n_ipa'] = NULL;
		$row['jumlah_nilai_usum'] = NULL;
		$row['bonus_prestasi'] = NULL;
		$row['nama_prestasi'] = NULL;
		$row['jumlah_bonus_prestasi'] = NULL;
		$row['kepemilikan_ijasah_mda'] = NULL;
		$row['nilai_mda'] = NULL;
		$row['nilai_akhir'] = NULL;
		$row['nama_ayah'] = NULL;
		$row['nama_ibu'] = NULL;
		$row['nama_wali'] = NULL;
		$row['status'] = NULL;
		$row['persyaratan'] = NULL;
		$row['catatan'] = NULL;
		$row['keterangan'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_pendaftar->DbValue = $row['id_pendaftar'];
		$this->nama_ruang->DbValue = $row['nama_ruang'];
		$this->nomor_pendaftaran->DbValue = $row['nomor_pendaftaran'];
		$this->nomor_peserta_ujian_sdmi->DbValue = $row['nomor_peserta_ujian_sdmi'];
		$this->sekolah_asal->DbValue = $row['sekolah_asal'];
		$this->nama_lengkap->DbValue = $row['nama_lengkap'];
		$this->nik->DbValue = $row['nik'];
		$this->nisn->DbValue = $row['nisn'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->agama->DbValue = $row['agama'];
		$this->alamat->DbValue = $row['alamat'];
		$this->kecamatan->DbValue = $row['kecamatan'];
		$this->zona->DbValue = $row['zona'];
		$this->n_ind->DbValue = $row['n_ind'];
		$this->n_mat->DbValue = $row['n_mat'];
		$this->n_ipa->DbValue = $row['n_ipa'];
		$this->jumlah_nilai_usum->DbValue = $row['jumlah_nilai_usum'];
		$this->bonus_prestasi->DbValue = $row['bonus_prestasi'];
		$this->nama_prestasi->DbValue = $row['nama_prestasi'];
		$this->jumlah_bonus_prestasi->DbValue = $row['jumlah_bonus_prestasi'];
		$this->kepemilikan_ijasah_mda->DbValue = $row['kepemilikan_ijasah_mda'];
		$this->nilai_mda->DbValue = $row['nilai_mda'];
		$this->nilai_akhir->DbValue = $row['nilai_akhir'];
		$this->nama_ayah->DbValue = $row['nama_ayah'];
		$this->nama_ibu->DbValue = $row['nama_ibu'];
		$this->nama_wali->DbValue = $row['nama_wali'];
		$this->status->DbValue = $row['status'];
		$this->persyaratan->DbValue = $row['persyaratan'];
		$this->catatan->DbValue = $row['catatan'];
		$this->keterangan->DbValue = $row['keterangan'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_pendaftar")) <> "")
			$this->id_pendaftar->CurrentValue = $this->getKey("id_pendaftar"); // id_pendaftar
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
		// Accumulate aggregate value

		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			$this->nama_lengkap->Count++; // Increment count
		}
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->nama_lengkap->Count = 0; // Initialize count
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->nama_lengkap->CurrentValue = $this->nama_lengkap->Count;
			$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
			$this->nama_lengkap->ViewCustomAttributes = "";
			$this->nama_lengkap->HrefValue = ""; // Clear href value
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
		$item->Body = "<button id=\"emf_pendaftar2\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pendaftar2',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpendaftar2list,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->nama_ruang->CurrentValue);
		return TRUE;
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
if (!isset($pendaftar2_list)) $pendaftar2_list = new cpendaftar2_list();

// Page init
$pendaftar2_list->Page_Init();

// Page main
$pendaftar2_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendaftar2_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pendaftar2->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpendaftar2list = new ew_Form("fpendaftar2list", "list");
fpendaftar2list.FormKeyCountName = '<?php echo $pendaftar2_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpendaftar2list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendaftar2list.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpendaftar2list.Lists["x_nama_ruang"] = {"LinkField":"x_nama_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fpendaftar2list.Lists["x_nama_ruang"].Data = "<?php echo $pendaftar2_list->nama_ruang->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar2list.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_nomor_pendaftaran","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fpendaftar2list.Lists["x_nomor_pendaftaran"].Data = "<?php echo $pendaftar2_list->nomor_pendaftaran->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar2list.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_nopes","Ajax":true,"AutoFill":false,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fpendaftar2list.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $pendaftar2_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar2list.AutoSuggests["x_nomor_peserta_ujian_sdmi"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $pendaftar2_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(TRUE, "list"))) ?>;
fpendaftar2list.Lists["x_jenis_kelamin"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar2list.Lists["x_jenis_kelamin"].Options = <?php echo json_encode($pendaftar2_list->jenis_kelamin->Options()) ?>;
fpendaftar2list.Lists["x_persyaratan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar2list.Lists["x_persyaratan"].Options = <?php echo json_encode($pendaftar2_list->persyaratan->Options()) ?>;

// Form object for search
var CurrentSearchForm = fpendaftar2listsrch = new ew_Form("fpendaftar2listsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pendaftar2->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pendaftar2_list->TotalRecs > 0 && $pendaftar2_list->ExportOptions->Visible()) { ?>
<?php $pendaftar2_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pendaftar2_list->SearchOptions->Visible()) { ?>
<?php $pendaftar2_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pendaftar2_list->FilterOptions->Visible()) { ?>
<?php $pendaftar2_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $pendaftar2_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pendaftar2_list->TotalRecs <= 0)
			$pendaftar2_list->TotalRecs = $pendaftar2->ListRecordCount();
	} else {
		if (!$pendaftar2_list->Recordset && ($pendaftar2_list->Recordset = $pendaftar2_list->LoadRecordset()))
			$pendaftar2_list->TotalRecs = $pendaftar2_list->Recordset->RecordCount();
	}
	$pendaftar2_list->StartRec = 1;
	if ($pendaftar2_list->DisplayRecs <= 0 || ($pendaftar2->Export <> "" && $pendaftar2->ExportAll)) // Display all records
		$pendaftar2_list->DisplayRecs = $pendaftar2_list->TotalRecs;
	if (!($pendaftar2->Export <> "" && $pendaftar2->ExportAll))
		$pendaftar2_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pendaftar2_list->Recordset = $pendaftar2_list->LoadRecordset($pendaftar2_list->StartRec-1, $pendaftar2_list->DisplayRecs);

	// Set no record found message
	if ($pendaftar2->CurrentAction == "" && $pendaftar2_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pendaftar2_list->setWarningMessage(ew_DeniedMsg());
		if ($pendaftar2_list->SearchWhere == "0=101")
			$pendaftar2_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pendaftar2_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pendaftar2_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($pendaftar2->Export == "" && $pendaftar2->CurrentAction == "") { ?>
<form name="fpendaftar2listsrch" id="fpendaftar2listsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pendaftar2_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpendaftar2listsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pendaftar2">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pendaftar2_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pendaftar2_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pendaftar2_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pendaftar2_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pendaftar2_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pendaftar2_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pendaftar2_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pendaftar2_list->ShowPageHeader(); ?>
<?php
$pendaftar2_list->ShowMessage();
?>
<?php if ($pendaftar2_list->TotalRecs > 0 || $pendaftar2->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($pendaftar2_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> pendaftar2">
<?php if ($pendaftar2->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($pendaftar2->CurrentAction <> "gridadd" && $pendaftar2->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pendaftar2_list->Pager)) $pendaftar2_list->Pager = new cPrevNextPager($pendaftar2_list->StartRec, $pendaftar2_list->DisplayRecs, $pendaftar2_list->TotalRecs, $pendaftar2_list->AutoHidePager) ?>
<?php if ($pendaftar2_list->Pager->RecordCount > 0 && $pendaftar2_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pendaftar2_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pendaftar2_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pendaftar2_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pendaftar2_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pendaftar2_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pendaftar2_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pendaftar2_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pendaftar2_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pendaftar2_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($pendaftar2_list->TotalRecs > 0 && (!$pendaftar2_list->AutoHidePageSizeSelector || $pendaftar2_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="pendaftar2">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($pendaftar2_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($pendaftar2_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($pendaftar2_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($pendaftar2_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($pendaftar2->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar2_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpendaftar2list" id="fpendaftar2list" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendaftar2_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendaftar2_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendaftar2">
<div id="gmp_pendaftar2" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($pendaftar2_list->TotalRecs > 0 || $pendaftar2->CurrentAction == "gridedit") { ?>
<table id="tbl_pendaftar2list" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$pendaftar2_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pendaftar2_list->RenderListOptions();

// Render list options (header, left)
$pendaftar2_list->ListOptions->Render("header", "left");
?>
<?php if ($pendaftar2->nama_ruang->Visible) { // nama_ruang ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->nama_ruang) == "") { ?>
		<th data-name="nama_ruang" class="<?php echo $pendaftar2->nama_ruang->HeaderCellClass() ?>"><div id="elh_pendaftar2_nama_ruang" class="pendaftar2_nama_ruang"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->nama_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ruang" class="<?php echo $pendaftar2->nama_ruang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->nama_ruang) ?>',1);"><div id="elh_pendaftar2_nama_ruang" class="pendaftar2_nama_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->nama_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->nama_ruang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->nama_ruang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->nomor_pendaftaran) == "") { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $pendaftar2->nomor_pendaftaran->HeaderCellClass() ?>"><div id="elh_pendaftar2_nomor_pendaftaran" class="pendaftar2_nomor_pendaftaran"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->nomor_pendaftaran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $pendaftar2->nomor_pendaftaran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->nomor_pendaftaran) ?>',1);"><div id="elh_pendaftar2_nomor_pendaftaran" class="pendaftar2_nomor_pendaftaran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->nomor_pendaftaran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->nomor_pendaftaran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->nomor_pendaftaran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->nomor_peserta_ujian_sdmi) == "") { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div id="elh_pendaftar2_nomor_peserta_ujian_sdmi" class="pendaftar2_nomor_peserta_ujian_sdmi"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->nomor_peserta_ujian_sdmi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->nomor_peserta_ujian_sdmi) ?>',1);"><div id="elh_pendaftar2_nomor_peserta_ujian_sdmi" class="pendaftar2_nomor_peserta_ujian_sdmi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->nomor_peserta_ujian_sdmi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->nomor_peserta_ujian_sdmi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->sekolah_asal->Visible) { // sekolah_asal ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->sekolah_asal) == "") { ?>
		<th data-name="sekolah_asal" class="<?php echo $pendaftar2->sekolah_asal->HeaderCellClass() ?>"><div id="elh_pendaftar2_sekolah_asal" class="pendaftar2_sekolah_asal"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->sekolah_asal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_asal" class="<?php echo $pendaftar2->sekolah_asal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->sekolah_asal) ?>',1);"><div id="elh_pendaftar2_sekolah_asal" class="pendaftar2_sekolah_asal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->sekolah_asal->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->sekolah_asal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->sekolah_asal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->nama_lengkap->Visible) { // nama_lengkap ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->nama_lengkap) == "") { ?>
		<th data-name="nama_lengkap" class="<?php echo $pendaftar2->nama_lengkap->HeaderCellClass() ?>"><div id="elh_pendaftar2_nama_lengkap" class="pendaftar2_nama_lengkap"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->nama_lengkap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lengkap" class="<?php echo $pendaftar2->nama_lengkap->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->nama_lengkap) ?>',1);"><div id="elh_pendaftar2_nama_lengkap" class="pendaftar2_nama_lengkap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->nama_lengkap->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->nama_lengkap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->nama_lengkap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->jenis_kelamin) == "") { ?>
		<th data-name="jenis_kelamin" class="<?php echo $pendaftar2->jenis_kelamin->HeaderCellClass() ?>"><div id="elh_pendaftar2_jenis_kelamin" class="pendaftar2_jenis_kelamin"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->jenis_kelamin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_kelamin" class="<?php echo $pendaftar2->jenis_kelamin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->jenis_kelamin) ?>',1);"><div id="elh_pendaftar2_jenis_kelamin" class="pendaftar2_jenis_kelamin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->jenis_kelamin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->jenis_kelamin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->jenis_kelamin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->zona->Visible) { // zona ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->zona) == "") { ?>
		<th data-name="zona" class="<?php echo $pendaftar2->zona->HeaderCellClass() ?>"><div id="elh_pendaftar2_zona" class="pendaftar2_zona"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona" class="<?php echo $pendaftar2->zona->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->zona) ?>',1);"><div id="elh_pendaftar2_zona" class="pendaftar2_zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->zona->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->nilai_akhir->Visible) { // nilai_akhir ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->nilai_akhir) == "") { ?>
		<th data-name="nilai_akhir" class="<?php echo $pendaftar2->nilai_akhir->HeaderCellClass() ?>"><div id="elh_pendaftar2_nilai_akhir" class="pendaftar2_nilai_akhir"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->nilai_akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai_akhir" class="<?php echo $pendaftar2->nilai_akhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->nilai_akhir) ?>',1);"><div id="elh_pendaftar2_nilai_akhir" class="pendaftar2_nilai_akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->nilai_akhir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->nilai_akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->nilai_akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->status->Visible) { // status ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->status) == "") { ?>
		<th data-name="status" class="<?php echo $pendaftar2->status->HeaderCellClass() ?>"><div id="elh_pendaftar2_status" class="pendaftar2_status"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $pendaftar2->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->status) ?>',1);"><div id="elh_pendaftar2_status" class="pendaftar2_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->persyaratan->Visible) { // persyaratan ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->persyaratan) == "") { ?>
		<th data-name="persyaratan" class="<?php echo $pendaftar2->persyaratan->HeaderCellClass() ?>"><div id="elh_pendaftar2_persyaratan" class="pendaftar2_persyaratan"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->persyaratan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="persyaratan" class="<?php echo $pendaftar2->persyaratan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->persyaratan) ?>',1);"><div id="elh_pendaftar2_persyaratan" class="pendaftar2_persyaratan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->persyaratan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->persyaratan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->persyaratan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar2->catatan->Visible) { // catatan ?>
	<?php if ($pendaftar2->SortUrl($pendaftar2->catatan) == "") { ?>
		<th data-name="catatan" class="<?php echo $pendaftar2->catatan->HeaderCellClass() ?>"><div id="elh_pendaftar2_catatan" class="pendaftar2_catatan"><div class="ewTableHeaderCaption"><?php echo $pendaftar2->catatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="catatan" class="<?php echo $pendaftar2->catatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar2->SortUrl($pendaftar2->catatan) ?>',1);"><div id="elh_pendaftar2_catatan" class="pendaftar2_catatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar2->catatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar2->catatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar2->catatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pendaftar2_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pendaftar2->ExportAll && $pendaftar2->Export <> "") {
	$pendaftar2_list->StopRec = $pendaftar2_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pendaftar2_list->TotalRecs > $pendaftar2_list->StartRec + $pendaftar2_list->DisplayRecs - 1)
		$pendaftar2_list->StopRec = $pendaftar2_list->StartRec + $pendaftar2_list->DisplayRecs - 1;
	else
		$pendaftar2_list->StopRec = $pendaftar2_list->TotalRecs;
}
$pendaftar2_list->RecCnt = $pendaftar2_list->StartRec - 1;
if ($pendaftar2_list->Recordset && !$pendaftar2_list->Recordset->EOF) {
	$pendaftar2_list->Recordset->MoveFirst();
	$bSelectLimit = $pendaftar2_list->UseSelectLimit;
	if (!$bSelectLimit && $pendaftar2_list->StartRec > 1)
		$pendaftar2_list->Recordset->Move($pendaftar2_list->StartRec - 1);
} elseif (!$pendaftar2->AllowAddDeleteRow && $pendaftar2_list->StopRec == 0) {
	$pendaftar2_list->StopRec = $pendaftar2->GridAddRowCount;
}

// Initialize aggregate
$pendaftar2->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pendaftar2->ResetAttrs();
$pendaftar2_list->RenderRow();
while ($pendaftar2_list->RecCnt < $pendaftar2_list->StopRec) {
	$pendaftar2_list->RecCnt++;
	if (intval($pendaftar2_list->RecCnt) >= intval($pendaftar2_list->StartRec)) {
		$pendaftar2_list->RowCnt++;

		// Set up key count
		$pendaftar2_list->KeyCount = $pendaftar2_list->RowIndex;

		// Init row class and style
		$pendaftar2->ResetAttrs();
		$pendaftar2->CssClass = "";
		if ($pendaftar2->CurrentAction == "gridadd") {
		} else {
			$pendaftar2_list->LoadRowValues($pendaftar2_list->Recordset); // Load row values
		}
		$pendaftar2->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pendaftar2->RowAttrs = array_merge($pendaftar2->RowAttrs, array('data-rowindex'=>$pendaftar2_list->RowCnt, 'id'=>'r' . $pendaftar2_list->RowCnt . '_pendaftar2', 'data-rowtype'=>$pendaftar2->RowType));

		// Render row
		$pendaftar2_list->RenderRow();

		// Render list options
		$pendaftar2_list->RenderListOptions();
?>
	<tr<?php echo $pendaftar2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pendaftar2_list->ListOptions->Render("body", "left", $pendaftar2_list->RowCnt);
?>
	<?php if ($pendaftar2->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang"<?php echo $pendaftar2->nama_ruang->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_nama_ruang" class="pendaftar2_nama_ruang">
<span<?php echo $pendaftar2->nama_ruang->ViewAttributes() ?>>
<?php echo $pendaftar2->nama_ruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran"<?php echo $pendaftar2->nomor_pendaftaran->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_nomor_pendaftaran" class="pendaftar2_nomor_pendaftaran">
<span<?php echo $pendaftar2->nomor_pendaftaran->ViewAttributes() ?>>
<?php echo $pendaftar2->nomor_pendaftaran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi"<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_nomor_peserta_ujian_sdmi" class="pendaftar2_nomor_peserta_ujian_sdmi">
<span<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->ViewAttributes() ?>>
<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal"<?php echo $pendaftar2->sekolah_asal->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_sekolah_asal" class="pendaftar2_sekolah_asal">
<span<?php echo $pendaftar2->sekolah_asal->ViewAttributes() ?>>
<?php echo $pendaftar2->sekolah_asal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap"<?php echo $pendaftar2->nama_lengkap->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_nama_lengkap" class="pendaftar2_nama_lengkap">
<span<?php echo $pendaftar2->nama_lengkap->ViewAttributes() ?>>
<?php echo $pendaftar2->nama_lengkap->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin"<?php echo $pendaftar2->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_jenis_kelamin" class="pendaftar2_jenis_kelamin">
<span<?php echo $pendaftar2->jenis_kelamin->ViewAttributes() ?>>
<?php echo $pendaftar2->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->zona->Visible) { // zona ?>
		<td data-name="zona"<?php echo $pendaftar2->zona->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_zona" class="pendaftar2_zona">
<span<?php echo $pendaftar2->zona->ViewAttributes() ?>>
<?php echo $pendaftar2->zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir"<?php echo $pendaftar2->nilai_akhir->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_nilai_akhir" class="pendaftar2_nilai_akhir">
<span<?php echo $pendaftar2->nilai_akhir->ViewAttributes() ?>>
<?php echo $pendaftar2->nilai_akhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->status->Visible) { // status ?>
		<td data-name="status"<?php echo $pendaftar2->status->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_status" class="pendaftar2_status">
<span<?php echo $pendaftar2->status->ViewAttributes() ?>>
<?php echo $pendaftar2->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan"<?php echo $pendaftar2->persyaratan->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_persyaratan" class="pendaftar2_persyaratan">
<span<?php echo $pendaftar2->persyaratan->ViewAttributes() ?>>
<?php echo $pendaftar2->persyaratan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pendaftar2->catatan->Visible) { // catatan ?>
		<td data-name="catatan"<?php echo $pendaftar2->catatan->CellAttributes() ?>>
<span id="el<?php echo $pendaftar2_list->RowCnt ?>_pendaftar2_catatan" class="pendaftar2_catatan">
<span<?php echo $pendaftar2->catatan->ViewAttributes() ?>>
<?php echo $pendaftar2->catatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pendaftar2_list->ListOptions->Render("body", "right", $pendaftar2_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pendaftar2->CurrentAction <> "gridadd")
		$pendaftar2_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$pendaftar2->RowType = EW_ROWTYPE_AGGREGATE;
$pendaftar2->ResetAttrs();
$pendaftar2_list->RenderRow();
?>
<?php if ($pendaftar2_list->TotalRecs > 0 && ($pendaftar2->CurrentAction <> "gridadd" && $pendaftar2->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$pendaftar2_list->RenderListOptions();

// Render list options (footer, left)
$pendaftar2_list->ListOptions->Render("footer", "left");
?>
	<?php if ($pendaftar2->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang" class="<?php echo $pendaftar2->nama_ruang->FooterCellClass() ?>"><span id="elf_pendaftar2_nama_ruang" class="pendaftar2_nama_ruang">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran" class="<?php echo $pendaftar2->nomor_pendaftaran->FooterCellClass() ?>"><span id="elf_pendaftar2_nomor_pendaftaran" class="pendaftar2_nomor_pendaftaran">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->FooterCellClass() ?>"><span id="elf_pendaftar2_nomor_peserta_ujian_sdmi" class="pendaftar2_nomor_peserta_ujian_sdmi">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal" class="<?php echo $pendaftar2->sekolah_asal->FooterCellClass() ?>"><span id="elf_pendaftar2_sekolah_asal" class="pendaftar2_sekolah_asal">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap" class="<?php echo $pendaftar2->nama_lengkap->FooterCellClass() ?>"><span id="elf_pendaftar2_nama_lengkap" class="pendaftar2_nama_lengkap">
<span class="ewAggregate"><?php echo $Language->Phrase("COUNT") ?></span><span class="ewAggregateValue">
<?php echo $pendaftar2->nama_lengkap->ViewValue ?></span>
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin" class="<?php echo $pendaftar2->jenis_kelamin->FooterCellClass() ?>"><span id="elf_pendaftar2_jenis_kelamin" class="pendaftar2_jenis_kelamin">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->zona->Visible) { // zona ?>
		<td data-name="zona" class="<?php echo $pendaftar2->zona->FooterCellClass() ?>"><span id="elf_pendaftar2_zona" class="pendaftar2_zona">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir" class="<?php echo $pendaftar2->nilai_akhir->FooterCellClass() ?>"><span id="elf_pendaftar2_nilai_akhir" class="pendaftar2_nilai_akhir">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->status->Visible) { // status ?>
		<td data-name="status" class="<?php echo $pendaftar2->status->FooterCellClass() ?>"><span id="elf_pendaftar2_status" class="pendaftar2_status">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan" class="<?php echo $pendaftar2->persyaratan->FooterCellClass() ?>"><span id="elf_pendaftar2_persyaratan" class="pendaftar2_persyaratan">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($pendaftar2->catatan->Visible) { // catatan ?>
		<td data-name="catatan" class="<?php echo $pendaftar2->catatan->FooterCellClass() ?>"><span id="elf_pendaftar2_catatan" class="pendaftar2_catatan">
		&nbsp;
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$pendaftar2_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>
<?php } ?>
</table>
<?php } ?>
<?php if ($pendaftar2->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pendaftar2_list->Recordset)
	$pendaftar2_list->Recordset->Close();
?>
<?php if ($pendaftar2->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($pendaftar2->CurrentAction <> "gridadd" && $pendaftar2->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pendaftar2_list->Pager)) $pendaftar2_list->Pager = new cPrevNextPager($pendaftar2_list->StartRec, $pendaftar2_list->DisplayRecs, $pendaftar2_list->TotalRecs, $pendaftar2_list->AutoHidePager) ?>
<?php if ($pendaftar2_list->Pager->RecordCount > 0 && $pendaftar2_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pendaftar2_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pendaftar2_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pendaftar2_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pendaftar2_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pendaftar2_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pendaftar2_list->PageUrl() ?>start=<?php echo $pendaftar2_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pendaftar2_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pendaftar2_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pendaftar2_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pendaftar2_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($pendaftar2_list->TotalRecs > 0 && (!$pendaftar2_list->AutoHidePageSizeSelector || $pendaftar2_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="pendaftar2">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($pendaftar2_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($pendaftar2_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($pendaftar2_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($pendaftar2_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($pendaftar2->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar2_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pendaftar2_list->TotalRecs == 0 && $pendaftar2->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar2_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pendaftar2->Export == "") { ?>
<script type="text/javascript">
fpendaftar2listsrch.FilterList = <?php echo $pendaftar2_list->GetFilterList() ?>;
fpendaftar2listsrch.Init();
fpendaftar2list.Init();
</script>
<?php } ?>
<?php
$pendaftar2_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pendaftar2->Export == "") { ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#x_jumlah_nilai_usum, #x_jumlah_bonus_prestasi, #x_nilai_mda").change(function () {
	   var jumlah_nilai_usum = parseDecimal($('#x_jumlah_nilai_usum').val());
	   var jumlah_bonus_prestasi = parseDecimal($('#x_jumlah_bonus_prestasi').val());
	   var nilai_mda = parseDecimal($('#x_nilai_mda').val());
	   var nilai_akhir = jumlah_nilai_usum + jumlah_bonus_prestasi + nilai_mda;
	   $("#x_nilai_akhir").val(nilai_akhir);    
	}); 
});
</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pendaftar2_list->Page_Terminate();
?>
