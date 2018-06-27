<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "bukti_pendaftaraninfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "no_pendaftaraninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$bukti_pendaftaran_list = NULL; // Initialize page object first

class cbukti_pendaftaran_list extends cbukti_pendaftaran {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'bukti_pendaftaran';

	// Page object name
	var $PageObjName = 'bukti_pendaftaran_list';

	// Grid form hidden field names
	var $FormName = 'fbukti_pendaftaranlist';
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

		// Table object (bukti_pendaftaran)
		if (!isset($GLOBALS["bukti_pendaftaran"]) || get_class($GLOBALS["bukti_pendaftaran"]) == "cbukti_pendaftaran") {
			$GLOBALS["bukti_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["bukti_pendaftaran"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "bukti_pendaftaranadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "bukti_pendaftarandelete.php";
		$this->MultiUpdateUrl = "bukti_pendaftaranupdate.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bukti_pendaftaran', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fbukti_pendaftaranlistsrch";

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
		$this->nama_lengkap->SetVisibility();
		$this->nisn->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->sekolah_asal->SetVisibility();
		$this->alamat->SetVisibility();
		$this->zona->SetVisibility();
		$this->nilai_akhir->SetVisibility();
		$this->nama_ayah->SetVisibility();
		$this->nama_ibu->SetVisibility();
		$this->nama_wali->SetVisibility();
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
		global $EW_EXPORT, $bukti_pendaftaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($bukti_pendaftaran);
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
	var $DisplayRecs = 40;
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
			$this->DisplayRecs = 40; // Load default
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
					$this->DisplayRecs = 40; // Non-numeric, load default
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
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fbukti_pendaftaranlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->nama_ruang->AdvancedSearch->ToJson(), ","); // Field nama_ruang
		$sFilterList = ew_Concat($sFilterList, $this->nomor_pendaftaran->AdvancedSearch->ToJson(), ","); // Field nomor_pendaftaran
		$sFilterList = ew_Concat($sFilterList, $this->nomor_peserta_ujian_sdmi->AdvancedSearch->ToJson(), ","); // Field nomor_peserta_ujian_sdmi
		$sFilterList = ew_Concat($sFilterList, $this->nama_lengkap->AdvancedSearch->ToJson(), ","); // Field nama_lengkap
		$sFilterList = ew_Concat($sFilterList, $this->nisn->AdvancedSearch->ToJson(), ","); // Field nisn
		$sFilterList = ew_Concat($sFilterList, $this->tempat_lahir->AdvancedSearch->ToJson(), ","); // Field tempat_lahir
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_lahir->AdvancedSearch->ToJson(), ","); // Field tanggal_lahir
		$sFilterList = ew_Concat($sFilterList, $this->jenis_kelamin->AdvancedSearch->ToJson(), ","); // Field jenis_kelamin
		$sFilterList = ew_Concat($sFilterList, $this->sekolah_asal->AdvancedSearch->ToJson(), ","); // Field sekolah_asal
		$sFilterList = ew_Concat($sFilterList, $this->alamat->AdvancedSearch->ToJson(), ","); // Field alamat
		$sFilterList = ew_Concat($sFilterList, $this->zona->AdvancedSearch->ToJson(), ","); // Field zona
		$sFilterList = ew_Concat($sFilterList, $this->nilai_akhir->AdvancedSearch->ToJson(), ","); // Field nilai_akhir
		$sFilterList = ew_Concat($sFilterList, $this->nama_ayah->AdvancedSearch->ToJson(), ","); // Field nama_ayah
		$sFilterList = ew_Concat($sFilterList, $this->nama_ibu->AdvancedSearch->ToJson(), ","); // Field nama_ibu
		$sFilterList = ew_Concat($sFilterList, $this->nama_wali->AdvancedSearch->ToJson(), ","); // Field nama_wali
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fbukti_pendaftaranlistsrch", $filters);

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

		// Field nama_lengkap
		$this->nama_lengkap->AdvancedSearch->SearchValue = @$filter["x_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchOperator = @$filter["z_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchCondition = @$filter["v_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchValue2 = @$filter["y_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->SearchOperator2 = @$filter["w_nama_lengkap"];
		$this->nama_lengkap->AdvancedSearch->Save();

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

		// Field sekolah_asal
		$this->sekolah_asal->AdvancedSearch->SearchValue = @$filter["x_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchOperator = @$filter["z_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchCondition = @$filter["v_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchValue2 = @$filter["y_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->SearchOperator2 = @$filter["w_sekolah_asal"];
		$this->sekolah_asal->AdvancedSearch->Save();

		// Field alamat
		$this->alamat->AdvancedSearch->SearchValue = @$filter["x_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator = @$filter["z_alamat"];
		$this->alamat->AdvancedSearch->SearchCondition = @$filter["v_alamat"];
		$this->alamat->AdvancedSearch->SearchValue2 = @$filter["y_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator2 = @$filter["w_alamat"];
		$this->alamat->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lengkap, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nisn, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tempat_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jenis_kelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->sekolah_asal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->zona, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nilai_akhir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ayah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ibu, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_wali, $arKeywords, $type);
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
			$this->UpdateSort($this->nama_lengkap); // nama_lengkap
			$this->UpdateSort($this->nisn); // nisn
			$this->UpdateSort($this->tempat_lahir); // tempat_lahir
			$this->UpdateSort($this->tanggal_lahir); // tanggal_lahir
			$this->UpdateSort($this->jenis_kelamin); // jenis_kelamin
			$this->UpdateSort($this->sekolah_asal); // sekolah_asal
			$this->UpdateSort($this->alamat); // alamat
			$this->UpdateSort($this->zona); // zona
			$this->UpdateSort($this->nilai_akhir); // nilai_akhir
			$this->UpdateSort($this->nama_ayah); // nama_ayah
			$this->UpdateSort($this->nama_ibu); // nama_ibu
			$this->UpdateSort($this->nama_wali); // nama_wali
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
				$this->nama_lengkap->setSort("");
				$this->nisn->setSort("");
				$this->tempat_lahir->setSort("");
				$this->tanggal_lahir->setSort("");
				$this->jenis_kelamin->setSort("");
				$this->sekolah_asal->setSort("");
				$this->alamat->setSort("");
				$this->zona->setSort("");
				$this->nilai_akhir->setSort("");
				$this->nama_ayah->setSort("");
				$this->nama_ibu->setSort("");
				$this->nama_wali->setSort("");
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
		$this->ListOptions->UseDropDownButton = TRUE;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fbukti_pendaftaranlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fbukti_pendaftaranlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fbukti_pendaftaranlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fbukti_pendaftaranlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->nama_ruang->setDbValue($row['nama_ruang']);
		$this->nomor_pendaftaran->setDbValue($row['nomor_pendaftaran']);
		$this->nomor_peserta_ujian_sdmi->setDbValue($row['nomor_peserta_ujian_sdmi']);
		if (array_key_exists('EV__nomor_peserta_ujian_sdmi', $rs->fields)) {
			$this->nomor_peserta_ujian_sdmi->VirtualValue = $rs->fields('EV__nomor_peserta_ujian_sdmi'); // Set up virtual field value
		} else {
			$this->nomor_peserta_ujian_sdmi->VirtualValue = ""; // Clear value
		}
		$this->nama_lengkap->setDbValue($row['nama_lengkap']);
		$this->nisn->setDbValue($row['nisn']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->sekolah_asal->setDbValue($row['sekolah_asal']);
		$this->alamat->setDbValue($row['alamat']);
		$this->zona->setDbValue($row['zona']);
		$this->nilai_akhir->setDbValue($row['nilai_akhir']);
		$this->nama_ayah->setDbValue($row['nama_ayah']);
		$this->nama_ibu->setDbValue($row['nama_ibu']);
		$this->nama_wali->setDbValue($row['nama_wali']);
		$this->persyaratan->setDbValue($row['persyaratan']);
		$this->catatan->setDbValue($row['catatan']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['nama_ruang'] = NULL;
		$row['nomor_pendaftaran'] = NULL;
		$row['nomor_peserta_ujian_sdmi'] = NULL;
		$row['nama_lengkap'] = NULL;
		$row['nisn'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['sekolah_asal'] = NULL;
		$row['alamat'] = NULL;
		$row['zona'] = NULL;
		$row['nilai_akhir'] = NULL;
		$row['nama_ayah'] = NULL;
		$row['nama_ibu'] = NULL;
		$row['nama_wali'] = NULL;
		$row['persyaratan'] = NULL;
		$row['catatan'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->nama_ruang->DbValue = $row['nama_ruang'];
		$this->nomor_pendaftaran->DbValue = $row['nomor_pendaftaran'];
		$this->nomor_peserta_ujian_sdmi->DbValue = $row['nomor_peserta_ujian_sdmi'];
		$this->nama_lengkap->DbValue = $row['nama_lengkap'];
		$this->nisn->DbValue = $row['nisn'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->sekolah_asal->DbValue = $row['sekolah_asal'];
		$this->alamat->DbValue = $row['alamat'];
		$this->zona->DbValue = $row['zona'];
		$this->nilai_akhir->DbValue = $row['nilai_akhir'];
		$this->nama_ayah->DbValue = $row['nama_ayah'];
		$this->nama_ibu->DbValue = $row['nama_ibu'];
		$this->nama_wali->DbValue = $row['nama_wali'];
		$this->persyaratan->DbValue = $row['persyaratan'];
		$this->catatan->DbValue = $row['catatan'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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
		// nama_ruang
		// nomor_pendaftaran
		// nomor_peserta_ujian_sdmi
		// nama_lengkap
		// nisn
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// sekolah_asal
		// alamat
		// zona
		// nilai_akhir
		// nama_ayah
		// nama_ibu
		// nama_wali
		// persyaratan
		// catatan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

		// nama_lengkap
		$this->nama_lengkap->ViewValue = $this->nama_lengkap->CurrentValue;
		$this->nama_lengkap->ViewCustomAttributes = "";

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
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// sekolah_asal
		$this->sekolah_asal->ViewValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->CellCssStyle .= "text-align: center;";
		$this->zona->ViewCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->ViewValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->CellCssStyle .= "text-align: center;";
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

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";
			$this->nama_lengkap->TooltipValue = "";

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

			// sekolah_asal
			$this->sekolah_asal->LinkCustomAttributes = "";
			$this->sekolah_asal->HrefValue = "";
			$this->sekolah_asal->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// zona
			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";
			$this->zona->TooltipValue = "";

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

			// persyaratan
			$this->persyaratan->LinkCustomAttributes = "";
			$this->persyaratan->HrefValue = "";
			$this->persyaratan->TooltipValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";
			$this->catatan->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_bukti_pendaftaran\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_bukti_pendaftaran',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fbukti_pendaftaranlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
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
if (!isset($bukti_pendaftaran_list)) $bukti_pendaftaran_list = new cbukti_pendaftaran_list();

// Page init
$bukti_pendaftaran_list->Page_Init();

// Page main
$bukti_pendaftaran_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bukti_pendaftaran_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($bukti_pendaftaran->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fbukti_pendaftaranlist = new ew_Form("fbukti_pendaftaranlist", "list");
fbukti_pendaftaranlist.FormKeyCountName = '<?php echo $bukti_pendaftaran_list->FormKeyCountName ?>';

// Form_CustomValidate event
fbukti_pendaftaranlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fbukti_pendaftaranlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fbukti_pendaftaranlist.Lists["x_nama_ruang"] = {"LinkField":"x_nama_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fbukti_pendaftaranlist.Lists["x_nama_ruang"].Data = "<?php echo $bukti_pendaftaran_list->nama_ruang->LookupFilterQuery(FALSE, "list") ?>";
fbukti_pendaftaranlist.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_nomor_pendaftaran","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fbukti_pendaftaranlist.Lists["x_nomor_pendaftaran"].Data = "<?php echo $bukti_pendaftaran_list->nomor_pendaftaran->LookupFilterQuery(FALSE, "list") ?>";
fbukti_pendaftaranlist.AutoSuggests["x_nomor_pendaftaran"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $bukti_pendaftaran_list->nomor_pendaftaran->LookupFilterQuery(TRUE, "list"))) ?>;
fbukti_pendaftaranlist.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_nopes","Ajax":true,"AutoFill":false,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fbukti_pendaftaranlist.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $bukti_pendaftaran_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "list") ?>";
fbukti_pendaftaranlist.AutoSuggests["x_nomor_peserta_ujian_sdmi"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $bukti_pendaftaran_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(TRUE, "list"))) ?>;
fbukti_pendaftaranlist.Lists["x_persyaratan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbukti_pendaftaranlist.Lists["x_persyaratan"].Options = <?php echo json_encode($bukti_pendaftaran_list->persyaratan->Options()) ?>;

// Form object for search
var CurrentSearchForm = fbukti_pendaftaranlistsrch = new ew_Form("fbukti_pendaftaranlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($bukti_pendaftaran->Export == "") { ?>
<div class="ewToolbar">
<?php if ($bukti_pendaftaran_list->TotalRecs > 0 && $bukti_pendaftaran_list->ExportOptions->Visible()) { ?>
<?php $bukti_pendaftaran_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($bukti_pendaftaran_list->SearchOptions->Visible()) { ?>
<?php $bukti_pendaftaran_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($bukti_pendaftaran_list->FilterOptions->Visible()) { ?>
<?php $bukti_pendaftaran_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $bukti_pendaftaran_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($bukti_pendaftaran_list->TotalRecs <= 0)
			$bukti_pendaftaran_list->TotalRecs = $bukti_pendaftaran->ListRecordCount();
	} else {
		if (!$bukti_pendaftaran_list->Recordset && ($bukti_pendaftaran_list->Recordset = $bukti_pendaftaran_list->LoadRecordset()))
			$bukti_pendaftaran_list->TotalRecs = $bukti_pendaftaran_list->Recordset->RecordCount();
	}
	$bukti_pendaftaran_list->StartRec = 1;
	if ($bukti_pendaftaran_list->DisplayRecs <= 0 || ($bukti_pendaftaran->Export <> "" && $bukti_pendaftaran->ExportAll)) // Display all records
		$bukti_pendaftaran_list->DisplayRecs = $bukti_pendaftaran_list->TotalRecs;
	if (!($bukti_pendaftaran->Export <> "" && $bukti_pendaftaran->ExportAll))
		$bukti_pendaftaran_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$bukti_pendaftaran_list->Recordset = $bukti_pendaftaran_list->LoadRecordset($bukti_pendaftaran_list->StartRec-1, $bukti_pendaftaran_list->DisplayRecs);

	// Set no record found message
	if ($bukti_pendaftaran->CurrentAction == "" && $bukti_pendaftaran_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$bukti_pendaftaran_list->setWarningMessage(ew_DeniedMsg());
		if ($bukti_pendaftaran_list->SearchWhere == "0=101")
			$bukti_pendaftaran_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$bukti_pendaftaran_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$bukti_pendaftaran_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($bukti_pendaftaran->Export == "" && $bukti_pendaftaran->CurrentAction == "") { ?>
<form name="fbukti_pendaftaranlistsrch" id="fbukti_pendaftaranlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($bukti_pendaftaran_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fbukti_pendaftaranlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="bukti_pendaftaran">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($bukti_pendaftaran_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($bukti_pendaftaran_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $bukti_pendaftaran_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($bukti_pendaftaran_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($bukti_pendaftaran_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($bukti_pendaftaran_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($bukti_pendaftaran_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $bukti_pendaftaran_list->ShowPageHeader(); ?>
<?php
$bukti_pendaftaran_list->ShowMessage();
?>
<?php if ($bukti_pendaftaran_list->TotalRecs > 0 || $bukti_pendaftaran->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($bukti_pendaftaran_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> bukti_pendaftaran">
<form name="fbukti_pendaftaranlist" id="fbukti_pendaftaranlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($bukti_pendaftaran_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $bukti_pendaftaran_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="bukti_pendaftaran">
<div id="gmp_bukti_pendaftaran" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($bukti_pendaftaran_list->TotalRecs > 0 || $bukti_pendaftaran->CurrentAction == "gridedit") { ?>
<table id="tbl_bukti_pendaftaranlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$bukti_pendaftaran_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$bukti_pendaftaran_list->RenderListOptions();

// Render list options (header, left)
$bukti_pendaftaran_list->ListOptions->Render("header", "left");
?>
<?php if ($bukti_pendaftaran->nama_ruang->Visible) { // nama_ruang ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ruang) == "") { ?>
		<th data-name="nama_ruang" class="<?php echo $bukti_pendaftaran->nama_ruang->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nama_ruang" class="bukti_pendaftaran_nama_ruang"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ruang" class="<?php echo $bukti_pendaftaran->nama_ruang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ruang) ?>',1);"><div id="elh_bukti_pendaftaran_nama_ruang" class="bukti_pendaftaran_nama_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nama_ruang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nama_ruang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nomor_pendaftaran) == "") { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $bukti_pendaftaran->nomor_pendaftaran->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nomor_pendaftaran" class="bukti_pendaftaran_nomor_pendaftaran"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nomor_pendaftaran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $bukti_pendaftaran->nomor_pendaftaran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nomor_pendaftaran) ?>',1);"><div id="elh_bukti_pendaftaran_nomor_pendaftaran" class="bukti_pendaftaran_nomor_pendaftaran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nomor_pendaftaran->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nomor_pendaftaran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nomor_pendaftaran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nomor_peserta_ujian_sdmi) == "") { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nomor_peserta_ujian_sdmi" class="bukti_pendaftaran_nomor_peserta_ujian_sdmi"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nomor_peserta_ujian_sdmi) ?>',1);"><div id="elh_bukti_pendaftaran_nomor_peserta_ujian_sdmi" class="bukti_pendaftaran_nomor_peserta_ujian_sdmi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nomor_peserta_ujian_sdmi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nomor_peserta_ujian_sdmi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nama_lengkap->Visible) { // nama_lengkap ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_lengkap) == "") { ?>
		<th data-name="nama_lengkap" class="<?php echo $bukti_pendaftaran->nama_lengkap->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nama_lengkap" class="bukti_pendaftaran_nama_lengkap"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_lengkap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lengkap" class="<?php echo $bukti_pendaftaran->nama_lengkap->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_lengkap) ?>',1);"><div id="elh_bukti_pendaftaran_nama_lengkap" class="bukti_pendaftaran_nama_lengkap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_lengkap->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nama_lengkap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nama_lengkap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nisn->Visible) { // nisn ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nisn) == "") { ?>
		<th data-name="nisn" class="<?php echo $bukti_pendaftaran->nisn->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nisn" class="bukti_pendaftaran_nisn"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nisn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nisn" class="<?php echo $bukti_pendaftaran->nisn->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nisn) ?>',1);"><div id="elh_bukti_pendaftaran_nisn" class="bukti_pendaftaran_nisn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nisn->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nisn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nisn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->tempat_lahir->Visible) { // tempat_lahir ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->tempat_lahir) == "") { ?>
		<th data-name="tempat_lahir" class="<?php echo $bukti_pendaftaran->tempat_lahir->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_tempat_lahir" class="bukti_pendaftaran_tempat_lahir"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->tempat_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tempat_lahir" class="<?php echo $bukti_pendaftaran->tempat_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->tempat_lahir) ?>',1);"><div id="elh_bukti_pendaftaran_tempat_lahir" class="bukti_pendaftaran_tempat_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->tempat_lahir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->tempat_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->tempat_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->tanggal_lahir) == "") { ?>
		<th data-name="tanggal_lahir" class="<?php echo $bukti_pendaftaran->tanggal_lahir->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_tanggal_lahir" class="bukti_pendaftaran_tanggal_lahir"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->tanggal_lahir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal_lahir" class="<?php echo $bukti_pendaftaran->tanggal_lahir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->tanggal_lahir) ?>',1);"><div id="elh_bukti_pendaftaran_tanggal_lahir" class="bukti_pendaftaran_tanggal_lahir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->tanggal_lahir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->tanggal_lahir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->tanggal_lahir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->jenis_kelamin) == "") { ?>
		<th data-name="jenis_kelamin" class="<?php echo $bukti_pendaftaran->jenis_kelamin->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_jenis_kelamin" class="bukti_pendaftaran_jenis_kelamin"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->jenis_kelamin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_kelamin" class="<?php echo $bukti_pendaftaran->jenis_kelamin->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->jenis_kelamin) ?>',1);"><div id="elh_bukti_pendaftaran_jenis_kelamin" class="bukti_pendaftaran_jenis_kelamin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->jenis_kelamin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->jenis_kelamin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->jenis_kelamin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->sekolah_asal->Visible) { // sekolah_asal ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->sekolah_asal) == "") { ?>
		<th data-name="sekolah_asal" class="<?php echo $bukti_pendaftaran->sekolah_asal->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_sekolah_asal" class="bukti_pendaftaran_sekolah_asal"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->sekolah_asal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_asal" class="<?php echo $bukti_pendaftaran->sekolah_asal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->sekolah_asal) ?>',1);"><div id="elh_bukti_pendaftaran_sekolah_asal" class="bukti_pendaftaran_sekolah_asal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->sekolah_asal->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->sekolah_asal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->sekolah_asal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->alamat->Visible) { // alamat ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->alamat) == "") { ?>
		<th data-name="alamat" class="<?php echo $bukti_pendaftaran->alamat->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_alamat" class="bukti_pendaftaran_alamat"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alamat" class="<?php echo $bukti_pendaftaran->alamat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->alamat) ?>',1);"><div id="elh_bukti_pendaftaran_alamat" class="bukti_pendaftaran_alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->alamat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->alamat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->alamat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->zona->Visible) { // zona ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->zona) == "") { ?>
		<th data-name="zona" class="<?php echo $bukti_pendaftaran->zona->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_zona" class="bukti_pendaftaran_zona"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona" class="<?php echo $bukti_pendaftaran->zona->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->zona) ?>',1);"><div id="elh_bukti_pendaftaran_zona" class="bukti_pendaftaran_zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->zona->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nilai_akhir->Visible) { // nilai_akhir ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nilai_akhir) == "") { ?>
		<th data-name="nilai_akhir" class="<?php echo $bukti_pendaftaran->nilai_akhir->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nilai_akhir" class="bukti_pendaftaran_nilai_akhir"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nilai_akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai_akhir" class="<?php echo $bukti_pendaftaran->nilai_akhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nilai_akhir) ?>',1);"><div id="elh_bukti_pendaftaran_nilai_akhir" class="bukti_pendaftaran_nilai_akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nilai_akhir->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nilai_akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nilai_akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nama_ayah->Visible) { // nama_ayah ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ayah) == "") { ?>
		<th data-name="nama_ayah" class="<?php echo $bukti_pendaftaran->nama_ayah->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nama_ayah" class="bukti_pendaftaran_nama_ayah"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ayah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ayah" class="<?php echo $bukti_pendaftaran->nama_ayah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ayah) ?>',1);"><div id="elh_bukti_pendaftaran_nama_ayah" class="bukti_pendaftaran_nama_ayah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ayah->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nama_ayah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nama_ayah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nama_ibu->Visible) { // nama_ibu ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ibu) == "") { ?>
		<th data-name="nama_ibu" class="<?php echo $bukti_pendaftaran->nama_ibu->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nama_ibu" class="bukti_pendaftaran_nama_ibu"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ibu->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ibu" class="<?php echo $bukti_pendaftaran->nama_ibu->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_ibu) ?>',1);"><div id="elh_bukti_pendaftaran_nama_ibu" class="bukti_pendaftaran_nama_ibu">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_ibu->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nama_ibu->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nama_ibu->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->nama_wali->Visible) { // nama_wali ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_wali) == "") { ?>
		<th data-name="nama_wali" class="<?php echo $bukti_pendaftaran->nama_wali->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_nama_wali" class="bukti_pendaftaran_nama_wali"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_wali->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_wali" class="<?php echo $bukti_pendaftaran->nama_wali->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->nama_wali) ?>',1);"><div id="elh_bukti_pendaftaran_nama_wali" class="bukti_pendaftaran_nama_wali">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->nama_wali->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->nama_wali->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->nama_wali->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->persyaratan->Visible) { // persyaratan ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->persyaratan) == "") { ?>
		<th data-name="persyaratan" class="<?php echo $bukti_pendaftaran->persyaratan->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_persyaratan" class="bukti_pendaftaran_persyaratan"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->persyaratan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="persyaratan" class="<?php echo $bukti_pendaftaran->persyaratan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->persyaratan) ?>',1);"><div id="elh_bukti_pendaftaran_persyaratan" class="bukti_pendaftaran_persyaratan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->persyaratan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->persyaratan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->persyaratan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($bukti_pendaftaran->catatan->Visible) { // catatan ?>
	<?php if ($bukti_pendaftaran->SortUrl($bukti_pendaftaran->catatan) == "") { ?>
		<th data-name="catatan" class="<?php echo $bukti_pendaftaran->catatan->HeaderCellClass() ?>"><div id="elh_bukti_pendaftaran_catatan" class="bukti_pendaftaran_catatan"><div class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->catatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="catatan" class="<?php echo $bukti_pendaftaran->catatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bukti_pendaftaran->SortUrl($bukti_pendaftaran->catatan) ?>',1);"><div id="elh_bukti_pendaftaran_catatan" class="bukti_pendaftaran_catatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bukti_pendaftaran->catatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bukti_pendaftaran->catatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bukti_pendaftaran->catatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$bukti_pendaftaran_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($bukti_pendaftaran->ExportAll && $bukti_pendaftaran->Export <> "") {
	$bukti_pendaftaran_list->StopRec = $bukti_pendaftaran_list->TotalRecs;
} else {

	// Set the last record to display
	if ($bukti_pendaftaran_list->TotalRecs > $bukti_pendaftaran_list->StartRec + $bukti_pendaftaran_list->DisplayRecs - 1)
		$bukti_pendaftaran_list->StopRec = $bukti_pendaftaran_list->StartRec + $bukti_pendaftaran_list->DisplayRecs - 1;
	else
		$bukti_pendaftaran_list->StopRec = $bukti_pendaftaran_list->TotalRecs;
}
$bukti_pendaftaran_list->RecCnt = $bukti_pendaftaran_list->StartRec - 1;
if ($bukti_pendaftaran_list->Recordset && !$bukti_pendaftaran_list->Recordset->EOF) {
	$bukti_pendaftaran_list->Recordset->MoveFirst();
	$bSelectLimit = $bukti_pendaftaran_list->UseSelectLimit;
	if (!$bSelectLimit && $bukti_pendaftaran_list->StartRec > 1)
		$bukti_pendaftaran_list->Recordset->Move($bukti_pendaftaran_list->StartRec - 1);
} elseif (!$bukti_pendaftaran->AllowAddDeleteRow && $bukti_pendaftaran_list->StopRec == 0) {
	$bukti_pendaftaran_list->StopRec = $bukti_pendaftaran->GridAddRowCount;
}

// Initialize aggregate
$bukti_pendaftaran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$bukti_pendaftaran->ResetAttrs();
$bukti_pendaftaran_list->RenderRow();
while ($bukti_pendaftaran_list->RecCnt < $bukti_pendaftaran_list->StopRec) {
	$bukti_pendaftaran_list->RecCnt++;
	if (intval($bukti_pendaftaran_list->RecCnt) >= intval($bukti_pendaftaran_list->StartRec)) {
		$bukti_pendaftaran_list->RowCnt++;

		// Set up key count
		$bukti_pendaftaran_list->KeyCount = $bukti_pendaftaran_list->RowIndex;

		// Init row class and style
		$bukti_pendaftaran->ResetAttrs();
		$bukti_pendaftaran->CssClass = "";
		if ($bukti_pendaftaran->CurrentAction == "gridadd") {
		} else {
			$bukti_pendaftaran_list->LoadRowValues($bukti_pendaftaran_list->Recordset); // Load row values
		}
		$bukti_pendaftaran->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$bukti_pendaftaran->RowAttrs = array_merge($bukti_pendaftaran->RowAttrs, array('data-rowindex'=>$bukti_pendaftaran_list->RowCnt, 'id'=>'r' . $bukti_pendaftaran_list->RowCnt . '_bukti_pendaftaran', 'data-rowtype'=>$bukti_pendaftaran->RowType));

		// Render row
		$bukti_pendaftaran_list->RenderRow();

		// Render list options
		$bukti_pendaftaran_list->RenderListOptions();
?>
	<tr<?php echo $bukti_pendaftaran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$bukti_pendaftaran_list->ListOptions->Render("body", "left", $bukti_pendaftaran_list->RowCnt);
?>
	<?php if ($bukti_pendaftaran->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang"<?php echo $bukti_pendaftaran->nama_ruang->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nama_ruang" class="bukti_pendaftaran_nama_ruang">
<span<?php echo $bukti_pendaftaran->nama_ruang->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nama_ruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran"<?php echo $bukti_pendaftaran->nomor_pendaftaran->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nomor_pendaftaran" class="bukti_pendaftaran_nomor_pendaftaran">
<span<?php echo $bukti_pendaftaran->nomor_pendaftaran->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nomor_pendaftaran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi"<?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nomor_peserta_ujian_sdmi" class="bukti_pendaftaran_nomor_peserta_ujian_sdmi">
<span<?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nomor_peserta_ujian_sdmi->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap"<?php echo $bukti_pendaftaran->nama_lengkap->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nama_lengkap" class="bukti_pendaftaran_nama_lengkap">
<span<?php echo $bukti_pendaftaran->nama_lengkap->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nama_lengkap->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nisn->Visible) { // nisn ?>
		<td data-name="nisn"<?php echo $bukti_pendaftaran->nisn->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nisn" class="bukti_pendaftaran_nisn">
<span<?php echo $bukti_pendaftaran->nisn->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nisn->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->tempat_lahir->Visible) { // tempat_lahir ?>
		<td data-name="tempat_lahir"<?php echo $bukti_pendaftaran->tempat_lahir->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_tempat_lahir" class="bukti_pendaftaran_tempat_lahir">
<span<?php echo $bukti_pendaftaran->tempat_lahir->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->tempat_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->tanggal_lahir->Visible) { // tanggal_lahir ?>
		<td data-name="tanggal_lahir"<?php echo $bukti_pendaftaran->tanggal_lahir->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_tanggal_lahir" class="bukti_pendaftaran_tanggal_lahir">
<span<?php echo $bukti_pendaftaran->tanggal_lahir->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->tanggal_lahir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->jenis_kelamin->Visible) { // jenis_kelamin ?>
		<td data-name="jenis_kelamin"<?php echo $bukti_pendaftaran->jenis_kelamin->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_jenis_kelamin" class="bukti_pendaftaran_jenis_kelamin">
<span<?php echo $bukti_pendaftaran->jenis_kelamin->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->jenis_kelamin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal"<?php echo $bukti_pendaftaran->sekolah_asal->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_sekolah_asal" class="bukti_pendaftaran_sekolah_asal">
<span<?php echo $bukti_pendaftaran->sekolah_asal->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->sekolah_asal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->alamat->Visible) { // alamat ?>
		<td data-name="alamat"<?php echo $bukti_pendaftaran->alamat->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_alamat" class="bukti_pendaftaran_alamat">
<span<?php echo $bukti_pendaftaran->alamat->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->zona->Visible) { // zona ?>
		<td data-name="zona"<?php echo $bukti_pendaftaran->zona->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_zona" class="bukti_pendaftaran_zona">
<span<?php echo $bukti_pendaftaran->zona->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->zona->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir"<?php echo $bukti_pendaftaran->nilai_akhir->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nilai_akhir" class="bukti_pendaftaran_nilai_akhir">
<span<?php echo $bukti_pendaftaran->nilai_akhir->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nilai_akhir->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nama_ayah->Visible) { // nama_ayah ?>
		<td data-name="nama_ayah"<?php echo $bukti_pendaftaran->nama_ayah->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nama_ayah" class="bukti_pendaftaran_nama_ayah">
<span<?php echo $bukti_pendaftaran->nama_ayah->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nama_ayah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nama_ibu->Visible) { // nama_ibu ?>
		<td data-name="nama_ibu"<?php echo $bukti_pendaftaran->nama_ibu->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nama_ibu" class="bukti_pendaftaran_nama_ibu">
<span<?php echo $bukti_pendaftaran->nama_ibu->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nama_ibu->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->nama_wali->Visible) { // nama_wali ?>
		<td data-name="nama_wali"<?php echo $bukti_pendaftaran->nama_wali->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_nama_wali" class="bukti_pendaftaran_nama_wali">
<span<?php echo $bukti_pendaftaran->nama_wali->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->nama_wali->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan"<?php echo $bukti_pendaftaran->persyaratan->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_persyaratan" class="bukti_pendaftaran_persyaratan">
<span<?php echo $bukti_pendaftaran->persyaratan->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->persyaratan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bukti_pendaftaran->catatan->Visible) { // catatan ?>
		<td data-name="catatan"<?php echo $bukti_pendaftaran->catatan->CellAttributes() ?>>
<span id="el<?php echo $bukti_pendaftaran_list->RowCnt ?>_bukti_pendaftaran_catatan" class="bukti_pendaftaran_catatan">
<span<?php echo $bukti_pendaftaran->catatan->ViewAttributes() ?>>
<?php echo $bukti_pendaftaran->catatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$bukti_pendaftaran_list->ListOptions->Render("body", "right", $bukti_pendaftaran_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($bukti_pendaftaran->CurrentAction <> "gridadd")
		$bukti_pendaftaran_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($bukti_pendaftaran->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($bukti_pendaftaran_list->Recordset)
	$bukti_pendaftaran_list->Recordset->Close();
?>
<?php if ($bukti_pendaftaran->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($bukti_pendaftaran->CurrentAction <> "gridadd" && $bukti_pendaftaran->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($bukti_pendaftaran_list->Pager)) $bukti_pendaftaran_list->Pager = new cPrevNextPager($bukti_pendaftaran_list->StartRec, $bukti_pendaftaran_list->DisplayRecs, $bukti_pendaftaran_list->TotalRecs, $bukti_pendaftaran_list->AutoHidePager) ?>
<?php if ($bukti_pendaftaran_list->Pager->RecordCount > 0 && $bukti_pendaftaran_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($bukti_pendaftaran_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $bukti_pendaftaran_list->PageUrl() ?>start=<?php echo $bukti_pendaftaran_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($bukti_pendaftaran_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $bukti_pendaftaran_list->PageUrl() ?>start=<?php echo $bukti_pendaftaran_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $bukti_pendaftaran_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($bukti_pendaftaran_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $bukti_pendaftaran_list->PageUrl() ?>start=<?php echo $bukti_pendaftaran_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($bukti_pendaftaran_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $bukti_pendaftaran_list->PageUrl() ?>start=<?php echo $bukti_pendaftaran_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $bukti_pendaftaran_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $bukti_pendaftaran_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $bukti_pendaftaran_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $bukti_pendaftaran_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($bukti_pendaftaran_list->TotalRecs > 0 && (!$bukti_pendaftaran_list->AutoHidePageSizeSelector || $bukti_pendaftaran_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="bukti_pendaftaran">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($bukti_pendaftaran_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($bukti_pendaftaran_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="40"<?php if ($bukti_pendaftaran_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($bukti_pendaftaran_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="ALL"<?php if ($bukti_pendaftaran->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($bukti_pendaftaran_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($bukti_pendaftaran_list->TotalRecs == 0 && $bukti_pendaftaran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($bukti_pendaftaran_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($bukti_pendaftaran->Export == "") { ?>
<script type="text/javascript">
fbukti_pendaftaranlistsrch.FilterList = <?php echo $bukti_pendaftaran_list->GetFilterList() ?>;
fbukti_pendaftaranlistsrch.Init();
fbukti_pendaftaranlist.Init();
</script>
<?php } ?>
<?php
$bukti_pendaftaran_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($bukti_pendaftaran->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$bukti_pendaftaran_list->Page_Terminate();
?>
