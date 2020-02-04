<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'pxa_feuserbookmarks',
    'Pxasitebookmarks',
    'Website User Bookmarks - List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'pxa_feuserbookmarks',
    'Pxasitebookmarksnew',
    'Website User Bookmarks - Add New'
);
