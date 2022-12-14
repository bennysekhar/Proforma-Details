<?php

// Data functions (insert, update, delete, form) for table Proforma_details

// This script and data application were generated by AppGini 22.13
// Download AppGini for free from https://bigprof.com/appgini/download/

function Proforma_details_insert(&$error_message = '') {
	global $Translation;

	// mm: can member insert record?
	$arrPerm = getTablePermissions('Proforma_details');
	if(!$arrPerm['insert']) return false;

	$data = [
		'field1' => Request::val('field1', ''),
		'Address' => br2nl(Request::val('Address', '')),
		'Mobile' => Request::val('Mobile', ''),
		'Email' => Request::val('Email', ''),
	];

	if($data['field1'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Name': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}
	if($data['Mobile'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Mobile': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}
	if($data['Email'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Email': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}

	// hook: Proforma_details_before_insert
	if(function_exists('Proforma_details_before_insert')) {
		$args = [];
		if(!Proforma_details_before_insert($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$error = '';
	// set empty fields to NULL
	$data = array_map(function($v) { return ($v === '' ? NULL : $v); }, $data);
	insert('Proforma_details', backtick_keys_once($data), $error);
	if($error) {
		$error_message = $error;
		return false;
	}

	$recID = $data['field1'];

	update_calc_fields('Proforma_details', $recID, calculated_fields()['Proforma_details']);

	// hook: Proforma_details_after_insert
	if(function_exists('Proforma_details_after_insert')) {
		$res = sql("SELECT * FROM `Proforma_details` WHERE `field1`='" . makeSafe($recID, false) . "' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) {
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args = [];
		if(!Proforma_details_after_insert($data, getMemberInfo(), $args)) { return $recID; }
	}

	// mm: save ownership data
	set_record_owner('Proforma_details', $recID, getLoggedMemberID());

	// if this record is a copy of another record, copy children if applicable
	if(strlen(Request::val('SelectedID'))) Proforma_details_copy_children($recID, Request::val('SelectedID'));

	return $recID;
}

function Proforma_details_copy_children($destination_id, $source_id) {
	global $Translation;
	$requests = []; // array of curl handlers for launching insert requests
	$eo = ['silentErrors' => true];
	$safe_sid = makeSafe($source_id);

	// launch requests, asynchronously
	curl_batch($requests);
}

function Proforma_details_delete($selected_id, $AllowDeleteOfParents = false, $skipChecks = false) {
	// insure referential integrity ...
	global $Translation;
	$selected_id = makeSafe($selected_id);

	// mm: can member delete record?
	if(!check_record_permission('Proforma_details', $selected_id, 'delete')) {
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: Proforma_details_before_delete
	if(function_exists('Proforma_details_before_delete')) {
		$args = [];
		if(!Proforma_details_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'] . (
				!empty($args['error_message']) ?
					'<div class="text-bold">' . strip_tags($args['error_message']) . '</div>'
					: '' 
			);
	}

	sql("DELETE FROM `Proforma_details` WHERE `field1`='{$selected_id}'", $eo);

	// hook: Proforma_details_after_delete
	if(function_exists('Proforma_details_after_delete')) {
		$args = [];
		Proforma_details_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("DELETE FROM `membership_userrecords` WHERE `tableName`='Proforma_details' AND `pkValue`='{$selected_id}'", $eo);
}

function Proforma_details_update(&$selected_id, &$error_message = '') {
	global $Translation;

	// mm: can member edit record?
	if(!check_record_permission('Proforma_details', $selected_id, 'edit')) return false;

	$data = [
		'field1' => Request::val('field1', ''),
		'Address' => br2nl(Request::val('Address', '')),
		'Mobile' => Request::val('Mobile', ''),
		'Email' => Request::val('Email', ''),
		'Date_Of_Birth' => parseCode('<%%editingDate%%>', false, true),
	];

	if($data['field1'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Name': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}
	if($data['Mobile'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Mobile': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}
	if($data['Email'] === '') {
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Email': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">' . $Translation['< back'] . '</a></div>';
		exit;
	}
	// get existing values
	$old_data = getRecord('Proforma_details', $selected_id);
	if(is_array($old_data)) {
		$old_data = array_map('makeSafe', $old_data);
		$old_data['selectedID'] = makeSafe($selected_id);
	}

	$data['selectedID'] = makeSafe($selected_id);

	// hook: Proforma_details_before_update
	if(function_exists('Proforma_details_before_update')) {
		$args = ['old_data' => $old_data];
		if(!Proforma_details_before_update($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$set = $data; unset($set['selectedID']);
	foreach ($set as $field => $value) {
		$set[$field] = ($value !== '' && $value !== NULL) ? $value : NULL;
	}

	if(!update(
		'Proforma_details', 
		backtick_keys_once($set), 
		['`field1`' => $selected_id], 
		$error_message
	)) {
		echo $error_message;
		echo '<a href="Proforma_details_view.php?SelectedID=' . urlencode($selected_id) . "\">{$Translation['< back']}</a>";
		exit;
	}

	$data['selectedID'] = $data['field1'];
	$newID = $data['field1'];

	$eo = ['silentErrors' => true];

	update_calc_fields('Proforma_details', $data['selectedID'], calculated_fields()['Proforma_details']);

	// hook: Proforma_details_after_update
	if(function_exists('Proforma_details_after_update')) {
		$res = sql("SELECT * FROM `Proforma_details` WHERE `field1`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) $data = array_map('makeSafe', $row);

		$data['selectedID'] = $data['field1'];
		$args = ['old_data' => $old_data];
		if(!Proforma_details_after_update($data, getMemberInfo(), $args)) return;
	}

	// mm: update ownership data
	sql("UPDATE `membership_userrecords` SET `dateUpdated`='" . time() . "', `pkValue`='{$data['field1']}' WHERE `tableName`='Proforma_details' AND `pkValue`='" . makeSafe($selected_id) . "'", $eo);

	// if PK value changed, update $selected_id
	$selected_id = $newID;
}

function Proforma_details_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $separateDV = 0, $TemplateDV = '', $TemplateDVP = '') {
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;
	$eo = ['silentErrors' => true];
	$noUploads = null;
	$row = $urow = $jsReadOnly = $jsEditable = $lookups = null;

	$noSaveAsCopy = false;

	// mm: get table permissions
	$arrPerm = getTablePermissions('Proforma_details');
	if(!$arrPerm['insert'] && $selected_id == '')
		// no insert permission and no record selected
		// so show access denied error unless TVDV
		return $separateDV ? $Translation['tableAccessDenied'] : '';
	$AllowInsert = ($arrPerm['insert'] ? true : false);
	// print preview?
	$dvprint = false;
	if(strlen($selected_id) && Request::val('dvprint_x') != '') {
		$dvprint = true;
	}


	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: Date_Of_Birth
	$combo_Date_Of_Birth = new DateCombo;
	$combo_Date_Of_Birth->DateFormat = "mdy";
	$combo_Date_Of_Birth->MinYear = defined('Proforma_details.Date_Of_Birth.MinYear') ? constant('Proforma_details.Date_Of_Birth.MinYear') : 1900;
	$combo_Date_Of_Birth->MaxYear = defined('Proforma_details.Date_Of_Birth.MaxYear') ? constant('Proforma_details.Date_Of_Birth.MaxYear') : 2100;
	$combo_Date_Of_Birth->DefaultDate = parseMySQLDate('<%%editingDate%%>', '<%%editingDate%%>');
	$combo_Date_Of_Birth->MonthNames = $Translation['month names'];
	$combo_Date_Of_Birth->NamePrefix = 'Date_Of_Birth';

	if($selected_id) {
		// mm: check member permissions
		if(!$arrPerm['view']) return $Translation['tableAccessDenied'];

		// mm: who is the owner?
		$ownerGroupID = sqlValue("SELECT `groupID` FROM `membership_userrecords` WHERE `tableName`='Proforma_details' AND `pkValue`='" . makeSafe($selected_id) . "'");
		$ownerMemberID = sqlValue("SELECT LCASE(`memberID`) FROM `membership_userrecords` WHERE `tableName`='Proforma_details' AND `pkValue`='" . makeSafe($selected_id) . "'");

		if($arrPerm['view'] == 1 && getLoggedMemberID() != $ownerMemberID) return $Translation['tableAccessDenied'];
		if($arrPerm['view'] == 2 && getLoggedGroupID() != $ownerGroupID) return $Translation['tableAccessDenied'];

		// can edit?
		$AllowUpdate = 0;
		if(($arrPerm['edit'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['edit'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['edit'] == 3) {
			$AllowUpdate = 1;
		}

		$res = sql("SELECT * FROM `Proforma_details` WHERE `field1`='" . makeSafe($selected_id) . "'", $eo);
		if(!($row = db_fetch_array($res))) {
			return error_message($Translation['No records found'], 'Proforma_details_view.php', false);
		}
		$combo_Date_Of_Birth->DefaultDate = $row['Date_Of_Birth'];
		$urow = $row; /* unsanitized data */
		$row = array_map('safe_html', $row);
	} else {
		$filterField = Request::val('FilterField');
		$filterOperator = Request::val('FilterOperator');
		$filterValue = Request::val('FilterValue');
	}

	// code for template based detail view forms

	// open the detail view template
	if($dvprint) {
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/Proforma_details_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	} else {
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/Proforma_details_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Person details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', (Request::val('Embedded') ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert) {
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return Proforma_details_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return Proforma_details_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if(Request::val('Embedded')) {
		$backAction = 'AppGini.closeParentModal(); return false;';
	} else {
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id) {
		if(!Request::val('Embedded')) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$j(\'form\').eq(0).prop(\'novalidate\', true); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate) {
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return Proforma_details_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		} else {
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm['delete'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['delete'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['delete'] == 3) { // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		} else {
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);

		// if not in embedded mode and user has insert only but no view/update/delete,
		// remove 'back' button
		if(
			$arrPerm['insert']
			&& !$arrPerm['update'] && !$arrPerm['delete'] && !$arrPerm['view']
			&& !Request::val('Embedded')
		)
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
		elseif($separateDV)
			$templateCode = str_replace(
				'<%%DESELECT_BUTTON%%>', 
				'<button
					type="submit" 
					class="btn btn-default" 
					id="deselect" 
					name="deselect_x" 
					value="1" 
					onclick="' . $backAction . '" 
					title="' . html_attr($Translation['Back']) . '">
						<i class="glyphicon glyphicon-chevron-left"></i> ' .
						$Translation['Back'] .
				'</button>',
				$templateCode
			);
		else
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)) {
		$jsReadOnly = '';
		$jsReadOnly .= "\tjQuery('#field1').replaceWith('<div class=\"form-control-static\" id=\"field1\">' + (jQuery('#field1').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Address').replaceWith('<div class=\"form-control-static\" id=\"Address\">' + (jQuery('#Address').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Mobile').replaceWith('<div class=\"form-control-static\" id=\"Mobile\">' + (jQuery('#Mobile').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Email').replaceWith('<div class=\"form-control-static\" id=\"Email\">' + (jQuery('#Email').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Email, #Email-edit-link').hide();\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	} elseif($AllowInsert) {
		$jsEditable = "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace(
		'<%%COMBO(Date_Of_Birth)%%>', 
		($selected_id && !$arrPerm['edit'] && ($noSaveAsCopy || !$arrPerm['insert']) ? 
			'<div class="form-control-static">' . $combo_Date_Of_Birth->GetHTML(true) . '</div>' : 
			$combo_Date_Of_Birth->GetHTML()
		), $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(Date_Of_Birth)%%>', $combo_Date_Of_Birth->GetHTML(true), $templateCode);

	/* lookup fields array: 'lookup field name' => ['parent table name', 'lookup field caption'] */
	$lookup_fields = [];
	foreach($lookup_fields as $luf => $ptfc) {
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']) {
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] /* && !Request::val('Embedded')*/) {
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-default add_new_parent" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus text-success"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(field1)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Address)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Mobile)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Email)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Date_Of_Birth)%%>', '', $templateCode);

	// process values
	if($selected_id) {
		if( $dvprint) $templateCode = str_replace('<%%VALUE(field1)%%>', safe_html($urow['field1']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(field1)%%>', html_attr($row['field1']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(field1)%%>', urlencode($urow['field1']), $templateCode);
		if($dvprint || (!$AllowUpdate && !$AllowInsert)) {
			$templateCode = str_replace('<%%VALUE(Address)%%>', safe_html($urow['Address']), $templateCode);
		} else {
			$templateCode = str_replace('<%%VALUE(Address)%%>', safe_html($urow['Address'], true), $templateCode);
		}
		$templateCode = str_replace('<%%URLVALUE(Address)%%>', urlencode($urow['Address']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Mobile)%%>', safe_html($urow['Mobile']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Mobile)%%>', html_attr($row['Mobile']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Mobile)%%>', urlencode($urow['Mobile']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Email)%%>', safe_html($urow['Email']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Email)%%>', html_attr($row['Email']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Email)%%>', urlencode($urow['Email']), $templateCode);
		$templateCode = str_replace('<%%VALUE(Date_Of_Birth)%%>', app_datetime($row['Date_Of_Birth']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Date_Of_Birth)%%>', urlencode(app_datetime($urow['Date_Of_Birth'])), $templateCode);
	} else {
		$templateCode = str_replace('<%%VALUE(field1)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(field1)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Address)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Address)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Mobile)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Mobile)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Email)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Email)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Date_Of_Birth)%%>', '<%%editingDate%%>', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Date_Of_Birth)%%>', urlencode('<%%editingDate%%>'), $templateCode);
	}

	// process translations
	$templateCode = parseTemplate($templateCode);

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if(Request::val('dvprint_x') == '') {
		$templateCode .= "\n\n<script>\$j(function() {\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption) {
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id) {
			$templateCode.="\n\tif(document.getElementById('EmailEdit')) { document.getElementById('EmailEdit').style.display='inline'; }";
			$templateCode.="\n\tif(document.getElementById('EmailEditLink')) { document.getElementById('EmailEditLink').style.display='none'; }";
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields
	$filterField = Request::val('FilterField');
	$filterOperator = Request::val('FilterOperator');
	$filterValue = Request::val('FilterValue');

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('Proforma_details');
	if($selected_id) {
		$jdata = get_joined_record('Proforma_details', $selected_id);
		if($jdata === false) $jdata = get_defaults('Proforma_details');
		$rdata = $row;
	}
	$templateCode .= loadView('Proforma_details-ajax-cache', ['rdata' => $rdata, 'jdata' => $jdata]);

	// hook: Proforma_details_dv
	if(function_exists('Proforma_details_dv')) {
		$args = [];
		Proforma_details_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}