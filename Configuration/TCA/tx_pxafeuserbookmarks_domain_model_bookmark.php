<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return [
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark',
		'label' => 'feuserid',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'feuserid,pageid,params,',
		'dynamicConfigFile' => 'EXT:pxa_feuserbookmarks/Configuration/TCA/Bookmark.php',
		'iconfile' => 'EXT:pxa_feuserbookmarks/Resources/Public/Icons/tx_pxafeuserbookmarks_domain_model_bookmark.gif',

		'rootLevel' => 1,
		'hideTable' => TRUE
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, feuserid, pageid, special_identificator, params',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, feuserid, pageid, special_identificator, params,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pxafeuserbookmarks_domain_model_bookmark',
				'foreign_table_where' => 'AND tx_pxafeuserbookmarks_domain_model_bookmark.pid=###CURRENT_PID### AND tx_pxafeuserbookmarks_domain_model_bookmark.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'feuserid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.feuserid',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'pageid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.pageid',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'special_identificator' => array(
			'exclude' => 0,
			'label' => 'special_identificator',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'params' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_db.xlf:tx_pxafeuserbookmarks_domain_model_bookmark.params',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
	),
];

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
?>