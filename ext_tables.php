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

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
?>