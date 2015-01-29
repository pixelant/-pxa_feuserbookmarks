<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pxa_feuserbookmarks".
 *
 * Auto generated 09-01-2015 15:41
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Website User Bookmarks',
	'description' => 'Website User can store bookmarks to pages',
	'category' => 'plugin',
	'author' => 'Mats Svensson',
	'author_email' => 'mats@pixelant.se',
	'author_company' => 'Pixelant AB',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.0',
	'constraints' => 
	array (
		'depends' => 
		array (
			'extbase' => '1.4',
			'fluid' => '1.4',
			'typo3' => '4.6-0.0.0',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'_md5_values_when_last_written' => 'a:26:{s:21:"ExtensionBuilder.json";s:4:"c9de";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"600b";s:14:"ext_tables.php";s:4:"4109";s:14:"ext_tables.sql";s:4:"f880";s:41:"Classes/Controller/BookmarkController.php";s:4:"d8d2";s:33:"Classes/Domain/Model/Bookmark.php";s:4:"1f14";s:48:"Classes/Domain/Repository/BookmarkRepository.php";s:4:"40fb";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"aaff";s:50:"Configuration/FlexForms/flexform_sitebookmarks.xml";s:4:"045b";s:30:"Configuration/TCA/Bookmark.php";s:4:"faf7";s:38:"Configuration/TypoScript/constants.txt";s:4:"8acc";s:34:"Configuration/TypoScript/setup.txt";s:4:"21f6";s:40:"Resources/Private/Language/locallang.xml";s:4:"65de";s:88:"Resources/Private/Language/locallang_csh_tx_pxafeuserbookmarks_domain_model_bookmark.xml";s:4:"9e80";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"c297";s:38:"Resources/Private/Layouts/Default.html";s:4:"50fe";s:46:"Resources/Private/Templates/Bookmark/List.html";s:4:"233a";s:48:"Resources/Private/Templates/Bookmark/widget.html";s:4:"2ee7";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:70:"Resources/Public/Icons/tx_pxafeuserbookmarks_domain_model_bookmark.gif";s:4:"905a";s:40:"Resources/Public/Images/add_bookmark.png";s:4:"f7e0";s:43:"Resources/Public/Images/remove_bookmark.png";s:4:"17e7";s:48:"Tests/Unit/Controller/BookmarkControllerTest.php";s:4:"75e1";s:40:"Tests/Unit/Domain/Model/BookmarkTest.php";s:4:"5c3c";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

