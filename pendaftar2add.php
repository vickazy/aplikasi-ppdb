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

$pendaftar2_add = NULL; // Initialize page object first

class cpendaftar2_add extends cpendaftar2 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'pendaftar2';

	// Page object name
	var $PageObjName = 'pendaftar2_add';

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

		// Table object (pendaftar2)
		if (!isset($GLOBALS["pendaftar2"]) || get_class($GLOBALS["pendaftar2"]) == "cpendaftar2") {
			$GLOBALS["pendaftar2"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendaftar2"];
		}

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Table object (no_pendaftaran)
		if (!isset($GLOBALS['no_pendaftaran'])) $GLOBALS['no_pendaftaran'] = new cno_pendaftaran();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("pendaftar2list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("pendaftar2list.php"));
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "pendaftar2view.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id_pendaftar"] != "") {
				$this->id_pendaftar->setQueryStringValue($_GET["id_pendaftar"]);
				$this->setKey("id_pendaftar", $this->id_pendaftar->CurrentValue); // Set up key
			} else {
				$this->setKey("id_pendaftar", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("pendaftar2list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "pendaftar2list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "pendaftar2view.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id_pendaftar->CurrentValue = NULL;
		$this->id_pendaftar->OldValue = $this->id_pendaftar->CurrentValue;
		$this->nama_ruang->CurrentValue = CurrentUserID();
		$this->nomor_pendaftaran->CurrentValue = NULL;
		$this->nomor_pendaftaran->OldValue = $this->nomor_pendaftaran->CurrentValue;
		$this->nomor_peserta_ujian_sdmi->CurrentValue = NULL;
		$this->nomor_peserta_ujian_sdmi->OldValue = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		$this->sekolah_asal->CurrentValue = NULL;
		$this->sekolah_asal->OldValue = $this->sekolah_asal->CurrentValue;
		$this->nama_lengkap->CurrentValue = NULL;
		$this->nama_lengkap->OldValue = $this->nama_lengkap->CurrentValue;
		$this->nik->CurrentValue = NULL;
		$this->nik->OldValue = $this->nik->CurrentValue;
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
		$this->alamat->CurrentValue = NULL;
		$this->alamat->OldValue = $this->alamat->CurrentValue;
		$this->kecamatan->CurrentValue = NULL;
		$this->kecamatan->OldValue = $this->kecamatan->CurrentValue;
		$this->zona->CurrentValue = NULL;
		$this->zona->OldValue = $this->zona->CurrentValue;
		$this->n_ind->CurrentValue = NULL;
		$this->n_ind->OldValue = $this->n_ind->CurrentValue;
		$this->n_mat->CurrentValue = NULL;
		$this->n_mat->OldValue = $this->n_mat->CurrentValue;
		$this->n_ipa->CurrentValue = NULL;
		$this->n_ipa->OldValue = $this->n_ipa->CurrentValue;
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
		$this->status->CurrentValue = NULL;
		$this->status->OldValue = $this->status->CurrentValue;
		$this->persyaratan->CurrentValue = 'Lengkap';
		$this->catatan->CurrentValue = NULL;
		$this->catatan->OldValue = $this->catatan->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
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
			$res = $this->ShowOptionLink('add');
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id_pendaftar'] = $this->id_pendaftar->CurrentValue;
		$row['nama_ruang'] = $this->nama_ruang->CurrentValue;
		$row['nomor_pendaftaran'] = $this->nomor_pendaftaran->CurrentValue;
		$row['nomor_peserta_ujian_sdmi'] = $this->nomor_peserta_ujian_sdmi->CurrentValue;
		$row['sekolah_asal'] = $this->sekolah_asal->CurrentValue;
		$row['nama_lengkap'] = $this->nama_lengkap->CurrentValue;
		$row['nik'] = $this->nik->CurrentValue;
		$row['nisn'] = $this->nisn->CurrentValue;
		$row['tempat_lahir'] = $this->tempat_lahir->CurrentValue;
		$row['tanggal_lahir'] = $this->tanggal_lahir->CurrentValue;
		$row['jenis_kelamin'] = $this->jenis_kelamin->CurrentValue;
		$row['agama'] = $this->agama->CurrentValue;
		$row['alamat'] = $this->alamat->CurrentValue;
		$row['kecamatan'] = $this->kecamatan->CurrentValue;
		$row['zona'] = $this->zona->CurrentValue;
		$row['n_ind'] = $this->n_ind->CurrentValue;
		$row['n_mat'] = $this->n_mat->CurrentValue;
		$row['n_ipa'] = $this->n_ipa->CurrentValue;
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
		$row['keterangan'] = $this->keterangan->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nama_ruang
			$this->nama_ruang->EditAttrs["class"] = "form-control";
			$this->nama_ruang->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("add")) { // Non system admin
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
			if (!$GLOBALS["pendaftar2"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
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
			if (!$GLOBALS["pendaftar2"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
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
			$this->nomor_peserta_ujian_sdmi->EditAttrs["class"] = "form-control";
			$this->nomor_peserta_ujian_sdmi->EditCustomAttributes = "";
			$this->nomor_peserta_ujian_sdmi->EditValue = ew_HtmlEncode($this->nomor_peserta_ujian_sdmi->CurrentValue);
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

			// jumlah_nilai_usum
			$this->jumlah_nilai_usum->EditAttrs["class"] = "form-control";
			$this->jumlah_nilai_usum->EditCustomAttributes = "";
			$this->jumlah_nilai_usum->EditValue = ew_HtmlEncode($this->jumlah_nilai_usum->CurrentValue);
			$this->jumlah_nilai_usum->PlaceHolder = ew_RemoveHtml($this->jumlah_nilai_usum->FldCaption());

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
			$this->jumlah_bonus_prestasi->EditValue = ew_HtmlEncode($this->jumlah_bonus_prestasi->CurrentValue);
			$this->jumlah_bonus_prestasi->PlaceHolder = ew_RemoveHtml($this->jumlah_bonus_prestasi->FldCaption());

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
			$this->nilai_mda->EditValue = ew_HtmlEncode($this->nilai_mda->CurrentValue);
			$this->nilai_mda->PlaceHolder = ew_RemoveHtml($this->nilai_mda->FldCaption());

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

			// Add refer script
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

			// n_mat
			$this->n_mat->LinkCustomAttributes = "";
			$this->n_mat->HrefValue = "";

			// n_ipa
			$this->n_ipa->LinkCustomAttributes = "";
			$this->n_ipa->HrefValue = "";

			// jumlah_nilai_usum
			$this->jumlah_nilai_usum->LinkCustomAttributes = "";
			$this->jumlah_nilai_usum->HrefValue = "";

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
		if (!$this->sekolah_asal->FldIsDetailKey && !is_null($this->sekolah_asal->FormValue) && $this->sekolah_asal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sekolah_asal->FldCaption(), $this->sekolah_asal->ReqErrMsg));
		}
		if (!$this->nama_lengkap->FldIsDetailKey && !is_null($this->nama_lengkap->FormValue) && $this->nama_lengkap->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_lengkap->FldCaption(), $this->nama_lengkap->ReqErrMsg));
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
		if (!$this->n_ind->FldIsDetailKey && !is_null($this->n_ind->FormValue) && $this->n_ind->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_ind->FldCaption(), $this->n_ind->ReqErrMsg));
		}
		if (!$this->n_mat->FldIsDetailKey && !is_null($this->n_mat->FormValue) && $this->n_mat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_mat->FldCaption(), $this->n_mat->ReqErrMsg));
		}
		if (!$this->n_ipa->FldIsDetailKey && !is_null($this->n_ipa->FormValue) && $this->n_ipa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->n_ipa->FldCaption(), $this->n_ipa->ReqErrMsg));
		}
		if (!$this->jumlah_nilai_usum->FldIsDetailKey && !is_null($this->jumlah_nilai_usum->FormValue) && $this->jumlah_nilai_usum->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jumlah_nilai_usum->FldCaption(), $this->jumlah_nilai_usum->ReqErrMsg));
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

		// nama_ruang
		$this->nama_ruang->SetDbValueDef($rsnew, $this->nama_ruang->CurrentValue, NULL, FALSE);

		// nomor_pendaftaran
		$this->nomor_pendaftaran->SetDbValueDef($rsnew, $this->nomor_pendaftaran->CurrentValue, "", FALSE);

		// nomor_peserta_ujian_sdmi
		$this->nomor_peserta_ujian_sdmi->SetDbValueDef($rsnew, $this->nomor_peserta_ujian_sdmi->CurrentValue, NULL, FALSE);

		// sekolah_asal
		$this->sekolah_asal->SetDbValueDef($rsnew, $this->sekolah_asal->CurrentValue, NULL, FALSE);

		// nama_lengkap
		$this->nama_lengkap->SetDbValueDef($rsnew, $this->nama_lengkap->CurrentValue, NULL, FALSE);

		// nik
		$this->nik->SetDbValueDef($rsnew, $this->nik->CurrentValue, NULL, FALSE);

		// nisn
		$this->nisn->SetDbValueDef($rsnew, $this->nisn->CurrentValue, NULL, FALSE);

		// tempat_lahir
		$this->tempat_lahir->SetDbValueDef($rsnew, $this->tempat_lahir->CurrentValue, NULL, FALSE);

		// tanggal_lahir
		$this->tanggal_lahir->SetDbValueDef($rsnew, $this->tanggal_lahir->CurrentValue, "", FALSE);

		// jenis_kelamin
		$this->jenis_kelamin->SetDbValueDef($rsnew, $this->jenis_kelamin->CurrentValue, NULL, FALSE);

		// agama
		$this->agama->SetDbValueDef($rsnew, $this->agama->CurrentValue, NULL, FALSE);

		// alamat
		$this->alamat->SetDbValueDef($rsnew, $this->alamat->CurrentValue, "", FALSE);

		// kecamatan
		$this->kecamatan->SetDbValueDef($rsnew, $this->kecamatan->CurrentValue, NULL, FALSE);

		// zona
		$this->zona->SetDbValueDef($rsnew, $this->zona->CurrentValue, "", FALSE);

		// n_ind
		$this->n_ind->SetDbValueDef($rsnew, $this->n_ind->CurrentValue, NULL, FALSE);

		// n_mat
		$this->n_mat->SetDbValueDef($rsnew, $this->n_mat->CurrentValue, NULL, FALSE);

		// n_ipa
		$this->n_ipa->SetDbValueDef($rsnew, $this->n_ipa->CurrentValue, NULL, FALSE);

		// jumlah_nilai_usum
		$this->jumlah_nilai_usum->SetDbValueDef($rsnew, $this->jumlah_nilai_usum->CurrentValue, NULL, FALSE);

		// bonus_prestasi
		$this->bonus_prestasi->SetDbValueDef($rsnew, $this->bonus_prestasi->CurrentValue, "", FALSE);

		// nama_prestasi
		$this->nama_prestasi->SetDbValueDef($rsnew, $this->nama_prestasi->CurrentValue, NULL, FALSE);

		// jumlah_bonus_prestasi
		$this->jumlah_bonus_prestasi->SetDbValueDef($rsnew, $this->jumlah_bonus_prestasi->CurrentValue, NULL, FALSE);

		// kepemilikan_ijasah_mda
		$this->kepemilikan_ijasah_mda->SetDbValueDef($rsnew, $this->kepemilikan_ijasah_mda->CurrentValue, NULL, FALSE);

		// nilai_mda
		$this->nilai_mda->SetDbValueDef($rsnew, $this->nilai_mda->CurrentValue, NULL, FALSE);

		// nilai_akhir
		$this->nilai_akhir->SetDbValueDef($rsnew, $this->nilai_akhir->CurrentValue, NULL, FALSE);

		// nama_ayah
		$this->nama_ayah->SetDbValueDef($rsnew, $this->nama_ayah->CurrentValue, NULL, FALSE);

		// nama_ibu
		$this->nama_ibu->SetDbValueDef($rsnew, $this->nama_ibu->CurrentValue, NULL, FALSE);

		// nama_wali
		$this->nama_wali->SetDbValueDef($rsnew, $this->nama_wali->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendaftar2list.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
			if (!$GLOBALS["pendaftar2"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["ruang"]->AddUserIDFilter($sWhereWrk);
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
			if (!$GLOBALS["pendaftar2"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["no_pendaftaran"]->AddUserIDFilter($sWhereWrk);
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
			$this->nomor_peserta_ujian_sdmi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nopes` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomor_peserta_ujian_sdmi, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
		case "x_nomor_peserta_ujian_sdmi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nopes`, `nopes` AS `DispFld` FROM `db_pd`";
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pendaftar2_add)) $pendaftar2_add = new cpendaftar2_add();

// Page init
$pendaftar2_add->Page_Init();

// Page main
$pendaftar2_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendaftar2_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpendaftar2add = new ew_Form("fpendaftar2add", "add");

// Validate form
fpendaftar2add.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nama_ruang->FldCaption(), $pendaftar2->nama_ruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomor_pendaftaran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nomor_pendaftaran->FldCaption(), $pendaftar2->nomor_pendaftaran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomor_peserta_ujian_sdmi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nomor_peserta_ujian_sdmi->FldCaption(), $pendaftar2->nomor_peserta_ujian_sdmi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sekolah_asal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->sekolah_asal->FldCaption(), $pendaftar2->sekolah_asal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_lengkap");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nama_lengkap->FldCaption(), $pendaftar2->nama_lengkap->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_lahir");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->tempat_lahir->FldCaption(), $pendaftar2->tempat_lahir->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_lahir");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->tanggal_lahir->FldCaption(), $pendaftar2->tanggal_lahir->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_lahir");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pendaftar2->tanggal_lahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jenis_kelamin");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->jenis_kelamin->FldCaption(), $pendaftar2->jenis_kelamin->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_agama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->agama->FldCaption(), $pendaftar2->agama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_alamat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->alamat->FldCaption(), $pendaftar2->alamat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kecamatan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->kecamatan->FldCaption(), $pendaftar2->kecamatan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_zona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->zona->FldCaption(), $pendaftar2->zona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_ind");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->n_ind->FldCaption(), $pendaftar2->n_ind->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_mat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->n_mat->FldCaption(), $pendaftar2->n_mat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_n_ipa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->n_ipa->FldCaption(), $pendaftar2->n_ipa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_nilai_usum");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->jumlah_nilai_usum->FldCaption(), $pendaftar2->jumlah_nilai_usum->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bonus_prestasi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->bonus_prestasi->FldCaption(), $pendaftar2->bonus_prestasi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kepemilikan_ijasah_mda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->kepemilikan_ijasah_mda->FldCaption(), $pendaftar2->kepemilikan_ijasah_mda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ayah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nama_ayah->FldCaption(), $pendaftar2->nama_ayah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ibu");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->nama_ibu->FldCaption(), $pendaftar2->nama_ibu->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_persyaratan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pendaftar2->persyaratan->FldCaption(), $pendaftar2->persyaratan->ReqErrMsg)) ?>");

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
fpendaftar2add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendaftar2add.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fpendaftar2add.MultiPage = new ew_MultiPage("fpendaftar2add");

// Dynamic selection lists
fpendaftar2add.Lists["x_nama_ruang"] = {"LinkField":"x_nama_ruang","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_ruang","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ruang"};
fpendaftar2add.Lists["x_nama_ruang"].Data = "<?php echo $pendaftar2_add->nama_ruang->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.Lists["x_nomor_pendaftaran"] = {"LinkField":"x_nomor_pendaftaran","Ajax":true,"AutoFill":false,"DisplayFields":["x_nomor_pendaftaran","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"no_pendaftaran"};
fpendaftar2add.Lists["x_nomor_pendaftaran"].Data = "<?php echo $pendaftar2_add->nomor_pendaftaran->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.Lists["x_nomor_peserta_ujian_sdmi"] = {"LinkField":"x_nopes","Ajax":true,"AutoFill":false,"DisplayFields":["x_nopes","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"db_pd"};
fpendaftar2add.Lists["x_nomor_peserta_ujian_sdmi"].Data = "<?php echo $pendaftar2_add->nomor_peserta_ujian_sdmi->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.AutoSuggests["x_nomor_peserta_ujian_sdmi"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $pendaftar2_add->nomor_peserta_ujian_sdmi->LookupFilterQuery(TRUE, "add"))) ?>;
fpendaftar2add.Lists["x_jenis_kelamin"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar2add.Lists["x_jenis_kelamin"].Options = <?php echo json_encode($pendaftar2_add->jenis_kelamin->Options()) ?>;
fpendaftar2add.Lists["x_agama"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar2add.Lists["x_agama"].Options = <?php echo json_encode($pendaftar2_add->agama->Options()) ?>;
fpendaftar2add.Lists["x_kecamatan"] = {"LinkField":"x_id_kec","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_kec","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"kecamatan"};
fpendaftar2add.Lists["x_kecamatan"].Data = "<?php echo $pendaftar2_add->kecamatan->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.Lists["x_bonus_prestasi"] = {"LinkField":"x_id_bonus","Ajax":true,"AutoFill":true,"DisplayFields":["x_bonus","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"bonus"};
fpendaftar2add.Lists["x_bonus_prestasi"].Data = "<?php echo $pendaftar2_add->bonus_prestasi->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.Lists["x_kepemilikan_ijasah_mda"] = {"LinkField":"x_id_mda","Ajax":true,"AutoFill":true,"DisplayFields":["x_mda","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"mda"};
fpendaftar2add.Lists["x_kepemilikan_ijasah_mda"].Data = "<?php echo $pendaftar2_add->kepemilikan_ijasah_mda->LookupFilterQuery(FALSE, "add") ?>";
fpendaftar2add.Lists["x_persyaratan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar2add.Lists["x_persyaratan"].Options = <?php echo json_encode($pendaftar2_add->persyaratan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pendaftar2_add->ShowPageHeader(); ?>
<?php
$pendaftar2_add->ShowMessage();
?>
<form name="fpendaftar2add" id="fpendaftar2add" class="<?php echo $pendaftar2_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendaftar2_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendaftar2_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendaftar2">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($pendaftar2_add->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="pendaftar2_add"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $pendaftar2_add->MultiPages->NavStyle() ?>">
		<li<?php echo $pendaftar2_add->MultiPages->TabStyle("1") ?>><a href="#tab_pendaftar21" data-toggle="tab"><?php echo $pendaftar2->PageCaption(1) ?></a></li>
		<li<?php echo $pendaftar2_add->MultiPages->TabStyle("2") ?>><a href="#tab_pendaftar22" data-toggle="tab"><?php echo $pendaftar2->PageCaption(2) ?></a></li>
		<li<?php echo $pendaftar2_add->MultiPages->TabStyle("3") ?>><a href="#tab_pendaftar23" data-toggle="tab"><?php echo $pendaftar2->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $pendaftar2_add->MultiPages->PageStyle("1") ?>" id="tab_pendaftar21"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($pendaftar2->nama_ruang->Visible) { // nama_ruang ?>
	<div id="r_nama_ruang" class="form-group">
		<label id="elh_pendaftar2_nama_ruang" for="x_nama_ruang" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_ruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_ruang->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$pendaftar2->UserIDAllow("add")) { // Non system admin ?>
<span id="el_pendaftar2_nama_ruang">
<select data-table="pendaftar2" data-field="x_nama_ruang" data-page="1" data-value-separator="<?php echo $pendaftar2->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x_nama_ruang" name="x_nama_ruang"<?php echo $pendaftar2->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar2->nama_ruang->SelectOptionListHtml("x_nama_ruang") ?>
</select>
</span>
<?php } else { ?>
<span id="el_pendaftar2_nama_ruang">
<select data-table="pendaftar2" data-field="x_nama_ruang" data-page="1" data-value-separator="<?php echo $pendaftar2->nama_ruang->DisplayValueSeparatorAttribute() ?>" id="x_nama_ruang" name="x_nama_ruang"<?php echo $pendaftar2->nama_ruang->EditAttributes() ?>>
<?php echo $pendaftar2->nama_ruang->SelectOptionListHtml("x_nama_ruang") ?>
</select>
</span>
<?php } ?>
<?php echo $pendaftar2->nama_ruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nomor_pendaftaran->Visible) { // nomor_pendaftaran ?>
	<div id="r_nomor_pendaftaran" class="form-group">
		<label id="elh_pendaftar2_nomor_pendaftaran" for="x_nomor_pendaftaran" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nomor_pendaftaran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nomor_pendaftaran->CellAttributes() ?>>
<span id="el_pendaftar2_nomor_pendaftaran">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_nomor_pendaftaran"><?php echo (strval($pendaftar2->nomor_pendaftaran->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar2->nomor_pendaftaran->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar2->nomor_pendaftaran->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_nomor_pendaftaran',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar2" data-field="x_nomor_pendaftaran" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar2->nomor_pendaftaran->DisplayValueSeparatorAttribute() ?>" name="x_nomor_pendaftaran" id="x_nomor_pendaftaran" value="<?php echo $pendaftar2->nomor_pendaftaran->CurrentValue ?>"<?php echo $pendaftar2->nomor_pendaftaran->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nomor_pendaftaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nomor_peserta_ujian_sdmi->Visible) { // nomor_peserta_ujian_sdmi ?>
	<div id="r_nomor_peserta_ujian_sdmi" class="form-group">
		<label id="elh_pendaftar2_nomor_peserta_ujian_sdmi" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nomor_peserta_ujian_sdmi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->CellAttributes() ?>>
<span id="el_pendaftar2_nomor_peserta_ujian_sdmi">
<?php
$wrkonchange = trim(" " . @$pendaftar2->nomor_peserta_ujian_sdmi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$pendaftar2->nomor_peserta_ujian_sdmi->EditAttrs["onchange"] = "";
?>
<span id="as_x_nomor_peserta_ujian_sdmi" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_nomor_peserta_ujian_sdmi" id="sv_x_nomor_peserta_ujian_sdmi" value="<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($pendaftar2->nomor_peserta_ujian_sdmi->getPlaceHolder()) ?>"<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="pendaftar2" data-field="x_nomor_peserta_ujian_sdmi" data-page="1" data-value-separator="<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->DisplayValueSeparatorAttribute() ?>" name="x_nomor_peserta_ujian_sdmi" id="x_nomor_peserta_ujian_sdmi" value="<?php echo ew_HtmlEncode($pendaftar2->nomor_peserta_ujian_sdmi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fpendaftar2add.CreateAutoSuggest({"id":"x_nomor_peserta_ujian_sdmi","forceSelect":false});
</script>
</span>
<?php echo $pendaftar2->nomor_peserta_ujian_sdmi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->sekolah_asal->Visible) { // sekolah_asal ?>
	<div id="r_sekolah_asal" class="form-group">
		<label id="elh_pendaftar2_sekolah_asal" for="x_sekolah_asal" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->sekolah_asal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->sekolah_asal->CellAttributes() ?>>
<span id="el_pendaftar2_sekolah_asal">
<input type="text" data-table="pendaftar2" data-field="x_sekolah_asal" data-page="1" name="x_sekolah_asal" id="x_sekolah_asal" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->sekolah_asal->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->sekolah_asal->EditValue ?>"<?php echo $pendaftar2->sekolah_asal->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->sekolah_asal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nama_lengkap->Visible) { // nama_lengkap ?>
	<div id="r_nama_lengkap" class="form-group">
		<label id="elh_pendaftar2_nama_lengkap" for="x_nama_lengkap" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_lengkap->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_lengkap->CellAttributes() ?>>
<span id="el_pendaftar2_nama_lengkap">
<input type="text" data-table="pendaftar2" data-field="x_nama_lengkap" data-page="1" name="x_nama_lengkap" id="x_nama_lengkap" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nama_lengkap->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nama_lengkap->EditValue ?>"<?php echo $pendaftar2->nama_lengkap->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nama_lengkap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nik->Visible) { // nik ?>
	<div id="r_nik" class="form-group">
		<label id="elh_pendaftar2_nik" for="x_nik" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nik->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nik->CellAttributes() ?>>
<span id="el_pendaftar2_nik">
<input type="text" data-table="pendaftar2" data-field="x_nik" data-page="1" name="x_nik" id="x_nik" size="30" maxlength="16" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nik->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nik->EditValue ?>"<?php echo $pendaftar2->nik->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nisn->Visible) { // nisn ?>
	<div id="r_nisn" class="form-group">
		<label id="elh_pendaftar2_nisn" for="x_nisn" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nisn->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nisn->CellAttributes() ?>>
<span id="el_pendaftar2_nisn">
<input type="text" data-table="pendaftar2" data-field="x_nisn" data-page="1" name="x_nisn" id="x_nisn" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nisn->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nisn->EditValue ?>"<?php echo $pendaftar2->nisn->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nisn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->tempat_lahir->Visible) { // tempat_lahir ?>
	<div id="r_tempat_lahir" class="form-group">
		<label id="elh_pendaftar2_tempat_lahir" for="x_tempat_lahir" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->tempat_lahir->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->tempat_lahir->CellAttributes() ?>>
<span id="el_pendaftar2_tempat_lahir">
<input type="text" data-table="pendaftar2" data-field="x_tempat_lahir" data-page="1" name="x_tempat_lahir" id="x_tempat_lahir" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->tempat_lahir->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->tempat_lahir->EditValue ?>"<?php echo $pendaftar2->tempat_lahir->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->tempat_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->tanggal_lahir->Visible) { // tanggal_lahir ?>
	<div id="r_tanggal_lahir" class="form-group">
		<label id="elh_pendaftar2_tanggal_lahir" for="x_tanggal_lahir" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->tanggal_lahir->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->tanggal_lahir->CellAttributes() ?>>
<span id="el_pendaftar2_tanggal_lahir">
<input type="text" data-table="pendaftar2" data-field="x_tanggal_lahir" data-page="1" name="x_tanggal_lahir" id="x_tanggal_lahir" placeholder="<?php echo ew_HtmlEncode($pendaftar2->tanggal_lahir->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->tanggal_lahir->EditValue ?>"<?php echo $pendaftar2->tanggal_lahir->EditAttributes() ?>>
<?php if (!$pendaftar2->tanggal_lahir->ReadOnly && !$pendaftar2->tanggal_lahir->Disabled && !isset($pendaftar2->tanggal_lahir->EditAttrs["readonly"]) && !isset($pendaftar2->tanggal_lahir->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fpendaftar2add", "x_tanggal_lahir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $pendaftar2->tanggal_lahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->jenis_kelamin->Visible) { // jenis_kelamin ?>
	<div id="r_jenis_kelamin" class="form-group">
		<label id="elh_pendaftar2_jenis_kelamin" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->jenis_kelamin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->jenis_kelamin->CellAttributes() ?>>
<span id="el_pendaftar2_jenis_kelamin">
<div id="tp_x_jenis_kelamin" class="ewTemplate"><input type="radio" data-table="pendaftar2" data-field="x_jenis_kelamin" data-page="1" data-value-separator="<?php echo $pendaftar2->jenis_kelamin->DisplayValueSeparatorAttribute() ?>" name="x_jenis_kelamin" id="x_jenis_kelamin" value="{value}"<?php echo $pendaftar2->jenis_kelamin->EditAttributes() ?>></div>
<div id="dsl_x_jenis_kelamin" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar2->jenis_kelamin->RadioButtonListHtml(FALSE, "x_jenis_kelamin", 1) ?>
</div></div>
</span>
<?php echo $pendaftar2->jenis_kelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->agama->Visible) { // agama ?>
	<div id="r_agama" class="form-group">
		<label id="elh_pendaftar2_agama" for="x_agama" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->agama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->agama->CellAttributes() ?>>
<span id="el_pendaftar2_agama">
<select data-table="pendaftar2" data-field="x_agama" data-page="1" data-value-separator="<?php echo $pendaftar2->agama->DisplayValueSeparatorAttribute() ?>" id="x_agama" name="x_agama"<?php echo $pendaftar2->agama->EditAttributes() ?>>
<?php echo $pendaftar2->agama->SelectOptionListHtml("x_agama") ?>
</select>
</span>
<?php echo $pendaftar2->agama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->alamat->Visible) { // alamat ?>
	<div id="r_alamat" class="form-group">
		<label id="elh_pendaftar2_alamat" for="x_alamat" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->alamat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->alamat->CellAttributes() ?>>
<span id="el_pendaftar2_alamat">
<input type="text" data-table="pendaftar2" data-field="x_alamat" data-page="1" name="x_alamat" id="x_alamat" placeholder="<?php echo ew_HtmlEncode($pendaftar2->alamat->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->alamat->EditValue ?>"<?php echo $pendaftar2->alamat->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->kecamatan->Visible) { // kecamatan ?>
	<div id="r_kecamatan" class="form-group">
		<label id="elh_pendaftar2_kecamatan" for="x_kecamatan" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->kecamatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->kecamatan->CellAttributes() ?>>
<span id="el_pendaftar2_kecamatan">
<?php $pendaftar2->kecamatan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pendaftar2->kecamatan->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_kecamatan"><?php echo (strval($pendaftar2->kecamatan->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar2->kecamatan->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar2->kecamatan->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_kecamatan',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar2" data-field="x_kecamatan" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar2->kecamatan->DisplayValueSeparatorAttribute() ?>" name="x_kecamatan" id="x_kecamatan" value="<?php echo $pendaftar2->kecamatan->CurrentValue ?>"<?php echo $pendaftar2->kecamatan->EditAttributes() ?>>
<input type="hidden" name="ln_x_kecamatan" id="ln_x_kecamatan" value="x_zona">
</span>
<?php echo $pendaftar2->kecamatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->zona->Visible) { // zona ?>
	<div id="r_zona" class="form-group">
		<label id="elh_pendaftar2_zona" for="x_zona" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->zona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->zona->CellAttributes() ?>>
<span id="el_pendaftar2_zona">
<input type="text" data-table="pendaftar2" data-field="x_zona" data-page="1" name="x_zona" id="x_zona" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->zona->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->zona->EditValue ?>"<?php echo $pendaftar2->zona->EditAttributes() ?>readonly>
</span>
<?php echo $pendaftar2->zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nama_ayah->Visible) { // nama_ayah ?>
	<div id="r_nama_ayah" class="form-group">
		<label id="elh_pendaftar2_nama_ayah" for="x_nama_ayah" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_ayah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_ayah->CellAttributes() ?>>
<span id="el_pendaftar2_nama_ayah">
<input type="text" data-table="pendaftar2" data-field="x_nama_ayah" data-page="1" name="x_nama_ayah" id="x_nama_ayah" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nama_ayah->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nama_ayah->EditValue ?>"<?php echo $pendaftar2->nama_ayah->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nama_ayah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nama_ibu->Visible) { // nama_ibu ?>
	<div id="r_nama_ibu" class="form-group">
		<label id="elh_pendaftar2_nama_ibu" for="x_nama_ibu" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_ibu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_ibu->CellAttributes() ?>>
<span id="el_pendaftar2_nama_ibu">
<input type="text" data-table="pendaftar2" data-field="x_nama_ibu" data-page="1" name="x_nama_ibu" id="x_nama_ibu" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nama_ibu->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nama_ibu->EditValue ?>"<?php echo $pendaftar2->nama_ibu->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nama_ibu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nama_wali->Visible) { // nama_wali ?>
	<div id="r_nama_wali" class="form-group">
		<label id="elh_pendaftar2_nama_wali" for="x_nama_wali" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_wali->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_wali->CellAttributes() ?>>
<span id="el_pendaftar2_nama_wali">
<input type="text" data-table="pendaftar2" data-field="x_nama_wali" data-page="1" name="x_nama_wali" id="x_nama_wali" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nama_wali->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nama_wali->EditValue ?>"<?php echo $pendaftar2->nama_wali->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nama_wali->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $pendaftar2_add->MultiPages->PageStyle("2") ?>" id="tab_pendaftar22"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($pendaftar2->n_ind->Visible) { // n_ind ?>
	<div id="r_n_ind" class="form-group">
		<label id="elh_pendaftar2_n_ind" for="x_n_ind" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->n_ind->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->n_ind->CellAttributes() ?>>
<span id="el_pendaftar2_n_ind">
<input type="text" data-table="pendaftar2" data-field="x_n_ind" data-page="2" name="x_n_ind" id="x_n_ind" size="30" placeholder="<?php echo ew_HtmlEncode($pendaftar2->n_ind->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->n_ind->EditValue ?>"<?php echo $pendaftar2->n_ind->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->n_ind->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->n_mat->Visible) { // n_mat ?>
	<div id="r_n_mat" class="form-group">
		<label id="elh_pendaftar2_n_mat" for="x_n_mat" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->n_mat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->n_mat->CellAttributes() ?>>
<span id="el_pendaftar2_n_mat">
<input type="text" data-table="pendaftar2" data-field="x_n_mat" data-page="2" name="x_n_mat" id="x_n_mat" size="30" placeholder="<?php echo ew_HtmlEncode($pendaftar2->n_mat->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->n_mat->EditValue ?>"<?php echo $pendaftar2->n_mat->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->n_mat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->n_ipa->Visible) { // n_ipa ?>
	<div id="r_n_ipa" class="form-group">
		<label id="elh_pendaftar2_n_ipa" for="x_n_ipa" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->n_ipa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->n_ipa->CellAttributes() ?>>
<span id="el_pendaftar2_n_ipa">
<input type="text" data-table="pendaftar2" data-field="x_n_ipa" data-page="2" name="x_n_ipa" id="x_n_ipa" size="30" placeholder="<?php echo ew_HtmlEncode($pendaftar2->n_ipa->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->n_ipa->EditValue ?>"<?php echo $pendaftar2->n_ipa->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->n_ipa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->jumlah_nilai_usum->Visible) { // jumlah_nilai_usum ?>
	<div id="r_jumlah_nilai_usum" class="form-group">
		<label id="elh_pendaftar2_jumlah_nilai_usum" for="x_jumlah_nilai_usum" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->jumlah_nilai_usum->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->jumlah_nilai_usum->CellAttributes() ?>>
<span id="el_pendaftar2_jumlah_nilai_usum">
<input type="text" data-table="pendaftar2" data-field="x_jumlah_nilai_usum" data-page="2" name="x_jumlah_nilai_usum" id="x_jumlah_nilai_usum" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->jumlah_nilai_usum->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->jumlah_nilai_usum->EditValue ?>"<?php echo $pendaftar2->jumlah_nilai_usum->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->jumlah_nilai_usum->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->bonus_prestasi->Visible) { // bonus_prestasi ?>
	<div id="r_bonus_prestasi" class="form-group">
		<label id="elh_pendaftar2_bonus_prestasi" for="x_bonus_prestasi" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->bonus_prestasi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->bonus_prestasi->CellAttributes() ?>>
<span id="el_pendaftar2_bonus_prestasi">
<?php $pendaftar2->bonus_prestasi->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$pendaftar2->bonus_prestasi->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_bonus_prestasi"><?php echo (strval($pendaftar2->bonus_prestasi->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $pendaftar2->bonus_prestasi->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($pendaftar2->bonus_prestasi->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_bonus_prestasi',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="pendaftar2" data-field="x_bonus_prestasi" data-page="2" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $pendaftar2->bonus_prestasi->DisplayValueSeparatorAttribute() ?>" name="x_bonus_prestasi" id="x_bonus_prestasi" value="<?php echo $pendaftar2->bonus_prestasi->CurrentValue ?>"<?php echo $pendaftar2->bonus_prestasi->EditAttributes() ?>>
<input type="hidden" name="ln_x_bonus_prestasi" id="ln_x_bonus_prestasi" value="x_jumlah_bonus_prestasi">
</span>
<?php echo $pendaftar2->bonus_prestasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nama_prestasi->Visible) { // nama_prestasi ?>
	<div id="r_nama_prestasi" class="form-group">
		<label id="elh_pendaftar2_nama_prestasi" for="x_nama_prestasi" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nama_prestasi->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nama_prestasi->CellAttributes() ?>>
<span id="el_pendaftar2_nama_prestasi">
<input type="text" data-table="pendaftar2" data-field="x_nama_prestasi" data-page="2" name="x_nama_prestasi" id="x_nama_prestasi" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nama_prestasi->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nama_prestasi->EditValue ?>"<?php echo $pendaftar2->nama_prestasi->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nama_prestasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->jumlah_bonus_prestasi->Visible) { // jumlah_bonus_prestasi ?>
	<div id="r_jumlah_bonus_prestasi" class="form-group">
		<label id="elh_pendaftar2_jumlah_bonus_prestasi" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->jumlah_bonus_prestasi->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->jumlah_bonus_prestasi->CellAttributes() ?>>
<span id="el_pendaftar2_jumlah_bonus_prestasi">
<input type="text" data-table="pendaftar2" data-field="x_jumlah_bonus_prestasi" data-page="2" name="x_jumlah_bonus_prestasi" id="x_jumlah_bonus_prestasi" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->jumlah_bonus_prestasi->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->jumlah_bonus_prestasi->EditValue ?>"<?php echo $pendaftar2->jumlah_bonus_prestasi->EditAttributes() ?>readonly>
</span>
<?php echo $pendaftar2->jumlah_bonus_prestasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->kepemilikan_ijasah_mda->Visible) { // kepemilikan_ijasah_mda ?>
	<div id="r_kepemilikan_ijasah_mda" class="form-group">
		<label id="elh_pendaftar2_kepemilikan_ijasah_mda" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->kepemilikan_ijasah_mda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->kepemilikan_ijasah_mda->CellAttributes() ?>>
<span id="el_pendaftar2_kepemilikan_ijasah_mda">
<?php $pendaftar2->kepemilikan_ijasah_mda->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$pendaftar2->kepemilikan_ijasah_mda->EditAttrs["onclick"]; ?>
<div id="tp_x_kepemilikan_ijasah_mda" class="ewTemplate"><input type="radio" data-table="pendaftar2" data-field="x_kepemilikan_ijasah_mda" data-page="2" data-value-separator="<?php echo $pendaftar2->kepemilikan_ijasah_mda->DisplayValueSeparatorAttribute() ?>" name="x_kepemilikan_ijasah_mda" id="x_kepemilikan_ijasah_mda" value="{value}"<?php echo $pendaftar2->kepemilikan_ijasah_mda->EditAttributes() ?>></div>
<div id="dsl_x_kepemilikan_ijasah_mda" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar2->kepemilikan_ijasah_mda->RadioButtonListHtml(FALSE, "x_kepemilikan_ijasah_mda", 2) ?>
</div></div>
<input type="hidden" name="ln_x_kepemilikan_ijasah_mda" id="ln_x_kepemilikan_ijasah_mda" value="x_nilai_mda">
</span>
<?php echo $pendaftar2->kepemilikan_ijasah_mda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nilai_mda->Visible) { // nilai_mda ?>
	<div id="r_nilai_mda" class="form-group">
		<label id="elh_pendaftar2_nilai_mda" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nilai_mda->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nilai_mda->CellAttributes() ?>>
<span id="el_pendaftar2_nilai_mda">
<input type="text" data-table="pendaftar2" data-field="x_nilai_mda" data-page="2" name="x_nilai_mda" id="x_nilai_mda" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nilai_mda->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nilai_mda->EditValue ?>"<?php echo $pendaftar2->nilai_mda->EditAttributes() ?>readonly>
</span>
<?php echo $pendaftar2->nilai_mda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->nilai_akhir->Visible) { // nilai_akhir ?>
	<div id="r_nilai_akhir" class="form-group">
		<label id="elh_pendaftar2_nilai_akhir" for="x_nilai_akhir" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->nilai_akhir->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->nilai_akhir->CellAttributes() ?>>
<span id="el_pendaftar2_nilai_akhir">
<input type="text" data-table="pendaftar2" data-field="x_nilai_akhir" data-page="2" name="x_nilai_akhir" id="x_nilai_akhir" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($pendaftar2->nilai_akhir->getPlaceHolder()) ?>" value="<?php echo $pendaftar2->nilai_akhir->EditValue ?>"<?php echo $pendaftar2->nilai_akhir->EditAttributes() ?>>
</span>
<?php echo $pendaftar2->nilai_akhir->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $pendaftar2_add->MultiPages->PageStyle("3") ?>" id="tab_pendaftar23"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($pendaftar2->persyaratan->Visible) { // persyaratan ?>
	<div id="r_persyaratan" class="form-group">
		<label id="elh_pendaftar2_persyaratan" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->persyaratan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->persyaratan->CellAttributes() ?>>
<span id="el_pendaftar2_persyaratan">
<div id="tp_x_persyaratan" class="ewTemplate"><input type="radio" data-table="pendaftar2" data-field="x_persyaratan" data-page="3" data-value-separator="<?php echo $pendaftar2->persyaratan->DisplayValueSeparatorAttribute() ?>" name="x_persyaratan" id="x_persyaratan" value="{value}"<?php echo $pendaftar2->persyaratan->EditAttributes() ?>></div>
<div id="dsl_x_persyaratan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar2->persyaratan->RadioButtonListHtml(FALSE, "x_persyaratan", 3) ?>
</div></div>
</span>
<?php echo $pendaftar2->persyaratan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pendaftar2->catatan->Visible) { // catatan ?>
	<div id="r_catatan" class="form-group">
		<label id="elh_pendaftar2_catatan" for="x_catatan" class="<?php echo $pendaftar2_add->LeftColumnClass ?>"><?php echo $pendaftar2->catatan->FldCaption() ?></label>
		<div class="<?php echo $pendaftar2_add->RightColumnClass ?>"><div<?php echo $pendaftar2->catatan->CellAttributes() ?>>
<span id="el_pendaftar2_catatan">
<textarea data-table="pendaftar2" data-field="x_catatan" data-page="3" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pendaftar2->catatan->getPlaceHolder()) ?>"<?php echo $pendaftar2->catatan->EditAttributes() ?>><?php echo $pendaftar2->catatan->EditValue ?></textarea>
</span>
<?php echo $pendaftar2->catatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$pendaftar2_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $pendaftar2_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pendaftar2_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fpendaftar2add.Init();
</script>
<?php
$pendaftar2_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#x_jumlah_nilai_usum, #x_jumlah_bonus_prestasi, #x_nilai_mda").change(function () {
	   var jumlah_nilai_usum = parseFloat($('#x_jumlah_nilai_usum').val());
	   var jumlah_bonus_prestasi = parseFloat($('#x_jumlah_bonus_prestasi').val());
	   var nilai_mda = parseFloat($('#x_nilai_mda').val());
	   var nilai_akhir = jumlah_nilai_usum + jumlah_bonus_prestasi + nilai_mda;
	   $("#x_nilai_akhir").val(nilai_akhir);    
	}); 
});
</script>
<?php include_once "footer.php" ?>
<?php
$pendaftar2_add->Page_Terminate();
?>
