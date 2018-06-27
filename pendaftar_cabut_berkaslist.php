<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendaftar_cabut_berkasinfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "no_pendaftaraninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendaftar_cabut_berkas_list = NULL; // Initialize page object first

class cpendaftar_cabut_berkas_list extends cpendaftar_cabut_berkas {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'pendaftar_cabut_berkas';

	// Page object name
	var $PageObjName = 'pendaftar_cabut_berkas_list';

	// Grid form hidden field names
	var $FormName = 'fpendaftar_cabut_berkaslist';
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

		// Table object (pendaftar_cabut_berkas)
		if (!isset($GLOBALS["pendaftar_cabut_berkas"]) || get_class($GLOBALS["pendaftar_cabut_berkas"]) == "cpendaftar_cabut_berkas") {
			$GLOBALS["pendaftar_cabut_berkas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendaftar_cabut_berkas"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pendaftar_cabut_berkasadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pendaftar_cabut_berkasdelete.php";
		$this->MultiUpdateUrl = "pendaftar_cabut_berkasupdate.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendaftar_cabut_berkas', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpendaftar_cabut_berkaslistsrch";

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
		// Create form object

		$objForm = new cFormObj();

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
		$this->nomor_pendaftaran->SetVisibility();
		$this->nama_ruang->SetVisibility();
		$this->nomor_peserta_ujian_sdmi->SetVisibility();
		$this->sekolah_asal->SetVisibility();
		$this->nama_lengkap->SetVisibility();
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
		global $EW_EXPORT, $pendaftar_cabut_berkas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendaftar_cabut_berkas);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id_pendaftar", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["id_pendaftar"])) {
			$this->id_pendaftar->setQueryStringValue($_GET["id_pendaftar"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {

				// Check if valid user id
				if (!$this->ShowOptionLink('edit')) {
					$sUserIdMsg = $Language->Phrase("NoEditPermission");
					$this->setFailureMessage($sUserIdMsg);
					$this->ClearInlineMode(); // Clear inline edit mode
					return;
				}
				$this->setKey("id_pendaftar", $this->id_pendaftar->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id_pendaftar")) <> strval($this->id_pendaftar->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_nomor_pendaftaran") && $objForm->HasValue("o_nomor_pendaftaran") && $this->nomor_pendaftaran->CurrentValue <> $this->nomor_pendaftaran->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nama_ruang") && $objForm->HasValue("o_nama_ruang") && $this->nama_ruang->CurrentValue <> $this->nama_ruang->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nomor_peserta_ujian_sdmi") && $objForm->HasValue("o_nomor_peserta_ujian_sdmi") && $this->nomor_peserta_ujian_sdmi->CurrentValue <> $this->nomor_peserta_ujian_sdmi->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_sekolah_asal") && $objForm->HasValue("o_sekolah_asal") && $this->sekolah_asal->CurrentValue <> $this->sekolah_asal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nama_lengkap") && $objForm->HasValue("o_nama_lengkap") && $this->nama_lengkap->CurrentValue <> $this->nama_lengkap->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_zona") && $objForm->HasValue("o_zona") && $this->zona->CurrentValue <> $this->zona->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nilai_akhir") && $objForm->HasValue("o_nilai_akhir") && $this->nilai_akhir->CurrentValue <> $this->nilai_akhir->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_status") && $objForm->HasValue("o_status") && $this->status->CurrentValue <> $this->status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_persyaratan") && $objForm->HasValue("o_persyaratan") && $this->persyaratan->CurrentValue <> $this->persyaratan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_catatan") && $objForm->HasValue("o_catatan") && $this->catatan->CurrentValue <> $this->catatan->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fpendaftar_cabut_berkaslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id_pendaftar->AdvancedSearch->ToJson(), ","); // Field id_pendaftar
		$sFilterList = ew_Concat($sFilterList, $this->nomor_pendaftaran->AdvancedSearch->ToJson(), ","); // Field nomor_pendaftaran
		$sFilterList = ew_Concat($sFilterList, $this->nama_ruang->AdvancedSearch->ToJson(), ","); // Field nama_ruang
		$sFilterList = ew_Concat($sFilterList, $this->nomor_peserta_ujian_sdmi->AdvancedSearch->ToJson(), ","); // Field nomor_peserta_ujian_sdmi
		$sFilterList = ew_Concat($sFilterList, $this->sekolah_asal->AdvancedSearch->ToJson(), ","); // Field sekolah_asal
		$sFilterList = ew_Concat($sFilterList, $this->nama_lengkap->AdvancedSearch->ToJson(), ","); // Field nama_lengkap
		$sFilterList = ew_Concat($sFilterList, $this->nisn->AdvancedSearch->ToJson(), ","); // Field nisn
		$sFilterList = ew_Concat($sFilterList, $this->tempat_lahir->AdvancedSearch->ToJson(), ","); // Field tempat_lahir
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_lahir->AdvancedSearch->ToJson(), ","); // Field tanggal_lahir
		$sFilterList = ew_Concat($sFilterList, $this->jenis_kelamin->AdvancedSearch->ToJson(), ","); // Field jenis_kelamin
		$sFilterList = ew_Concat($sFilterList, $this->agama->AdvancedSearch->ToJson(), ","); // Field agama
		$sFilterList = ew_Concat($sFilterList, $this->kecamatan->AdvancedSearch->ToJson(), ","); // Field kecamatan
		$sFilterList = ew_Concat($sFilterList, $this->zona->AdvancedSearch->ToJson(), ","); // Field zona
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
		$sFilterList = ew_Concat($sFilterList, $this->n_ind->AdvancedSearch->ToJson(), ","); // Field n_ind
		$sFilterList = ew_Concat($sFilterList, $this->n_mat->AdvancedSearch->ToJson(), ","); // Field n_mat
		$sFilterList = ew_Concat($sFilterList, $this->n_ipa->AdvancedSearch->ToJson(), ","); // Field n_ipa
		$sFilterList = ew_Concat($sFilterList, $this->keterangan->AdvancedSearch->ToJson(), ","); // Field keterangan
		$sFilterList = ew_Concat($sFilterList, $this->alamat->AdvancedSearch->ToJson(), ","); // Field alamat
		$sFilterList = ew_Concat($sFilterList, $this->nik->AdvancedSearch->ToJson(), ","); // Field nik
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpendaftar_cabut_berkaslistsrch", $filters);

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

		// Field nomor_pendaftaran
		$this->nomor_pendaftaran->AdvancedSearch->SearchValue = @$filter["x_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchOperator = @$filter["z_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchCondition = @$filter["v_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchValue2 = @$filter["y_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->SearchOperator2 = @$filter["w_nomor_pendaftaran"];
		$this->nomor_pendaftaran->AdvancedSearch->Save();

		// Field nama_ruang
		$this->nama_ruang->AdvancedSearch->SearchValue = @$filter["x_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchOperator = @$filter["z_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchCondition = @$filter["v_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchValue2 = @$filter["y_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->SearchOperator2 = @$filter["w_nama_ruang"];
		$this->nama_ruang->AdvancedSearch->Save();

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

		// Field keterangan
		$this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
		$this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
		$this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
		$this->keterangan->AdvancedSearch->Save();

		// Field alamat
		$this->alamat->AdvancedSearch->SearchValue = @$filter["x_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator = @$filter["z_alamat"];
		$this->alamat->AdvancedSearch->SearchCondition = @$filter["v_alamat"];
		$this->alamat->AdvancedSearch->SearchValue2 = @$filter["y_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator2 = @$filter["w_alamat"];
		$this->alamat->AdvancedSearch->Save();

		// Field nik
		$this->nik->AdvancedSearch->SearchValue = @$filter["x_nik"];
		$this->nik->AdvancedSearch->SearchOperator = @$filter["z_nik"];
		$this->nik->AdvancedSearch->SearchCondition = @$filter["v_nik"];
		$this->nik->AdvancedSearch->SearchValue2 = @$filter["y_nik"];
		$this->nik->AdvancedSearch->SearchOperator2 = @$filter["w_nik"];
		$this->nik->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_pendaftaran, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ruang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomor_peserta_ujian_sdmi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->sekolah_asal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_lengkap, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nisn, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tempat_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tanggal_lahir, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jenis_kelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->agama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kecamatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->zona, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bonus_prestasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_prestasi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kepemilikan_ijasah_mda, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ayah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ibu, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_wali, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->persyaratan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->catatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keterangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nik, $arKeywords, $type);
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
			$this->UpdateSort($this->nomor_pendaftaran); // nomor_pendaftaran
			$this->UpdateSort($this->nama_ruang); // nama_ruang
			$this->UpdateSort($this->nomor_peserta_ujian_sdmi); // nomor_peserta_ujian_sdmi
			$this->UpdateSort($this->sekolah_asal); // sekolah_asal
			$this->UpdateSort($this->nama_lengkap); // nama_lengkap
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
				$this->nomor_pendaftaran->setSort("");
				$this->nama_ruang->setSort("");
				$this->nomor_peserta_ujian_sdmi->setSort("");
				$this->sekolah_asal->setSort("");
				$this->nama_lengkap->setSort("");
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

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

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
		$item->Visible = FALSE;
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id_pendaftar->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id_pendaftar->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpendaftar_cabut_berkaslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpendaftar_cabut_berkaslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpendaftar_cabut_berkaslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = FALSE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpendaftar_cabut_berkaslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->id_pendaftar->CurrentValue = NULL;
		$this->id_pendaftar->OldValue = $this->id_pendaftar->CurrentValue;
		$this->nomor_pendaftaran->CurrentValue = NULL;
		$this->nomor_pendaftaran->OldValue = $this->nomor_pendaftaran->CurrentValue;
		$this->nama_ruang->CurrentValue = CurrentUserID();
		$this->nama_ruang->OldValue = $this->nama_ruang->CurrentValue;
		$this->nomor_peserta_ujian_sdmi->CurrentValue = NULL;
		$this->nomor_peserta_ujian_sdmi->OldValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		$this->sekolah_asal->CurrentValue = NULL;
		$this->sekolah_asal->OldValue = $this->sekolah_asal->CurrentValue;
		$this->nama_lengkap->CurrentValue = NULL;
		$this->nama_lengkap->OldValue = $this->nama_lengkap->CurrentValue;
		$this->nisn->CurrentValue = NULL;
		$this->nisn->OldValue = $this->nisn->CurrentValue;
		$this->tempat_lahir->CurrentValue = NULL;
		$this->tempat_lahir->OldValue = $this->tempat_lahir->CurrentValue;
		$this->tanggal_lahir->CurrentValue = NULL;
		$this->tanggal_lahir->OldValue = $this->tanggal_lahir->CurrentValue;
		$this->jenis_kelamin->CurrentValue = NULL;
		$this->jenis_kelamin->OldValue = $this->jenis_kelamin->CurrentValue;
		$this->agama->CurrentValue = NULL;
		$this->agama->OldValue = $this->agama->CurrentValue;
		$this->kecamatan->CurrentValue = NULL;
		$this->kecamatan->OldValue = $this->kecamatan->CurrentValue;
		$this->zona->CurrentValue = NULL;
		$this->zona->OldValue = $this->zona->CurrentValue;
		$this->jumlah_nilai_usum->CurrentValue = NULL;
		$this->jumlah_nilai_usum->OldValue = $this->jumlah_nilai_usum->CurrentValue;
		$this->bonus_prestasi->CurrentValue = NULL;
		$this->bonus_prestasi->OldValue = $this->bonus_prestasi->CurrentValue;
		$this->nama_prestasi->CurrentValue = NULL;
		$this->nama_prestasi->OldValue = $this->nama_prestasi->CurrentValue;
		$this->jumlah_bonus_prestasi->CurrentValue = NULL;
		$this->jumlah_bonus_prestasi->OldValue = $this->jumlah_bonus_prestasi->CurrentValue;
		$this->kepemilikan_ijasah_mda->CurrentValue = NULL;
		$this->kepemilikan_ijasah_mda->OldValue = $this->kepemilikan_ijasah_mda->CurrentValue;
		$this->nilai_mda->CurrentValue = NULL;
		$this->nilai_mda->OldValue = $this->nilai_mda->CurrentValue;
		$this->nilai_akhir->CurrentValue = NULL;
		$this->nilai_akhir->OldValue = $this->nilai_akhir->CurrentValue;
		$this->nama_ayah->CurrentValue = NULL;
		$this->nama_ayah->OldValue = $this->nama_ayah->CurrentValue;
		$this->nama_ibu->CurrentValue = NULL;
		$this->nama_ibu->OldValue = $this->nama_ibu->CurrentValue;
		$this->nama_wali->CurrentValue = NULL;
		$this->nama_wali->OldValue = $this->nama_wali->CurrentValue;
		$this->status->CurrentValue = "Terdaftar";
		$this->status->OldValue = $this->status->CurrentValue;
		$this->persyaratan->CurrentValue = NULL;
		$this->persyaratan->OldValue = $this->persyaratan->CurrentValue;
		$this->catatan->CurrentValue = NULL;
		$this->catatan->OldValue = $this->catatan->CurrentValue;
		$this->n_ind->CurrentValue = NULL;
		$this->n_ind->OldValue = $this->n_ind->CurrentValue;
		$this->n_mat->CurrentValue = NULL;
		$this->n_mat->OldValue = $this->n_mat->CurrentValue;
		$this->n_ipa->CurrentValue = NULL;
		$this->n_ipa->OldValue = $this->n_ipa->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->alamat->CurrentValue = NULL;
		$this->alamat->OldValue = $this->alamat->CurrentValue;
		$this->nik->CurrentValue = NULL;
		$this->nik->OldValue = $this->nik->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomor_pendaftaran->FldIsDetailKey) {
			$this->nomor_pendaftaran->setFormValue($objForm->GetValue("x_nomor_pendaftaran"));
		}
		if (!$this->nama_ruang->FldIsDetailKey) {
			$this->nama_ruang->setFormValue($objForm->GetValue("x_nama_ruang"));
		}
		if (!$this->nomor_peserta_ujian_sdmi->FldIsDetailKey) {
			$this->nomor_peserta_ujian_sdmi->setFormValue($objForm->GetValue("x_nomor_peserta_ujian_sdmi"));
		}
		if (!$this->sekolah_asal->FldIsDetailKey) {
			$this->sekolah_asal->setFormValue($objForm->GetValue("x_sekolah_asal"));
		}
		if (!$this->nama_lengkap->FldIsDetailKey) {
			$this->nama_lengkap->setFormValue($objForm->GetValue("x_nama_lengkap"));
		}
		if (!$this->zona->FldIsDetailKey) {
			$this->zona->setFormValue($objForm->GetValue("x_zona"));
		}
		if (!$this->nilai_akhir->FldIsDetailKey) {
			$this->nilai_akhir->setFormValue($objForm->GetValue("x_nilai_akhir"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->persyaratan->FldIsDetailKey) {
			$this->persyaratan->setFormValue($objForm->GetValue("x_persyaratan"));
		}
		if (!$this->catatan->FldIsDetailKey) {
			$this->catatan->setFormValue($objForm->GetValue("x_catatan"));
		}
		if (!$this->id_pendaftar->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_pendaftar->setFormValue($objForm->GetValue("x_id_pendaftar"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_pendaftar->CurrentValue = $this->id_pendaftar->FormValue;
		$this->nomor_pendaftaran->CurrentValue = $this->nomor_pendaftaran->FormValue;
		$this->nama_ruang->CurrentValue = $this->nama_ruang->FormValue;
		$this->nomor_peserta_ujian_sdmi->CurrentValue = $this->nomor_peserta_ujian_sdmi->FormValue;
		$this->sekolah_asal->CurrentValue = $this->sekolah_asal->FormValue;
		$this->nama_lengkap->CurrentValue = $this->nama_lengkap->FormValue;
		$this->zona->CurrentValue = $this->zona->FormValue;
		$this->nilai_akhir->CurrentValue = $this->nilai_akhir->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->persyaratan->CurrentValue = $this->persyaratan->FormValue;
		$this->catatan->CurrentValue = $this->catatan->FormValue;
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
		$this->nomor_pendaftaran->setDbValue($row['nomor_pendaftaran']);
		$this->nama_ruang->setDbValue($row['nama_ruang']);
		$this->nomor_peserta_ujian_sdmi->setDbValue($row['nomor_peserta_ujian_sdmi']);
		$this->sekolah_asal->setDbValue($row['sekolah_asal']);
		$this->nama_lengkap->setDbValue($row['nama_lengkap']);
		$this->nisn->setDbValue($row['nisn']);
		$this->tempat_lahir->setDbValue($row['tempat_lahir']);
		$this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
		$this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
		$this->agama->setDbValue($row['agama']);
		$this->kecamatan->setDbValue($row['kecamatan']);
		$this->zona->setDbValue($row['zona']);
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
		$this->n_ind->setDbValue($row['n_ind']);
		$this->n_mat->setDbValue($row['n_mat']);
		$this->n_ipa->setDbValue($row['n_ipa']);
		$this->keterangan->setDbValue($row['keterangan']);
		$this->alamat->setDbValue($row['alamat']);
		$this->nik->setDbValue($row['nik']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id_pendaftar'] = $this->id_pendaftar->CurrentValue;
		$row['nomor_pendaftaran'] = $this->nomor_pendaftaran->CurrentValue;
		$row['nama_ruang'] = $this->nama_ruang->CurrentValue;
		$row['nomor_peserta_ujian_sdmi'] = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		$row['sekolah_asal'] = $this->sekolah_asal->CurrentValue;
		$row['nama_lengkap'] = $this->nama_lengkap->CurrentValue;
		$row['nisn'] = $this->nisn->CurrentValue;
		$row['tempat_lahir'] = $this->tempat_lahir->CurrentValue;
		$row['tanggal_lahir'] = $this->tanggal_lahir->CurrentValue;
		$row['jenis_kelamin'] = $this->jenis_kelamin->CurrentValue;
		$row['agama'] = $this->agama->CurrentValue;
		$row['kecamatan'] = $this->kecamatan->CurrentValue;
		$row['zona'] = $this->zona->CurrentValue;
		$row['jumlah_nilai_usum'] = $this->jumlah_nilai_usum->CurrentValue;
		$row['bonus_prestasi'] = $this->bonus_prestasi->CurrentValue;
		$row['nama_prestasi'] = $this->nama_prestasi->CurrentValue;
		$row['jumlah_bonus_prestasi'] = $this->jumlah_bonus_prestasi->CurrentValue;
		$row['kepemilikan_ijasah_mda'] = $this->kepemilikan_ijasah_mda->CurrentValue;
		$row['nilai_mda'] = $this->nilai_mda->CurrentValue;
		$row['nilai_akhir'] = $this->nilai_akhir->CurrentValue;
		$row['nama_ayah'] = $this->nama_ayah->CurrentValue;
		$row['nama_ibu'] = $this->nama_ibu->CurrentValue;
		$row['nama_wali'] = $this->nama_wali->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['persyaratan'] = $this->persyaratan->CurrentValue;
		$row['catatan'] = $this->catatan->CurrentValue;
		$row['n_ind'] = $this->n_ind->CurrentValue;
		$row['n_mat'] = $this->n_mat->CurrentValue;
		$row['n_ipa'] = $this->n_ipa->CurrentValue;
		$row['keterangan'] = $this->keterangan->CurrentValue;
		$row['alamat'] = $this->alamat->CurrentValue;
		$row['nik'] = $this->nik->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_pendaftar->DbValue = $row['id_pendaftar'];
		$this->nomor_pendaftaran->DbValue = $row['nomor_pendaftaran'];
		$this->nama_ruang->DbValue = $row['nama_ruang'];
		$this->nomor_peserta_ujian_sdmi->DbValue = $row['nomor_peserta_ujian_sdmi'];
		$this->sekolah_asal->DbValue = $row['sekolah_asal'];
		$this->nama_lengkap->DbValue = $row['nama_lengkap'];
		$this->nisn->DbValue = $row['nisn'];
		$this->tempat_lahir->DbValue = $row['tempat_lahir'];
		$this->tanggal_lahir->DbValue = $row['tanggal_lahir'];
		$this->jenis_kelamin->DbValue = $row['jenis_kelamin'];
		$this->agama->DbValue = $row['agama'];
		$this->kecamatan->DbValue = $row['kecamatan'];
		$this->zona->DbValue = $row['zona'];
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
		$this->n_ind->DbValue = $row['n_ind'];
		$this->n_mat->DbValue = $row['n_mat'];
		$this->n_ipa->DbValue = $row['n_ipa'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->alamat->DbValue = $row['alamat'];
		$this->nik->DbValue = $row['nik'];
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
		// nomor_pendaftaran
		// nama_ruang
		// nomor_peserta_ujian_sdmi
		// sekolah_asal
		// nama_lengkap
		// nisn
		// tempat_lahir
		// tanggal_lahir
		// jenis_kelamin
		// agama
		// kecamatan
		// zona
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
		// n_ind
		// n_mat
		// n_ipa
		// keterangan
		// alamat
		// nik

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_pendaftar
		$this->id_pendaftar->ViewValue = $this->id_pendaftar->CurrentValue;
		$this->id_pendaftar->CellCssStyle .= "text-align: center;";
		$this->id_pendaftar->ViewCustomAttributes = "";

		// nomor_pendaftaran
		$this->nomor_pendaftaran->ViewValue = $this->nomor_pendaftaran->CurrentValue;
		if (strval($this->nomor_pendaftaran->CurrentValue) <> "") {
			$sFilterWrk = "`id_no`" . ew_SearchString("=", $this->nomor_pendaftaran->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_no`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
		$sWhereWrk = "";
		$this->nomor_pendaftaran->LookupFilters = array();
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

		// nama_ruang
		$this->nama_ruang->ViewValue = $this->nama_ruang->CurrentValue;
		if (strval($this->nama_ruang->CurrentValue) <> "") {
			$sFilterWrk = "`id_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
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
		$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
			$sFilterWrk = "`id_pd`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_pd`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
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
		$this->nomor_peserta_ujian_sdmi->CellCssStyle .= "text-align: center;";
		$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

		// sekolah_asal
		$this->sekolah_asal->ViewValue = $this->sekolah_asal->CurrentValue;
		$this->sekolah_asal->ViewCustomAttributes = "";

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
		$this->tanggal_lahir->ViewCustomAttributes = "";

		// jenis_kelamin
		$this->jenis_kelamin->ViewValue = $this->jenis_kelamin->CurrentValue;
		$this->jenis_kelamin->ViewCustomAttributes = "";

		// agama
		$this->agama->ViewValue = $this->agama->CurrentValue;
		$this->agama->ViewCustomAttributes = "";

		// kecamatan
		$this->kecamatan->ViewValue = $this->kecamatan->CurrentValue;
		$this->kecamatan->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->CellCssStyle .= "text-align: center;";
		$this->zona->ViewCustomAttributes = "";

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum->ViewValue = $this->jumlah_nilai_usum->CurrentValue;
		$this->jumlah_nilai_usum->ViewCustomAttributes = "";

		// bonus_prestasi
		$this->bonus_prestasi->ViewValue = $this->bonus_prestasi->CurrentValue;
		$this->bonus_prestasi->ViewCustomAttributes = "";

		// nama_prestasi
		$this->nama_prestasi->ViewValue = $this->nama_prestasi->CurrentValue;
		$this->nama_prestasi->ViewCustomAttributes = "";

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->ViewValue = $this->jumlah_bonus_prestasi->CurrentValue;
		$this->jumlah_bonus_prestasi->ViewCustomAttributes = "";

		// kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda->ViewValue = $this->kepemilikan_ijasah_mda->CurrentValue;
		$this->kepemilikan_ijasah_mda->ViewCustomAttributes = "";

		// nilai_mda
		$this->nilai_mda->ViewValue = $this->nilai_mda->CurrentValue;
		$this->nilai_mda->ViewCustomAttributes = "";

		// nilai_akhir
		$this->nilai_akhir->ViewValue = $this->nilai_akhir->CurrentValue;
		$this->nilai_akhir->ViewValue = ew_FormatNumber($this->nilai_akhir->ViewValue, 1, -2, -2, -2);
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

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// persyaratan
		$this->persyaratan->ViewValue = $this->persyaratan->CurrentValue;
		$this->persyaratan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// n_ind
		$this->n_ind->ViewValue = $this->n_ind->CurrentValue;
		$this->n_ind->ViewCustomAttributes = "";

		// n_mat
		$this->n_mat->ViewValue = $this->n_mat->CurrentValue;
		$this->n_mat->ViewCustomAttributes = "";

		// n_ipa
		$this->n_ipa->ViewValue = $this->n_ipa->CurrentValue;
		$this->n_ipa->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

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

			// sekolah_asal
			$this->sekolah_asal->LinkCustomAttributes = "";
			$this->sekolah_asal->HrefValue = "";
			$this->sekolah_asal->TooltipValue = "";

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";
			$this->nama_lengkap->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomor_pendaftaran
			$this->nomor_pendaftaran->EditAttrs["class"] = "form-control";
			$this->nomor_pendaftaran->EditCustomAttributes = "";
			$this->nomor_pendaftaran->EditValue = ew_HtmlEncode($this->nomor_pendaftaran->CurrentValue);
			if (strval($this->nomor_pendaftaran->CurrentValue) <> "") {
				$sFilterWrk = "`id_no`" . ew_SearchString("=", $this->nomor_pendaftaran->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_no`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
			$sWhereWrk = "";
			$this->nomor_pendaftaran->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->nomor_pendaftaran->EditValue = $this->nomor_pendaftaran->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomor_pendaftaran->EditValue = ew_HtmlEncode($this->nomor_pendaftaran->CurrentValue);
				}
			} else {
				$this->nomor_pendaftaran->EditValue = NULL;
			}
			$this->nomor_pendaftaran->PlaceHolder = ew_RemoveHtml($this->nomor_pendaftaran->FldCaption());

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow($this->CurrentAction)) { // Non system admin
			if (trim(strval($this->nama_ruang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			ew_AddFilter($sFilterWrk, $GLOBALS["ruang"]->AddUserIDFilter(""));
			$sSqlWrk = "SELECT `id_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_ruang->EditValue = $arwrk;
			} else {
			$this->nama_ruang->EditValue = ew_HtmlEncode($this->nama_ruang->CurrentValue);
			if (strval($this->nama_ruang->CurrentValue) <> "") {
				$sFilterWrk = "`id_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->nama_ruang->EditValue = $this->nama_ruang->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nama_ruang->EditValue = ew_HtmlEncode($this->nama_ruang->CurrentValue);
				}
			} else {
				$this->nama_ruang->EditValue = NULL;
			}
			$this->nama_ruang->PlaceHolder = ew_RemoveHtml($this->nama_ruang->FldCaption());
			}

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->EditAttrs["class"] = "form-control";
			$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";
			$this->nomor_peserta_ujian_sdmi->EditValue = ew_HtmlEncode($this->nomor_peserta_ujian_sdmi->CurrentValue);
			if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
				$sFilterWrk = "`id_pd`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_pd`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
			$sWhereWrk = "";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->nomor_peserta_ujian_sdmi->EditValue = $this->nomor_peserta_ujian_sdmi->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomor_peserta_ujian_sdmi->EditValue = ew_HtmlEncode($this->nomor_peserta_ujian_sdmi->CurrentValue);
				}
			} else {
				$this->nomor_peserta_ujian_sdmi->EditValue = NULL;
			}
			$this->nomor_peserta_ujian_sdmi->PlaceHolder = ew_RemoveHtml($this->nomor_peserta_ujian_sdmi->FldCaption());

			// sekolah_asal
			$this->sekolah_asal->EditAttrs["class"] = "form-control";
			$this->sekolah_asal->EditCustomAttributes = "";
			$this->sekolah_asal->EditValue = ew_HtmlEncode($this->sekolah_asal->CurrentValue);
			$this->sekolah_asal->PlaceHolder = ew_RemoveHtml($this->sekolah_asal->FldCaption());

			// nama_lengkap
			$this->nama_lengkap->EditAttrs["class"] = "form-control";
			$this->nama_lengkap->EditCustomAttributes = "";
			$this->nama_lengkap->EditValue = ew_HtmlEncode($this->nama_lengkap->CurrentValue);
			$this->nama_lengkap->PlaceHolder = ew_RemoveHtml($this->nama_lengkap->FldCaption());

			// zona
			$this->zona->EditAttrs["class"] = "form-control";
			$this->zona->EditCustomAttributes = "";
			$this->zona->EditValue = ew_HtmlEncode($this->zona->CurrentValue);
			$this->zona->PlaceHolder = ew_RemoveHtml($this->zona->FldCaption());

			// nilai_akhir
			$this->nilai_akhir->EditAttrs["class"] = "form-control";
			$this->nilai_akhir->EditCustomAttributes = "";
			$this->nilai_akhir->EditValue = ew_HtmlEncode($this->nilai_akhir->CurrentValue);
			$this->nilai_akhir->PlaceHolder = ew_RemoveHtml($this->nilai_akhir->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// persyaratan
			$this->persyaratan->EditAttrs["class"] = "form-control";
			$this->persyaratan->EditCustomAttributes = "";
			$this->persyaratan->EditValue = ew_HtmlEncode($this->persyaratan->CurrentValue);
			$this->persyaratan->PlaceHolder = ew_RemoveHtml($this->persyaratan->FldCaption());

			// catatan
			$this->catatan->EditAttrs["class"] = "form-control";
			$this->catatan->EditCustomAttributes = "";
			$this->catatan->EditValue = ew_HtmlEncode($this->catatan->CurrentValue);
			$this->catatan->PlaceHolder = ew_RemoveHtml($this->catatan->FldCaption());

			// Add refer script
			// nomor_pendaftaran

			$this->nomor_pendaftaran->LinkCustomAttributes = "";
			$this->nomor_pendaftaran->HrefValue = "";

			// nama_ruang
			$this->nama_ruang->LinkCustomAttributes = "";
			$this->nama_ruang->HrefValue = "";

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->LinkCustomAttributes = "";
			$this->nomor_peserta_ujian_sdmi->HrefValue = "";

			// sekolah_asal
			$this->sekolah_asal->LinkCustomAttributes = "";
			$this->sekolah_asal->HrefValue = "";

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";

			// zona
			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";

			// nilai_akhir
			$this->nilai_akhir->LinkCustomAttributes = "";
			$this->nilai_akhir->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// persyaratan
			$this->persyaratan->LinkCustomAttributes = "";
			$this->persyaratan->HrefValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomor_pendaftaran
			$this->nomor_pendaftaran->EditAttrs["class"] = "form-control";
			$this->nomor_pendaftaran->EditCustomAttributes = "";
			$this->nomor_pendaftaran->EditValue = $this->nomor_pendaftaran->CurrentValue;
			if (strval($this->nomor_pendaftaran->CurrentValue) <> "") {
				$sFilterWrk = "`id_no`" . ew_SearchString("=", $this->nomor_pendaftaran->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_no`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
			$sWhereWrk = "";
			$this->nomor_pendaftaran->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->nomor_pendaftaran->EditValue = $this->nomor_pendaftaran->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomor_pendaftaran->EditValue = $this->nomor_pendaftaran->CurrentValue;
				}
			} else {
				$this->nomor_pendaftaran->EditValue = NULL;
			}
			$this->nomor_pendaftaran->CellCssStyle .= "text-align: center;";
			$this->nomor_pendaftaran->ViewCustomAttributes = "";

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			$this->nama_ruang->EditValue = $this->nama_ruang->CurrentValue;
			if (strval($this->nama_ruang->CurrentValue) <> "") {
				$sFilterWrk = "`id_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->nama_ruang->EditValue = $this->nama_ruang->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nama_ruang->EditValue = $this->nama_ruang->CurrentValue;
				}
			} else {
				$this->nama_ruang->EditValue = NULL;
			}
			$this->nama_ruang->ViewCustomAttributes = "";

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->EditAttrs["class"] = "form-control";
			$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";
			$this->nomor_peserta_ujian_sdmi->EditValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
			if (strval($this->nomor_peserta_ujian_sdmi->CurrentValue) <> "") {
				$sFilterWrk = "`id_pd`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id_pd`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
			$sWhereWrk = "";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->nomor_peserta_ujian_sdmi->EditValue = $this->nomor_peserta_ujian_sdmi->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomor_peserta_ujian_sdmi->EditValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
				}
			} else {
				$this->nomor_peserta_ujian_sdmi->EditValue = NULL;
			}
			$this->nomor_peserta_ujian_sdmi->CellCssStyle .= "text-align: center;";
			$this->nomor_peserta_ujian_sdmi->ViewCustomAttributes = "";

			// sekolah_asal
			$this->sekolah_asal->EditAttrs["class"] = "form-control";
			$this->sekolah_asal->EditCustomAttributes = "";
			$this->sekolah_asal->EditValue = $this->sekolah_asal->CurrentValue;
			$this->sekolah_asal->ViewCustomAttributes = "";

			// nama_lengkap
			$this->nama_lengkap->EditAttrs["class"] = "form-control";
			$this->nama_lengkap->EditCustomAttributes = "";
			$this->nama_lengkap->EditValue = $this->nama_lengkap->CurrentValue;
			$this->nama_lengkap->ViewCustomAttributes = "";

			// zona
			$this->zona->EditAttrs["class"] = "form-control";
			$this->zona->EditCustomAttributes = "";
			$this->zona->EditValue = $this->zona->CurrentValue;
			$this->zona->CellCssStyle .= "text-align: center;";
			$this->zona->ViewCustomAttributes = "";

			// nilai_akhir
			$this->nilai_akhir->EditAttrs["class"] = "form-control";
			$this->nilai_akhir->EditCustomAttributes = "";
			$this->nilai_akhir->EditValue = $this->nilai_akhir->CurrentValue;
			$this->nilai_akhir->EditValue = ew_FormatNumber($this->nilai_akhir->EditValue, 1, -2, -2, -2);
			$this->nilai_akhir->CellCssStyle .= "text-align: center;";
			$this->nilai_akhir->ViewCustomAttributes = "";

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// persyaratan
			$this->persyaratan->EditAttrs["class"] = "form-control";
			$this->persyaratan->EditCustomAttributes = "";
			$this->persyaratan->EditValue = $this->persyaratan->CurrentValue;
			$this->persyaratan->ViewCustomAttributes = "";

			// catatan
			$this->catatan->EditAttrs["class"] = "form-control";
			$this->catatan->EditCustomAttributes = "";
			$this->catatan->EditValue = $this->catatan->CurrentValue;
			$this->catatan->ViewCustomAttributes = "";

			// Edit refer script
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

			// sekolah_asal
			$this->sekolah_asal->LinkCustomAttributes = "";
			$this->sekolah_asal->HrefValue = "";
			$this->sekolah_asal->TooltipValue = "";

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";
			$this->nama_lengkap->TooltipValue = "";

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

			// persyaratan
			$this->persyaratan->LinkCustomAttributes = "";
			$this->persyaratan->HrefValue = "";
			$this->persyaratan->TooltipValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";
			$this->catatan->TooltipValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->nomor_pendaftaran->FldIsDetailKey && !is_null($this->nomor_pendaftaran->FormValue) && $this->nomor_pendaftaran->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomor_pendaftaran->FldCaption(), $this->nomor_pendaftaran->ReqErrMsg));
		}
		if (!$this->zona->FldIsDetailKey && !is_null($this->zona->FormValue) && $this->zona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->zona->FldCaption(), $this->zona->ReqErrMsg));
		}
		if ($this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
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
				$sThisKey .= $row['id_pendaftar'];
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		if ($this->nomor_pendaftaran->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`nomor_pendaftaran` = '" . ew_AdjustSql($this->nomor_pendaftaran->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->nomor_pendaftaran->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->nomor_pendaftaran->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->nama_ruang->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->nama_ruang->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->nama_ruang->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}
		if ($this->nomor_pendaftaran->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(nomor_pendaftaran = '" . ew_AdjustSql($this->nomor_pendaftaran->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->nomor_pendaftaran->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->nomor_pendaftaran->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// nomor_pendaftaran
		$this->nomor_pendaftaran->SetDbValueDef($rsnew, $this->nomor_pendaftaran->CurrentValue, "", FALSE);

		// nama_ruang
		$this->nama_ruang->SetDbValueDef($rsnew, $this->nama_ruang->CurrentValue, NULL, FALSE);

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->SetDbValueDef($rsnew, $this->nomor_peserta_ujian_sdmi->CurrentValue, NULL, FALSE);

		// sekolah_asal
		$this->sekolah_asal->SetDbValueDef($rsnew, $this->sekolah_asal->CurrentValue, NULL, FALSE);

		// nama_lengkap
		$this->nama_lengkap->SetDbValueDef($rsnew, $this->nama_lengkap->CurrentValue, NULL, FALSE);

		// zona
		$this->zona->SetDbValueDef($rsnew, $this->zona->CurrentValue, "", FALSE);

		// nilai_akhir
		$this->nilai_akhir->SetDbValueDef($rsnew, $this->nilai_akhir->CurrentValue, NULL, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

		// persyaratan
		$this->persyaratan->SetDbValueDef($rsnew, $this->persyaratan->CurrentValue, NULL, FALSE);

		// catatan
		$this->catatan->SetDbValueDef($rsnew, $this->catatan->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$item->Body = "<button id=\"emf_pendaftar_cabut_berkas\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pendaftar_cabut_berkas',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpendaftar_cabut_berkaslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		case "x_nomor_pendaftaran":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_no` AS `LinkFld`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
			$sWhereWrk = "{filter}";
			$this->nomor_pendaftaran->LookupFilters = array();
			if (!$GLOBALS["pendaftar_cabut_berkas"]->UserIDAllow($GLOBALS["pendaftar_cabut_berkas"]->CurrentAction)) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_no` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_ruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_ruang` AS `LinkFld`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
			$sWhereWrk = "{filter}";
			$this->nama_ruang->LookupFilters = array();
			if (!$GLOBALS["pendaftar_cabut_berkas"]->UserIDAllow($GLOBALS["pendaftar_cabut_berkas"]->CurrentAction)) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_ruang` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nomor_peserta_ujian_sdmi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_pd` AS `LinkFld`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
			$sWhereWrk = "{filter}";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_pd` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nomor_pendaftaran":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_no`, `nomor_pendaftaran` AS `DispFld` FROM `no_pendaftaran`";
			$sWhereWrk = "`nomor_pendaftaran` LIKE '{query_value}%'";
			$this->nomor_pendaftaran->LookupFilters = array();
			if (!$GLOBALS["pendaftar_cabut_berkas"]->UserIDAllow($GLOBALS["pendaftar_cabut_berkas"]->CurrentAction)) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_ruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_ruang`, `nama_ruang` AS `DispFld` FROM `ruang`";
			$sWhereWrk = "`nama_ruang` LIKE '{query_value}%'";
			$this->nama_ruang->LookupFilters = array();
			if (!$GLOBALS["pendaftar_cabut_berkas"]->UserIDAllow($GLOBALS["pendaftar_cabut_berkas"]->CurrentAction)) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nomor_peserta_ujian_sdmi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_pd`, `nopes` AS `DispFld` FROM `db_pd`";
			$sWhereWrk = "`nopes` LIKE '{query_value}%'";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($pendaftar_cabut_berkas_list)) $pendaftar_cabut_berkas_list = new cpendaftar_cabut_berkas_list();

// Page init
$pendaftar_cabut_berkas_list->Page_Init();

// Page main
$pendaftar_cabut_berkas_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendaftar_cabut_berkas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpendaftar_cabut_berkaslist = new ew_Form("fpendaftar_cabut_berkaslist", "list");
fpendaftar_cabut_berkaslist.FormKeyCountName = '<?php echo $pendaftar_cabut_berkas_list->FormKeyCountName ?>';

// Validate form
fpendaftar_cabut_berkaslist.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_nomor_pendaftaran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar_cabut_berkas->nomor_pendaftaran->FldCaption(), $pendaftar_cabut_berkas->nomor_pendaftaran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_zona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar_cabut_berkas->zona->FldCaption(), $pendaftar_cabut_berkas->zona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar_cabut_berkas->status->FldCaption(), $pendaftar_cabut_berkas->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpendaftar_cabut_berkaslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendaftar_cabut_berkaslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpendaftar_cabut_berkaslist.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_id_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fpendaftar_cabut_berkaslist.Lists["x_nomor_pendaftaran"].Data = "<?php echo $pendaftar_cabut_berkas_list->nomor_pendaftaran->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar_cabut_berkaslist.AutoSuggests["x_nomor_pendaftaran"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $pendaftar_cabut_berkas_list->nomor_pendaftaran->LookupFilterQuery(TRUE, "list"))) ?>;
fpendaftar_cabut_berkaslist.Lists["x_nama_ruang"] = {"LinkField":"x_id_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fpendaftar_cabut_berkaslist.Lists["x_nama_ruang"].Data = "<?php echo $pendaftar_cabut_berkas_list->nama_ruang->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar_cabut_berkaslist.AutoSuggests["x_nama_ruang"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $pendaftar_cabut_berkas_list->nama_ruang->LookupFilterQuery(TRUE, "list"))) ?>;
fpendaftar_cabut_berkaslist.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_id_pd","Ajax":true,"AutoFill":false,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fpendaftar_cabut_berkaslist.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $pendaftar_cabut_berkas_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "list") ?>";
fpendaftar_cabut_berkaslist.AutoSuggests["x_nomor_peserta_ujian_sdmi"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $pendaftar_cabut_berkas_list->nomor_peserta_ujian_sdmi->LookupFilterQuery(TRUE, "list"))) ?>;
fpendaftar_cabut_berkaslist.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar_cabut_berkaslist.Lists["x_status"].Options = <?php echo json_encode($pendaftar_cabut_berkas_list->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fpendaftar_cabut_berkaslistsrch = new ew_Form("fpendaftar_cabut_berkaslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pendaftar_cabut_berkas_list->TotalRecs > 0 && $pendaftar_cabut_berkas_list->ExportOptions->Visible()) { ?>
<?php $pendaftar_cabut_berkas_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas_list->SearchOptions->Visible()) { ?>
<?php $pendaftar_cabut_berkas_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas_list->FilterOptions->Visible()) { ?>
<?php $pendaftar_cabut_berkas_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $pendaftar_cabut_berkas_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pendaftar_cabut_berkas_list->TotalRecs <= 0)
			$pendaftar_cabut_berkas_list->TotalRecs = $pendaftar_cabut_berkas->ListRecordCount();
	} else {
		if (!$pendaftar_cabut_berkas_list->Recordset && ($pendaftar_cabut_berkas_list->Recordset = $pendaftar_cabut_berkas_list->LoadRecordset()))
			$pendaftar_cabut_berkas_list->TotalRecs = $pendaftar_cabut_berkas_list->Recordset->RecordCount();
	}
	$pendaftar_cabut_berkas_list->StartRec = 1;
	if ($pendaftar_cabut_berkas_list->DisplayRecs <= 0 || ($pendaftar_cabut_berkas->Export <> "" && $pendaftar_cabut_berkas->ExportAll)) // Display all records
		$pendaftar_cabut_berkas_list->DisplayRecs = $pendaftar_cabut_berkas_list->TotalRecs;
	if (!($pendaftar_cabut_berkas->Export <> "" && $pendaftar_cabut_berkas->ExportAll))
		$pendaftar_cabut_berkas_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pendaftar_cabut_berkas_list->Recordset = $pendaftar_cabut_berkas_list->LoadRecordset($pendaftar_cabut_berkas_list->StartRec-1, $pendaftar_cabut_berkas_list->DisplayRecs);

	// Set no record found message
	if ($pendaftar_cabut_berkas->CurrentAction == "" && $pendaftar_cabut_berkas_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pendaftar_cabut_berkas_list->setWarningMessage(ew_DeniedMsg());
		if ($pendaftar_cabut_berkas_list->SearchWhere == "0=101")
			$pendaftar_cabut_berkas_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pendaftar_cabut_berkas_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pendaftar_cabut_berkas_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($pendaftar_cabut_berkas->Export == "" && $pendaftar_cabut_berkas->CurrentAction == "") { ?>
<form name="fpendaftar_cabut_berkaslistsrch" id="fpendaftar_cabut_berkaslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pendaftar_cabut_berkas_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpendaftar_cabut_berkaslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pendaftar_cabut_berkas">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pendaftar_cabut_berkas_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pendaftar_cabut_berkas_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pendaftar_cabut_berkas_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pendaftar_cabut_berkas_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pendaftar_cabut_berkas_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $pendaftar_cabut_berkas_list->ShowPageHeader(); ?>
<?php
$pendaftar_cabut_berkas_list->ShowMessage();
?>
<?php if ($pendaftar_cabut_berkas_list->TotalRecs > 0 || $pendaftar_cabut_berkas->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($pendaftar_cabut_berkas_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> pendaftar_cabut_berkas">
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($pendaftar_cabut_berkas->CurrentAction <> "gridadd" && $pendaftar_cabut_berkas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pendaftar_cabut_berkas_list->Pager)) $pendaftar_cabut_berkas_list->Pager = new cPrevNextPager($pendaftar_cabut_berkas_list->StartRec, $pendaftar_cabut_berkas_list->DisplayRecs, $pendaftar_cabut_berkas_list->TotalRecs, $pendaftar_cabut_berkas_list->AutoHidePager) ?>
<?php if ($pendaftar_cabut_berkas_list->Pager->RecordCount > 0 && $pendaftar_cabut_berkas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pendaftar_cabut_berkas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($pendaftar_cabut_berkas_list->TotalRecs > 0 && (!$pendaftar_cabut_berkas_list->AutoHidePageSizeSelector || $pendaftar_cabut_berkas_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="pendaftar_cabut_berkas">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($pendaftar_cabut_berkas->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar_cabut_berkas_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpendaftar_cabut_berkaslist" id="fpendaftar_cabut_berkaslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendaftar_cabut_berkas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendaftar_cabut_berkas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendaftar_cabut_berkas">
<div id="gmp_pendaftar_cabut_berkas" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($pendaftar_cabut_berkas_list->TotalRecs > 0 || $pendaftar_cabut_berkas->CurrentAction == "gridedit") { ?>
<table id="tbl_pendaftar_cabut_berkaslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$pendaftar_cabut_berkas_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pendaftar_cabut_berkas_list->RenderListOptions();

// Render list options (header, left)
$pendaftar_cabut_berkas_list->ListOptions->Render("header", "left");
?>
<?php if ($pendaftar_cabut_berkas->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nomor_pendaftaran) == "") { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_nomor_pendaftaran" class="pendaftar_cabut_berkas_nomor_pendaftaran"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_pendaftaran" class="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nomor_pendaftaran) ?>',1);"><div id="elh_pendaftar_cabut_berkas_nomor_pendaftaran" class="pendaftar_cabut_berkas_nomor_pendaftaran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->nomor_pendaftaran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->nomor_pendaftaran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->nama_ruang->Visible) { // nama_ruang ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nama_ruang) == "") { ?>
		<th data-name="nama_ruang" class="<?php echo $pendaftar_cabut_berkas->nama_ruang->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_nama_ruang" class="pendaftar_cabut_berkas_nama_ruang"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nama_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ruang" class="<?php echo $pendaftar_cabut_berkas->nama_ruang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nama_ruang) ?>',1);"><div id="elh_pendaftar_cabut_berkas_nama_ruang" class="pendaftar_cabut_berkas_nama_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nama_ruang->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->nama_ruang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->nama_ruang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi) == "") { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi) ?>',1);"><div id="elh_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->sekolah_asal->Visible) { // sekolah_asal ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->sekolah_asal) == "") { ?>
		<th data-name="sekolah_asal" class="<?php echo $pendaftar_cabut_berkas->sekolah_asal->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_sekolah_asal" class="pendaftar_cabut_berkas_sekolah_asal"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->sekolah_asal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_asal" class="<?php echo $pendaftar_cabut_berkas->sekolah_asal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->sekolah_asal) ?>',1);"><div id="elh_pendaftar_cabut_berkas_sekolah_asal" class="pendaftar_cabut_berkas_sekolah_asal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->sekolah_asal->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->sekolah_asal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->sekolah_asal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->nama_lengkap->Visible) { // nama_lengkap ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nama_lengkap) == "") { ?>
		<th data-name="nama_lengkap" class="<?php echo $pendaftar_cabut_berkas->nama_lengkap->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_nama_lengkap" class="pendaftar_cabut_berkas_nama_lengkap"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nama_lengkap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_lengkap" class="<?php echo $pendaftar_cabut_berkas->nama_lengkap->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nama_lengkap) ?>',1);"><div id="elh_pendaftar_cabut_berkas_nama_lengkap" class="pendaftar_cabut_berkas_nama_lengkap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nama_lengkap->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->nama_lengkap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->nama_lengkap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->zona->Visible) { // zona ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->zona) == "") { ?>
		<th data-name="zona" class="<?php echo $pendaftar_cabut_berkas->zona->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_zona" class="pendaftar_cabut_berkas_zona"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->zona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona" class="<?php echo $pendaftar_cabut_berkas->zona->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->zona) ?>',1);"><div id="elh_pendaftar_cabut_berkas_zona" class="pendaftar_cabut_berkas_zona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->zona->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->zona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->zona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->nilai_akhir->Visible) { // nilai_akhir ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nilai_akhir) == "") { ?>
		<th data-name="nilai_akhir" class="<?php echo $pendaftar_cabut_berkas->nilai_akhir->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_nilai_akhir" class="pendaftar_cabut_berkas_nilai_akhir"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nilai_akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai_akhir" class="<?php echo $pendaftar_cabut_berkas->nilai_akhir->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->nilai_akhir) ?>',1);"><div id="elh_pendaftar_cabut_berkas_nilai_akhir" class="pendaftar_cabut_berkas_nilai_akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->nilai_akhir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->nilai_akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->nilai_akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->status->Visible) { // status ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->status) == "") { ?>
		<th data-name="status" class="<?php echo $pendaftar_cabut_berkas->status->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_status" class="pendaftar_cabut_berkas_status"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $pendaftar_cabut_berkas->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->status) ?>',1);"><div id="elh_pendaftar_cabut_berkas_status" class="pendaftar_cabut_berkas_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->persyaratan->Visible) { // persyaratan ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->persyaratan) == "") { ?>
		<th data-name="persyaratan" class="<?php echo $pendaftar_cabut_berkas->persyaratan->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_persyaratan" class="pendaftar_cabut_berkas_persyaratan"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->persyaratan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="persyaratan" class="<?php echo $pendaftar_cabut_berkas->persyaratan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->persyaratan) ?>',1);"><div id="elh_pendaftar_cabut_berkas_persyaratan" class="pendaftar_cabut_berkas_persyaratan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->persyaratan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->persyaratan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->persyaratan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->catatan->Visible) { // catatan ?>
	<?php if ($pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->catatan) == "") { ?>
		<th data-name="catatan" class="<?php echo $pendaftar_cabut_berkas->catatan->HeaderCellClass() ?>"><div id="elh_pendaftar_cabut_berkas_catatan" class="pendaftar_cabut_berkas_catatan"><div class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->catatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="catatan" class="<?php echo $pendaftar_cabut_berkas->catatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pendaftar_cabut_berkas->SortUrl($pendaftar_cabut_berkas->catatan) ?>',1);"><div id="elh_pendaftar_cabut_berkas_catatan" class="pendaftar_cabut_berkas_catatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pendaftar_cabut_berkas->catatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pendaftar_cabut_berkas->catatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pendaftar_cabut_berkas->catatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pendaftar_cabut_berkas_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pendaftar_cabut_berkas->ExportAll && $pendaftar_cabut_berkas->Export <> "") {
	$pendaftar_cabut_berkas_list->StopRec = $pendaftar_cabut_berkas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pendaftar_cabut_berkas_list->TotalRecs > $pendaftar_cabut_berkas_list->StartRec + $pendaftar_cabut_berkas_list->DisplayRecs - 1)
		$pendaftar_cabut_berkas_list->StopRec = $pendaftar_cabut_berkas_list->StartRec + $pendaftar_cabut_berkas_list->DisplayRecs - 1;
	else
		$pendaftar_cabut_berkas_list->StopRec = $pendaftar_cabut_berkas_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($pendaftar_cabut_berkas_list->FormKeyCountName) && ($pendaftar_cabut_berkas->CurrentAction == "gridadd" || $pendaftar_cabut_berkas->CurrentAction == "gridedit" || $pendaftar_cabut_berkas->CurrentAction == "F")) {
		$pendaftar_cabut_berkas_list->KeyCount = $objForm->GetValue($pendaftar_cabut_berkas_list->FormKeyCountName);
		$pendaftar_cabut_berkas_list->StopRec = $pendaftar_cabut_berkas_list->StartRec + $pendaftar_cabut_berkas_list->KeyCount - 1;
	}
}
$pendaftar_cabut_berkas_list->RecCnt = $pendaftar_cabut_berkas_list->StartRec - 1;
if ($pendaftar_cabut_berkas_list->Recordset && !$pendaftar_cabut_berkas_list->Recordset->EOF) {
	$pendaftar_cabut_berkas_list->Recordset->MoveFirst();
	$bSelectLimit = $pendaftar_cabut_berkas_list->UseSelectLimit;
	if (!$bSelectLimit && $pendaftar_cabut_berkas_list->StartRec > 1)
		$pendaftar_cabut_berkas_list->Recordset->Move($pendaftar_cabut_berkas_list->StartRec - 1);
} elseif (!$pendaftar_cabut_berkas->AllowAddDeleteRow && $pendaftar_cabut_berkas_list->StopRec == 0) {
	$pendaftar_cabut_berkas_list->StopRec = $pendaftar_cabut_berkas->GridAddRowCount;
}

// Initialize aggregate
$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pendaftar_cabut_berkas->ResetAttrs();
$pendaftar_cabut_berkas_list->RenderRow();
$pendaftar_cabut_berkas_list->EditRowCnt = 0;
if ($pendaftar_cabut_berkas->CurrentAction == "edit")
	$pendaftar_cabut_berkas_list->RowIndex = 1;
if ($pendaftar_cabut_berkas->CurrentAction == "gridedit")
	$pendaftar_cabut_berkas_list->RowIndex = 0;
while ($pendaftar_cabut_berkas_list->RecCnt < $pendaftar_cabut_berkas_list->StopRec) {
	$pendaftar_cabut_berkas_list->RecCnt++;
	if (intval($pendaftar_cabut_berkas_list->RecCnt) >= intval($pendaftar_cabut_berkas_list->StartRec)) {
		$pendaftar_cabut_berkas_list->RowCnt++;
		if ($pendaftar_cabut_berkas->CurrentAction == "gridadd" || $pendaftar_cabut_berkas->CurrentAction == "gridedit" || $pendaftar_cabut_berkas->CurrentAction == "F") {
			$pendaftar_cabut_berkas_list->RowIndex++;
			$objForm->Index = $pendaftar_cabut_berkas_list->RowIndex;
			if ($objForm->HasValue($pendaftar_cabut_berkas_list->FormActionName))
				$pendaftar_cabut_berkas_list->RowAction = strval($objForm->GetValue($pendaftar_cabut_berkas_list->FormActionName));
			elseif ($pendaftar_cabut_berkas->CurrentAction == "gridadd")
				$pendaftar_cabut_berkas_list->RowAction = "insert";
			else
				$pendaftar_cabut_berkas_list->RowAction = "";
		}

		// Set up key count
		$pendaftar_cabut_berkas_list->KeyCount = $pendaftar_cabut_berkas_list->RowIndex;

		// Init row class and style
		$pendaftar_cabut_berkas->ResetAttrs();
		$pendaftar_cabut_berkas->CssClass = "";
		if ($pendaftar_cabut_berkas->CurrentAction == "gridadd") {
			$pendaftar_cabut_berkas_list->LoadRowValues(); // Load default values
		} else {
			$pendaftar_cabut_berkas_list->LoadRowValues($pendaftar_cabut_berkas_list->Recordset); // Load row values
		}
		$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($pendaftar_cabut_berkas->CurrentAction == "edit") {
			if ($pendaftar_cabut_berkas_list->CheckInlineEditKey() && $pendaftar_cabut_berkas_list->EditRowCnt == 0) { // Inline edit
				$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($pendaftar_cabut_berkas->CurrentAction == "gridedit") { // Grid edit
			if ($pendaftar_cabut_berkas->EventCancelled) {
				$pendaftar_cabut_berkas_list->RestoreCurrentRowFormValues($pendaftar_cabut_berkas_list->RowIndex); // Restore form values
			}
			if ($pendaftar_cabut_berkas_list->RowAction == "insert")
				$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($pendaftar_cabut_berkas->CurrentAction == "edit" && $pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT && $pendaftar_cabut_berkas->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$pendaftar_cabut_berkas_list->RestoreFormValues(); // Restore form values
		}
		if ($pendaftar_cabut_berkas->CurrentAction == "gridedit" && ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT || $pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) && $pendaftar_cabut_berkas->EventCancelled) // Update failed
			$pendaftar_cabut_berkas_list->RestoreCurrentRowFormValues($pendaftar_cabut_berkas_list->RowIndex); // Restore form values
		if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$pendaftar_cabut_berkas_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$pendaftar_cabut_berkas->RowAttrs = array_merge($pendaftar_cabut_berkas->RowAttrs, array('data-rowindex'=>$pendaftar_cabut_berkas_list->RowCnt, 'id'=>'r' . $pendaftar_cabut_berkas_list->RowCnt . '_pendaftar_cabut_berkas', 'data-rowtype'=>$pendaftar_cabut_berkas->RowType));

		// Render row
		$pendaftar_cabut_berkas_list->RenderRow();

		// Render list options
		$pendaftar_cabut_berkas_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pendaftar_cabut_berkas_list->RowAction <> "delete" && $pendaftar_cabut_berkas_list->RowAction <> "insertdelete" && !($pendaftar_cabut_berkas_list->RowAction == "insert" && $pendaftar_cabut_berkas->CurrentAction == "F" && $pendaftar_cabut_berkas_list->EmptyRow())) {
?>
	<tr<?php echo $pendaftar_cabut_berkas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pendaftar_cabut_berkas_list->ListOptions->Render("body", "left", $pendaftar_cabut_berkas_list->RowCnt);
?>
	<?php if ($pendaftar_cabut_berkas->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran"<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_pendaftaran" class="form-group pendaftar_cabut_berkas_nomor_pendaftaran">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nomor_pendaftaran->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nomor_pendaftaran->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->EditValue ?>" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_pendaftaran" data-value-separator="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_pendaftaran" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_pendaftaran" class="form-group pendaftar_cabut_berkas_nomor_pendaftaran">
<span<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_pendaftaran" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_pendaftaran" class="pendaftar_cabut_berkas_nomor_pendaftaran">
<span<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_id_pendaftar" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->id_pendaftar->CurrentValue) ?>">
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_id_pendaftar" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->id_pendaftar->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT || $pendaftar_cabut_berkas->CurrentMode == "edit") { ?>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_id_pendaftar" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_id_pendaftar" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->id_pendaftar->CurrentValue) ?>">
<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang"<?php echo $pendaftar_cabut_berkas->nama_ruang->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$pendaftar_cabut_berkas->UserIDAllow($pendaftar_cabut_berkas->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_ruang" class="form-group pendaftar_cabut_berkas_nama_ruang">
<select data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" data-value-separator="<?php echo $pendaftar_cabut_berkas->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang"<?php echo $pendaftar_cabut_berkas->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nama_ruang->SelectOptionListHtml("x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_ruang" class="form-group pendaftar_cabut_berkas_nama_ruang">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nama_ruang->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nama_ruang->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo $pendaftar_cabut_berkas->nama_ruang->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nama_ruang->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" data-value-separator="<?php echo $pendaftar_cabut_berkas->nama_ruang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_ruang" class="form-group pendaftar_cabut_berkas_nama_ruang">
<span<?php echo $pendaftar_cabut_berkas->nama_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->nama_ruang->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_ruang" class="pendaftar_cabut_berkas_nama_ruang">
<span<?php echo $pendaftar_cabut_berkas->nama_ruang->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nama_ruang->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi"<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="form-group pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_peserta_ujian_sdmi" data-value-separator="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_peserta_ujian_sdmi" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="form-group pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi">
<span<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_peserta_ujian_sdmi" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi">
<span<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal"<?php echo $pendaftar_cabut_berkas->sekolah_asal->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_sekolah_asal" class="form-group pendaftar_cabut_berkas_sekolah_asal">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_sekolah_asal" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->sekolah_asal->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->sekolah_asal->EditValue ?>"<?php echo $pendaftar_cabut_berkas->sekolah_asal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_sekolah_asal" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->sekolah_asal->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_sekolah_asal" class="form-group pendaftar_cabut_berkas_sekolah_asal">
<span<?php echo $pendaftar_cabut_berkas->sekolah_asal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->sekolah_asal->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_sekolah_asal" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->sekolah_asal->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_sekolah_asal" class="pendaftar_cabut_berkas_sekolah_asal">
<span<?php echo $pendaftar_cabut_berkas->sekolah_asal->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->sekolah_asal->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap"<?php echo $pendaftar_cabut_berkas->nama_lengkap->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_lengkap" class="form-group pendaftar_cabut_berkas_nama_lengkap">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_nama_lengkap" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_lengkap->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->nama_lengkap->EditValue ?>"<?php echo $pendaftar_cabut_berkas->nama_lengkap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_lengkap" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_lengkap->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_lengkap" class="form-group pendaftar_cabut_berkas_nama_lengkap">
<span<?php echo $pendaftar_cabut_berkas->nama_lengkap->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->nama_lengkap->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_lengkap" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_lengkap->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nama_lengkap" class="pendaftar_cabut_berkas_nama_lengkap">
<span<?php echo $pendaftar_cabut_berkas->nama_lengkap->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nama_lengkap->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->zona->Visible) { // zona ?>
		<td data-name="zona"<?php echo $pendaftar_cabut_berkas->zona->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_zona" class="form-group pendaftar_cabut_berkas_zona">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_zona" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->zona->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->zona->EditValue ?>"<?php echo $pendaftar_cabut_berkas->zona->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_zona" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->zona->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_zona" class="form-group pendaftar_cabut_berkas_zona">
<span<?php echo $pendaftar_cabut_berkas->zona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->zona->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_zona" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->zona->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_zona" class="pendaftar_cabut_berkas_zona">
<span<?php echo $pendaftar_cabut_berkas->zona->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->zona->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir"<?php echo $pendaftar_cabut_berkas->nilai_akhir->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nilai_akhir" class="form-group pendaftar_cabut_berkas_nilai_akhir">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_nilai_akhir" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" size="30" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nilai_akhir->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->nilai_akhir->EditValue ?>"<?php echo $pendaftar_cabut_berkas->nilai_akhir->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nilai_akhir" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nilai_akhir->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nilai_akhir" class="form-group pendaftar_cabut_berkas_nilai_akhir">
<span<?php echo $pendaftar_cabut_berkas->nilai_akhir->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->nilai_akhir->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nilai_akhir" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nilai_akhir->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_nilai_akhir" class="pendaftar_cabut_berkas_nilai_akhir">
<span<?php echo $pendaftar_cabut_berkas->nilai_akhir->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nilai_akhir->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->status->Visible) { // status ?>
		<td data-name="status"<?php echo $pendaftar_cabut_berkas->status->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_status" class="form-group pendaftar_cabut_berkas_status">
<div id="tp_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" class="ewTemplate"><input type="radio" data-table="pendaftar_cabut_berkas" data-field="x_status" data-value-separator="<?php echo $pendaftar_cabut_berkas->status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" value="{value}"<?php echo $pendaftar_cabut_berkas->status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar_cabut_berkas->status->RadioButtonListHtml(FALSE, "x{$pendaftar_cabut_berkas_list->RowIndex}_status") ?>
</div></div>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_status" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->status->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_status" class="form-group pendaftar_cabut_berkas_status">
<div id="tp_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" class="ewTemplate"><input type="radio" data-table="pendaftar_cabut_berkas" data-field="x_status" data-value-separator="<?php echo $pendaftar_cabut_berkas->status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" value="{value}"<?php echo $pendaftar_cabut_berkas->status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar_cabut_berkas->status->RadioButtonListHtml(FALSE, "x{$pendaftar_cabut_berkas_list->RowIndex}_status") ?>
</div></div>
</span>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_status" class="pendaftar_cabut_berkas_status">
<span<?php echo $pendaftar_cabut_berkas->status->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan"<?php echo $pendaftar_cabut_berkas->persyaratan->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_persyaratan" class="form-group pendaftar_cabut_berkas_persyaratan">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_persyaratan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->persyaratan->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->persyaratan->EditValue ?>"<?php echo $pendaftar_cabut_berkas->persyaratan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_persyaratan" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->persyaratan->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_persyaratan" class="form-group pendaftar_cabut_berkas_persyaratan">
<span<?php echo $pendaftar_cabut_berkas->persyaratan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->persyaratan->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_persyaratan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->persyaratan->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_persyaratan" class="pendaftar_cabut_berkas_persyaratan">
<span<?php echo $pendaftar_cabut_berkas->persyaratan->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->persyaratan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->catatan->Visible) { // catatan ?>
		<td data-name="catatan"<?php echo $pendaftar_cabut_berkas->catatan->CellAttributes() ?>>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_catatan" class="form-group pendaftar_cabut_berkas_catatan">
<textarea data-table="pendaftar_cabut_berkas" data-field="x_catatan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->catatan->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->catatan->EditAttributes() ?>><?php echo $pendaftar_cabut_berkas->catatan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_catatan" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->catatan->OldValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_catatan" class="form-group pendaftar_cabut_berkas_catatan">
<span<?php echo $pendaftar_cabut_berkas->catatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar_cabut_berkas->catatan->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_catatan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->catatan->CurrentValue) ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pendaftar_cabut_berkas_list->RowCnt ?>_pendaftar_cabut_berkas_catatan" class="pendaftar_cabut_berkas_catatan">
<span<?php echo $pendaftar_cabut_berkas->catatan->ViewAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->catatan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pendaftar_cabut_berkas_list->ListOptions->Render("body", "right", $pendaftar_cabut_berkas_list->RowCnt);
?>
	</tr>
<?php if ($pendaftar_cabut_berkas->RowType == EW_ROWTYPE_ADD || $pendaftar_cabut_berkas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.UpdateOpts(<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($pendaftar_cabut_berkas->CurrentAction <> "gridadd")
		if (!$pendaftar_cabut_berkas_list->Recordset->EOF) $pendaftar_cabut_berkas_list->Recordset->MoveNext();
}
?>
<?php
	if ($pendaftar_cabut_berkas->CurrentAction == "gridadd" || $pendaftar_cabut_berkas->CurrentAction == "gridedit") {
		$pendaftar_cabut_berkas_list->RowIndex = '$rowindex$';
		$pendaftar_cabut_berkas_list->LoadRowValues();

		// Set row properties
		$pendaftar_cabut_berkas->ResetAttrs();
		$pendaftar_cabut_berkas->RowAttrs = array_merge($pendaftar_cabut_berkas->RowAttrs, array('data-rowindex'=>$pendaftar_cabut_berkas_list->RowIndex, 'id'=>'r0_pendaftar_cabut_berkas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($pendaftar_cabut_berkas->RowAttrs["class"], "ewTemplate");
		$pendaftar_cabut_berkas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$pendaftar_cabut_berkas_list->RenderRow();

		// Render list options
		$pendaftar_cabut_berkas_list->RenderListOptions();
		$pendaftar_cabut_berkas_list->StartRowCnt = 0;
?>
	<tr<?php echo $pendaftar_cabut_berkas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pendaftar_cabut_berkas_list->ListOptions->Render("body", "left", $pendaftar_cabut_berkas_list->RowIndex);
?>
	<?php if ($pendaftar_cabut_berkas->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
		<td data-name="nomor_pendaftaran">
<span id="el$rowindex$_pendaftar_cabut_berkas_nomor_pendaftaran" class="form-group pendaftar_cabut_berkas_nomor_pendaftaran">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nomor_pendaftaran->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nomor_pendaftaran->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->EditValue ?>" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_pendaftaran" data-value-separator="<?php echo $pendaftar_cabut_berkas->nomor_pendaftaran->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_pendaftaran" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_pendaftaran" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_pendaftaran->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$pendaftar_cabut_berkas->UserIDAllow($pendaftar_cabut_berkas->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_pendaftar_cabut_berkas_nama_ruang" class="form-group pendaftar_cabut_berkas_nama_ruang">
<select data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" data-value-separator="<?php echo $pendaftar_cabut_berkas->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang"<?php echo $pendaftar_cabut_berkas->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar_cabut_berkas->nama_ruang->SelectOptionListHtml("x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendaftar_cabut_berkas_nama_ruang" class="form-group pendaftar_cabut_berkas_nama_ruang">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nama_ruang->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nama_ruang->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo $pendaftar_cabut_berkas->nama_ruang->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nama_ruang->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" data-value-separator="<?php echo $pendaftar_cabut_berkas->nama_ruang->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_ruang" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_ruang->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
		<td data-name="nomor_peserta_ujian_sdmi">
<span id="el$rowindex$_pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi" class="form-group pendaftar_cabut_berkas_nomor_peserta_ujian_sdmi">
<?php
$wrkonchange = trim(" " . @$pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" style="white-space: nowrap; z-index: <?php echo (9000 - $pendaftar_cabut_berkas_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="sv_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_peserta_ujian_sdmi" data-value-separator="<?php echo $pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.CreateAutoSuggest({"id":"x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nomor_peserta_ujian_sdmi" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nomor_peserta_ujian_sdmi->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->sekolah_asal->Visible) { // sekolah_asal ?>
		<td data-name="sekolah_asal">
<span id="el$rowindex$_pendaftar_cabut_berkas_sekolah_asal" class="form-group pendaftar_cabut_berkas_sekolah_asal">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_sekolah_asal" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->sekolah_asal->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->sekolah_asal->EditValue ?>"<?php echo $pendaftar_cabut_berkas->sekolah_asal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_sekolah_asal" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_sekolah_asal" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->sekolah_asal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nama_lengkap->Visible) { // nama_lengkap ?>
		<td data-name="nama_lengkap">
<span id="el$rowindex$_pendaftar_cabut_berkas_nama_lengkap" class="form-group pendaftar_cabut_berkas_nama_lengkap">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_nama_lengkap" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_lengkap->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->nama_lengkap->EditValue ?>"<?php echo $pendaftar_cabut_berkas->nama_lengkap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nama_lengkap" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nama_lengkap" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nama_lengkap->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->zona->Visible) { // zona ?>
		<td data-name="zona">
<span id="el$rowindex$_pendaftar_cabut_berkas_zona" class="form-group pendaftar_cabut_berkas_zona">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_zona" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->zona->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->zona->EditValue ?>"<?php echo $pendaftar_cabut_berkas->zona->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_zona" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_zona" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->zona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->nilai_akhir->Visible) { // nilai_akhir ?>
		<td data-name="nilai_akhir">
<span id="el$rowindex$_pendaftar_cabut_berkas_nilai_akhir" class="form-group pendaftar_cabut_berkas_nilai_akhir">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_nilai_akhir" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" size="30" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nilai_akhir->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->nilai_akhir->EditValue ?>"<?php echo $pendaftar_cabut_berkas->nilai_akhir->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_nilai_akhir" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_nilai_akhir" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->nilai_akhir->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->status->Visible) { // status ?>
		<td data-name="status">
<span id="el$rowindex$_pendaftar_cabut_berkas_status" class="form-group pendaftar_cabut_berkas_status">
<div id="tp_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" class="ewTemplate"><input type="radio" data-table="pendaftar_cabut_berkas" data-field="x_status" data-value-separator="<?php echo $pendaftar_cabut_berkas->status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" value="{value}"<?php echo $pendaftar_cabut_berkas->status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar_cabut_berkas->status->RadioButtonListHtml(FALSE, "x{$pendaftar_cabut_berkas_list->RowIndex}_status") ?>
</div></div>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_status" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->persyaratan->Visible) { // persyaratan ?>
		<td data-name="persyaratan">
<span id="el$rowindex$_pendaftar_cabut_berkas_persyaratan" class="form-group pendaftar_cabut_berkas_persyaratan">
<input type="text" data-table="pendaftar_cabut_berkas" data-field="x_persyaratan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->persyaratan->getPlaceHolder()) ?>" value="<?php echo $pendaftar_cabut_berkas->persyaratan->EditValue ?>"<?php echo $pendaftar_cabut_berkas->persyaratan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_persyaratan" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_persyaratan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->persyaratan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pendaftar_cabut_berkas->catatan->Visible) { // catatan ?>
		<td data-name="catatan">
<span id="el$rowindex$_pendaftar_cabut_berkas_catatan" class="form-group pendaftar_cabut_berkas_catatan">
<textarea data-table="pendaftar_cabut_berkas" data-field="x_catatan" name="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" id="x<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->catatan->getPlaceHolder()) ?>"<?php echo $pendaftar_cabut_berkas->catatan->EditAttributes() ?>><?php echo $pendaftar_cabut_berkas->catatan->EditValue ?></textarea>
</span>
<input type="hidden" data-table="pendaftar_cabut_berkas" data-field="x_catatan" name="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" id="o<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>_catatan" value="<?php echo ew_HtmlEncode($pendaftar_cabut_berkas->catatan->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pendaftar_cabut_berkas_list->ListOptions->Render("body", "right", $pendaftar_cabut_berkas_list->RowCnt);
?>
<script type="text/javascript">
fpendaftar_cabut_berkaslist.UpdateOpts(<?php echo $pendaftar_cabut_berkas_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $pendaftar_cabut_berkas_list->FormKeyCountName ?>" id="<?php echo $pendaftar_cabut_berkas_list->FormKeyCountName ?>" value="<?php echo $pendaftar_cabut_berkas_list->KeyCount ?>">
<?php } ?>
<?php if ($pendaftar_cabut_berkas->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $pendaftar_cabut_berkas_list->FormKeyCountName ?>" id="<?php echo $pendaftar_cabut_berkas_list->FormKeyCountName ?>" value="<?php echo $pendaftar_cabut_berkas_list->KeyCount ?>">
<?php echo $pendaftar_cabut_berkas_list->MultiSelectKey ?>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pendaftar_cabut_berkas_list->Recordset)
	$pendaftar_cabut_berkas_list->Recordset->Close();
?>
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($pendaftar_cabut_berkas->CurrentAction <> "gridadd" && $pendaftar_cabut_berkas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pendaftar_cabut_berkas_list->Pager)) $pendaftar_cabut_berkas_list->Pager = new cPrevNextPager($pendaftar_cabut_berkas_list->StartRec, $pendaftar_cabut_berkas_list->DisplayRecs, $pendaftar_cabut_berkas_list->TotalRecs, $pendaftar_cabut_berkas_list->AutoHidePager) ?>
<?php if ($pendaftar_cabut_berkas_list->Pager->RecordCount > 0 && $pendaftar_cabut_berkas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pendaftar_cabut_berkas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pendaftar_cabut_berkas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pendaftar_cabut_berkas_list->PageUrl() ?>start=<?php echo $pendaftar_cabut_berkas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pendaftar_cabut_berkas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($pendaftar_cabut_berkas_list->TotalRecs > 0 && (!$pendaftar_cabut_berkas_list->AutoHidePageSizeSelector || $pendaftar_cabut_berkas_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="pendaftar_cabut_berkas">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($pendaftar_cabut_berkas_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($pendaftar_cabut_berkas->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar_cabut_berkas_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pendaftar_cabut_berkas_list->TotalRecs == 0 && $pendaftar_cabut_berkas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pendaftar_cabut_berkas_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<script type="text/javascript">
fpendaftar_cabut_berkaslistsrch.FilterList = <?php echo $pendaftar_cabut_berkas_list->GetFilterList() ?>;
fpendaftar_cabut_berkaslistsrch.Init();
fpendaftar_cabut_berkaslist.Init();
</script>
<?php } ?>
<?php
$pendaftar_cabut_berkas_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pendaftar_cabut_berkas->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$pendaftar_cabut_berkas_list->Page_Terminate();
?>
