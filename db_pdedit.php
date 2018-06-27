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

$db_pd_edit = NULL; // Initialize page object first

class cdb_pd_edit extends cdb_pd {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'db_pd';

	// Page object name
	var $PageObjName = 'db_pd_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_pd->SetVisibility();
		$this->id_pd->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nopes->SetVisibility();
		$this->nm_pes->SetVisibility();
		$this->tmp_lhr->SetVisibility();
		$this->tgl_lhr->SetVisibility();
		$this->tgl->SetVisibility();
		$this->bln->SetVisibility();
		$this->thn->SetVisibility();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "db_pdview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
				}
				echo ew_ArrayToJson(array($row));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id_pd")) {
				$this->id_pd->setFormValue($objForm->GetValue("x_id_pd"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id_pd"])) {
				$this->id_pd->setQueryStringValue($_GET["id_pd"]);
				$loadByQuery = TRUE;
			} else {
				$this->id_pd->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("db_pdlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "db_pdlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_pd->FldIsDetailKey)
			$this->id_pd->setFormValue($objForm->GetValue("x_id_pd"));
		if (!$this->nopes->FldIsDetailKey) {
			$this->nopes->setFormValue($objForm->GetValue("x_nopes"));
		}
		if (!$this->nm_pes->FldIsDetailKey) {
			$this->nm_pes->setFormValue($objForm->GetValue("x_nm_pes"));
		}
		if (!$this->tmp_lhr->FldIsDetailKey) {
			$this->tmp_lhr->setFormValue($objForm->GetValue("x_tmp_lhr"));
		}
		if (!$this->tgl_lhr->FldIsDetailKey) {
			$this->tgl_lhr->setFormValue($objForm->GetValue("x_tgl_lhr"));
		}
		if (!$this->tgl->FldIsDetailKey) {
			$this->tgl->setFormValue($objForm->GetValue("x_tgl"));
		}
		if (!$this->bln->FldIsDetailKey) {
			$this->bln->setFormValue($objForm->GetValue("x_bln"));
		}
		if (!$this->thn->FldIsDetailKey) {
			$this->thn->setFormValue($objForm->GetValue("x_thn"));
		}
		if (!$this->sex->FldIsDetailKey) {
			$this->sex->setFormValue($objForm->GetValue("x_sex"));
		}
		if (!$this->nm_ortu->FldIsDetailKey) {
			$this->nm_ortu->setFormValue($objForm->GetValue("x_nm_ortu"));
		}
		if (!$this->asal_sek->FldIsDetailKey) {
			$this->asal_sek->setFormValue($objForm->GetValue("x_asal_sek"));
		}
		if (!$this->n_ind->FldIsDetailKey) {
			$this->n_ind->setFormValue($objForm->GetValue("x_n_ind"));
		}
		if (!$this->n_mat->FldIsDetailKey) {
			$this->n_mat->setFormValue($objForm->GetValue("x_n_mat"));
		}
		if (!$this->n_ipa->FldIsDetailKey) {
			$this->n_ipa->setFormValue($objForm->GetValue("x_n_ipa"));
		}
		if (!$this->n_jml->FldIsDetailKey) {
			$this->n_jml->setFormValue($objForm->GetValue("x_n_jml"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id_pd->CurrentValue = $this->id_pd->FormValue;
		$this->nopes->CurrentValue = $this->nopes->FormValue;
		$this->nm_pes->CurrentValue = $this->nm_pes->FormValue;
		$this->tmp_lhr->CurrentValue = $this->tmp_lhr->FormValue;
		$this->tgl_lhr->CurrentValue = $this->tgl_lhr->FormValue;
		$this->tgl->CurrentValue = $this->tgl->FormValue;
		$this->bln->CurrentValue = $this->bln->FormValue;
		$this->thn->CurrentValue = $this->thn->FormValue;
		$this->sex->CurrentValue = $this->sex->FormValue;
		$this->nm_ortu->CurrentValue = $this->nm_ortu->FormValue;
		$this->asal_sek->CurrentValue = $this->asal_sek->FormValue;
		$this->n_ind->CurrentValue = $this->n_ind->FormValue;
		$this->n_mat->CurrentValue = $this->n_mat->FormValue;
		$this->n_ipa->CurrentValue = $this->n_ipa->FormValue;
		$this->n_jml->CurrentValue = $this->n_jml->FormValue;
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

			// tmp_lhr
			$this->tmp_lhr->LinkCustomAttributes = "";
			$this->tmp_lhr->HrefValue = "";
			$this->tmp_lhr->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_pd
			$this->id_pd->EditAttrs["class"] = "form-control";
			$this->id_pd->EditCustomAttributes = "";
			$this->id_pd->EditValue = $this->id_pd->CurrentValue;
			$this->id_pd->ViewCustomAttributes = "";

			// nopes
			$this->nopes->EditAttrs["class"] = "form-control";
			$this->nopes->EditCustomAttributes = "";
			$this->nopes->EditValue = ew_HtmlEncode($this->nopes->CurrentValue);
			$this->nopes->PlaceHolder = ew_RemoveHtml($this->nopes->FldCaption());

			// nm_pes
			$this->nm_pes->EditAttrs["class"] = "form-control";
			$this->nm_pes->EditCustomAttributes = "";
			$this->nm_pes->EditValue = ew_HtmlEncode($this->nm_pes->CurrentValue);
			$this->nm_pes->PlaceHolder = ew_RemoveHtml($this->nm_pes->FldCaption());

			// tmp_lhr
			$this->tmp_lhr->EditAttrs["class"] = "form-control";
			$this->tmp_lhr->EditCustomAttributes = "";
			$this->tmp_lhr->EditValue = ew_HtmlEncode($this->tmp_lhr->CurrentValue);
			$this->tmp_lhr->PlaceHolder = ew_RemoveHtml($this->tmp_lhr->FldCaption());

			// tgl_lhr
			$this->tgl_lhr->EditAttrs["class"] = "form-control";
			$this->tgl_lhr->EditCustomAttributes = "";
			$this->tgl_lhr->EditValue = ew_HtmlEncode($this->tgl_lhr->CurrentValue);
			$this->tgl_lhr->PlaceHolder = ew_RemoveHtml($this->tgl_lhr->FldCaption());

			// tgl
			$this->tgl->EditAttrs["class"] = "form-control";
			$this->tgl->EditCustomAttributes = "";
			$this->tgl->EditValue = ew_HtmlEncode($this->tgl->CurrentValue);
			$this->tgl->PlaceHolder = ew_RemoveHtml($this->tgl->FldCaption());

			// bln
			$this->bln->EditAttrs["class"] = "form-control";
			$this->bln->EditCustomAttributes = "";
			$this->bln->EditValue = ew_HtmlEncode($this->bln->CurrentValue);
			$this->bln->PlaceHolder = ew_RemoveHtml($this->bln->FldCaption());

			// thn
			$this->thn->EditAttrs["class"] = "form-control";
			$this->thn->EditCustomAttributes = "";
			$this->thn->EditValue = ew_HtmlEncode($this->thn->CurrentValue);
			$this->thn->PlaceHolder = ew_RemoveHtml($this->thn->FldCaption());

			// sex
			$this->sex->EditAttrs["class"] = "form-control";
			$this->sex->EditCustomAttributes = "";
			$this->sex->EditValue = ew_HtmlEncode($this->sex->CurrentValue);
			$this->sex->PlaceHolder = ew_RemoveHtml($this->sex->FldCaption());

			// nm_ortu
			$this->nm_ortu->EditAttrs["class"] = "form-control";
			$this->nm_ortu->EditCustomAttributes = "";
			$this->nm_ortu->EditValue = ew_HtmlEncode($this->nm_ortu->CurrentValue);
			$this->nm_ortu->PlaceHolder = ew_RemoveHtml($this->nm_ortu->FldCaption());

			// asal_sek
			$this->asal_sek->EditAttrs["class"] = "form-control";
			$this->asal_sek->EditCustomAttributes = "";
			$this->asal_sek->EditValue = ew_HtmlEncode($this->asal_sek->CurrentValue);
			$this->asal_sek->PlaceHolder = ew_RemoveHtml($this->asal_sek->FldCaption());

			// n_ind
			$this->n_ind->EditAttrs["class"] = "form-control";
			$this->n_ind->EditCustomAttributes = "";
			$this->n_ind->EditValue = ew_HtmlEncode($this->n_ind->CurrentValue);
			$this->n_ind->PlaceHolder = ew_RemoveHtml($this->n_ind->FldCaption());

			// n_mat
			$this->n_mat->EditAttrs["class"] = "form-control";
			$this->n_mat->EditCustomAttributes = "";
			$this->n_mat->EditValue = ew_HtmlEncode($this->n_mat->CurrentValue);
			$this->n_mat->PlaceHolder = ew_RemoveHtml($this->n_mat->FldCaption());

			// n_ipa
			$this->n_ipa->EditAttrs["class"] = "form-control";
			$this->n_ipa->EditCustomAttributes = "";
			$this->n_ipa->EditValue = ew_HtmlEncode($this->n_ipa->CurrentValue);
			$this->n_ipa->PlaceHolder = ew_RemoveHtml($this->n_ipa->FldCaption());

			// n_jml
			$this->n_jml->EditAttrs["class"] = "form-control";
			$this->n_jml->EditCustomAttributes = "";
			$this->n_jml->EditValue = ew_HtmlEncode($this->n_jml->CurrentValue);
			$this->n_jml->PlaceHolder = ew_RemoveHtml($this->n_jml->FldCaption());

			// Edit refer script
			// id_pd

			$this->id_pd->LinkCustomAttributes = "";
			$this->id_pd->HrefValue = "";

			// nopes
			$this->nopes->LinkCustomAttributes = "";
			$this->nopes->HrefValue = "";

			// nm_pes
			$this->nm_pes->LinkCustomAttributes = "";
			$this->nm_pes->HrefValue = "";

			// tmp_lhr
			$this->tmp_lhr->LinkCustomAttributes = "";
			$this->tmp_lhr->HrefValue = "";

			// tgl_lhr
			$this->tgl_lhr->LinkCustomAttributes = "";
			$this->tgl_lhr->HrefValue = "";

			// tgl
			$this->tgl->LinkCustomAttributes = "";
			$this->tgl->HrefValue = "";

			// bln
			$this->bln->LinkCustomAttributes = "";
			$this->bln->HrefValue = "";

			// thn
			$this->thn->LinkCustomAttributes = "";
			$this->thn->HrefValue = "";

			// sex
			$this->sex->LinkCustomAttributes = "";
			$this->sex->HrefValue = "";

			// nm_ortu
			$this->nm_ortu->LinkCustomAttributes = "";
			$this->nm_ortu->HrefValue = "";

			// asal_sek
			$this->asal_sek->LinkCustomAttributes = "";
			$this->asal_sek->HrefValue = "";

			// n_ind
			$this->n_ind->LinkCustomAttributes = "";
			$this->n_ind->HrefValue = "";

			// n_mat
			$this->n_mat->LinkCustomAttributes = "";
			$this->n_mat->HrefValue = "";

			// n_ipa
			$this->n_ipa->LinkCustomAttributes = "";
			$this->n_ipa->HrefValue = "";

			// n_jml
			$this->n_jml->LinkCustomAttributes = "";
			$this->n_jml->HrefValue = "";
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
		if (!$this->nopes->FldIsDetailKey && !is_null($this->nopes->FormValue) && $this->nopes->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nopes->FldCaption(), $this->nopes->ReqErrMsg));
		}
		if (!$this->nm_pes->FldIsDetailKey && !is_null($this->nm_pes->FormValue) && $this->nm_pes->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nm_pes->FldCaption(), $this->nm_pes->ReqErrMsg));
		}
		if (!$this->tmp_lhr->FldIsDetailKey && !is_null($this->tmp_lhr->FormValue) && $this->tmp_lhr->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tmp_lhr->FldCaption(), $this->tmp_lhr->ReqErrMsg));
		}
		if (!$this->tgl_lhr->FldIsDetailKey && !is_null($this->tgl_lhr->FormValue) && $this->tgl_lhr->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl_lhr->FldCaption(), $this->tgl_lhr->ReqErrMsg));
		}
		if (!$this->tgl->FldIsDetailKey && !is_null($this->tgl->FormValue) && $this->tgl->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl->FldCaption(), $this->tgl->ReqErrMsg));
		}
		if (!$this->bln->FldIsDetailKey && !is_null($this->bln->FormValue) && $this->bln->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bln->FldCaption(), $this->bln->ReqErrMsg));
		}
		if (!$this->thn->FldIsDetailKey && !is_null($this->thn->FormValue) && $this->thn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->thn->FldCaption(), $this->thn->ReqErrMsg));
		}
		if (!$this->sex->FldIsDetailKey && !is_null($this->sex->FormValue) && $this->sex->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sex->FldCaption(), $this->sex->ReqErrMsg));
		}
		if (!$this->nm_ortu->FldIsDetailKey && !is_null($this->nm_ortu->FormValue) && $this->nm_ortu->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nm_ortu->FldCaption(), $this->nm_ortu->ReqErrMsg));
		}
		if (!$this->asal_sek->FldIsDetailKey && !is_null($this->asal_sek->FormValue) && $this->asal_sek->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->asal_sek->FldCaption(), $this->asal_sek->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->asal_sek->FormValue)) {
			ew_AddMessage($gsFormError, $this->asal_sek->FldErrMsg());
		}
		if (!$this->n_ind->FldIsDetailKey && !is_null($this->n_ind->FormValue) && $this->n_ind->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_ind->FldCaption(), $this->n_ind->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->n_ind->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_ind->FldErrMsg());
		}
		if (!$this->n_mat->FldIsDetailKey && !is_null($this->n_mat->FormValue) && $this->n_mat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_mat->FldCaption(), $this->n_mat->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->n_mat->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_mat->FldErrMsg());
		}
		if (!$this->n_ipa->FldIsDetailKey && !is_null($this->n_ipa->FormValue) && $this->n_ipa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_ipa->FldCaption(), $this->n_ipa->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->n_ipa->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_ipa->FldErrMsg());
		}
		if (!$this->n_jml->FldIsDetailKey && !is_null($this->n_jml->FormValue) && $this->n_jml->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_jml->FldCaption(), $this->n_jml->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->n_jml->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_jml->FldErrMsg());
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

			// nopes
			$this->nopes->SetDbValueDef($rsnew, $this->nopes->CurrentValue, "", $this->nopes->ReadOnly);

			// nm_pes
			$this->nm_pes->SetDbValueDef($rsnew, $this->nm_pes->CurrentValue, "", $this->nm_pes->ReadOnly);

			// tmp_lhr
			$this->tmp_lhr->SetDbValueDef($rsnew, $this->tmp_lhr->CurrentValue, "", $this->tmp_lhr->ReadOnly);

			// tgl_lhr
			$this->tgl_lhr->SetDbValueDef($rsnew, $this->tgl_lhr->CurrentValue, "", $this->tgl_lhr->ReadOnly);

			// tgl
			$this->tgl->SetDbValueDef($rsnew, $this->tgl->CurrentValue, "", $this->tgl->ReadOnly);

			// bln
			$this->bln->SetDbValueDef($rsnew, $this->bln->CurrentValue, "", $this->bln->ReadOnly);

			// thn
			$this->thn->SetDbValueDef($rsnew, $this->thn->CurrentValue, "", $this->thn->ReadOnly);

			// sex
			$this->sex->SetDbValueDef($rsnew, $this->sex->CurrentValue, "", $this->sex->ReadOnly);

			// nm_ortu
			$this->nm_ortu->SetDbValueDef($rsnew, $this->nm_ortu->CurrentValue, "", $this->nm_ortu->ReadOnly);

			// asal_sek
			$this->asal_sek->SetDbValueDef($rsnew, $this->asal_sek->CurrentValue, "", $this->asal_sek->ReadOnly);

			// n_ind
			$this->n_ind->SetDbValueDef($rsnew, $this->n_ind->CurrentValue, 0, $this->n_ind->ReadOnly);

			// n_mat
			$this->n_mat->SetDbValueDef($rsnew, $this->n_mat->CurrentValue, 0, $this->n_mat->ReadOnly);

			// n_ipa
			$this->n_ipa->SetDbValueDef($rsnew, $this->n_ipa->CurrentValue, 0, $this->n_ipa->ReadOnly);

			// n_jml
			$this->n_jml->SetDbValueDef($rsnew, $this->n_jml->CurrentValue, 0, $this->n_jml->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("db_pdlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($db_pd_edit)) $db_pd_edit = new cdb_pd_edit();

// Page init
$db_pd_edit->Page_Init();

// Page main
$db_pd_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$db_pd_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdb_pdedit = new ew_Form("fdb_pdedit", "edit");

// Validate form
fdb_pdedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nopes");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->nopes->FldCaption(), $db_pd->nopes->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nm_pes");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->nm_pes->FldCaption(), $db_pd->nm_pes->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tmp_lhr");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->tmp_lhr->FldCaption(), $db_pd->tmp_lhr->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_lhr");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->tgl_lhr->FldCaption(), $db_pd->tgl_lhr->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->tgl->FldCaption(), $db_pd->tgl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bln");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->bln->FldCaption(), $db_pd->bln->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_thn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->thn->FldCaption(), $db_pd->thn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sex");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->sex->FldCaption(), $db_pd->sex->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nm_ortu");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->nm_ortu->FldCaption(), $db_pd->nm_ortu->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_asal_sek");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->asal_sek->FldCaption(), $db_pd->asal_sek->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_asal_sek");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($db_pd->asal_sek->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_n_ind");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->n_ind->FldCaption(), $db_pd->n_ind->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_ind");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($db_pd->n_ind->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_n_mat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->n_mat->FldCaption(), $db_pd->n_mat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_mat");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($db_pd->n_mat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_n_ipa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->n_ipa->FldCaption(), $db_pd->n_ipa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_ipa");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($db_pd->n_ipa->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_n_jml");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $db_pd->n_jml->FldCaption(), $db_pd->n_jml->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_jml");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($db_pd->n_jml->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdb_pdedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdb_pdedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $db_pd_edit->ShowPageHeader(); ?>
<?php
$db_pd_edit->ShowMessage();
?>
<form name="fdb_pdedit" id="fdb_pdedit" class="<?php echo $db_pd_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($db_pd_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $db_pd_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="db_pd">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($db_pd_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($db_pd->id_pd->Visible) { // id_pd ?>
	<div id="r_id_pd" class="form-group">
		<label id="elh_db_pd_id_pd" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->id_pd->FldCaption() ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->id_pd->CellAttributes() ?>>
<span id="el_db_pd_id_pd">
<span<?php echo $db_pd->id_pd->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $db_pd->id_pd->EditValue ?></p></span>
</span>
<input type="hidden" data-table="db_pd" data-field="x_id_pd" name="x_id_pd" id="x_id_pd" value="<?php echo ew_HtmlEncode($db_pd->id_pd->CurrentValue) ?>">
<?php echo $db_pd->id_pd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->nopes->Visible) { // nopes ?>
	<div id="r_nopes" class="form-group">
		<label id="elh_db_pd_nopes" for="x_nopes" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->nopes->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->nopes->CellAttributes() ?>>
<span id="el_db_pd_nopes">
<input type="text" data-table="db_pd" data-field="x_nopes" name="x_nopes" id="x_nopes" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($db_pd->nopes->getPlaceHolder()) ?>" value="<?php echo $db_pd->nopes->EditValue ?>"<?php echo $db_pd->nopes->EditAttributes() ?>>
</span>
<?php echo $db_pd->nopes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->nm_pes->Visible) { // nm_pes ?>
	<div id="r_nm_pes" class="form-group">
		<label id="elh_db_pd_nm_pes" for="x_nm_pes" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->nm_pes->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->nm_pes->CellAttributes() ?>>
<span id="el_db_pd_nm_pes">
<input type="text" data-table="db_pd" data-field="x_nm_pes" name="x_nm_pes" id="x_nm_pes" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($db_pd->nm_pes->getPlaceHolder()) ?>" value="<?php echo $db_pd->nm_pes->EditValue ?>"<?php echo $db_pd->nm_pes->EditAttributes() ?>>
</span>
<?php echo $db_pd->nm_pes->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->tmp_lhr->Visible) { // tmp_lhr ?>
	<div id="r_tmp_lhr" class="form-group">
		<label id="elh_db_pd_tmp_lhr" for="x_tmp_lhr" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->tmp_lhr->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->tmp_lhr->CellAttributes() ?>>
<span id="el_db_pd_tmp_lhr">
<input type="text" data-table="db_pd" data-field="x_tmp_lhr" name="x_tmp_lhr" id="x_tmp_lhr" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($db_pd->tmp_lhr->getPlaceHolder()) ?>" value="<?php echo $db_pd->tmp_lhr->EditValue ?>"<?php echo $db_pd->tmp_lhr->EditAttributes() ?>>
</span>
<?php echo $db_pd->tmp_lhr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->tgl_lhr->Visible) { // tgl_lhr ?>
	<div id="r_tgl_lhr" class="form-group">
		<label id="elh_db_pd_tgl_lhr" for="x_tgl_lhr" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->tgl_lhr->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->tgl_lhr->CellAttributes() ?>>
<span id="el_db_pd_tgl_lhr">
<input type="text" data-table="db_pd" data-field="x_tgl_lhr" name="x_tgl_lhr" id="x_tgl_lhr" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($db_pd->tgl_lhr->getPlaceHolder()) ?>" value="<?php echo $db_pd->tgl_lhr->EditValue ?>"<?php echo $db_pd->tgl_lhr->EditAttributes() ?>>
</span>
<?php echo $db_pd->tgl_lhr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->tgl->Visible) { // tgl ?>
	<div id="r_tgl" class="form-group">
		<label id="elh_db_pd_tgl" for="x_tgl" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->tgl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->tgl->CellAttributes() ?>>
<span id="el_db_pd_tgl">
<input type="text" data-table="db_pd" data-field="x_tgl" name="x_tgl" id="x_tgl" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($db_pd->tgl->getPlaceHolder()) ?>" value="<?php echo $db_pd->tgl->EditValue ?>"<?php echo $db_pd->tgl->EditAttributes() ?>>
</span>
<?php echo $db_pd->tgl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->bln->Visible) { // bln ?>
	<div id="r_bln" class="form-group">
		<label id="elh_db_pd_bln" for="x_bln" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->bln->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->bln->CellAttributes() ?>>
<span id="el_db_pd_bln">
<input type="text" data-table="db_pd" data-field="x_bln" name="x_bln" id="x_bln" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($db_pd->bln->getPlaceHolder()) ?>" value="<?php echo $db_pd->bln->EditValue ?>"<?php echo $db_pd->bln->EditAttributes() ?>>
</span>
<?php echo $db_pd->bln->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->thn->Visible) { // thn ?>
	<div id="r_thn" class="form-group">
		<label id="elh_db_pd_thn" for="x_thn" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->thn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->thn->CellAttributes() ?>>
<span id="el_db_pd_thn">
<input type="text" data-table="db_pd" data-field="x_thn" name="x_thn" id="x_thn" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($db_pd->thn->getPlaceHolder()) ?>" value="<?php echo $db_pd->thn->EditValue ?>"<?php echo $db_pd->thn->EditAttributes() ?>>
</span>
<?php echo $db_pd->thn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->sex->Visible) { // sex ?>
	<div id="r_sex" class="form-group">
		<label id="elh_db_pd_sex" for="x_sex" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->sex->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->sex->CellAttributes() ?>>
<span id="el_db_pd_sex">
<input type="text" data-table="db_pd" data-field="x_sex" name="x_sex" id="x_sex" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($db_pd->sex->getPlaceHolder()) ?>" value="<?php echo $db_pd->sex->EditValue ?>"<?php echo $db_pd->sex->EditAttributes() ?>>
</span>
<?php echo $db_pd->sex->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->nm_ortu->Visible) { // nm_ortu ?>
	<div id="r_nm_ortu" class="form-group">
		<label id="elh_db_pd_nm_ortu" for="x_nm_ortu" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->nm_ortu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->nm_ortu->CellAttributes() ?>>
<span id="el_db_pd_nm_ortu">
<input type="text" data-table="db_pd" data-field="x_nm_ortu" name="x_nm_ortu" id="x_nm_ortu" size="30" maxlength="55" placeholder="<?php echo ew_HtmlEncode($db_pd->nm_ortu->getPlaceHolder()) ?>" value="<?php echo $db_pd->nm_ortu->EditValue ?>"<?php echo $db_pd->nm_ortu->EditAttributes() ?>>
</span>
<?php echo $db_pd->nm_ortu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->asal_sek->Visible) { // asal_sek ?>
	<div id="r_asal_sek" class="form-group">
		<label id="elh_db_pd_asal_sek" for="x_asal_sek" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->asal_sek->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->asal_sek->CellAttributes() ?>>
<span id="el_db_pd_asal_sek">
<input type="text" data-table="db_pd" data-field="x_asal_sek" name="x_asal_sek" id="x_asal_sek" size="30" placeholder="<?php echo ew_HtmlEncode($db_pd->asal_sek->getPlaceHolder()) ?>" value="<?php echo $db_pd->asal_sek->EditValue ?>"<?php echo $db_pd->asal_sek->EditAttributes() ?>>
</span>
<?php echo $db_pd->asal_sek->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->n_ind->Visible) { // n_ind ?>
	<div id="r_n_ind" class="form-group">
		<label id="elh_db_pd_n_ind" for="x_n_ind" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->n_ind->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->n_ind->CellAttributes() ?>>
<span id="el_db_pd_n_ind">
<input type="text" data-table="db_pd" data-field="x_n_ind" name="x_n_ind" id="x_n_ind" size="30" placeholder="<?php echo ew_HtmlEncode($db_pd->n_ind->getPlaceHolder()) ?>" value="<?php echo $db_pd->n_ind->EditValue ?>"<?php echo $db_pd->n_ind->EditAttributes() ?>>
</span>
<?php echo $db_pd->n_ind->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->n_mat->Visible) { // n_mat ?>
	<div id="r_n_mat" class="form-group">
		<label id="elh_db_pd_n_mat" for="x_n_mat" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->n_mat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->n_mat->CellAttributes() ?>>
<span id="el_db_pd_n_mat">
<input type="text" data-table="db_pd" data-field="x_n_mat" name="x_n_mat" id="x_n_mat" size="30" placeholder="<?php echo ew_HtmlEncode($db_pd->n_mat->getPlaceHolder()) ?>" value="<?php echo $db_pd->n_mat->EditValue ?>"<?php echo $db_pd->n_mat->EditAttributes() ?>>
</span>
<?php echo $db_pd->n_mat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->n_ipa->Visible) { // n_ipa ?>
	<div id="r_n_ipa" class="form-group">
		<label id="elh_db_pd_n_ipa" for="x_n_ipa" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->n_ipa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->n_ipa->CellAttributes() ?>>
<span id="el_db_pd_n_ipa">
<input type="text" data-table="db_pd" data-field="x_n_ipa" name="x_n_ipa" id="x_n_ipa" size="30" placeholder="<?php echo ew_HtmlEncode($db_pd->n_ipa->getPlaceHolder()) ?>" value="<?php echo $db_pd->n_ipa->EditValue ?>"<?php echo $db_pd->n_ipa->EditAttributes() ?>>
</span>
<?php echo $db_pd->n_ipa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($db_pd->n_jml->Visible) { // n_jml ?>
	<div id="r_n_jml" class="form-group">
		<label id="elh_db_pd_n_jml" for="x_n_jml" class="<?php echo $db_pd_edit->LeftColumnClass ?>"><?php echo $db_pd->n_jml->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $db_pd_edit->RightColumnClass ?>"><div<?php echo $db_pd->n_jml->CellAttributes() ?>>
<span id="el_db_pd_n_jml">
<input type="text" data-table="db_pd" data-field="x_n_jml" name="x_n_jml" id="x_n_jml" size="30" placeholder="<?php echo ew_HtmlEncode($db_pd->n_jml->getPlaceHolder()) ?>" value="<?php echo $db_pd->n_jml->EditValue ?>"<?php echo $db_pd->n_jml->EditAttributes() ?>>
</span>
<?php echo $db_pd->n_jml->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$db_pd_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $db_pd_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $db_pd_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fdb_pdedit.Init();
</script>
<?php
$db_pd_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$db_pd_edit->Page_Terminate();
?>
