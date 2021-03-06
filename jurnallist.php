<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "jurnalinfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "no_pendaftaraninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$jurnal_list = NULL; // Initialize page object first

class cjurnal_list extends cjurnal {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'jurnal';

	// Page object name
	var $PageObjName = 'jurnal_list';

	// Grid form hidden field names
	var $FormName = 'fjurnallist';
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

		// Table object (jurnal)
		if (!isset($GLOBALS["jurnal"]) || get_class($GLOBALS["jurnal"]) == "cjurnal") {
			$GLOBALS["jurnal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["jurnal"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "jurnaladd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "jurnaldelete.php";
		$this->MultiUpdateUrl = "jurnalupdate.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'jurnal', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fjurnallistsrch";

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
		global $EW_EXPORT, $jurnal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($jurnal);
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
	var $DisplayRecs = 0;
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
			$this->DisplayRecs = 0; // Load default
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fjurnallistsrch") : "";
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
		$sFilterList = ew_Concat($sFilterList, $this->jenis_kelamin->AdvancedSearch->ToJson(), ","); // Field jenis_kelamin
		$sFilterList = ew_Concat($sFilterList, $this->zona->AdvancedSearch->ToJson(), ","); // Field zona
		$sFilterList = ew_Concat($sFilterList, $this->nilai_akhir->AdvancedSearch->ToJson(), ","); // Field nilai_akhir
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->persyaratan->AdvancedSearch->ToJson(), ","); // Field persyaratan
		$sFilterList = ew_Concat($sFilterList, $this->catatan->AdvancedSearch->ToJson(), ","); // Field catatan
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fjurnallistsrch", $filters);

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

		// Field jenis_kelamin
		$this->jenis_kelamin->AdvancedSearch->SearchValue = @$filter["x_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator = @$filter["z_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchCondition = @$filter["v_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchValue2 = @$filter["y_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_kelamin"];
		$this->jenis_kelamin->AdvancedSearch->Save();

		// Field zona
		$this->zona->AdvancedSearch->SearchValue = @$filter["x_zona"];
		$this->zona->AdvancedSearch->SearchOperator = @$filter["z_zona"];
		$this->zona->AdvancedSearch->SearchCondition = @$filter["v_zona"];
		$this->zona->AdvancedSearch->SearchValue2 = @$filter["y_zona"];
		$this->zona->AdvancedSearch->SearchOperator2 = @$filter["w_zona"];
		$this->zona->AdvancedSearch->Save();

		// Field nilai_akhir
		$this->nilai_akhir->AdvancedSearch->SearchValue = @$filter["x_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchOperator = @$filter["z_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchCondition = @$filter["v_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchValue2 = @$filter["y_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->SearchOperator2 = @$filter["w_nilai_akhir"];
		$this->nilai_akhir->AdvancedSearch->Save();

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
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ruang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_pendaftaran, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_peserta_ujian_sdmi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->sekolah_asal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lengkap, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jenis_kelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->zona, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nilai_akhir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->persyaratan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->catatan, $arKeywords, $type);
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
				$this->setSessionOrderByList($sOrderBy);
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
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
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
		$this->ListOptions->UseButtonGroup = FALSE;
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
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fjurnallistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fjurnallistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fjurnallist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fjurnallistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
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
		if (array_key_exists('EV__nomor_peserta_ujian_sdmi', $rs->fields)) {
			$this->nomor_peserta_ujian_sdmi->VirtualValue = $rs->fields('EV__nomor_peserta_ujian_sdmi'); // Set up virtual field value
		} else {
			$this->nomor_peserta_ujian_sdmi->VirtualValue = ""; // Clear value
		}
		$this->sekolah_asal->setDbValue($row['sekolah_asal']);
		$this->nama_lengkap->setDbValue($row['nama_lengkap']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->zona->setDbValue($row['zona']);
		$this->nilai_akhir->setDbValue($row['nilai_akhir']);
		$this->status->setDbValue($row['status']);
		$this->persyaratan->setDbValue($row['persyaratan']);
		$this->catatan->setDbValue($row['catatan']);
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
		$row['jenis_kelamin'] = NULL;
		$row['zona'] = NULL;
		$row['nilai_akhir'] = NULL;
		$row['status'] = NULL;
		$row['persyaratan'] = NULL;
		$row['catatan'] = NULL;
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
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->zona->DbValue = $row['zona'];
		$this->nilai_akhir->DbValue = $row['nilai_akhir'];
		$this->status->DbValue = $row['status'];
		$this->persyaratan->DbValue = $row['persyaratan'];
		$this->catatan->DbValue = $row['catatan'];
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
		// jenis_kelamin
		// zona
		// nilai_akhir
		// status
		// persyaratan
		// catatan
		// Accumulate aggregate value

		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			$this->nama_lengkap->Count++; // Increment count
		}
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_pendaftar
		$this->id_pendaftar->ViewValue = $this->id_pendaftar->CurrentValue;
		$this->id_pendaftar->CellCssStyle .= "text-align: center;";
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
		$this->nama_ruang->CellCssStyle .= "text-align: center;";
		$this->nama_ruang->ViewCustomAttributes = "";

		// nomor_pendaftaran
		$this->nomor_pendaftaran->ViewValue = $this->nomor_pendaftaran->CurrentValue;
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
		$this->nomor_pendaftaran->CellCssStyle .= "text-align: center;";
		$this->nomor_pendaftaran->ViewCustomAttributes = "";

		// nomor_peserta_ujian_sdmi
		if ($this->nomor_peserta_ujian_sdmi->VirtualValue <> "") {
			$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->VirtualValue;
		} else {
			$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
			$sFilterWrk = "`nopes`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nopes`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
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
		$this->nomor_peserta_ujian_sdmi->CellCssStyle .= "text-align: center;";
		$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

		// sekolah_asal
		$this->sekolah_asal->ViewValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->ViewCustomAttributes = "";

		// nama_lengkap
		$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->CellCssStyle .= "text-align: center;";
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->CellCssStyle .= "text-align: center;";
		$this->zona->ViewCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->ViewValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->ViewValue = ew_FormatNumber($this->nilai_akhir->ViewValue, 1, 0, 0, 0);
		$this->nilai_akhir->CellCssStyle .= "text-align: center;";
		$this->nilai_akhir->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->CellCssStyle .= "text-align: center;";
		$this->status->ViewCustomAttributes = "";

		// persyaratan
		if (strval($this->persyaratan->CurrentValue) <> "") {
			$this->persyaratan->ViewValue = $this->persyaratan->OptionCaption($this->persyaratan->CurrentValue);
		} else {
			$this->persyaratan->ViewValue = NULL;
		}
		$this->persyaratan->CellCssStyle .= "text-align: center;";
		$this->persyaratan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

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
		$item->Body = "<button id=\"emf_jurnal\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_jurnal',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fjurnallist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		include 'header_jurnal.php';
	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		include 'footer_cetak.php';
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
if (!isset($jurnal_list)) $jurnal_list = new cjurnal_list();

// Page init
$jurnal_list->Page_Init();

// Page main
$jurnal_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jurnal_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($jurnal->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fjurnallist = new ew_Form("fjurnallist", "list");
fjurnallist.FormKeyCountName = '<?php echo $jurnal_list->FormKeyCountName ?>';

// Form_CustomValidate event
fjurnallist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fjurnallist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjurnallist.Lists["x_nama_ruang"] = {"LinkField":"x_nama_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fjurnallist.Lists["x_nama_ruang"].Data = "<?php echo $jurnal_list->nama_ruang->LookupFilterQuery(FALSE, "list") ?>";
fjurnallist.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_nomor_pendaftaran","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fjurnallist.Lists["x_nomor_pendaftaran"].Data = "<?php echo $jurnal_list->nomor_pendaftaran->LookupFilterQuery(FALSE, "list") ?>";
fjurnallist.AutoSuggests["x_nomor_pendaftaran"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $jurnal_list->nomor_pendaftaran->LookupFilterQuery(TRUE, "list"))) ?>;
fjurnallist.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_nopes","Ajax":true,"AutoFill":false,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fjurnallist.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $jurnal_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "list") ?>";
fjurnallist.AutoSuggests["x_nomor_peserta_ujian_sdmi"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $jurnal_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(TRUE, "list"))) ?>;
fjurnallist.Lists["x_persyaratan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fjurnallist.Lists["x_persyaratan"].Options = <?php echo json_encode($jurnal_list->persyaratan->Options()) ?>;

// Form object for search
var CurrentSearchForm = fjurnallistsrch = new ew_Form("fjurnallistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($jurnal->Export == "") { ?>
<div class="ewToolbar">
<?php if ($jurnal_list->TotalRecs > 0 && $jurnal_list->ExportOptions->Visible()) { ?>
<?php $jurnal_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($jurnal_list->SearchOptions->Visible()) { ?>
<?php $jurnal_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($jurnal_list->FilterOptions->Visible()) { ?>
<?php $jurnal_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $jurnal_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($jurnal_list->TotalRecs <= 0)
			$jurnal_list->TotalRecs = $jurnal->ListRecordCount();
	} else {
		if (!$jurnal_list->Recordset && ($jurnal_list->Recordset = $jurnal_list->LoadRecordset()))
			$jurnal_list->TotalRecs = $jurnal_list->Recordset->RecordCount();
	}
	$jurnal_list->StartRec = 1;
	if ($jurnal_list->DisplayRecs <= 0 || ($jurnal->Export <> "" && $jurnal->ExportAll)) // Display all records
		$jurnal_list->DisplayRecs = $jurnal_list->TotalRecs;
	if (!($jurnal->Export <> "" && $jurnal->ExportAll))
		$jurnal_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$jurnal_list->Recordset = $jurnal_list->LoadRecordset($jurnal_list->StartRec-1, $jurnal_list->DisplayRecs);

	// Set no record found message
	if ($jurnal->CurrentAction == "" && $jurnal_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$jurnal_list->setWarningMessage(ew_DeniedMsg());
		if ($jurnal_list->SearchWhere == "0=101")
			$jurnal_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$jurnal_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$jurnal_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($jurnal->Export == "" && $jurnal->CurrentAction == "") { ?>
<form name="fjurnallistsrch" id="fjurnallistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($jurnal_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fjurnallistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="jurnal">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($jurnal_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($jurnal_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $jurnal_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($jurnal_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($jurnal_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($jurnal_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($jurnal_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $jurnal_list->ShowPageHeader(); ?>
<?php
$jurnal_list->ShowMessage();
?>
<?php if ($jurnal_list->TotalRecs > 0 || $jurnal->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($jurnal_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> jurnal">
<form name="fjurnallist" id="fjurnallist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($jurnal_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $jurnal_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jurnal">
<div id="gmp_jurnal" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($jurnal_list->TotalRecs > 0 || $jurnal->CurrentAction == "gridedit") { ?>
<table id="tbl_jurnallist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$jurnal_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$jurnal_list->RenderListOptions();

// Render list options (header, left)
$jurnal_list->ListOptions->Render("header", "left");
?>
<?php if ($jurnal->nama_ruang->Visible) { // nama_ruang ?>
	<?php if ($jurnal->SortUrl($jurnal->nama_ruang) == "") { ?>
		<th data-name="nama_ruang" class="<?php echo $jurnal->nama_ruang->HeaderCellClass() ?>"><div id="elh_jurnal_nama_ruang" class="jurnal_nama_ruang"><div class="ewTableHeaderCaption"><?php echo $jurnal->nama_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ruang" class="<?php echo $jurnal->nama_ruang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->nama_ruang) ?>',1);"><div id="elh_jurnal_nama_ruang" class="jurnal_nama_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->nama_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->nama_ruang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->nama_ruang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<?php if ($jurnal->SortUrl($jurnal->nomor_pendaftaran) == "") { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $jurnal->nomor_pendaftaran->HeaderCellClass() ?>"><div id="elh_jurnal_nomor_pendaftaran" class="jurnal_nomor_pendaftaran"><div class="ewTableHeaderCaption"><?php echo $jurnal->nomor_pendaftaran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $jurnal->nomor_pendaftaran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->nomor_pendaftaran) ?>',1);"><div id="elh_jurnal_nomor_pendaftaran" class="jurnal_nomor_pendaftaran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->nomor_pendaftaran->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->nomor_pendaftaran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->nomor_pendaftaran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<?php if ($jurnal->SortUrl($jurnal->nomor_peserta_ujian_sdmi) == "") { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $jurnal->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div id="elh_jurnal_nomor_peserta_ujian_sdmi" class="jurnal_nomor_peserta_ujian_sdmi"><div class="ewTableHeaderCaption"><?php echo $jurnal->nomor_peserta_ujian_sdmi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $jurnal->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->nomor_peserta_ujian_sdmi) ?>',1);"><div id="elh_jurnal_nomor_peserta_ujian_sdmi" class="jurnal_nomor_peserta_ujian_sdmi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->nomor_peserta_ujian_sdmi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->nomor_peserta_ujian_sdmi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->sekolah_asal->Visible) { // sekolah_asal ?>
	<?php if ($jurnal->SortUrl($jurnal->sekolah_asal) == "") { ?>
		<th data-name="sekolah_asal" class="<?php echo $jurnal->sekolah_asal->HeaderCellClass() ?>"><div id="elh_jurnal_sekolah_asal" class="jurnal_sekolah_asal"><div class="ewTableHeaderCaption"><?php echo $jurnal->sekolah_asal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_asal" class="<?php echo $jurnal->sekolah_asal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->sekolah_asal) ?>',1);"><div id="elh_jurnal_sekolah_asal" class="jurnal_sekolah_asal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->sekolah_asal->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->sekolah_asal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->sekolah_asal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->nama_lengkap->Visible) { // nama_lengkap ?>
	<?php if ($jurnal->SortUrl($jurnal->nama_lengkap) == "") { ?>
		<th data-name="nama_lengkap" class="<?php echo $jurnal->nama_lengkap->HeaderCellClass() ?>"><div id="elh_jurnal_nama_lengkap" class="jurnal_nama_lengkap"><div class="ewTableHeaderCaption"><?php echo $jurnal->nama_lengkap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lengkap" class="<?php echo $jurnal->nama_lengkap->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->nama_lengkap) ?>',1);"><div id="elh_jurnal_nama_lengkap" class="jurnal_nama_lengkap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->nama_lengkap->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->nama_lengkap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->nama_lengkap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<?php if ($jurnal->SortUrl($jurnal->jenis_kelamin) == "") { ?>
		<th data-name="jenis_kelamin" class="<?php echo $jurnal->jenis_kelamin->HeaderCellClass() ?>"><div id="elh_jurnal_jenis_kelamin" class="jurnal_jenis_kelamin"><div class="ewTableHeaderCaption"><?php echo $jurnal->jenis_kelamin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_kelamin" class="<?php echo $jurnal->jenis_kelamin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->jenis_kelamin) ?>',1);"><div id="elh_jurnal_jenis_kelamin" class="jurnal_jenis_kelamin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->jenis_kelamin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->jenis_kelamin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->jenis_kelamin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->zona->Visible) { // zona ?>
	<?php if ($jurnal->SortUrl($jurnal->zona) == "") { ?>
		<th data-name="zona" class="<?php echo $jurnal->zona->HeaderCellClass() ?>"><div id="elh_jurnal_zona" class="jurnal_zona"><div class="ewTableHeaderCaption"><?php echo $jurnal->zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona" class="<?php echo $jurnal->zona->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->zona) ?>',1);"><div id="elh_jurnal_zona" class="jurnal_zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->zona->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->nilai_akhir->Visible) { // nilai_akhir ?>
	<?php if ($jurnal->SortUrl($jurnal->nilai_akhir) == "") { ?>
		<th data-name="nilai_akhir" class="<?php echo $jurnal->nilai_akhir->HeaderCellClass() ?>"><div id="elh_jurnal_nilai_akhir" class="jurnal_nilai_akhir"><div class="ewTableHeaderCaption"><?php echo $jurnal->nilai_akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai_akhir" class="<?php echo $jurnal->nilai_akhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->nilai_akhir) ?>',1);"><div id="elh_jurnal_nilai_akhir" class="jurnal_nilai_akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->nilai_akhir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->nilai_akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->nilai_akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->status->Visible) { // status ?>
	<?php if ($jurnal->SortUrl($jurnal->status) == "") { ?>
		<th data-name="status" class="<?php echo $jurnal->status->HeaderCellClass() ?>"><div id="elh_jurnal_status" class="jurnal_status"><div class="ewTableHeaderCaption"><?php echo $jurnal->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $jurnal->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->status) ?>',1);"><div id="elh_jurnal_status" class="jurnal_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->status->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->persyaratan->Visible) { // persyaratan ?>
	<?php if ($jurnal->SortUrl($jurnal->persyaratan) == "") { ?>
		<th data-name="persyaratan" class="<?php echo $jurnal->persyaratan->HeaderCellClass() ?>"><div id="elh_jurnal_persyaratan" class="jurnal_persyaratan"><div class="ewTableHeaderCaption"><?php echo $jurnal->persyaratan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="persyaratan" class="<?php echo $jurnal->persyaratan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->persyaratan) ?>',1);"><div id="elh_jurnal_persyaratan" class="jurnal_persyaratan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->persyaratan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->persyaratan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->persyaratan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jurnal->catatan->Visible) { // catatan ?>
	<?php if ($jurnal->SortUrl($jurnal->catatan) == "") { ?>
		<th data-name="catatan" class="<?php echo $jurnal->catatan->HeaderCellClass() ?>"><div id="elh_jurnal_catatan" class="jurnal_catatan"><div class="ewTableHeaderCaption"><?php echo $jurnal->catatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="catatan" class="<?php echo $jurnal->catatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $jurnal->SortUrl($jurnal->catatan) ?>',1);"><div id="elh_jurnal_catatan" class="jurnal_catatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $jurnal->catatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($jurnal->catatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($jurnal->catatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$jurnal_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($jurnal->ExportAll && $jurnal->Export <> "") {
	$jurnal_list->StopRec = $jurnal_list->TotalRecs;
} else {

	// Set the last record to display
	if ($jurnal_list->TotalRecs > $jurnal_list->StartRec + $jurnal_list->DisplayRecs - 1)
		$jurnal_list->StopRec = $jurnal_list->StartRec + $jurnal_list->DisplayRecs - 1;
	else
		$jurnal_list->StopRec = $jurnal_list->TotalRecs;
}
$jurnal_list->RecCnt = $jurnal_list->StartRec - 1;
if ($jurnal_list->Recordset && !$jurnal_list->Recordset->EOF) {
	$jurnal_list->Recordset->MoveFirst();
	$bSelectLimit = $jurnal_list->UseSelectLimit;
	if (!$bSelectLimit && $jurnal_list->StartRec > 1)
		$jurnal_list->Recordset->Move($jurnal_list->StartRec - 1);
} elseif (!$jurnal->AllowAddDeleteRow && $jurnal_list->StopRec == 0) {
	$jurnal_list->StopRec = $jurnal->GridAddRowCount;
}

// Initialize aggregate
$jurnal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$jurnal->ResetAttrs();
$jurnal_list->RenderRow();
while ($jurnal_list->RecCnt < $jurnal_list->StopRec) {
	$jurnal_list->RecCnt++;
	if (intval($jurnal_list->RecCnt) >= intval($jurnal_list->StartRec)) {
		$jurnal_list->RowCnt++;

		// Set up key count
		$jurnal_list->KeyCount = $jurnal_list->RowIndex;

		// Init row class and style
		$jurnal->ResetAttrs();
		$jurnal->CssClass = "";
		if ($jurnal->CurrentAction == "gridadd") {
		} else {
			$jurnal_list->LoadRowValues($jurnal_list->Recordset); // Load row values
		}
		$jurnal->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$jurnal->RowAttrs = array_merge($jurnal->RowAttrs, array('data-rowindex'=>$jurnal_list->RowCnt, 'id'=>'r' . $jurnal_list->RowCnt . '_jurnal', 'data-rowtype'=>$jurnal->RowType));

		// Render row
		$jurnal_list->RenderRow();

		// Render list options
		$jurnal_list->RenderListOptions();
?>
	<tr<?php echo $jurnal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$jurnal_list->ListOptions->Render("body", "left", $jurnal_list->RowCnt);
?>
	<?php if ($jurnal->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang"<?php echo $jurnal->nama_ruang->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_nama_ruang" class="jurnal_nama_ruang">
<span<?php echo $jurnal->nama_ruang->ViewAttributes() ?>>
<?php echo $jurnal->nama_ruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran"<?php echo $jurnal->nomor_pendaftaran->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_nomor_pendaftaran" class="jurnal_nomor_pendaftaran">
<span<?php echo $jurnal->nomor_pendaftaran->ViewAttributes() ?>>
<?php echo $jurnal->nomor_pendaftaran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi"<?php echo $jurnal->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_nomor_peserta_ujian_sdmi" class="jurnal_nomor_peserta_ujian_sdmi">
<span<?php echo $jurnal->nomor_peserta_ujian_sdmi->ViewAttributes() ?>>
<?php echo $jurnal->nomor_peserta_ujian_sdmi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal"<?php echo $jurnal->sekolah_asal->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_sekolah_asal" class="jurnal_sekolah_asal">
<span<?php echo $jurnal->sekolah_asal->ViewAttributes() ?>>
<?php echo $jurnal->sekolah_asal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap"<?php echo $jurnal->nama_lengkap->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_nama_lengkap" class="jurnal_nama_lengkap">
<span<?php echo $jurnal->nama_lengkap->ViewAttributes() ?>>
<?php echo $jurnal->nama_lengkap->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin"<?php echo $jurnal->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_jenis_kelamin" class="jurnal_jenis_kelamin">
<span<?php echo $jurnal->jenis_kelamin->ViewAttributes() ?>>
<?php echo $jurnal->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->zona->Visible) { // zona ?>
		<td data-name="zona"<?php echo $jurnal->zona->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_zona" class="jurnal_zona">
<span<?php echo $jurnal->zona->ViewAttributes() ?>>
<?php echo $jurnal->zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir"<?php echo $jurnal->nilai_akhir->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_nilai_akhir" class="jurnal_nilai_akhir">
<span<?php echo $jurnal->nilai_akhir->ViewAttributes() ?>>
<?php echo $jurnal->nilai_akhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->status->Visible) { // status ?>
		<td data-name="status"<?php echo $jurnal->status->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_status" class="jurnal_status">
<span<?php echo $jurnal->status->ViewAttributes() ?>>
<?php echo $jurnal->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan"<?php echo $jurnal->persyaratan->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_persyaratan" class="jurnal_persyaratan">
<span<?php echo $jurnal->persyaratan->ViewAttributes() ?>>
<?php echo $jurnal->persyaratan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jurnal->catatan->Visible) { // catatan ?>
		<td data-name="catatan"<?php echo $jurnal->catatan->CellAttributes() ?>>
<span id="el<?php echo $jurnal_list->RowCnt ?>_jurnal_catatan" class="jurnal_catatan">
<span<?php echo $jurnal->catatan->ViewAttributes() ?>>
<?php echo $jurnal->catatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$jurnal_list->ListOptions->Render("body", "right", $jurnal_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($jurnal->CurrentAction <> "gridadd")
		$jurnal_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$jurnal->RowType = EW_ROWTYPE_AGGREGATE;
$jurnal->ResetAttrs();
$jurnal_list->RenderRow();
?>
<?php if ($jurnal_list->TotalRecs > 0 && ($jurnal->CurrentAction <> "gridadd" && $jurnal->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$jurnal_list->RenderListOptions();

// Render list options (footer, left)
$jurnal_list->ListOptions->Render("footer", "left");
?>
	<?php if ($jurnal->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang" class="<?php echo $jurnal->nama_ruang->FooterCellClass() ?>"><span id="elf_jurnal_nama_ruang" class="jurnal_nama_ruang">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran" class="<?php echo $jurnal->nomor_pendaftaran->FooterCellClass() ?>"><span id="elf_jurnal_nomor_pendaftaran" class="jurnal_nomor_pendaftaran">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi" class="<?php echo $jurnal->nomor_peserta_ujian_sdmi->FooterCellClass() ?>"><span id="elf_jurnal_nomor_peserta_ujian_sdmi" class="jurnal_nomor_peserta_ujian_sdmi">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal" class="<?php echo $jurnal->sekolah_asal->FooterCellClass() ?>"><span id="elf_jurnal_sekolah_asal" class="jurnal_sekolah_asal">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap" class="<?php echo $jurnal->nama_lengkap->FooterCellClass() ?>"><span id="elf_jurnal_nama_lengkap" class="jurnal_nama_lengkap">
<span class="ewAggregate"><?php echo $Language->Phrase("COUNT") ?></span><span class="ewAggregateValue">
<?php echo $jurnal->nama_lengkap->ViewValue ?></span>
		</span></td>
	<?php } ?>
	<?php if ($jurnal->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin" class="<?php echo $jurnal->jenis_kelamin->FooterCellClass() ?>"><span id="elf_jurnal_jenis_kelamin" class="jurnal_jenis_kelamin">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->zona->Visible) { // zona ?>
		<td data-name="zona" class="<?php echo $jurnal->zona->FooterCellClass() ?>"><span id="elf_jurnal_zona" class="jurnal_zona">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir" class="<?php echo $jurnal->nilai_akhir->FooterCellClass() ?>"><span id="elf_jurnal_nilai_akhir" class="jurnal_nilai_akhir">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->status->Visible) { // status ?>
		<td data-name="status" class="<?php echo $jurnal->status->FooterCellClass() ?>"><span id="elf_jurnal_status" class="jurnal_status">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan" class="<?php echo $jurnal->persyaratan->FooterCellClass() ?>"><span id="elf_jurnal_persyaratan" class="jurnal_persyaratan">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($jurnal->catatan->Visible) { // catatan ?>
		<td data-name="catatan" class="<?php echo $jurnal->catatan->FooterCellClass() ?>"><span id="elf_jurnal_catatan" class="jurnal_catatan">
		&nbsp;
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$jurnal_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>
<?php } ?>
</table>
<?php } ?>
<?php if ($jurnal->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($jurnal_list->Recordset)
	$jurnal_list->Recordset->Close();
?>
<?php if ($jurnal->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($jurnal->CurrentAction <> "gridadd" && $jurnal->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($jurnal_list->Pager)) $jurnal_list->Pager = new cPrevNextPager($jurnal_list->StartRec, $jurnal_list->DisplayRecs, $jurnal_list->TotalRecs, $jurnal_list->AutoHidePager) ?>
<?php if ($jurnal_list->Pager->RecordCount > 0 && $jurnal_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($jurnal_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $jurnal_list->PageUrl() ?>start=<?php echo $jurnal_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($jurnal_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $jurnal_list->PageUrl() ?>start=<?php echo $jurnal_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $jurnal_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($jurnal_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $jurnal_list->PageUrl() ?>start=<?php echo $jurnal_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($jurnal_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $jurnal_list->PageUrl() ?>start=<?php echo $jurnal_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $jurnal_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $jurnal_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $jurnal_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $jurnal_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($jurnal_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($jurnal_list->TotalRecs == 0 && $jurnal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($jurnal_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($jurnal->Export == "") { ?>
<script type="text/javascript">
fjurnallistsrch.FilterList = <?php echo $jurnal_list->GetFilterList() ?>;
fjurnallistsrch.Init();
fjurnallist.Init();
</script>
<?php } ?>
<?php
$jurnal_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($jurnal->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$jurnal_list->Page_Terminate();
?>
