<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "dashboardinfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$dashboard_list = NULL; // Initialize page object first

class cdashboard_list extends cdashboard {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'dashboard';

	// Page object name
	var $PageObjName = 'dashboard_list';

	// Grid form hidden field names
	var $FormName = 'fdashboardlist';
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

		// Table object (dashboard)
		if (!isset($GLOBALS["dashboard"]) || get_class($GLOBALS["dashboard"]) == "cdashboard") {
			$GLOBALS["dashboard"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dashboard"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "dashboardadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "dashboarddelete.php";
		$this->MultiUpdateUrl = "dashboardupdate.php";

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dashboard', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdashboardlistsrch";

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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->kode_sek->SetVisibility();
		$this->nama_sekolah->SetVisibility();
		$this->kepsek->SetVisibility();
		$this->nip_ks->SetVisibility();
		$this->jumlah_rombel->SetVisibility();
		$this->daya_tampung->SetVisibility();
		$this->zona1->SetVisibility();
		$this->zona2->SetVisibility();
		$this->zona3->SetVisibility();
		$this->thn_pelajaran->SetVisibility();

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
		global $EW_EXPORT, $dashboard;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dashboard);
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

			// Set up sorting order
			$this->SetupSortOrder();
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
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
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
			$this->UpdateSort($this->kode_sek); // kode_sek
			$this->UpdateSort($this->nama_sekolah); // nama_sekolah
			$this->UpdateSort($this->kepsek); // kepsek
			$this->UpdateSort($this->nip_ks); // nip_ks
			$this->UpdateSort($this->jumlah_rombel); // jumlah_rombel
			$this->UpdateSort($this->daya_tampung); // daya_tampung
			$this->UpdateSort($this->zona1); // zona1
			$this->UpdateSort($this->zona2); // zona2
			$this->UpdateSort($this->zona3); // zona3
			$this->UpdateSort($this->thn_pelajaran); // thn_pelajaran
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
				$this->kode_sek->setSort("");
				$this->nama_sekolah->setSort("");
				$this->kepsek->setSort("");
				$this->nip_ks->setSort("");
				$this->jumlah_rombel->setSort("");
				$this->daya_tampung->setSort("");
				$this->zona1->setSort("");
				$this->zona2->setSort("");
				$this->zona3->setSort("");
				$this->thn_pelajaran->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdashboardlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdashboardlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdashboardlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->id->setDbValue($row['id']);
		$this->kode_sek->setDbValue($row['kode_sek']);
		$this->nama_sekolah->setDbValue($row['nama_sekolah']);
		$this->kepsek->setDbValue($row['kepsek']);
		$this->nip_ks->setDbValue($row['nip_ks']);
		$this->jumlah_rombel->setDbValue($row['jumlah_rombel']);
		$this->daya_tampung->setDbValue($row['daya_tampung']);
		$this->zona1->setDbValue($row['zona1']);
		$this->zona2->setDbValue($row['zona2']);
		$this->zona3->setDbValue($row['zona3']);
		$this->thn_pelajaran->setDbValue($row['thn_pelajaran']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['kode_sek'] = NULL;
		$row['nama_sekolah'] = NULL;
		$row['kepsek'] = NULL;
		$row['nip_ks'] = NULL;
		$row['jumlah_rombel'] = NULL;
		$row['daya_tampung'] = NULL;
		$row['zona1'] = NULL;
		$row['zona2'] = NULL;
		$row['zona3'] = NULL;
		$row['thn_pelajaran'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kode_sek->DbValue = $row['kode_sek'];
		$this->nama_sekolah->DbValue = $row['nama_sekolah'];
		$this->kepsek->DbValue = $row['kepsek'];
		$this->nip_ks->DbValue = $row['nip_ks'];
		$this->jumlah_rombel->DbValue = $row['jumlah_rombel'];
		$this->daya_tampung->DbValue = $row['daya_tampung'];
		$this->zona1->DbValue = $row['zona1'];
		$this->zona2->DbValue = $row['zona2'];
		$this->zona3->DbValue = $row['zona3'];
		$this->thn_pelajaran->DbValue = $row['thn_pelajaran'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		include 'dashboardview.php';
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
if (!isset($dashboard_list)) $dashboard_list = new cdashboard_list();

// Page init
$dashboard_list->Page_Init();

// Page main
$dashboard_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dashboard_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdashboardlist = new ew_Form("fdashboardlist", "list");
fdashboardlist.FormKeyCountName = '<?php echo $dashboard_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdashboardlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdashboardlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($dashboard_list->TotalRecs > 0 && $dashboard_list->ExportOptions->Visible()) { ?>
<?php $dashboard_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $dashboard_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($dashboard_list->TotalRecs <= 0)
			$dashboard_list->TotalRecs = $dashboard->ListRecordCount();
	} else {
		if (!$dashboard_list->Recordset && ($dashboard_list->Recordset = $dashboard_list->LoadRecordset()))
			$dashboard_list->TotalRecs = $dashboard_list->Recordset->RecordCount();
	}
	$dashboard_list->StartRec = 1;
	if ($dashboard_list->DisplayRecs <= 0 || ($dashboard->Export <> "" && $dashboard->ExportAll)) // Display all records
		$dashboard_list->DisplayRecs = $dashboard_list->TotalRecs;
	if (!($dashboard->Export <> "" && $dashboard->ExportAll))
		$dashboard_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$dashboard_list->Recordset = $dashboard_list->LoadRecordset($dashboard_list->StartRec-1, $dashboard_list->DisplayRecs);

	// Set no record found message
	if ($dashboard->CurrentAction == "" && $dashboard_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$dashboard_list->setWarningMessage(ew_DeniedMsg());
		if ($dashboard_list->SearchWhere == "0=101")
			$dashboard_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$dashboard_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$dashboard_list->RenderOtherOptions();
?>
<?php $dashboard_list->ShowPageHeader(); ?>
<?php
$dashboard_list->ShowMessage();
?>
<?php if ($dashboard_list->TotalRecs > 0 || $dashboard->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($dashboard_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> dashboard">
<form name="fdashboardlist" id="fdashboardlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dashboard_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dashboard_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dashboard">
<div id="gmp_dashboard" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($dashboard_list->TotalRecs > 0 || $dashboard->CurrentAction == "gridedit") { ?>
<table id="tbl_dashboardlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$dashboard_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$dashboard_list->RenderListOptions();

// Render list options (header, left)
$dashboard_list->ListOptions->Render("header", "left");
?>
<?php if ($dashboard->kode_sek->Visible) { // kode_sek ?>
	<?php if ($dashboard->SortUrl($dashboard->kode_sek) == "") { ?>
		<th data-name="kode_sek" class="<?php echo $dashboard->kode_sek->HeaderCellClass() ?>"><div id="elh_dashboard_kode_sek" class="dashboard_kode_sek"><div class="ewTableHeaderCaption"><?php echo $dashboard->kode_sek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_sek" class="<?php echo $dashboard->kode_sek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->kode_sek) ?>',1);"><div id="elh_dashboard_kode_sek" class="dashboard_kode_sek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->kode_sek->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->kode_sek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->kode_sek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->nama_sekolah->Visible) { // nama_sekolah ?>
	<?php if ($dashboard->SortUrl($dashboard->nama_sekolah) == "") { ?>
		<th data-name="nama_sekolah" class="<?php echo $dashboard->nama_sekolah->HeaderCellClass() ?>"><div id="elh_dashboard_nama_sekolah" class="dashboard_nama_sekolah"><div class="ewTableHeaderCaption"><?php echo $dashboard->nama_sekolah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_sekolah" class="<?php echo $dashboard->nama_sekolah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->nama_sekolah) ?>',1);"><div id="elh_dashboard_nama_sekolah" class="dashboard_nama_sekolah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->nama_sekolah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->nama_sekolah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->nama_sekolah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->kepsek->Visible) { // kepsek ?>
	<?php if ($dashboard->SortUrl($dashboard->kepsek) == "") { ?>
		<th data-name="kepsek" class="<?php echo $dashboard->kepsek->HeaderCellClass() ?>"><div id="elh_dashboard_kepsek" class="dashboard_kepsek"><div class="ewTableHeaderCaption"><?php echo $dashboard->kepsek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kepsek" class="<?php echo $dashboard->kepsek->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->kepsek) ?>',1);"><div id="elh_dashboard_kepsek" class="dashboard_kepsek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->kepsek->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->kepsek->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->kepsek->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->nip_ks->Visible) { // nip_ks ?>
	<?php if ($dashboard->SortUrl($dashboard->nip_ks) == "") { ?>
		<th data-name="nip_ks" class="<?php echo $dashboard->nip_ks->HeaderCellClass() ?>"><div id="elh_dashboard_nip_ks" class="dashboard_nip_ks"><div class="ewTableHeaderCaption"><?php echo $dashboard->nip_ks->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip_ks" class="<?php echo $dashboard->nip_ks->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->nip_ks) ?>',1);"><div id="elh_dashboard_nip_ks" class="dashboard_nip_ks">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->nip_ks->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->nip_ks->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->nip_ks->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->jumlah_rombel->Visible) { // jumlah_rombel ?>
	<?php if ($dashboard->SortUrl($dashboard->jumlah_rombel) == "") { ?>
		<th data-name="jumlah_rombel" class="<?php echo $dashboard->jumlah_rombel->HeaderCellClass() ?>"><div id="elh_dashboard_jumlah_rombel" class="dashboard_jumlah_rombel"><div class="ewTableHeaderCaption"><?php echo $dashboard->jumlah_rombel->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_rombel" class="<?php echo $dashboard->jumlah_rombel->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->jumlah_rombel) ?>',1);"><div id="elh_dashboard_jumlah_rombel" class="dashboard_jumlah_rombel">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->jumlah_rombel->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->jumlah_rombel->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->jumlah_rombel->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->daya_tampung->Visible) { // daya_tampung ?>
	<?php if ($dashboard->SortUrl($dashboard->daya_tampung) == "") { ?>
		<th data-name="daya_tampung" class="<?php echo $dashboard->daya_tampung->HeaderCellClass() ?>"><div id="elh_dashboard_daya_tampung" class="dashboard_daya_tampung"><div class="ewTableHeaderCaption"><?php echo $dashboard->daya_tampung->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="daya_tampung" class="<?php echo $dashboard->daya_tampung->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->daya_tampung) ?>',1);"><div id="elh_dashboard_daya_tampung" class="dashboard_daya_tampung">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->daya_tampung->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->daya_tampung->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->daya_tampung->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->zona1->Visible) { // zona1 ?>
	<?php if ($dashboard->SortUrl($dashboard->zona1) == "") { ?>
		<th data-name="zona1" class="<?php echo $dashboard->zona1->HeaderCellClass() ?>"><div id="elh_dashboard_zona1" class="dashboard_zona1"><div class="ewTableHeaderCaption"><?php echo $dashboard->zona1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona1" class="<?php echo $dashboard->zona1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->zona1) ?>',1);"><div id="elh_dashboard_zona1" class="dashboard_zona1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->zona1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->zona1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->zona1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->zona2->Visible) { // zona2 ?>
	<?php if ($dashboard->SortUrl($dashboard->zona2) == "") { ?>
		<th data-name="zona2" class="<?php echo $dashboard->zona2->HeaderCellClass() ?>"><div id="elh_dashboard_zona2" class="dashboard_zona2"><div class="ewTableHeaderCaption"><?php echo $dashboard->zona2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona2" class="<?php echo $dashboard->zona2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->zona2) ?>',1);"><div id="elh_dashboard_zona2" class="dashboard_zona2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->zona2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->zona2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->zona2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->zona3->Visible) { // zona3 ?>
	<?php if ($dashboard->SortUrl($dashboard->zona3) == "") { ?>
		<th data-name="zona3" class="<?php echo $dashboard->zona3->HeaderCellClass() ?>"><div id="elh_dashboard_zona3" class="dashboard_zona3"><div class="ewTableHeaderCaption"><?php echo $dashboard->zona3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zona3" class="<?php echo $dashboard->zona3->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->zona3) ?>',1);"><div id="elh_dashboard_zona3" class="dashboard_zona3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->zona3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->zona3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->zona3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($dashboard->thn_pelajaran->Visible) { // thn_pelajaran ?>
	<?php if ($dashboard->SortUrl($dashboard->thn_pelajaran) == "") { ?>
		<th data-name="thn_pelajaran" class="<?php echo $dashboard->thn_pelajaran->HeaderCellClass() ?>"><div id="elh_dashboard_thn_pelajaran" class="dashboard_thn_pelajaran"><div class="ewTableHeaderCaption"><?php echo $dashboard->thn_pelajaran->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="thn_pelajaran" class="<?php echo $dashboard->thn_pelajaran->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $dashboard->SortUrl($dashboard->thn_pelajaran) ?>',1);"><div id="elh_dashboard_thn_pelajaran" class="dashboard_thn_pelajaran">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $dashboard->thn_pelajaran->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($dashboard->thn_pelajaran->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($dashboard->thn_pelajaran->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$dashboard_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($dashboard->ExportAll && $dashboard->Export <> "") {
	$dashboard_list->StopRec = $dashboard_list->TotalRecs;
} else {

	// Set the last record to display
	if ($dashboard_list->TotalRecs > $dashboard_list->StartRec + $dashboard_list->DisplayRecs - 1)
		$dashboard_list->StopRec = $dashboard_list->StartRec + $dashboard_list->DisplayRecs - 1;
	else
		$dashboard_list->StopRec = $dashboard_list->TotalRecs;
}
$dashboard_list->RecCnt = $dashboard_list->StartRec - 1;
if ($dashboard_list->Recordset && !$dashboard_list->Recordset->EOF) {
	$dashboard_list->Recordset->MoveFirst();
	$bSelectLimit = $dashboard_list->UseSelectLimit;
	if (!$bSelectLimit && $dashboard_list->StartRec > 1)
		$dashboard_list->Recordset->Move($dashboard_list->StartRec - 1);
} elseif (!$dashboard->AllowAddDeleteRow && $dashboard_list->StopRec == 0) {
	$dashboard_list->StopRec = $dashboard->GridAddRowCount;
}

// Initialize aggregate
$dashboard->RowType = EW_ROWTYPE_AGGREGATEINIT;
$dashboard->ResetAttrs();
$dashboard_list->RenderRow();
while ($dashboard_list->RecCnt < $dashboard_list->StopRec) {
	$dashboard_list->RecCnt++;
	if (intval($dashboard_list->RecCnt) >= intval($dashboard_list->StartRec)) {
		$dashboard_list->RowCnt++;

		// Set up key count
		$dashboard_list->KeyCount = $dashboard_list->RowIndex;

		// Init row class and style
		$dashboard->ResetAttrs();
		$dashboard->CssClass = "";
		if ($dashboard->CurrentAction == "gridadd") {
		} else {
			$dashboard_list->LoadRowValues($dashboard_list->Recordset); // Load row values
		}
		$dashboard->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$dashboard->RowAttrs = array_merge($dashboard->RowAttrs, array('data-rowindex'=>$dashboard_list->RowCnt, 'id'=>'r' . $dashboard_list->RowCnt . '_dashboard', 'data-rowtype'=>$dashboard->RowType));

		// Render row
		$dashboard_list->RenderRow();

		// Render list options
		$dashboard_list->RenderListOptions();
?>
	<tr<?php echo $dashboard->RowAttributes() ?>>
<?php

// Render list options (body, left)
$dashboard_list->ListOptions->Render("body", "left", $dashboard_list->RowCnt);
?>
	<?php if ($dashboard->kode_sek->Visible) { // kode_sek ?>
		<td data-name="kode_sek"<?php echo $dashboard->kode_sek->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_kode_sek" class="dashboard_kode_sek">
<span<?php echo $dashboard->kode_sek->ViewAttributes() ?>>
<?php echo $dashboard->kode_sek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->nama_sekolah->Visible) { // nama_sekolah ?>
		<td data-name="nama_sekolah"<?php echo $dashboard->nama_sekolah->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_nama_sekolah" class="dashboard_nama_sekolah">
<span<?php echo $dashboard->nama_sekolah->ViewAttributes() ?>>
<?php echo $dashboard->nama_sekolah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->kepsek->Visible) { // kepsek ?>
		<td data-name="kepsek"<?php echo $dashboard->kepsek->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_kepsek" class="dashboard_kepsek">
<span<?php echo $dashboard->kepsek->ViewAttributes() ?>>
<?php echo $dashboard->kepsek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->nip_ks->Visible) { // nip_ks ?>
		<td data-name="nip_ks"<?php echo $dashboard->nip_ks->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_nip_ks" class="dashboard_nip_ks">
<span<?php echo $dashboard->nip_ks->ViewAttributes() ?>>
<?php echo $dashboard->nip_ks->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->jumlah_rombel->Visible) { // jumlah_rombel ?>
		<td data-name="jumlah_rombel"<?php echo $dashboard->jumlah_rombel->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_jumlah_rombel" class="dashboard_jumlah_rombel">
<span<?php echo $dashboard->jumlah_rombel->ViewAttributes() ?>>
<?php echo $dashboard->jumlah_rombel->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->daya_tampung->Visible) { // daya_tampung ?>
		<td data-name="daya_tampung"<?php echo $dashboard->daya_tampung->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_daya_tampung" class="dashboard_daya_tampung">
<span<?php echo $dashboard->daya_tampung->ViewAttributes() ?>>
<?php echo $dashboard->daya_tampung->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->zona1->Visible) { // zona1 ?>
		<td data-name="zona1"<?php echo $dashboard->zona1->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_zona1" class="dashboard_zona1">
<span<?php echo $dashboard->zona1->ViewAttributes() ?>>
<?php echo $dashboard->zona1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->zona2->Visible) { // zona2 ?>
		<td data-name="zona2"<?php echo $dashboard->zona2->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_zona2" class="dashboard_zona2">
<span<?php echo $dashboard->zona2->ViewAttributes() ?>>
<?php echo $dashboard->zona2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->zona3->Visible) { // zona3 ?>
		<td data-name="zona3"<?php echo $dashboard->zona3->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_zona3" class="dashboard_zona3">
<span<?php echo $dashboard->zona3->ViewAttributes() ?>>
<?php echo $dashboard->zona3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($dashboard->thn_pelajaran->Visible) { // thn_pelajaran ?>
		<td data-name="thn_pelajaran"<?php echo $dashboard->thn_pelajaran->CellAttributes() ?>>
<span id="el<?php echo $dashboard_list->RowCnt ?>_dashboard_thn_pelajaran" class="dashboard_thn_pelajaran">
<span<?php echo $dashboard->thn_pelajaran->ViewAttributes() ?>>
<?php echo $dashboard->thn_pelajaran->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$dashboard_list->ListOptions->Render("body", "right", $dashboard_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($dashboard->CurrentAction <> "gridadd")
		$dashboard_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($dashboard->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($dashboard_list->Recordset)
	$dashboard_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($dashboard->CurrentAction <> "gridadd" && $dashboard->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($dashboard_list->Pager)) $dashboard_list->Pager = new cPrevNextPager($dashboard_list->StartRec, $dashboard_list->DisplayRecs, $dashboard_list->TotalRecs, $dashboard_list->AutoHidePager) ?>
<?php if ($dashboard_list->Pager->RecordCount > 0 && $dashboard_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($dashboard_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $dashboard_list->PageUrl() ?>start=<?php echo $dashboard_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($dashboard_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $dashboard_list->PageUrl() ?>start=<?php echo $dashboard_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $dashboard_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($dashboard_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $dashboard_list->PageUrl() ?>start=<?php echo $dashboard_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($dashboard_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $dashboard_list->PageUrl() ?>start=<?php echo $dashboard_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $dashboard_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $dashboard_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $dashboard_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $dashboard_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dashboard_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($dashboard_list->TotalRecs == 0 && $dashboard->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($dashboard_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fdashboardlist.Init();
</script>
<?php
$dashboard_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dashboard_list->Page_Terminate();
?>
