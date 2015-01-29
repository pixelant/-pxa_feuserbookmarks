<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pixelant.' . $_EXTKEY,
	'Pxasitebookmarks',
	array(
		'Bookmark' => 'widget, remove',
		
	),
	// non-cacheable actions
	array(
		'Bookmark' => 'widget, remove',
	)
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pixelant.' . $_EXTKEY,
	'Pxasitebookmarksnew',
	array(
		'Bookmark' => 'add, remove, new',
		
	),
	// non-cacheable actions
	array(
		'Bookmark' => 'add, remove, new',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
?>