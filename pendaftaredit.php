<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendaftarinfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "no_pendaftaraninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendaftar_edit = NULL; // Initialize page object first

class cpendaftar_edit extends cpendaftar {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'pendaftar';

	// Page object name
	var $PageObjName = 'pendaftar_edit';

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

		// Table object (pendaftar)
		if (!isset($GLOBALS["pendaftar"]) || get_class($GLOBALS["pendaftar"]) == "cpendaftar") {
			$GLOBALS["pendaftar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendaftar"];
		}

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendaftar', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pendaftarlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("pendaftarlist.php"));
			}
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nama_ruang->SetVisibility();
		$this->nomor_pendaftaran->SetVisibility();
		$this->nomor_peserta_ujian_sdmi->SetVisibility();
		$this->sekolah_asal->SetVisibility();
		$this->nama_lengkap->SetVisibility();
		$this->nik->SetVisibility();
		$this->nisn->SetVisibility();
		$this->tempat_lahir->SetVisibility();
		$this->tanggal_lahir->SetVisibility();
		$this->jenis_kelamin->SetVisibility();
		$this->agama->SetVisibility();
		$this->alamat->SetVisibility();
		$this->kecamatan->SetVisibility();
		$this->zona->SetVisibility();
		$this->n_ind->SetVisibility();
		$this->n_mat->SetVisibility();
		$this->n_ipa->SetVisibility();
		$this->jumlah_nilai_usum->SetVisibility();
		$this->bonus_prestasi->SetVisibility();
		$this->nama_prestasi->SetVisibility();
		$this->jumlah_bonus_prestasi->SetVisibility();
		$this->kepemilikan_ijasah_mda->SetVisibility();
		$this->nilai_mda->SetVisibility();
		$this->nilai_akhir->SetVisibility();
		$this->nama_ayah->SetVisibility();
		$this->nama_ibu->SetVisibility();
		$this->nama_wali->SetVisibility();
		$this->persyaratan->SetVisibility();
		$this->catatan->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $pendaftar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendaftar);
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
					if ($pageName == "pendaftarview.php")
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
	var $MultiPages; // Multi pages object

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
			if ($objForm->HasValue("x_id_pendaftar")) {
				$this->id_pendaftar->setFormValue($objForm->GetValue("x_id_pendaftar"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id_pendaftar"])) {
				$this->id_pendaftar->setQueryStringValue($_GET["id_pendaftar"]);
				$loadByQuery = TRUE;
			} else {
				$this->id_pendaftar->CurrentValue = NULL;
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
					$this->Page_Terminate("pendaftarlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "pendaftarlist.php")
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
		if (!$this->nama_ruang->FldIsDetailKey) {
			$this->nama_ruang->setFormValue($objForm->GetValue("x_nama_ruang"));
		}
		if (!$this->nomor_pendaftaran->FldIsDetailKey) {
			$this->nomor_pendaftaran->setFormValue($objForm->GetValue("x_nomor_pendaftaran"));
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
		if (!$this->nik->FldIsDetailKey) {
			$this->nik->setFormValue($objForm->GetValue("x_nik"));
		}
		if (!$this->nisn->FldIsDetailKey) {
			$this->nisn->setFormValue($objForm->GetValue("x_nisn"));
		}
		if (!$this->tempat_lahir->FldIsDetailKey) {
			$this->tempat_lahir->setFormValue($objForm->GetValue("x_tempat_lahir"));
		}
		if (!$this->tanggal_lahir->FldIsDetailKey) {
			$this->tanggal_lahir->setFormValue($objForm->GetValue("x_tanggal_lahir"));
		}
		if (!$this->jenis_kelamin->FldIsDetailKey) {
			$this->jenis_kelamin->setFormValue($objForm->GetValue("x_jenis_kelamin"));
		}
		if (!$this->agama->FldIsDetailKey) {
			$this->agama->setFormValue($objForm->GetValue("x_agama"));
		}
		if (!$this->alamat->FldIsDetailKey) {
			$this->alamat->setFormValue($objForm->GetValue("x_alamat"));
		}
		if (!$this->kecamatan->FldIsDetailKey) {
			$this->kecamatan->setFormValue($objForm->GetValue("x_kecamatan"));
		}
		if (!$this->zona->FldIsDetailKey) {
			$this->zona->setFormValue($objForm->GetValue("x_zona"));
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
		if (!$this->jumlah_nilai_usum->FldIsDetailKey) {
			$this->jumlah_nilai_usum->setFormValue($objForm->GetValue("x_jumlah_nilai_usum"));
		}
		if (!$this->bonus_prestasi->FldIsDetailKey) {
			$this->bonus_prestasi->setFormValue($objForm->GetValue("x_bonus_prestasi"));
		}
		if (!$this->nama_prestasi->FldIsDetailKey) {
			$this->nama_prestasi->setFormValue($objForm->GetValue("x_nama_prestasi"));
		}
		if (!$this->jumlah_bonus_prestasi->FldIsDetailKey) {
			$this->jumlah_bonus_prestasi->setFormValue($objForm->GetValue("x_jumlah_bonus_prestasi"));
		}
		if (!$this->kepemilikan_ijasah_mda->FldIsDetailKey) {
			$this->kepemilikan_ijasah_mda->setFormValue($objForm->GetValue("x_kepemilikan_ijasah_mda"));
		}
		if (!$this->nilai_mda->FldIsDetailKey) {
			$this->nilai_mda->setFormValue($objForm->GetValue("x_nilai_mda"));
		}
		if (!$this->nilai_akhir->FldIsDetailKey) {
			$this->nilai_akhir->setFormValue($objForm->GetValue("x_nilai_akhir"));
		}
		if (!$this->nama_ayah->FldIsDetailKey) {
			$this->nama_ayah->setFormValue($objForm->GetValue("x_nama_ayah"));
		}
		if (!$this->nama_ibu->FldIsDetailKey) {
			$this->nama_ibu->setFormValue($objForm->GetValue("x_nama_ibu"));
		}
		if (!$this->nama_wali->FldIsDetailKey) {
			$this->nama_wali->setFormValue($objForm->GetValue("x_nama_wali"));
		}
		if (!$this->persyaratan->FldIsDetailKey) {
			$this->persyaratan->setFormValue($objForm->GetValue("x_persyaratan"));
		}
		if (!$this->catatan->FldIsDetailKey) {
			$this->catatan->setFormValue($objForm->GetValue("x_catatan"));
		}
		if (!$this->id_pendaftar->FldIsDetailKey)
			$this->id_pendaftar->setFormValue($objForm->GetValue("x_id_pendaftar"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id_pendaftar->CurrentValue = $this->id_pendaftar->FormValue;
		$this->nama_ruang->CurrentValue = $this->nama_ruang->FormValue;
		$this->nomor_pendaftaran->CurrentValue = $this->nomor_pendaftaran->FormValue;
		$this->nomor_peserta_ujian_sdmi->CurrentValue = $this->nomor_peserta_ujian_sdmi->FormValue;
		$this->sekolah_asal->CurrentValue = $this->sekolah_asal->FormValue;
		$this->nama_lengkap->CurrentValue = $this->nama_lengkap->FormValue;
		$this->nik->CurrentValue = $this->nik->FormValue;
		$this->nisn->CurrentValue = $this->nisn->FormValue;
		$this->tempat_lahir->CurrentValue = $this->tempat_lahir->FormValue;
		$this->tanggal_lahir->CurrentValue = $this->tanggal_lahir->FormValue;
		$this->jenis_kelamin->CurrentValue = $this->jenis_kelamin->FormValue;
		$this->agama->CurrentValue = $this->agama->FormValue;
		$this->alamat->CurrentValue = $this->alamat->FormValue;
		$this->kecamatan->CurrentValue = $this->kecamatan->FormValue;
		$this->zona->CurrentValue = $this->zona->FormValue;
		$this->n_ind->CurrentValue = $this->n_ind->FormValue;
		$this->n_mat->CurrentValue = $this->n_mat->FormValue;
		$this->n_ipa->CurrentValue = $this->n_ipa->FormValue;
		$this->jumlah_nilai_usum->CurrentValue = $this->jumlah_nilai_usum->FormValue;
		$this->bonus_prestasi->CurrentValue = $this->bonus_prestasi->FormValue;
		$this->nama_prestasi->CurrentValue = $this->nama_prestasi->FormValue;
		$this->jumlah_bonus_prestasi->CurrentValue = $this->jumlah_bonus_prestasi->FormValue;
		$this->kepemilikan_ijasah_mda->CurrentValue = $this->kepemilikan_ijasah_mda->FormValue;
		$this->nilai_mda->CurrentValue = $this->nilai_mda->FormValue;
		$this->nilai_akhir->CurrentValue = $this->nilai_akhir->FormValue;
		$this->nama_ayah->CurrentValue = $this->nama_ayah->FormValue;
		$this->nama_ibu->CurrentValue = $this->nama_ibu->FormValue;
		$this->nama_wali->CurrentValue = $this->nama_wali->FormValue;
		$this->persyaratan->CurrentValue = $this->persyaratan->FormValue;
		$this->catatan->CurrentValue = $this->catatan->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('edit');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
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

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

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
		$this->bonus_prestasi->ViewValue = ew_FormatNumber($this->bonus_prestasi->ViewValue, 1, 0, 0, 0);
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

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";
			$this->nik->TooltipValue = "";

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

			// agama
			$this->agama->LinkCustomAttributes = "";
			$this->agama->HrefValue = "";
			$this->agama->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// kecamatan
			$this->kecamatan->LinkCustomAttributes = "";
			$this->kecamatan->HrefValue = "";
			$this->kecamatan->TooltipValue = "";

			// zona
			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";
			$this->zona->TooltipValue = "";

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

			// jumlah_nilai_usum
			$this->jumlah_nilai_usum->LinkCustomAttributes = "";
			$this->jumlah_nilai_usum->HrefValue = "";
			$this->jumlah_nilai_usum->TooltipValue = "";

			// bonus_prestasi
			$this->bonus_prestasi->LinkCustomAttributes = "";
			$this->bonus_prestasi->HrefValue = "";
			$this->bonus_prestasi->TooltipValue = "";

			// nama_prestasi
			$this->nama_prestasi->LinkCustomAttributes = "";
			$this->nama_prestasi->HrefValue = "";
			$this->nama_prestasi->TooltipValue = "";

			// jumlah_bonus_prestasi
			$this->jumlah_bonus_prestasi->LinkCustomAttributes = "";
			$this->jumlah_bonus_prestasi->HrefValue = "";
			$this->jumlah_bonus_prestasi->TooltipValue = "";

			// kepemilikan_ijasah_mda
			$this->kepemilikan_ijasah_mda->LinkCustomAttributes = "";
			$this->kepemilikan_ijasah_mda->HrefValue = "";
			$this->kepemilikan_ijasah_mda->TooltipValue = "";

			// nilai_mda
			$this->nilai_mda->LinkCustomAttributes = "";
			$this->nilai_mda->HrefValue = "";
			$this->nilai_mda->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("edit")) { // Non system admin
			if (trim(strval($this->nama_ruang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_STRING, "");
			}
			ew_AddFilter($sFilterWrk, $GLOBALS["ruang"]->AddUserIDFilter(""));
			$sSqlWrk = "SELECT `nama_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->nama_ruang->ViewValue = $this->nama_ruang->DisplayValue($arwrk);
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_ruang->EditValue = $this->nama_ruang->ViewValue;
			} else {
			if (trim(strval($this->nama_ruang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama_ruang`" . ew_SearchString("=", $this->nama_ruang->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nama_ruang`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["pendaftar"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_ruang->EditValue = $arwrk;
			}

			// nomor_pendaftaran
			$this->nomor_pendaftaran->EditCustomAttributes = "";
			if (trim(strval($this->nomor_pendaftaran->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nomor_pendaftaran`" . ew_SearchString("=", $this->nomor_pendaftaran->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nomor_pendaftaran`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `no_pendaftaran`";
			$sWhereWrk = "";
			$this->nomor_pendaftaran->LookupFilters = array("dx1" => '`nomor_pendaftaran`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["pendaftar"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->nomor_pendaftaran->ViewValue = $this->nomor_pendaftaran->DisplayValue($arwrk);
			} else {
				$this->nomor_pendaftaran->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nomor_pendaftaran->EditValue = $arwrk;

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";
			if (trim(strval($this->nomor_peserta_ujian_sdmi->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nopes`" . ew_SearchString("=", $this->nomor_peserta_ujian_sdmi->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nopes`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `db_pd`";
			$sWhereWrk = "";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array("dx1" => '`nopes`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nopes` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->nomor_peserta_ujian_sdmi->ViewValue = $this->nomor_peserta_ujian_sdmi->DisplayValue($arwrk);
			} else {
				$this->nomor_peserta_ujian_sdmi->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nomor_peserta_ujian_sdmi->EditValue = $arwrk;

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

			// nik
			$this->nik->EditAttrs["class"] = "form-control";
			$this->nik->EditCustomAttributes = "";
			$this->nik->EditValue = ew_HtmlEncode($this->nik->CurrentValue);
			$this->nik->PlaceHolder = ew_RemoveHtml($this->nik->FldCaption());

			// nisn
			$this->nisn->EditAttrs["class"] = "form-control";
			$this->nisn->EditCustomAttributes = "";
			$this->nisn->EditValue = ew_HtmlEncode($this->nisn->CurrentValue);
			$this->nisn->PlaceHolder = ew_RemoveHtml($this->nisn->FldCaption());

			// tempat_lahir
			$this->tempat_lahir->EditAttrs["class"] = "form-control";
			$this->tempat_lahir->EditCustomAttributes = "";
			$this->tempat_lahir->EditValue = ew_HtmlEncode($this->tempat_lahir->CurrentValue);
			$this->tempat_lahir->PlaceHolder = ew_RemoveHtml($this->tempat_lahir->FldCaption());

			// tanggal_lahir
			$this->tanggal_lahir->EditAttrs["class"] = "form-control";
			$this->tanggal_lahir->EditCustomAttributes = "";
			$this->tanggal_lahir->EditValue = ew_HtmlEncode($this->tanggal_lahir->CurrentValue);
			$this->tanggal_lahir->PlaceHolder = ew_RemoveHtml($this->tanggal_lahir->FldCaption());

			// jenis_kelamin
			$this->jenis_kelamin->EditCustomAttributes = "";
			$this->jenis_kelamin->EditValue = $this->jenis_kelamin->Options(FALSE);

			// agama
			$this->agama->EditAttrs["class"] = "form-control";
			$this->agama->EditCustomAttributes = "";
			$this->agama->EditValue = $this->agama->Options(TRUE);

			// alamat
			$this->alamat->EditAttrs["class"] = "form-control";
			$this->alamat->EditCustomAttributes = "";
			$this->alamat->EditValue = ew_HtmlEncode($this->alamat->CurrentValue);
			$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

			// kecamatan
			$this->kecamatan->EditCustomAttributes = "";
			if (trim(strval($this->kecamatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_kec`" . ew_SearchString("=", $this->kecamatan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_kec`, `nama_kec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `kecamatan`";
			$sWhereWrk = "";
			$this->kecamatan->LookupFilters = array("dx1" => '`nama_kec`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kecamatan, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->kecamatan->ViewValue = $this->kecamatan->DisplayValue($arwrk);
			} else {
				$this->kecamatan->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kecamatan->EditValue = $arwrk;

			// zona
			$this->zona->EditAttrs["class"] = "form-control";
			$this->zona->EditCustomAttributes = "";
			$this->zona->EditValue = ew_HtmlEncode($this->zona->CurrentValue);
			$this->zona->PlaceHolder = ew_RemoveHtml($this->zona->FldCaption());

			// n_ind
			$this->n_ind->EditAttrs["class"] = "form-control";
			$this->n_ind->EditCustomAttributes = "";
			$this->n_ind->EditValue = $this->n_ind->CurrentValue;
			$this->n_ind->EditValue = ew_FormatNumber($this->n_ind->EditValue, 1, 0, 0, 0);
			$this->n_ind->ViewCustomAttributes = "";

			// n_mat
			$this->n_mat->EditAttrs["class"] = "form-control";
			$this->n_mat->EditCustomAttributes = "";
			$this->n_mat->EditValue = $this->n_mat->CurrentValue;
			$this->n_mat->EditValue = ew_FormatNumber($this->n_mat->EditValue, 1, 0, 0, 0);
			$this->n_mat->ViewCustomAttributes = "";

			// n_ipa
			$this->n_ipa->EditAttrs["class"] = "form-control";
			$this->n_ipa->EditCustomAttributes = "";
			$this->n_ipa->EditValue = $this->n_ipa->CurrentValue;
			$this->n_ipa->EditValue = ew_FormatNumber($this->n_ipa->EditValue, 1, 0, 0, 0);
			$this->n_ipa->ViewCustomAttributes = "";

			// jumlah_nilai_usum
			$this->jumlah_nilai_usum->EditAttrs["class"] = "form-control";
			$this->jumlah_nilai_usum->EditCustomAttributes = "";
			$this->jumlah_nilai_usum->EditValue = $this->jumlah_nilai_usum->CurrentValue;
			$this->jumlah_nilai_usum->EditValue = ew_FormatNumber($this->jumlah_nilai_usum->EditValue, 1, 0, 0, 0);
			$this->jumlah_nilai_usum->ViewCustomAttributes = "";

			// bonus_prestasi
			$this->bonus_prestasi->EditCustomAttributes = "";
			if (trim(strval($this->bonus_prestasi->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_bonus`" . ew_SearchString("=", $this->bonus_prestasi->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_bonus`, `bonus` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `bonus`";
			$sWhereWrk = "";
			$this->bonus_prestasi->LookupFilters = array("dx1" => '`bonus`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->bonus_prestasi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->bonus_prestasi->ViewValue = $this->bonus_prestasi->DisplayValue($arwrk);
			} else {
				$this->bonus_prestasi->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->bonus_prestasi->EditValue = $arwrk;

			// nama_prestasi
			$this->nama_prestasi->EditAttrs["class"] = "form-control";
			$this->nama_prestasi->EditCustomAttributes = "";
			$this->nama_prestasi->EditValue = ew_HtmlEncode($this->nama_prestasi->CurrentValue);
			$this->nama_prestasi->PlaceHolder = ew_RemoveHtml($this->nama_prestasi->FldCaption());

			// jumlah_bonus_prestasi
			$this->jumlah_bonus_prestasi->EditAttrs["class"] = "form-control";
			$this->jumlah_bonus_prestasi->EditCustomAttributes = "";

			// kepemilikan_ijasah_mda
			$this->kepemilikan_ijasah_mda->EditCustomAttributes = "";
			if (trim(strval($this->kepemilikan_ijasah_mda->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_mda`" . ew_SearchString("=", $this->kepemilikan_ijasah_mda->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_mda`, `mda` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `mda`";
			$sWhereWrk = "";
			$this->kepemilikan_ijasah_mda->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kepemilikan_ijasah_mda, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kepemilikan_ijasah_mda->EditValue = $arwrk;

			// nilai_mda
			$this->nilai_mda->EditAttrs["class"] = "form-control";
			$this->nilai_mda->EditCustomAttributes = "";

			// nilai_akhir
			$this->nilai_akhir->EditAttrs["class"] = "form-control";
			$this->nilai_akhir->EditCustomAttributes = "";
			$this->nilai_akhir->EditValue = ew_HtmlEncode($this->nilai_akhir->CurrentValue);
			$this->nilai_akhir->PlaceHolder = ew_RemoveHtml($this->nilai_akhir->FldCaption());

			// nama_ayah
			$this->nama_ayah->EditAttrs["class"] = "form-control";
			$this->nama_ayah->EditCustomAttributes = "";
			$this->nama_ayah->EditValue = ew_HtmlEncode($this->nama_ayah->CurrentValue);
			$this->nama_ayah->PlaceHolder = ew_RemoveHtml($this->nama_ayah->FldCaption());

			// nama_ibu
			$this->nama_ibu->EditAttrs["class"] = "form-control";
			$this->nama_ibu->EditCustomAttributes = "";
			$this->nama_ibu->EditValue = ew_HtmlEncode($this->nama_ibu->CurrentValue);
			$this->nama_ibu->PlaceHolder = ew_RemoveHtml($this->nama_ibu->FldCaption());

			// nama_wali
			$this->nama_wali->EditAttrs["class"] = "form-control";
			$this->nama_wali->EditCustomAttributes = "";
			$this->nama_wali->EditValue = ew_HtmlEncode($this->nama_wali->CurrentValue);
			$this->nama_wali->PlaceHolder = ew_RemoveHtml($this->nama_wali->FldCaption());

			// persyaratan
			$this->persyaratan->EditCustomAttributes = "";
			$this->persyaratan->EditValue = $this->persyaratan->Options(FALSE);

			// catatan
			$this->catatan->EditAttrs["class"] = "form-control";
			$this->catatan->EditCustomAttributes = "";
			$this->catatan->EditValue = ew_HtmlEncode($this->catatan->CurrentValue);
			$this->catatan->PlaceHolder = ew_RemoveHtml($this->catatan->FldCaption());

			// Edit refer script
			// nama_ruang

			$this->nama_ruang->LinkCustomAttributes = "";
			$this->nama_ruang->HrefValue = "";

			// nomor_pendaftaran
			$this->nomor_pendaftaran->LinkCustomAttributes = "";
			$this->nomor_pendaftaran->HrefValue = "";

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->LinkCustomAttributes = "";
			$this->nomor_peserta_ujian_sdmi->HrefValue = "";

			// sekolah_asal
			$this->sekolah_asal->LinkCustomAttributes = "";
			$this->sekolah_asal->HrefValue = "";

			// nama_lengkap
			$this->nama_lengkap->LinkCustomAttributes = "";
			$this->nama_lengkap->HrefValue = "";

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";

			// nisn
			$this->nisn->LinkCustomAttributes = "";
			$this->nisn->HrefValue = "";

			// tempat_lahir
			$this->tempat_lahir->LinkCustomAttributes = "";
			$this->tempat_lahir->HrefValue = "";

			// tanggal_lahir
			$this->tanggal_lahir->LinkCustomAttributes = "";
			$this->tanggal_lahir->HrefValue = "";

			// jenis_kelamin
			$this->jenis_kelamin->LinkCustomAttributes = "";
			$this->jenis_kelamin->HrefValue = "";

			// agama
			$this->agama->LinkCustomAttributes = "";
			$this->agama->HrefValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";

			// kecamatan
			$this->kecamatan->LinkCustomAttributes = "";
			$this->kecamatan->HrefValue = "";

			// zona
			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";

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

			// jumlah_nilai_usum
			$this->jumlah_nilai_usum->LinkCustomAttributes = "";
			$this->jumlah_nilai_usum->HrefValue = "";
			$this->jumlah_nilai_usum->TooltipValue = "";

			// bonus_prestasi
			$this->bonus_prestasi->LinkCustomAttributes = "";
			$this->bonus_prestasi->HrefValue = "";

			// nama_prestasi
			$this->nama_prestasi->LinkCustomAttributes = "";
			$this->nama_prestasi->HrefValue = "";

			// jumlah_bonus_prestasi
			$this->jumlah_bonus_prestasi->LinkCustomAttributes = "";
			$this->jumlah_bonus_prestasi->HrefValue = "";

			// kepemilikan_ijasah_mda
			$this->kepemilikan_ijasah_mda->LinkCustomAttributes = "";
			$this->kepemilikan_ijasah_mda->HrefValue = "";

			// nilai_mda
			$this->nilai_mda->LinkCustomAttributes = "";
			$this->nilai_mda->HrefValue = "";

			// nilai_akhir
			$this->nilai_akhir->LinkCustomAttributes = "";
			$this->nilai_akhir->HrefValue = "";

			// nama_ayah
			$this->nama_ayah->LinkCustomAttributes = "";
			$this->nama_ayah->HrefValue = "";

			// nama_ibu
			$this->nama_ibu->LinkCustomAttributes = "";
			$this->nama_ibu->HrefValue = "";

			// nama_wali
			$this->nama_wali->LinkCustomAttributes = "";
			$this->nama_wali->HrefValue = "";

			// persyaratan
			$this->persyaratan->LinkCustomAttributes = "";
			$this->persyaratan->HrefValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";
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
		if (!$this->nomor_pendaftaran->FldIsDetailKey && !is_null($this->nomor_pendaftaran->FormValue) && $this->nomor_pendaftaran->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomor_pendaftaran->FldCaption(), $this->nomor_pendaftaran->ReqErrMsg));
		}
		if (!$this->nomor_peserta_ujian_sdmi->FldIsDetailKey && !is_null($this->nomor_peserta_ujian_sdmi->FormValue) && $this->nomor_peserta_ujian_sdmi->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomor_peserta_ujian_sdmi->FldCaption(), $this->nomor_peserta_ujian_sdmi->ReqErrMsg));
		}
		if (!$this->tempat_lahir->FldIsDetailKey && !is_null($this->tempat_lahir->FormValue) && $this->tempat_lahir->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_lahir->FldCaption(), $this->tempat_lahir->ReqErrMsg));
		}
		if (!$this->tanggal_lahir->FldIsDetailKey && !is_null($this->tanggal_lahir->FormValue) && $this->tanggal_lahir->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tanggal_lahir->FldCaption(), $this->tanggal_lahir->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tanggal_lahir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_lahir->FldErrMsg());
		}
		if ($this->jenis_kelamin->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jenis_kelamin->FldCaption(), $this->jenis_kelamin->ReqErrMsg));
		}
		if (!$this->agama->FldIsDetailKey && !is_null($this->agama->FormValue) && $this->agama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->agama->FldCaption(), $this->agama->ReqErrMsg));
		}
		if (!$this->alamat->FldIsDetailKey && !is_null($this->alamat->FormValue) && $this->alamat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->alamat->FldCaption(), $this->alamat->ReqErrMsg));
		}
		if (!$this->kecamatan->FldIsDetailKey && !is_null($this->kecamatan->FormValue) && $this->kecamatan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kecamatan->FldCaption(), $this->kecamatan->ReqErrMsg));
		}
		if (!$this->zona->FldIsDetailKey && !is_null($this->zona->FormValue) && $this->zona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->zona->FldCaption(), $this->zona->ReqErrMsg));
		}
		if (!$this->bonus_prestasi->FldIsDetailKey && !is_null($this->bonus_prestasi->FormValue) && $this->bonus_prestasi->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bonus_prestasi->FldCaption(), $this->bonus_prestasi->ReqErrMsg));
		}
		if ($this->kepemilikan_ijasah_mda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kepemilikan_ijasah_mda->FldCaption(), $this->kepemilikan_ijasah_mda->ReqErrMsg));
		}
		if (!$this->nama_ayah->FldIsDetailKey && !is_null($this->nama_ayah->FormValue) && $this->nama_ayah->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_ayah->FldCaption(), $this->nama_ayah->ReqErrMsg));
		}
		if (!$this->nama_ibu->FldIsDetailKey && !is_null($this->nama_ibu->FormValue) && $this->nama_ibu->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_ibu->FldCaption(), $this->nama_ibu->ReqErrMsg));
		}
		if ($this->persyaratan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->persyaratan->FldCaption(), $this->persyaratan->ReqErrMsg));
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
		if ($this->nomor_peserta_ujian_sdmi->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`nomor_peserta_ujian_sdmi` = '" . ew_AdjustSql($this->nomor_peserta_ujian_sdmi->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->nomor_peserta_ujian_sdmi->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->nomor_peserta_ujian_sdmi->CurrentValue, $sIdxErrMsg);
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

			// nama_ruang
			$this->nama_ruang->SetDbValueDef($rsnew, $this->nama_ruang->CurrentValue, NULL, $this->nama_ruang->ReadOnly);

			// nomor_pendaftaran
			$this->nomor_pendaftaran->SetDbValueDef($rsnew, $this->nomor_pendaftaran->CurrentValue, "", $this->nomor_pendaftaran->ReadOnly);

			// nomor_peserta_ujian_sdmi
			$this->nomor_peserta_ujian_sdmi->SetDbValueDef($rsnew, $this->nomor_peserta_ujian_sdmi->CurrentValue, NULL, $this->nomor_peserta_ujian_sdmi->ReadOnly);

			// sekolah_asal
			$this->sekolah_asal->SetDbValueDef($rsnew, $this->sekolah_asal->CurrentValue, NULL, $this->sekolah_asal->ReadOnly);

			// nama_lengkap
			$this->nama_lengkap->SetDbValueDef($rsnew, $this->nama_lengkap->CurrentValue, NULL, $this->nama_lengkap->ReadOnly);

			// nik
			$this->nik->SetDbValueDef($rsnew, $this->nik->CurrentValue, NULL, $this->nik->ReadOnly);

			// nisn
			$this->nisn->SetDbValueDef($rsnew, $this->nisn->CurrentValue, NULL, $this->nisn->ReadOnly);

			// tempat_lahir
			$this->tempat_lahir->SetDbValueDef($rsnew, $this->tempat_lahir->CurrentValue, NULL, $this->tempat_lahir->ReadOnly);

			// tanggal_lahir
			$this->tanggal_lahir->SetDbValueDef($rsnew, $this->tanggal_lahir->CurrentValue, "", $this->tanggal_lahir->ReadOnly);

			// jenis_kelamin
			$this->jenis_kelamin->SetDbValueDef($rsnew, $this->jenis_kelamin->CurrentValue, NULL, $this->jenis_kelamin->ReadOnly);

			// agama
			$this->agama->SetDbValueDef($rsnew, $this->agama->CurrentValue, NULL, $this->agama->ReadOnly);

			// alamat
			$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, "", $this->alamat->ReadOnly);

			// kecamatan
			$this->kecamatan->SetDbValueDef($rsnew, $this->kecamatan->CurrentValue, NULL, $this->kecamatan->ReadOnly);

			// zona
			$this->zona->SetDbValueDef($rsnew, $this->zona->CurrentValue, "", $this->zona->ReadOnly);

			// bonus_prestasi
			$this->bonus_prestasi->SetDbValueDef($rsnew, $this->bonus_prestasi->CurrentValue, "", $this->bonus_prestasi->ReadOnly);

			// nama_prestasi
			$this->nama_prestasi->SetDbValueDef($rsnew, $this->nama_prestasi->CurrentValue, NULL, $this->nama_prestasi->ReadOnly);

			// jumlah_bonus_prestasi
			$this->jumlah_bonus_prestasi->SetDbValueDef($rsnew, $this->jumlah_bonus_prestasi->CurrentValue, NULL, $this->jumlah_bonus_prestasi->ReadOnly);

			// kepemilikan_ijasah_mda
			$this->kepemilikan_ijasah_mda->SetDbValueDef($rsnew, $this->kepemilikan_ijasah_mda->CurrentValue, NULL, $this->kepemilikan_ijasah_mda->ReadOnly);

			// nilai_mda
			$this->nilai_mda->SetDbValueDef($rsnew, $this->nilai_mda->CurrentValue, NULL, $this->nilai_mda->ReadOnly);

			// nilai_akhir
			$this->nilai_akhir->SetDbValueDef($rsnew, $this->nilai_akhir->CurrentValue, NULL, $this->nilai_akhir->ReadOnly);

			// nama_ayah
			$this->nama_ayah->SetDbValueDef($rsnew, $this->nama_ayah->CurrentValue, NULL, $this->nama_ayah->ReadOnly);

			// nama_ibu
			$this->nama_ibu->SetDbValueDef($rsnew, $this->nama_ibu->CurrentValue, NULL, $this->nama_ibu->ReadOnly);

			// nama_wali
			$this->nama_wali->SetDbValueDef($rsnew, $this->nama_wali->CurrentValue, NULL, $this->nama_wali->ReadOnly);

			// persyaratan
			$this->persyaratan->SetDbValueDef($rsnew, $this->persyaratan->CurrentValue, NULL, $this->persyaratan->ReadOnly);

			// catatan
			$this->catatan->SetDbValueDef($rsnew, $this->catatan->CurrentValue, NULL, $this->catatan->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendaftarlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$this->MultiPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nama_ruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama_ruang` AS `LinkFld`, `nama_ruang` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ruang`";
			$sWhereWrk = "";
			$this->nama_ruang->LookupFilters = array();
			if (!$GLOBALS["pendaftar"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama_ruang` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_ruang, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nomor_pendaftaran":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nomor_pendaftaran` AS `LinkFld`, `nomor_pendaftaran` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `no_pendaftaran`";
			$sWhereWrk = "{filter}";
			$this->nomor_pendaftaran->LookupFilters = array("dx1" => '`nomor_pendaftaran`');
			if (!$GLOBALS["pendaftar"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nomor_pendaftaran` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_pendaftaran, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nomor_peserta_ujian_sdmi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nopes` AS `LinkFld`, `nopes` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `db_pd`";
			$sWhereWrk = "{filter}";
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array("dx1" => '`nopes`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nopes` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nopes` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kecamatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_kec` AS `LinkFld`, `nama_kec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kecamatan`";
			$sWhereWrk = "{filter}";
			$this->kecamatan->LookupFilters = array("dx1" => '`nama_kec`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_kec` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kecamatan, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_bonus_prestasi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_bonus` AS `LinkFld`, `bonus` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bonus`";
			$sWhereWrk = "{filter}";
			$this->bonus_prestasi->LookupFilters = array("dx1" => '`bonus`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_bonus` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->bonus_prestasi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kepemilikan_ijasah_mda":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_mda` AS `LinkFld`, `mda` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `mda`";
			$sWhereWrk = "";
			$this->kepemilikan_ijasah_mda->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_mda` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kepemilikan_ijasah_mda, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($pendaftar_edit)) $pendaftar_edit = new cpendaftar_edit();

// Page init
$pendaftar_edit->Page_Init();

// Page main
$pendaftar_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendaftar_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpendaftaredit = new ew_Form("fpendaftaredit", "edit");

// Validate form
fpendaftaredit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->nama_ruang->FldCaption(), $pendaftar->nama_ruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomor_pendaftaran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->nomor_pendaftaran->FldCaption(), $pendaftar->nomor_pendaftaran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomor_peserta_ujian_sdmi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->nomor_peserta_ujian_sdmi->FldCaption(), $pendaftar->nomor_peserta_ujian_sdmi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_lahir");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->tempat_lahir->FldCaption(), $pendaftar->tempat_lahir->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_lahir");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->tanggal_lahir->FldCaption(), $pendaftar->tanggal_lahir->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_lahir");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendaftar->tanggal_lahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jenis_kelamin");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->jenis_kelamin->FldCaption(), $pendaftar->jenis_kelamin->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_agama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->agama->FldCaption(), $pendaftar->agama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_alamat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->alamat->FldCaption(), $pendaftar->alamat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kecamatan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->kecamatan->FldCaption(), $pendaftar->kecamatan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_zona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->zona->FldCaption(), $pendaftar->zona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bonus_prestasi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->bonus_prestasi->FldCaption(), $pendaftar->bonus_prestasi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kepemilikan_ijasah_mda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->kepemilikan_ijasah_mda->FldCaption(), $pendaftar->kepemilikan_ijasah_mda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ayah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->nama_ayah->FldCaption(), $pendaftar->nama_ayah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ibu");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->nama_ibu->FldCaption(), $pendaftar->nama_ibu->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_persyaratan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar->persyaratan->FldCaption(), $pendaftar->persyaratan->ReqErrMsg)) ?>");

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
fpendaftaredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendaftaredit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fpendaftaredit.MultiPage = new ew_MultiPage("fpendaftaredit");

// Dynamic selection lists
fpendaftaredit.Lists["x_nama_ruang"] = {"LinkField":"x_nama_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fpendaftaredit.Lists["x_nama_ruang"].Data = "<?php echo $pendaftar_edit->nama_ruang->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_nomor_pendaftaran","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fpendaftaredit.Lists["x_nomor_pendaftaran"].Data = "<?php echo $pendaftar_edit->nomor_pendaftaran->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_nopes","Ajax":true,"AutoFill":true,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fpendaftaredit.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $pendaftar_edit->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_jenis_kelamin"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftaredit.Lists["x_jenis_kelamin"].Options = <?php echo json_encode($pendaftar_edit->jenis_kelamin->Options()) ?>;
fpendaftaredit.Lists["x_agama"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftaredit.Lists["x_agama"].Options = <?php echo json_encode($pendaftar_edit->agama->Options()) ?>;
fpendaftaredit.Lists["x_kecamatan"] = {"LinkField":"x_id_kec","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_kec","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"kecamatan"};
fpendaftaredit.Lists["x_kecamatan"].Data = "<?php echo $pendaftar_edit->kecamatan->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_bonus_prestasi"] = {"LinkField":"x_id_bonus","Ajax":true,"AutoFill":true,"DisplayFields":["x_bonus","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"bonus"};
fpendaftaredit.Lists["x_bonus_prestasi"].Data = "<?php echo $pendaftar_edit->bonus_prestasi->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_kepemilikan_ijasah_mda"] = {"LinkField":"x_id_mda","Ajax":true,"AutoFill":true,"DisplayFields":["x_mda","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"mda"};
fpendaftaredit.Lists["x_kepemilikan_ijasah_mda"].Data = "<?php echo $pendaftar_edit->kepemilikan_ijasah_mda->LookupFilterQuery(FALSE, "edit") ?>";
fpendaftaredit.Lists["x_persyaratan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftaredit.Lists["x_persyaratan"].Options = <?php echo json_encode($pendaftar_edit->persyaratan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pendaftar_edit->ShowPageHeader(); ?>
<?php
$pendaftar_edit->ShowMessage();
?>
<form name="fpendaftaredit" id="fpendaftaredit" class="<?php echo $pendaftar_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendaftar_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendaftar_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendaftar">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($pendaftar_edit->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="pendaftar_edit"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $pendaftar_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $pendaftar_edit->MultiPages->TabStyle("1") ?>><a href="#tab_pendaftar1" data-toggle="tab"><?php echo $pendaftar->PageCaption(1) ?></a></li>
		<li<?php echo $pendaftar_edit->MultiPages->TabStyle("2") ?>><a href="#tab_pendaftar2" data-toggle="tab"><?php echo $pendaftar->PageCaption(2) ?></a></li>
		<li<?php echo $pendaftar_edit->MultiPages->TabStyle("3") ?>><a href="#tab_pendaftar3" data-toggle="tab"><?php echo $pendaftar->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $pendaftar_edit->MultiPages->PageStyle("1") ?>" id="tab_pendaftar1"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($pendaftar->nama_ruang->Visible) { // nama_ruang ?>
	<div id="r_nama_ruang" class="form-group">
		<label id="elh_pendaftar_nama_ruang" for="x_nama_ruang" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_ruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_ruang->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$pendaftar->UserIDAllow("edit")) { // Non system admin ?>
<span id="el_pendaftar_nama_ruang">
<select data-table="pendaftar" data-field="x_nama_ruang" data-page="1" data-value-separator="<?php echo $pendaftar->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x_nama_ruang" name="x_nama_ruang"<?php echo $pendaftar->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar->nama_ruang->SelectOptionListHtml("x_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el_pendaftar_nama_ruang">
<select data-table="pendaftar" data-field="x_nama_ruang" data-page="1" data-value-separator="<?php echo $pendaftar->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x_nama_ruang" name="x_nama_ruang"<?php echo $pendaftar->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar->nama_ruang->SelectOptionListHtml("x_nama_ruang") ?>
</select>
</span>
<?php } ?>
<?php echo $pendaftar->nama_ruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<div id="r_nomor_pendaftaran" class="form-group">
		<label id="elh_pendaftar_nomor_pendaftaran" for="x_nomor_pendaftaran" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nomor_pendaftaran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nomor_pendaftaran->CellAttributes() ?>>
<span id="el_pendaftar_nomor_pendaftaran">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_nomor_pendaftaran"><?php echo (strval($pendaftar->nomor_pendaftaran->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar->nomor_pendaftaran->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar->nomor_pendaftaran->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_nomor_pendaftaran',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar" data-field="x_nomor_pendaftaran" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar->nomor_pendaftaran->DisplayValueSeparatorAttribute() ?>" name="x_nomor_pendaftaran" id="x_nomor_pendaftaran" value="<?php echo $pendaftar->nomor_pendaftaran->CurrentValue ?>"<?php echo $pendaftar->nomor_pendaftaran->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nomor_pendaftaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<div id="r_nomor_peserta_ujian_sdmi" class="form-group">
		<label id="elh_pendaftar_nomor_peserta_ujian_sdmi" for="x_nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<span id="el_pendaftar_nomor_peserta_ujian_sdmi">
<?php $pendaftar->nomor_peserta_ujian_sdmi->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pendaftar->nomor_peserta_ujian_sdmi->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_nomor_peserta_ujian_sdmi"><?php echo (strval($pendaftar->nomor_peserta_ujian_sdmi->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar->nomor_peserta_ujian_sdmi->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar->nomor_peserta_ujian_sdmi->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_nomor_peserta_ujian_sdmi',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar" data-field="x_nomor_peserta_ujian_sdmi" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar->nomor_peserta_ujian_sdmi->DisplayValueSeparatorAttribute() ?>" name="x_nomor_peserta_ujian_sdmi" id="x_nomor_peserta_ujian_sdmi" value="<?php echo $pendaftar->nomor_peserta_ujian_sdmi->CurrentValue ?>"<?php echo $pendaftar->nomor_peserta_ujian_sdmi->EditAttributes() ?>>
<input type="hidden" name="ln_x_nomor_peserta_ujian_sdmi" id="ln_x_nomor_peserta_ujian_sdmi" value="x_sekolah_asal,x_nama_lengkap,x_nisn,x_nama_ayah">
</span>
<?php echo $pendaftar->nomor_peserta_ujian_sdmi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->sekolah_asal->Visible) { // sekolah_asal ?>
	<div id="r_sekolah_asal" class="form-group">
		<label id="elh_pendaftar_sekolah_asal" for="x_sekolah_asal" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->sekolah_asal->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->sekolah_asal->CellAttributes() ?>>
<span id="el_pendaftar_sekolah_asal">
<input type="text" data-table="pendaftar" data-field="x_sekolah_asal" data-page="1" name="x_sekolah_asal" id="x_sekolah_asal" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->sekolah_asal->getPlaceHolder()) ?>" value="<?php echo $pendaftar->sekolah_asal->EditValue ?>"<?php echo $pendaftar->sekolah_asal->EditAttributes() ?>>
</span>
<?php echo $pendaftar->sekolah_asal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nama_lengkap->Visible) { // nama_lengkap ?>
	<div id="r_nama_lengkap" class="form-group">
		<label id="elh_pendaftar_nama_lengkap" for="x_nama_lengkap" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_lengkap->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_lengkap->CellAttributes() ?>>
<span id="el_pendaftar_nama_lengkap">
<input type="text" data-table="pendaftar" data-field="x_nama_lengkap" data-page="1" name="x_nama_lengkap" id="x_nama_lengkap" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nama_lengkap->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nama_lengkap->EditValue ?>"<?php echo $pendaftar->nama_lengkap->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nama_lengkap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nik->Visible) { // nik ?>
	<div id="r_nik" class="form-group">
		<label id="elh_pendaftar_nik" for="x_nik" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nik->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nik->CellAttributes() ?>>
<span id="el_pendaftar_nik">
<input type="text" data-table="pendaftar" data-field="x_nik" data-page="1" name="x_nik" id="x_nik" size="30" maxlength="16" placeholder="<?php echo ew_HtmlEncode($pendaftar->nik->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nik->EditValue ?>"<?php echo $pendaftar->nik->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nisn->Visible) { // nisn ?>
	<div id="r_nisn" class="form-group">
		<label id="elh_pendaftar_nisn" for="x_nisn" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nisn->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nisn->CellAttributes() ?>>
<span id="el_pendaftar_nisn">
<input type="text" data-table="pendaftar" data-field="x_nisn" data-page="1" name="x_nisn" id="x_nisn" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nisn->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nisn->EditValue ?>"<?php echo $pendaftar->nisn->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nisn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->tempat_lahir->Visible) { // tempat_lahir ?>
	<div id="r_tempat_lahir" class="form-group">
		<label id="elh_pendaftar_tempat_lahir" for="x_tempat_lahir" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->tempat_lahir->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->tempat_lahir->CellAttributes() ?>>
<span id="el_pendaftar_tempat_lahir">
<input type="text" data-table="pendaftar" data-field="x_tempat_lahir" data-page="1" name="x_tempat_lahir" id="x_tempat_lahir" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->tempat_lahir->getPlaceHolder()) ?>" value="<?php echo $pendaftar->tempat_lahir->EditValue ?>"<?php echo $pendaftar->tempat_lahir->EditAttributes() ?>>
</span>
<?php echo $pendaftar->tempat_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<div id="r_tanggal_lahir" class="form-group">
		<label id="elh_pendaftar_tanggal_lahir" for="x_tanggal_lahir" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->tanggal_lahir->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->tanggal_lahir->CellAttributes() ?>>
<span id="el_pendaftar_tanggal_lahir">
<input type="text" data-table="pendaftar" data-field="x_tanggal_lahir" data-page="1" name="x_tanggal_lahir" id="x_tanggal_lahir" placeholder="<?php echo ew_HtmlEncode($pendaftar->tanggal_lahir->getPlaceHolder()) ?>" value="<?php echo $pendaftar->tanggal_lahir->EditValue ?>"<?php echo $pendaftar->tanggal_lahir->EditAttributes() ?>>
<?php if (!$pendaftar->tanggal_lahir->ReadOnly && !$pendaftar->tanggal_lahir->Disabled && !isset($pendaftar->tanggal_lahir->EditAttrs["readonly"]) && !isset($pendaftar->tanggal_lahir->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fpendaftaredit", "x_tanggal_lahir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $pendaftar->tanggal_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<div id="r_jenis_kelamin" class="form-group">
		<label id="elh_pendaftar_jenis_kelamin" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->jenis_kelamin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->jenis_kelamin->CellAttributes() ?>>
<span id="el_pendaftar_jenis_kelamin">
<div id="tp_x_jenis_kelamin" class="ewTemplate"><input type="radio" data-table="pendaftar" data-field="x_jenis_kelamin" data-page="1" data-value-separator="<?php echo $pendaftar->jenis_kelamin->DisplayValueSeparatorAttribute() ?>" name="x_jenis_kelamin" id="x_jenis_kelamin" value="{value}"<?php echo $pendaftar->jenis_kelamin->EditAttributes() ?>></div>
<div id="dsl_x_jenis_kelamin" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar->jenis_kelamin->RadioButtonListHtml(FALSE, "x_jenis_kelamin", 1) ?>
</div></div>
</span>
<?php echo $pendaftar->jenis_kelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->agama->Visible) { // agama ?>
	<div id="r_agama" class="form-group">
		<label id="elh_pendaftar_agama" for="x_agama" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->agama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->agama->CellAttributes() ?>>
<span id="el_pendaftar_agama">
<select data-table="pendaftar" data-field="x_agama" data-page="1" data-value-separator="<?php echo $pendaftar->agama->DisplayValueSeparatorAttribute() ?>" id="x_agama" name="x_agama"<?php echo $pendaftar->agama->EditAttributes() ?>>
<?php echo $pendaftar->agama->SelectOptionListHtml("x_agama") ?>
</select>
</span>
<?php echo $pendaftar->agama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_pendaftar_alamat" for="x_alamat" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->alamat->CellAttributes() ?>>
<span id="el_pendaftar_alamat">
<input type="text" data-table="pendaftar" data-field="x_alamat" data-page="1" name="x_alamat" id="x_alamat" placeholder="<?php echo ew_HtmlEncode($pendaftar->alamat->getPlaceHolder()) ?>" value="<?php echo $pendaftar->alamat->EditValue ?>"<?php echo $pendaftar->alamat->EditAttributes() ?>>
</span>
<?php echo $pendaftar->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->kecamatan->Visible) { // kecamatan ?>
	<div id="r_kecamatan" class="form-group">
		<label id="elh_pendaftar_kecamatan" for="x_kecamatan" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->kecamatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->kecamatan->CellAttributes() ?>>
<span id="el_pendaftar_kecamatan">
<?php $pendaftar->kecamatan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pendaftar->kecamatan->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_kecamatan"><?php echo (strval($pendaftar->kecamatan->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar->kecamatan->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar->kecamatan->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_kecamatan',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar" data-field="x_kecamatan" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar->kecamatan->DisplayValueSeparatorAttribute() ?>" name="x_kecamatan" id="x_kecamatan" value="<?php echo $pendaftar->kecamatan->CurrentValue ?>"<?php echo $pendaftar->kecamatan->EditAttributes() ?>>
<input type="hidden" name="ln_x_kecamatan" id="ln_x_kecamatan" value="x_zona">
</span>
<?php echo $pendaftar->kecamatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->zona->Visible) { // zona ?>
	<div id="r_zona" class="form-group">
		<label id="elh_pendaftar_zona" for="x_zona" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->zona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->zona->CellAttributes() ?>>
<span id="el_pendaftar_zona">
<input type="text" data-table="pendaftar" data-field="x_zona" data-page="1" name="x_zona" id="x_zona" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->zona->getPlaceHolder()) ?>" value="<?php echo $pendaftar->zona->EditValue ?>"<?php echo $pendaftar->zona->EditAttributes() ?>>
</span>
<?php echo $pendaftar->zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nama_ayah->Visible) { // nama_ayah ?>
	<div id="r_nama_ayah" class="form-group">
		<label id="elh_pendaftar_nama_ayah" for="x_nama_ayah" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_ayah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_ayah->CellAttributes() ?>>
<span id="el_pendaftar_nama_ayah">
<input type="text" data-table="pendaftar" data-field="x_nama_ayah" data-page="1" name="x_nama_ayah" id="x_nama_ayah" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nama_ayah->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nama_ayah->EditValue ?>"<?php echo $pendaftar->nama_ayah->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nama_ayah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nama_ibu->Visible) { // nama_ibu ?>
	<div id="r_nama_ibu" class="form-group">
		<label id="elh_pendaftar_nama_ibu" for="x_nama_ibu" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_ibu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_ibu->CellAttributes() ?>>
<span id="el_pendaftar_nama_ibu">
<input type="text" data-table="pendaftar" data-field="x_nama_ibu" data-page="1" name="x_nama_ibu" id="x_nama_ibu" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nama_ibu->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nama_ibu->EditValue ?>"<?php echo $pendaftar->nama_ibu->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nama_ibu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nama_wali->Visible) { // nama_wali ?>
	<div id="r_nama_wali" class="form-group">
		<label id="elh_pendaftar_nama_wali" for="x_nama_wali" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_wali->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_wali->CellAttributes() ?>>
<span id="el_pendaftar_nama_wali">
<input type="text" data-table="pendaftar" data-field="x_nama_wali" data-page="1" name="x_nama_wali" id="x_nama_wali" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nama_wali->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nama_wali->EditValue ?>"<?php echo $pendaftar->nama_wali->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nama_wali->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $pendaftar_edit->MultiPages->PageStyle("2") ?>" id="tab_pendaftar2"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($pendaftar->n_ind->Visible) { // n_ind ?>
	<div id="r_n_ind" class="form-group">
		<label id="elh_pendaftar_n_ind" for="x_n_ind" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->n_ind->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->n_ind->CellAttributes() ?>>
<span id="el_pendaftar_n_ind">
<span<?php echo $pendaftar->n_ind->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar->n_ind->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar" data-field="x_n_ind" data-page="2" name="x_n_ind" id="x_n_ind" value="<?php echo ew_HtmlEncode($pendaftar->n_ind->CurrentValue) ?>">
<?php echo $pendaftar->n_ind->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->n_mat->Visible) { // n_mat ?>
	<div id="r_n_mat" class="form-group">
		<label id="elh_pendaftar_n_mat" for="x_n_mat" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->n_mat->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->n_mat->CellAttributes() ?>>
<span id="el_pendaftar_n_mat">
<span<?php echo $pendaftar->n_mat->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar->n_mat->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar" data-field="x_n_mat" data-page="2" name="x_n_mat" id="x_n_mat" value="<?php echo ew_HtmlEncode($pendaftar->n_mat->CurrentValue) ?>">
<?php echo $pendaftar->n_mat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->n_ipa->Visible) { // n_ipa ?>
	<div id="r_n_ipa" class="form-group">
		<label id="elh_pendaftar_n_ipa" for="x_n_ipa" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->n_ipa->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->n_ipa->CellAttributes() ?>>
<span id="el_pendaftar_n_ipa">
<span<?php echo $pendaftar->n_ipa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar->n_ipa->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar" data-field="x_n_ipa" data-page="2" name="x_n_ipa" id="x_n_ipa" value="<?php echo ew_HtmlEncode($pendaftar->n_ipa->CurrentValue) ?>">
<?php echo $pendaftar->n_ipa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->jumlah_nilai_usum->Visible) { // jumlah_nilai_usum ?>
	<div id="r_jumlah_nilai_usum" class="form-group">
		<label id="elh_pendaftar_jumlah_nilai_usum" for="x_jumlah_nilai_usum" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->jumlah_nilai_usum->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->jumlah_nilai_usum->CellAttributes() ?>>
<span id="el_pendaftar_jumlah_nilai_usum">
<span<?php echo $pendaftar->jumlah_nilai_usum->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pendaftar->jumlah_nilai_usum->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pendaftar" data-field="x_jumlah_nilai_usum" data-page="2" name="x_jumlah_nilai_usum" id="x_jumlah_nilai_usum" value="<?php echo ew_HtmlEncode($pendaftar->jumlah_nilai_usum->CurrentValue) ?>">
<?php echo $pendaftar->jumlah_nilai_usum->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->bonus_prestasi->Visible) { // bonus_prestasi ?>
	<div id="r_bonus_prestasi" class="form-group">
		<label id="elh_pendaftar_bonus_prestasi" for="x_bonus_prestasi" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->bonus_prestasi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->bonus_prestasi->CellAttributes() ?>>
<span id="el_pendaftar_bonus_prestasi">
<?php $pendaftar->bonus_prestasi->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pendaftar->bonus_prestasi->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_bonus_prestasi"><?php echo (strval($pendaftar->bonus_prestasi->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar->bonus_prestasi->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar->bonus_prestasi->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_bonus_prestasi',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar" data-field="x_bonus_prestasi" data-page="2" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar->bonus_prestasi->DisplayValueSeparatorAttribute() ?>" name="x_bonus_prestasi" id="x_bonus_prestasi" value="<?php echo $pendaftar->bonus_prestasi->CurrentValue ?>"<?php echo $pendaftar->bonus_prestasi->EditAttributes() ?>>
<input type="hidden" name="ln_x_bonus_prestasi" id="ln_x_bonus_prestasi" value="x_jumlah_bonus_prestasi">
</span>
<?php echo $pendaftar->bonus_prestasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nama_prestasi->Visible) { // nama_prestasi ?>
	<div id="r_nama_prestasi" class="form-group">
		<label id="elh_pendaftar_nama_prestasi" for="x_nama_prestasi" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nama_prestasi->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nama_prestasi->CellAttributes() ?>>
<span id="el_pendaftar_nama_prestasi">
<input type="text" data-table="pendaftar" data-field="x_nama_prestasi" data-page="2" name="x_nama_prestasi" id="x_nama_prestasi" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pendaftar->nama_prestasi->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nama_prestasi->EditValue ?>"<?php echo $pendaftar->nama_prestasi->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nama_prestasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->kepemilikan_ijasah_mda->Visible) { // kepemilikan_ijasah_mda ?>
	<div id="r_kepemilikan_ijasah_mda" class="form-group">
		<label id="elh_pendaftar_kepemilikan_ijasah_mda" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->kepemilikan_ijasah_mda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->kepemilikan_ijasah_mda->CellAttributes() ?>>
<span id="el_pendaftar_kepemilikan_ijasah_mda">
<?php $pendaftar->kepemilikan_ijasah_mda->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$pendaftar->kepemilikan_ijasah_mda->EditAttrs["onclick"]; ?>
<div id="tp_x_kepemilikan_ijasah_mda" class="ewTemplate"><input type="radio" data-table="pendaftar" data-field="x_kepemilikan_ijasah_mda" data-page="2" data-value-separator="<?php echo $pendaftar->kepemilikan_ijasah_mda->DisplayValueSeparatorAttribute() ?>" name="x_kepemilikan_ijasah_mda" id="x_kepemilikan_ijasah_mda" value="{value}"<?php echo $pendaftar->kepemilikan_ijasah_mda->EditAttributes() ?>></div>
<div id="dsl_x_kepemilikan_ijasah_mda" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar->kepemilikan_ijasah_mda->RadioButtonListHtml(FALSE, "x_kepemilikan_ijasah_mda", 2) ?>
</div></div>
<input type="hidden" name="ln_x_kepemilikan_ijasah_mda" id="ln_x_kepemilikan_ijasah_mda" value="x_nilai_mda">
</span>
<?php echo $pendaftar->kepemilikan_ijasah_mda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->nilai_akhir->Visible) { // nilai_akhir ?>
	<div id="r_nilai_akhir" class="form-group">
		<label id="elh_pendaftar_nilai_akhir" for="x_nilai_akhir" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->nilai_akhir->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->nilai_akhir->CellAttributes() ?>>
<span id="el_pendaftar_nilai_akhir">
<input type="text" data-table="pendaftar" data-field="x_nilai_akhir" data-page="2" name="x_nilai_akhir" id="x_nilai_akhir" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar->nilai_akhir->getPlaceHolder()) ?>" value="<?php echo $pendaftar->nilai_akhir->EditValue ?>"<?php echo $pendaftar->nilai_akhir->EditAttributes() ?>>
</span>
<?php echo $pendaftar->nilai_akhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $pendaftar_edit->MultiPages->PageStyle("3") ?>" id="tab_pendaftar3"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($pendaftar->persyaratan->Visible) { // persyaratan ?>
	<div id="r_persyaratan" class="form-group">
		<label id="elh_pendaftar_persyaratan" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->persyaratan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->persyaratan->CellAttributes() ?>>
<span id="el_pendaftar_persyaratan">
<div id="tp_x_persyaratan" class="ewTemplate"><input type="radio" data-table="pendaftar" data-field="x_persyaratan" data-page="3" data-value-separator="<?php echo $pendaftar->persyaratan->DisplayValueSeparatorAttribute() ?>" name="x_persyaratan" id="x_persyaratan" value="{value}"<?php echo $pendaftar->persyaratan->EditAttributes() ?>></div>
<div id="dsl_x_persyaratan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar->persyaratan->RadioButtonListHtml(FALSE, "x_persyaratan", 3) ?>
</div></div>
</span>
<?php echo $pendaftar->persyaratan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar->catatan->Visible) { // catatan ?>
	<div id="r_catatan" class="form-group">
		<label id="elh_pendaftar_catatan" for="x_catatan" class="<?php echo $pendaftar_edit->LeftColumnClass ?>"><?php echo $pendaftar->catatan->FldCaption() ?></label>
		<div class="<?php echo $pendaftar_edit->RightColumnClass ?>"><div<?php echo $pendaftar->catatan->CellAttributes() ?>>
<span id="el_pendaftar_catatan">
<textarea data-table="pendaftar" data-field="x_catatan" data-page="3" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pendaftar->catatan->getPlaceHolder()) ?>"<?php echo $pendaftar->catatan->EditAttributes() ?>><?php echo $pendaftar->catatan->EditValue ?></textarea>
</span>
<?php echo $pendaftar->catatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<span id="el_pendaftar_jumlah_bonus_prestasi">
<input type="hidden" data-table="pendaftar" data-field="x_jumlah_bonus_prestasi" data-page="2" name="x_jumlah_bonus_prestasi" id="x_jumlah_bonus_prestasi" value="<?php echo ew_HtmlEncode($pendaftar->jumlah_bonus_prestasi->CurrentValue) ?>">
</span>
<span id="el_pendaftar_nilai_mda">
<input type="hidden" data-table="pendaftar" data-field="x_nilai_mda" data-page="2" name="x_nilai_mda" id="x_nilai_mda" value="<?php echo ew_HtmlEncode($pendaftar->nilai_mda->CurrentValue) ?>">
</span>
<input type="hidden" data-table="pendaftar" data-field="x_id_pendaftar" name="x_id_pendaftar" id="x_id_pendaftar" value="<?php echo ew_HtmlEncode($pendaftar->id_pendaftar->CurrentValue) ?>">
<?php if (!$pendaftar_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $pendaftar_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pendaftar_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fpendaftaredit.Init();
</script>
<?php
$pendaftar_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#x_n_ind, #x_n_mat, #x_n_ipa").change(function () {
	   var n_ind = parseFloat($('#x_n_ind').val());
	   var n_mat = parseFloat($('#x_n_mat').val());
	   var n_ipa = parseFloat($('#x_n_ipa').val());
	   var jumlah_nilai_usum = n_ind + n_mat + n_ipa;
	   $("#x_jumlah_nilai_usum").val(jumlah_nilai_usum);    
	}); 
});
$(document).ready(function() {
	$("#x_jumlah_nilai_usum, #x_jumlah_bonus_prestasi, #x_nilai_mda").change(function () {
	   var jumlah_nilai_usum = parseFloat($('#x_jumlah_nilai_usum').val());
	   var jumlah_bonus_prestasi = parseFloat($('#x_jumlah_bonus_prestasi').val());
	   var nilai_mda = parseInt($('#x_nilai_mda').val());
	   var nilai_akhir = jumlah_nilai_usum + jumlah_bonus_prestasi + nilai_mda;
	   $("#x_nilai_akhir").val(nilai_akhir);    
	}); 
});
</script>
<?php include_once "footer.php" ?>
<?php
$pendaftar_edit->Page_Terminate();
?>
