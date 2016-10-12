<?php
namespace Pixelant\PxaFeuserbookmarks\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mats Svensson <mats@pixelant.se>, Pixelant AB
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package pxa_feuserbookmarks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BookmarkController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * bookmarkRepository
	 *
	 * @var \Pixelant\PxaFeuserbookmarks\Domain\Repository\BookmarkRepository
	 * @inject
	 */
	protected $bookmarkRepository;

	/**
	 * action widget
	 *
	 * @return void
	 */
	public function widgetAction() {				
		if($GLOBALS['TSFE']->loginUser) {
			$bookmarks = $this->bookmarkRepository->getBookmarksList();
        	$this->view->assign('bookmarks', $bookmarks);			
		}
	}

	/**
	 * action add
	 *
	 * @return void
	 */
	public function addAction() {
		$isVisible = false;
		$isExluded = \TYPO3\CMS\Core\Utility\GeneralUtility::inList($this->settings['excludePages'], $GLOBALS['TSFE']->id);

		if($GLOBALS['TSFE']->loginUser) {
            $this->view->assign('bookmarks', $this->bookmarkRepository->getBookmarksList()->toArray());

		    if(!$isExluded) {
                $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
                $params = $this->getParams();
                $isPageSpecial = $this->isPageSpecial();

                if($isPageSpecial) {
                    $identificatorValue = $this->getIdentificatorValue($params);
                } else {
                    $identificatorValue = NULL;
                }

                $bookmarks = $this->bookmarkRepository->findBookmarkByFeuserAndPageID($userId,$GLOBALS['TSFE']->id,$isPageSpecial,$identificatorValue);

                $isPageFavorite = ($bookmarks->count() > 0);

                $this->view->assignMultiple(array(
                    'params' => count($params) > 0 ? serialize($params) : false,
                    'isPageFavorite' => $isPageFavorite,
                    'isPageSpecial' => $isPageSpecial,
                    'identificatorValue' => $identificatorValue
                ));
                $isVisible = true;
            }

		}

		$this->view->assign('isVisible',$isVisible);
	}

	/**
	 * action remove
	 *
	 * @param int $ajax if call ajax
	 * @param int $identificatorValue special identificator
	 * @param int $pageId pageId
	 * @return mixed
	 */
	public function removeAction($ajax = NULL, $identificatorValue = NULL, $pageId = NULL) {
		$status = false;
		$pageId = is_null($pageId) ? $GLOBALS['TSFE']->id : $pageId;

		if($GLOBALS['TSFE']->loginUser) {
			$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

			if($identificatorValue > 0) {
				$isPageSpecial = true;
			}

			$bookmarks = $this->bookmarkRepository->findBookmarkByFeuserAndPageID($userId,$pageId,$isPageSpecial,$identificatorValue);

			foreach ($bookmarks as $bookmark) {
				$this->bookmarkRepository->remove($bookmark);
			}
        	
        	$status = ($bookmarks->count() > 0);
		}
		
		if($ajax) {
			$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();             	
			$response = array(
				'status' => $status,
				'text' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('remove_from_favorites_success', $this->extensionName),
			);

			echo json_encode($response);
			exit(0);
		} else {
			if($status) {
				$message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('remove_from_favorites_success', $this->extensionName);
				//$title = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('success', $this->extensionName);
				$this->flashMessageContainer->add($message, '', \TYPO3\CMS\Core\Messaging\FlashMessage::OK,TRUE);
				
			} else {
				$message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error_msg', $this->extensionName);
				$title = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error', $this->extensionName);
				$this->flashMessageContainer->add($message, $title, \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			}
			
			$this->redirect('widget');
		}
	}	

	/**
	 * action remove
	 *
	 * @param string $params
	 * @param int $identificatorValue
	 * @return string
	 */
	public function newAction($params = NULL, $identificatorValue = NULL) {
		$status = false;
		
		if($GLOBALS['TSFE']->loginUser) {
			$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

			$bookmark = $this->objectManager->get('Pixelant\\PxaFeuserbookmarks\\Domain\\Model\\Bookmark');
			$bookmark->setFeuserid($userId);
			$bookmark->setPageid($GLOBALS['TSFE']->id);
			
			if(!is_null($params) && !is_null($identificatorValue)) {
				$bookmark->setParams($params);
				$bookmark->setSpecialIdentificator($identificatorValue);
			}

			$this->bookmarkRepository->add($bookmark);

			$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
			$status = true;
		}		

		$response = array(
			'status' => $status,
			'text' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('add_to_favorites_success', $this->extensionName)
		);

		echo json_encode($response);
		exit(0);
	}

	private function getParams() {
		$params = array();
		$getParams = $_GET;
		$postParams = $_POST;

		foreach ($getParams as $key => $value) {
			$params[$key] = $value;
		}
		foreach ($postParams as $key => $value) {
			$params[$key] = $value;
		}
		unset($params['tx_pxafeuserbookmarks_sitebookmarks']);
		unset($params['cHash']);
		return $params;
	}

	/**
	 * check if page is special
	 *
	 * @return boolean
	 */
	private function isPageSpecial() {
		if(is_array($this->settings['specialPages']))
				$isSpecialPage = array_key_exists($GLOBALS['TSFE']->id, $this->settings['specialPages']);
			else
				$isSpecialPage = false;

		return $isSpecialPage;
	}

	/** 
	 * get special identificator Value
	 *
	 * @param array $params
	 * @return int
	 */
	private function getIdentificatorValue($params) {
		$identificatorParam = $this->settings['specialPages'][$GLOBALS['TSFE']->id]['identificatorParam'];
		$paramPrefix = $this->settings['specialPages'][$GLOBALS['TSFE']->id]['paramPrefix'];

		$identificatorValue = $params[$paramPrefix][$identificatorParam];

		return $identificatorValue;
	}
}
?>