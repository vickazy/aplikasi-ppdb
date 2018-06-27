<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ruang_list = NULL; // Initialize page object first

class cruang_list extends cruang {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'ruang';

	// Page object name
	var $PageObjName = 'ruang_list';

	// Grid form hidden field names
	var $FormName = 'fruanglist';
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

		// Table object (ruang)
		if (!isset($GLOBALS["ruang"]) || get_class($GLOBALS["ruang"]) == "cruang") {
			$GLOBALS["ruang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ruang"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ruangadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ruangdelete.php";
		$this->MultiUpdateUrl = "ruangupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ruang', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fruanglistsrch";

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
		$this->nama_ruang->SetVisibility();
		$this->pwd->SetVisibility();
		$this->user_level->SetVisibility();

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
		global $EW_EXPORT, $ruang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ruang);
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
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
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
			$this->id_ruang->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_ruang->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_nama_ruang") && $objForm->HasValue("o_nama_ruang") && $this->nama_ruang->CurrentValue <> $this->nama_ruang->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pwd") && $objForm->HasValue("o_pwd") && $this->pwd->CurrentValue <> $this->pwd->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_user_level") && $objForm->HasValue("o_user_level") && $this->user_level->CurrentValue <> $this->user_level->OldValue)
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

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->nama_ruang); // nama_ruang
			$this->UpdateSort($this->pwd); // pwd
			$this->UpdateSort($this->user_level); // user_level
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
				$this->nama_ruang->setSort("");
				$this->pwd->setSort("");
				$this->user_level->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id_ruang->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id_ruang->CurrentValue . "\">";
		}
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

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fruanglistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fruanglistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fruanglist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$item->Visible = $Security->CanAdd();
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
					$user = $row['nama_ruang'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = FALSE;
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = FALSE;
					elseif ($UserAction == "resetloginretry")
						$Processed = FALSE;
					elseif ($UserAction == "setpasswordexpired")
						$Processed = FALSE;
					else
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

	// Load default values
	function LoadDefaultValues() {
		$this->id_ruang->CurrentValue = NULL;
		$this->id_ruang->OldValue = $this->id_ruang->CurrentValue;
		$this->nama_ruang->CurrentValue = NULL;
		$this->nama_ruang->OldValue = $this->nama_ruang->CurrentValue;
		$this->pwd->CurrentValue = NULL;
		$this->pwd->OldValue = $this->pwd->CurrentValue;
		$this->user_level->CurrentValue = NULL;
		$this->user_level->OldValue = $this->user_level->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nama_ruang->FldIsDetailKey) {
			$this->nama_ruang->setFormValue($objForm->GetValue("x_nama_ruang"));
		}
		if (!$this->pwd->FldIsDetailKey) {
			$this->pwd->setFormValue($objForm->GetValue("x_pwd"));
		}
		if (!$this->user_level->FldIsDetailKey) {
			$this->user_level->setFormValue($objForm->GetValue("x_user_level"));
		}
		if (!$this->id_ruang->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_ruang->setFormValue($objForm->GetValue("x_id_ruang"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_ruang->CurrentValue = $this->id_ruang->FormValue;
		$this->nama_ruang->CurrentValue = $this->nama_ruang->FormValue;
		$this->pwd->CurrentValue = $this->pwd->FormValue;
		$this->user_level->CurrentValue = $this->user_level->FormValue;
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
		$this->id_ruang->setDbValue($row['id_ruang']);
		$this->nama_ruang->setDbValue($row['nama_ruang']);
		$this->pwd->setDbValue($row['pwd']);
		$this->user_level->setDbValue($row['user_level']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id_ruang'] = $this->id_ruang->CurrentValue;
		$row['nama_ruang'] = $this->nama_ruang->CurrentValue;
		$row['pwd'] = $this->pwd->CurrentValue;
		$row['user_level'] = $this->user_level->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_ruang->DbValue = $row['id_ruang'];
		$this->nama_ruang->DbValue = $row['nama_ruang'];
		$this->pwd->DbValue = $row['pwd'];
		$this->user_level->DbValue = $row['user_level'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_ruang")) <> "")
			$this->id_ruang->CurrentValue = $this->getKey("id_ruang"); // id_ruang
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
		// id_ruang
		// nama_ruang
		// pwd
		// user_level

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_ruang
		$this->id_ruang->ViewValue = $this->id_ruang->CurrentValue;
		$this->id_ruang->ViewCustomAttributes = "";

		// nama_ruang
		$this->nama_ruang->ViewValue = $this->nama_ruang->CurrentValue;
		$this->nama_ruang->ViewCustomAttributes = "";

		// pwd
		$this->pwd->ViewValue = $this->pwd->CurrentValue;
		$this->pwd->ViewCustomAttributes = "";

		// user_level
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->user_level->CurrentValue) <> "") {
			$this->user_level->ViewValue = $this->user_level->OptionCaption($this->user_level->CurrentValue);
		} else {
			$this->user_level->ViewValue = NULL;
		}
		} else {
			$this->user_level->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->user_level->ViewCustomAttributes = "";

			// nama_ruang
			$this->nama_ruang->LinkCustomAttributes = "";
			$this->nama_ruang->HrefValue = "";
			$this->nama_ruang->TooltipValue = "";

			// pwd
			$this->pwd->LinkCustomAttributes = "";
			$this->pwd->HrefValue = "";
			$this->pwd->TooltipValue = "";

			// user_level
			$this->user_level->LinkCustomAttributes = "";
			$this->user_level->HrefValue = "";
			$this->user_level->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
			} elseif (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow($this->CurrentAction)) { // Non system admin
			} else {
			$this->nama_ruang->EditValue = ew_HtmlEncode($this->nama_ruang->CurrentValue);
			$this->nama_ruang->PlaceHolder = ew_RemoveHtml($this->nama_ruang->FldCaption());
			}

			// pwd
			$this->pwd->EditAttrs["class"] = "form-control";
			$this->pwd->EditCustomAttributes = "";
			$this->pwd->EditValue = ew_HtmlEncode($this->pwd->CurrentValue);
			$this->pwd->PlaceHolder = ew_RemoveHtml($this->pwd->FldCaption());

			// user_level
			$this->user_level->EditAttrs["class"] = "form-control";
			$this->user_level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->user_level->EditValue = $Language->Phrase("PasswordMask");
			} else {
			$this->user_level->EditValue = $this->user_level->Options(TRUE);
			}

			// Add refer script
			// nama_ruang

			$this->nama_ruang->LinkCustomAttributes = "";
			$this->nama_ruang->HrefValue = "";

			// pwd
			$this->pwd->LinkCustomAttributes = "";
			$this->pwd->HrefValue = "";

			// user_level
			$this->user_level->LinkCustomAttributes = "";
			$this->user_level->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			$this->nama_ruang->EditValue = $this->nama_ruang->CurrentValue;
			$this->nama_ruang->ViewCustomAttributes = "";

			// pwd
			$this->pwd->EditAttrs["class"] = "form-control";
			$this->pwd->EditCustomAttributes = "";
			$this->pwd->EditValue = ew_HtmlEncode($this->pwd->CurrentValue);
			$this->pwd->PlaceHolder = ew_RemoveHtml($this->pwd->FldCaption());

			// user_level
			$this->user_level->EditAttrs["class"] = "form-control";
			$this->user_level->EditCustomAttributes = "";
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->user_level->CurrentValue) <> "") {
				$this->user_level->EditValue = $this->user_level->OptionCaption($this->user_level->CurrentValue);
			} else {
				$this->user_level->EditValue = NULL;
			}
			} else {
				$this->user_level->EditValue = $Language->Phrase("PasswordMask");
			}
			$this->user_level->ViewCustomAttributes = "";

			// Edit refer script
			// nama_ruang

			$this->nama_ruang->LinkCustomAttributes = "";
			$this->nama_ruang->HrefValue = "";
			$this->nama_ruang->TooltipValue = "";

			// pwd
			$this->pwd->LinkCustomAttributes = "";
			$this->pwd->HrefValue = "";

			// user_level
			$this->user_level->LinkCustomAttributes = "";
			$this->user_level->HrefValue = "";
			$this->user_level->TooltipValue = "";
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
		if (!$this->nama_ruang->FldIsDetailKey && !is_null($this->nama_ruang->FormValue) && $this->nama_ruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_ruang->FldCaption(), $this->nama_ruang->ReqErrMsg));
		}
		if (!$this->pwd->FldIsDetailKey && !is_null($this->pwd->FormValue) && $this->pwd->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pwd->FldCaption(), $this->pwd->ReqErrMsg));
		}
		if (!$this->user_level->FldIsDetailKey && !is_null($this->user_level->FormValue) && $this->user_level->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user_level->FldCaption(), $this->user_level->ReqErrMsg));
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
				$sThisKey .= $row['id_ruang'];
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

			// pwd
			$this->pwd->SetDbValueDef($rsnew, $this->pwd->CurrentValue, "", $this->pwd->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('pwd') == $this->pwd->CurrentValue));

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

		// Check if valid parent user id
		$bValidParentUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->nama_ruang->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidParentUser = $Security->IsValidUserID($this->nama_ruang->CurrentValue);
			if (!$bValidParentUser) {
				$sParentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedParentUserID"));
				$sParentUserIdMsg = str_replace("%p", $this->nama_ruang->CurrentValue, $sParentUserIdMsg);
				$this->setFailureMessage($sParentUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// nama_ruang
		$this->nama_ruang->SetDbValueDef($rsnew, $this->nama_ruang->CurrentValue, NULL, FALSE);

		// pwd
		$this->pwd->SetDbValueDef($rsnew, $this->pwd->CurrentValue, "", FALSE);

		// user_level
		if ($Security->CanAdmin()) { // System admin
		$this->user_level->SetDbValueDef($rsnew, $this->user_level->CurrentValue, 0, FALSE);
		}

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
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

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
		$item->Body = "<button id=\"emf_ruang\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_ruang',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fruanglist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($ruang_list)) $ruang_list = new cruang_list();

// Page init
$ruang_list->Page_Init();

// Page main
$ruang_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ruang_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($ruang->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fruanglist = new ew_Form("fruanglist", "list");
fruanglist.FormKeyCountName = '<?php echo $ruang_list->FormKeyCountName ?>';

// Validate form
fruanglist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nama_ruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ruang->nama_ruang->FldCaption(), $ruang->nama_ruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pwd");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ruang->pwd->FldCaption(), $ruang->pwd->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_level");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ruang->user_level->FldCaption(), $ruang->user_level->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fruanglist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fruanglist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fruanglist.Lists["x_user_level"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fruanglist.Lists["x_user_level"].Options = <?php echo json_encode($ruang_list->user_level->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($ruang->Export == "") { ?>
<div class="ewToolbar">
<?php if ($ruang_list->TotalRecs > 0 && $ruang_list->ExportOptions->Visible()) { ?>
<?php $ruang_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $ruang_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($ruang_list->TotalRecs <= 0)
			$ruang_list->TotalRecs = $ruang->ListRecordCount();
	} else {
		if (!$ruang_list->Recordset && ($ruang_list->Recordset = $ruang_list->LoadRecordset()))
			$ruang_list->TotalRecs = $ruang_list->Recordset->RecordCount();
	}
	$ruang_list->StartRec = 1;
	if ($ruang_list->DisplayRecs <= 0 || ($ruang->Export <> "" && $ruang->ExportAll)) // Display all records
		$ruang_list->DisplayRecs = $ruang_list->TotalRecs;
	if (!($ruang->Export <> "" && $ruang->ExportAll))
		$ruang_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$ruang_list->Recordset = $ruang_list->LoadRecordset($ruang_list->StartRec-1, $ruang_list->DisplayRecs);

	// Set no record found message
	if ($ruang->CurrentAction == "" && $ruang_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$ruang_list->setWarningMessage(ew_DeniedMsg());
		if ($ruang_list->SearchWhere == "0=101")
			$ruang_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$ruang_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$ruang_list->RenderOtherOptions();
?>
<?php $ruang_list->ShowPageHeader(); ?>
<?php
$ruang_list->ShowMessage();
?>
<?php if ($ruang_list->TotalRecs > 0 || $ruang->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($ruang_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> ruang">
<?php if ($ruang->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($ruang->CurrentAction <> "gridadd" && $ruang->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ruang_list->Pager)) $ruang_list->Pager = new cPrevNextPager($ruang_list->StartRec, $ruang_list->DisplayRecs, $ruang_list->TotalRecs, $ruang_list->AutoHidePager) ?>
<?php if ($ruang_list->Pager->RecordCount > 0 && $ruang_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ruang_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ruang_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ruang_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ruang_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ruang_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ruang_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ruang_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ruang_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ruang_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($ruang_list->TotalRecs > 0 && (!$ruang_list->AutoHidePageSizeSelector || $ruang_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="ruang">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($ruang_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($ruang_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($ruang_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="ALL"<?php if ($ruang->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ruang_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fruanglist" id="fruanglist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ruang_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ruang_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ruang">
<div id="gmp_ruang" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($ruang_list->TotalRecs > 0 || $ruang->CurrentAction == "gridedit") { ?>
<table id="tbl_ruanglist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$ruang_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$ruang_list->RenderListOptions();

// Render list options (header, left)
$ruang_list->ListOptions->Render("header", "left");
?>
<?php if ($ruang->nama_ruang->Visible) { // nama_ruang ?>
	<?php if ($ruang->SortUrl($ruang->nama_ruang) == "") { ?>
		<th data-name="nama_ruang" class="<?php echo $ruang->nama_ruang->HeaderCellClass() ?>"><div id="elh_ruang_nama_ruang" class="ruang_nama_ruang"><div class="ewTableHeaderCaption"><?php echo $ruang->nama_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_ruang" class="<?php echo $ruang->nama_ruang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ruang->SortUrl($ruang->nama_ruang) ?>',1);"><div id="elh_ruang_nama_ruang" class="ruang_nama_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ruang->nama_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ruang->nama_ruang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ruang->nama_ruang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ruang->pwd->Visible) { // pwd ?>
	<?php if ($ruang->SortUrl($ruang->pwd) == "") { ?>
		<th data-name="pwd" class="<?php echo $ruang->pwd->HeaderCellClass() ?>"><div id="elh_ruang_pwd" class="ruang_pwd"><div class="ewTableHeaderCaption"><?php echo $ruang->pwd->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pwd" class="<?php echo $ruang->pwd->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ruang->SortUrl($ruang->pwd) ?>',1);"><div id="elh_ruang_pwd" class="ruang_pwd">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ruang->pwd->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ruang->pwd->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ruang->pwd->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ruang->user_level->Visible) { // user_level ?>
	<?php if ($ruang->SortUrl($ruang->user_level) == "") { ?>
		<th data-name="user_level" class="<?php echo $ruang->user_level->HeaderCellClass() ?>"><div id="elh_ruang_user_level" class="ruang_user_level"><div class="ewTableHeaderCaption"><?php echo $ruang->user_level->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_level" class="<?php echo $ruang->user_level->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $ruang->SortUrl($ruang->user_level) ?>',1);"><div id="elh_ruang_user_level" class="ruang_user_level">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $ruang->user_level->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($ruang->user_level->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($ruang->user_level->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$ruang_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ruang->ExportAll && $ruang->Export <> "") {
	$ruang_list->StopRec = $ruang_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ruang_list->TotalRecs > $ruang_list->StartRec + $ruang_list->DisplayRecs - 1)
		$ruang_list->StopRec = $ruang_list->StartRec + $ruang_list->DisplayRecs - 1;
	else
		$ruang_list->StopRec = $ruang_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($ruang_list->FormKeyCountName) && ($ruang->CurrentAction == "gridadd" || $ruang->CurrentAction == "gridedit" || $ruang->CurrentAction == "F")) {
		$ruang_list->KeyCount = $objForm->GetValue($ruang_list->FormKeyCountName);
		$ruang_list->StopRec = $ruang_list->StartRec + $ruang_list->KeyCount - 1;
	}
}
$ruang_list->RecCnt = $ruang_list->StartRec - 1;
if ($ruang_list->Recordset && !$ruang_list->Recordset->EOF) {
	$ruang_list->Recordset->MoveFirst();
	$bSelectLimit = $ruang_list->UseSelectLimit;
	if (!$bSelectLimit && $ruang_list->StartRec > 1)
		$ruang_list->Recordset->Move($ruang_list->StartRec - 1);
} elseif (!$ruang->AllowAddDeleteRow && $ruang_list->StopRec == 0) {
	$ruang_list->StopRec = $ruang->GridAddRowCount;
}

// Initialize aggregate
$ruang->RowType = EW_ROWTYPE_AGGREGATEINIT;
$ruang->ResetAttrs();
$ruang_list->RenderRow();
if ($ruang->CurrentAction == "gridedit")
	$ruang_list->RowIndex = 0;
while ($ruang_list->RecCnt < $ruang_list->StopRec) {
	$ruang_list->RecCnt++;
	if (intval($ruang_list->RecCnt) >= intval($ruang_list->StartRec)) {
		$ruang_list->RowCnt++;
		if ($ruang->CurrentAction == "gridadd" || $ruang->CurrentAction == "gridedit" || $ruang->CurrentAction == "F") {
			$ruang_list->RowIndex++;
			$objForm->Index = $ruang_list->RowIndex;
			if ($objForm->HasValue($ruang_list->FormActionName))
				$ruang_list->RowAction = strval($objForm->GetValue($ruang_list->FormActionName));
			elseif ($ruang->CurrentAction == "gridadd")
				$ruang_list->RowAction = "insert";
			else
				$ruang_list->RowAction = "";
		}

		// Set up key count
		$ruang_list->KeyCount = $ruang_list->RowIndex;

		// Init row class and style
		$ruang->ResetAttrs();
		$ruang->CssClass = "";
		if ($ruang->CurrentAction == "gridadd") {
			$ruang_list->LoadRowValues(); // Load default values
		} else {
			$ruang_list->LoadRowValues($ruang_list->Recordset); // Load row values
		}
		$ruang->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($ruang->CurrentAction == "gridedit") { // Grid edit
			if ($ruang->EventCancelled) {
				$ruang_list->RestoreCurrentRowFormValues($ruang_list->RowIndex); // Restore form values
			}
			if ($ruang_list->RowAction == "insert")
				$ruang->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$ruang->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($ruang->CurrentAction == "gridedit" && ($ruang->RowType == EW_ROWTYPE_EDIT || $ruang->RowType == EW_ROWTYPE_ADD) && $ruang->EventCancelled) // Update failed
			$ruang_list->RestoreCurrentRowFormValues($ruang_list->RowIndex); // Restore form values
		if ($ruang->RowType == EW_ROWTYPE_EDIT) // Edit row
			$ruang_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$ruang->RowAttrs = array_merge($ruang->RowAttrs, array('data-rowindex'=>$ruang_list->RowCnt, 'id'=>'r' . $ruang_list->RowCnt . '_ruang', 'data-rowtype'=>$ruang->RowType));

		// Render row
		$ruang_list->RenderRow();

		// Render list options
		$ruang_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($ruang_list->RowAction <> "delete" && $ruang_list->RowAction <> "insertdelete" && !($ruang_list->RowAction == "insert" && $ruang->CurrentAction == "F" && $ruang_list->EmptyRow())) {
?>
	<tr<?php echo $ruang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ruang_list->ListOptions->Render("body", "left", $ruang_list->RowCnt);
?>
	<?php if ($ruang->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang"<?php echo $ruang->nama_ruang->CellAttributes() ?>>
<?php if ($ruang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<select data-table="ruang" data-field="x_nama_ruang" data-value-separator="<?php echo $ruang->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
<?php echo $ruang->nama_ruang->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } elseif (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$ruang->UserIDAllow($ruang->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<select data-table="ruang" data-field="x_nama_ruang" data-value-separator="<?php echo $ruang->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
<?php echo $ruang->nama_ruang->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<input type="text" data-table="ruang" data-field="x_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ruang->nama_ruang->getPlaceHolder()) ?>" value="<?php echo $ruang->nama_ruang->EditValue ?>"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="ruang" data-field="x_nama_ruang" name="o<?php echo $ruang_list->RowIndex ?>_nama_ruang" id="o<?php echo $ruang_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($ruang->nama_ruang->OldValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<span<?php echo $ruang->nama_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ruang->nama_ruang->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ruang" data-field="x_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($ruang->nama_ruang->CurrentValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_nama_ruang" class="ruang_nama_ruang">
<span<?php echo $ruang->nama_ruang->ViewAttributes() ?>>
<?php echo $ruang->nama_ruang->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="ruang" data-field="x_id_ruang" name="x<?php echo $ruang_list->RowIndex ?>_id_ruang" id="x<?php echo $ruang_list->RowIndex ?>_id_ruang" value="<?php echo ew_HtmlEncode($ruang->id_ruang->CurrentValue) ?>">
<input type="hidden" data-table="ruang" data-field="x_id_ruang" name="o<?php echo $ruang_list->RowIndex ?>_id_ruang" id="o<?php echo $ruang_list->RowIndex ?>_id_ruang" value="<?php echo ew_HtmlEncode($ruang->id_ruang->OldValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_EDIT || $ruang->CurrentMode == "edit") { ?>
<input type="hidden" data-table="ruang" data-field="x_id_ruang" name="x<?php echo $ruang_list->RowIndex ?>_id_ruang" id="x<?php echo $ruang_list->RowIndex ?>_id_ruang" value="<?php echo ew_HtmlEncode($ruang->id_ruang->CurrentValue) ?>">
<?php } ?>
	<?php if ($ruang->pwd->Visible) { // pwd ?>
		<td data-name="pwd"<?php echo $ruang->pwd->CellAttributes() ?>>
<?php if ($ruang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_pwd" class="form-group ruang_pwd">
<input type="text" data-table="ruang" data-field="x_pwd" name="x<?php echo $ruang_list->RowIndex ?>_pwd" id="x<?php echo $ruang_list->RowIndex ?>_pwd" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ruang->pwd->getPlaceHolder()) ?>" value="<?php echo $ruang->pwd->EditValue ?>"<?php echo $ruang->pwd->EditAttributes() ?>>
</span>
<input type="hidden" data-table="ruang" data-field="x_pwd" name="o<?php echo $ruang_list->RowIndex ?>_pwd" id="o<?php echo $ruang_list->RowIndex ?>_pwd" value="<?php echo ew_HtmlEncode($ruang->pwd->OldValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_pwd" class="form-group ruang_pwd">
<input type="text" data-table="ruang" data-field="x_pwd" name="x<?php echo $ruang_list->RowIndex ?>_pwd" id="x<?php echo $ruang_list->RowIndex ?>_pwd" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ruang->pwd->getPlaceHolder()) ?>" value="<?php echo $ruang->pwd->EditValue ?>"<?php echo $ruang->pwd->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_pwd" class="ruang_pwd">
<span<?php echo $ruang->pwd->ViewAttributes() ?>>
<?php echo $ruang->pwd->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($ruang->user_level->Visible) { // user_level ?>
		<td data-name="user_level"<?php echo $ruang->user_level->CellAttributes() ?>>
<?php if ($ruang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_user_level" class="form-group ruang_user_level">
<p class="form-control-static"><?php echo $ruang->user_level->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_user_level" class="form-group ruang_user_level">
<select data-table="ruang" data-field="x_user_level" data-value-separator="<?php echo $ruang->user_level->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_user_level" name="x<?php echo $ruang_list->RowIndex ?>_user_level"<?php echo $ruang->user_level->EditAttributes() ?>>
<?php echo $ruang->user_level->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_user_level") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="ruang" data-field="x_user_level" name="o<?php echo $ruang_list->RowIndex ?>_user_level" id="o<?php echo $ruang_list->RowIndex ?>_user_level" value="<?php echo ew_HtmlEncode($ruang->user_level->OldValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_user_level" class="form-group ruang_user_level">
<span<?php echo $ruang->user_level->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ruang->user_level->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ruang" data-field="x_user_level" name="x<?php echo $ruang_list->RowIndex ?>_user_level" id="x<?php echo $ruang_list->RowIndex ?>_user_level" value="<?php echo ew_HtmlEncode($ruang->user_level->CurrentValue) ?>">
<?php } ?>
<?php if ($ruang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $ruang_list->RowCnt ?>_ruang_user_level" class="ruang_user_level">
<span<?php echo $ruang->user_level->ViewAttributes() ?>>
<?php echo $ruang->user_level->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ruang_list->ListOptions->Render("body", "right", $ruang_list->RowCnt);
?>
	</tr>
<?php if ($ruang->RowType == EW_ROWTYPE_ADD || $ruang->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fruanglist.UpdateOpts(<?php echo $ruang_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($ruang->CurrentAction <> "gridadd")
		if (!$ruang_list->Recordset->EOF) $ruang_list->Recordset->MoveNext();
}
?>
<?php
	if ($ruang->CurrentAction == "gridadd" || $ruang->CurrentAction == "gridedit") {
		$ruang_list->RowIndex = '$rowindex$';
		$ruang_list->LoadRowValues();

		// Set row properties
		$ruang->ResetAttrs();
		$ruang->RowAttrs = array_merge($ruang->RowAttrs, array('data-rowindex'=>$ruang_list->RowIndex, 'id'=>'r0_ruang', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($ruang->RowAttrs["class"], "ewTemplate");
		$ruang->RowType = EW_ROWTYPE_ADD;

		// Render row
		$ruang_list->RenderRow();

		// Render list options
		$ruang_list->RenderListOptions();
		$ruang_list->StartRowCnt = 0;
?>
	<tr<?php echo $ruang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$ruang_list->ListOptions->Render("body", "left", $ruang_list->RowIndex);
?>
	<?php if ($ruang->nama_ruang->Visible) { // nama_ruang ?>
		<td data-name="nama_ruang">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<select data-table="ruang" data-field="x_nama_ruang" data-value-separator="<?php echo $ruang->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
<?php echo $ruang->nama_ruang->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } elseif (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$ruang->UserIDAllow($ruang->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<select data-table="ruang" data-field="x_nama_ruang" data-value-separator="<?php echo $ruang->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
<?php echo $ruang->nama_ruang->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_ruang_nama_ruang" class="form-group ruang_nama_ruang">
<input type="text" data-table="ruang" data-field="x_nama_ruang" name="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" id="x<?php echo $ruang_list->RowIndex ?>_nama_ruang" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ruang->nama_ruang->getPlaceHolder()) ?>" value="<?php echo $ruang->nama_ruang->EditValue ?>"<?php echo $ruang->nama_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="ruang" data-field="x_nama_ruang" name="o<?php echo $ruang_list->RowIndex ?>_nama_ruang" id="o<?php echo $ruang_list->RowIndex ?>_nama_ruang" value="<?php echo ew_HtmlEncode($ruang->nama_ruang->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($ruang->pwd->Visible) { // pwd ?>
		<td data-name="pwd">
<span id="el$rowindex$_ruang_pwd" class="form-group ruang_pwd">
<input type="text" data-table="ruang" data-field="x_pwd" name="x<?php echo $ruang_list->RowIndex ?>_pwd" id="x<?php echo $ruang_list->RowIndex ?>_pwd" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ruang->pwd->getPlaceHolder()) ?>" value="<?php echo $ruang->pwd->EditValue ?>"<?php echo $ruang->pwd->EditAttributes() ?>>
</span>
<input type="hidden" data-table="ruang" data-field="x_pwd" name="o<?php echo $ruang_list->RowIndex ?>_pwd" id="o<?php echo $ruang_list->RowIndex ?>_pwd" value="<?php echo ew_HtmlEncode($ruang->pwd->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($ruang->user_level->Visible) { // user_level ?>
		<td data-name="user_level">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_ruang_user_level" class="form-group ruang_user_level">
<p class="form-control-static"><?php echo $ruang->user_level->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el$rowindex$_ruang_user_level" class="form-group ruang_user_level">
<select data-table="ruang" data-field="x_user_level" data-value-separator="<?php echo $ruang->user_level->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $ruang_list->RowIndex ?>_user_level" name="x<?php echo $ruang_list->RowIndex ?>_user_level"<?php echo $ruang->user_level->EditAttributes() ?>>
<?php echo $ruang->user_level->SelectOptionListHtml("x<?php echo $ruang_list->RowIndex ?>_user_level") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="ruang" data-field="x_user_level" name="o<?php echo $ruang_list->RowIndex ?>_user_level" id="o<?php echo $ruang_list->RowIndex ?>_user_level" value="<?php echo ew_HtmlEncode($ruang->user_level->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ruang_list->ListOptions->Render("body", "right", $ruang_list->RowCnt);
?>
<script type="text/javascript">
fruanglist.UpdateOpts(<?php echo $ruang_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($ruang->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $ruang_list->FormKeyCountName ?>" id="<?php echo $ruang_list->FormKeyCountName ?>" value="<?php echo $ruang_list->KeyCount ?>">
<?php echo $ruang_list->MultiSelectKey ?>
<?php } ?>
<?php if ($ruang->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($ruang_list->Recordset)
	$ruang_list->Recordset->Close();
?>
<?php if ($ruang->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($ruang->CurrentAction <> "gridadd" && $ruang->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ruang_list->Pager)) $ruang_list->Pager = new cPrevNextPager($ruang_list->StartRec, $ruang_list->DisplayRecs, $ruang_list->TotalRecs, $ruang_list->AutoHidePager) ?>
<?php if ($ruang_list->Pager->RecordCount > 0 && $ruang_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ruang_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ruang_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ruang_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ruang_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ruang_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ruang_list->PageUrl() ?>start=<?php echo $ruang_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ruang_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ruang_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ruang_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ruang_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($ruang_list->TotalRecs > 0 && (!$ruang_list->AutoHidePageSizeSelector || $ruang_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="ruang">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($ruang_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($ruang_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($ruang_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="ALL"<?php if ($ruang->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ruang_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($ruang_list->TotalRecs == 0 && $ruang->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($ruang_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($ruang->Export == "") { ?>
<script type="text/javascript">
fruanglist.Init();
</script>
<?php } ?>
<?php
$ruang_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ruang->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ruang_list->Page_Terminate();
?>
