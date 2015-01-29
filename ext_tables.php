<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pxasitebookmarks',
	'Website User Bookmarks - List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pxasitebookmarksnew',
	'Website User Bookmarks - Add New'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Website User Bookmarks');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pxafeuserbookmarks_domain_model_bookmark', 'EXT:pxa_feuserbookmarks/Resources/Private/Language/locallang_csh_tx_pxafeuserbookmarks_domain_model_bookmark.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pxafeuserbookmarks_domain_model_bookmark');
$TCA['tx_pxafeuserbookmarks_domain_model_bookmark'] = array(
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Bookmark.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pxafeuserbookmarks_domain_model_bookmark.gif',

		'rootLevel' => 1,
		'hideTable' => TRUE
	),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
?>