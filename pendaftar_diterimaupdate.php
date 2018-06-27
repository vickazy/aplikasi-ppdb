<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "pendaftar_diterimainfo.php" ?>
<?php include_once "ruanginfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$pendaftar_diterima_update = NULL; // Initialize page object first

class cpendaftar_diterima_update extends cpendaftar_diterima {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = '{27E315CC-B02A-4AE4-92E7-B346521044C4}';

	// Table name
	var $TableName = 'pendaftar_diterima';

	// Page object name
	var $PageObjName = 'pendaftar_diterima_update';

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

		// Table object (pendaftar_diterima)
		if (!isset($GLOBALS["pendaftar_diterima"]) || get_class($GLOBALS["pendaftar_diterima"]) == "cpendaftar_diterima") {
			$GLOBALS["pendaftar_diterima"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pendaftar_diterima"];
		}

		// Table object (ruang)
		if (!isset($GLOBALS['ruang'])) $GLOBALS['ruang'] = new cruang();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendaftar_diterima', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pendaftar_diterimalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("pendaftar_diterimalist.php"));
			}
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->keterangan->SetVisibility();
		$this->nik->SetVisibility();

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
		global $EW_EXPORT, $pendaftar_diterima;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pendaftar_diterima);
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
					if ($pageName == "pendaftar_diterimaview.php")
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
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

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
		$this->FormClassName = "ewForm ewUpdateForm form-horizontal";

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys

		// Check if valid user id
		$sql = $this->GetSQL($this->GetKeyFilter(), "");
		$conn = &$this->Connection();
		if ($this->Recordset = ew_LoadRecordset($sql, $conn)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->LoadRowValues($this->Recordset);
				if (!$this->ShowOptionLink('update')) {
					$sUserIdMsg = $Language->Phrase("NoEditPermission");
					$this->setFailureMessage($sUserIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
			if (!$res) $this->Page_Terminate("pendaftar_diterimalist.php"); // Return to list
		}
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("pendaftar_diterimalist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->keterangan->setDbValue($this->Recordset->fields('keterangan'));
					$this->nik->setDbValue($this->Recordset->fields('nik'));
				} else {
					if (!ew_CompareValue($this->keterangan->DbValue, $this->Recordset->fields('keterangan')))
						$this->keterangan->CurrentValue = NULL;
					if (!ew_CompareValue($this->nik->DbValue, $this->Recordset->fields('nik')))
						$this->nik->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->id_pendaftar->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
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
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		$this->keterangan->MultiUpdate = $objForm->GetValue("u_keterangan");
		if (!$this->nik->FldIsDetailKey) {
			$this->nik->setFormValue($objForm->GetValue("x_nik"));
		}
		$this->nik->MultiUpdate = $objForm->GetValue("u_nik");
		if (!$this->id_pendaftar->FldIsDetailKey)
			$this->id_pendaftar->setFormValue($objForm->GetValue("x_id_pendaftar"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id_pendaftar->CurrentValue = $this->id_pendaftar->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->nik->CurrentValue = $this->nik->FormValue;
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
		$row = array();
		$row['id_pendaftar'] = NULL;
		$row['nomor_pendaftaran'] = NULL;
		$row['nama_ruang'] = NULL;
		$row['nomor_peserta_ujian_sdmi'] = NULL;
		$row['sekolah_asal'] = NULL;
		$row['nama_lengkap'] = NULL;
		$row['nisn'] = NULL;
		$row['tempat_lahir'] = NULL;
		$row['tanggal_lahir'] = NULL;
		$row['jenis_kelamin'] = NULL;
		$row['agama'] = NULL;
		$row['kecamatan'] = NULL;
		$row['zona'] = NULL;
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
		$row['n_ind'] = NULL;
		$row['n_mat'] = NULL;
		$row['n_ipa'] = NULL;
		$row['keterangan'] = NULL;
		$row['alamat'] = NULL;
		$row['nik'] = NULL;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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
		$this->status->ViewValue = $this->status->CurrentValue;
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
		if (strval($this->keterangan->CurrentValue) <> "") {
			$this->keterangan->ViewValue = $this->keterangan->OptionCaption($this->keterangan->CurrentValue);
		} else {
			$this->keterangan->ViewValue = NULL;
		}
		$this->keterangan->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";
			$this->nik->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// keterangan
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = $this->keterangan->Options(FALSE);

			// nik
			$this->nik->EditAttrs["class"] = "form-control";
			$this->nik->EditCustomAttributes = "";
			$this->nik->EditValue = $this->nik->CurrentValue;
			$this->nik->ViewCustomAttributes = "";

			// Edit refer script
			// keterangan

			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";
			$this->nik->TooltipValue = "";
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
		$lUpdateCnt = 0;
		if ($this->keterangan->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->nik->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

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

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, $this->keterangan->ReadOnly || $this->keterangan->MultiUpdate <> "1");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pendaftar_diterimalist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
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
if (!isset($pendaftar_diterima_update)) $pendaftar_diterima_update = new cpendaftar_diterima_update();

// Page init
$pendaftar_diterima_update->Page_Init();

// Page main
$pendaftar_diterima_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pendaftar_diterima_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = fpendaftar_diterimaupdate = new ew_Form("fpendaftar_diterimaupdate", "update");

// Validate form
fpendaftar_diterimaupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpendaftar_diterimaupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fpendaftar_diterimaupdate.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fpendaftar_diterimaupdate.Lists["x_keterangan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpendaftar_diterimaupdate.Lists["x_keterangan"].Options = <?php echo json_encode($pendaftar_diterima_update->keterangan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pendaftar_diterima_update->ShowPageHeader(); ?>
<?php
$pendaftar_diterima_update->ShowMessage();
?>
<form name="fpendaftar_diterimaupdate" id="fpendaftar_diterimaupdate" class="<?php echo $pendaftar_diterima_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pendaftar_diterima_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pendaftar_diterima_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pendaftar_diterima">
<input type="hidden" name="a_update" id="a_update" value="U">
<input type="hidden" name="modal" value="<?php echo intval($pendaftar_diterima_update->IsModal) ?>">
<?php foreach ($pendaftar_diterima_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_pendaftar_diterimaupdate" class="ewUpdateDiv"><!-- page -->
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($pendaftar_diterima->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label class="<?php echo $pendaftar_diterima_update->LeftColumnClass ?>"><div class="checkbox"><label>
<input type="checkbox" name="u_keterangan" id="u_keterangan" class="ewMultiSelect" value="1"<?php echo ($pendaftar_diterima->keterangan->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $pendaftar_diterima->keterangan->FldCaption() ?></label></div></label>
		<div class="<?php echo $pendaftar_diterima_update->RightColumnClass ?>"><div<?php echo $pendaftar_diterima->keterangan->CellAttributes() ?>>
<span id="el_pendaftar_diterima_keterangan">
<div id="tp_x_keterangan" class="ewTemplate"><input type="radio" data-table="pendaftar_diterima" data-field="x_keterangan" data-value-separator="<?php echo $pendaftar_diterima->keterangan->DisplayValueSeparatorAttribute() ?>" name="x_keterangan" id="x_keterangan" value="{value}"<?php echo $pendaftar_diterima->keterangan->EditAttributes() ?>></div>
<div id="dsl_x_keterangan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $pendaftar_diterima->keterangan->RadioButtonListHtml(FALSE, "x_keterangan") ?>
</div></div>
</span>
<?php echo $pendaftar_diterima->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$pendaftar_diterima_update->IsModal) { ?>
	<div class="form-group"><!-- buttons .form-group -->
		<div class="<?php echo $pendaftar_diterima_update->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pendaftar_diterima_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fpendaftar_diterimaupdate.Init();
</script>
<?php
$pendaftar_diterima_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pendaftar_diterima_update->Page_Terminate();
?>
