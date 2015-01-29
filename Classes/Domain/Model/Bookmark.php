<?php
namespace Pixelant\PxaFeuserbookmarks\Domain\Model;
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
class Bookmark extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Website User Id
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $feuserid;

	/**
	 * Page Id
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $pageid;

	/**
	 * specialIdentificator
	 *
	 * @var integer
	 */
	protected $specialIdentificator;

	/**
	 * Url Params
	 *
	 * @var string
	 */
	protected $params;

	/**
	 * Returns the feuserid
	 *
	 * @return integer $feuserid
	 */
	public function getFeuserid() {
		return $this->feuserid;
	}

	/**
	 * Sets the feuserid
	 *
	 * @param integer $feuserid
	 * @return void
	 */
	public function setFeuserid($feuserid) {
		$this->feuserid = $feuserid;
	}

	/**
	 * Returns the pageid
	 *
	 * @return integer $pageid
	 */
	public function getPageid() {
		return $this->pageid;
	}

	/**
	 * Sets the pageid
	 *
	 * @param integer $pageid
	 * @return void
	 */
	public function setPageid($pageid) {
		$this->pageid = $pageid;
	}

	/**
	 * Returns the specialIdentificator
	 *
	 * @return integer $specialIdentificator
	 */
	public function getSpecialIdentificator() {
		return $this->specialIdentificator;
	}

	/**
	 * Sets the specialIdentificator
	 *
	 * @param integer $specialIdentificator
	 * @return void
	 */
	public function setSpecialIdentificator($specialIdentificator) {
		$this->specialIdentificator = $specialIdentificator;
	}

	/**
	 * Returns the params
	 *
	 * @return string $params
	 */
	public function getParams() {
		$val = strlen($this->params) > 0 ? unserialize($this->params) : array();
		return $val;
	}

	/**
	 * Sets the params
	 *
	 * @param string $params
	 * @return void
	 */
	public function setParams($params) {
		//$val = is_array($params) ? serialize($params) : "";
		$this->params = $params;
	}

	/**
	* Get the pageTitle
	*
	*
	* @return array
	*/
	public function getPageTitle() {
		$title = '';
		if($this->specialIdentificator == 0) {
			$page = $GLOBALS['TSFE']->sys_page->getPage($this->pageid);
			$pageArray = $GLOBALS['TSFE']->sys_page->getPageOverlay($page, $GLOBALS['TSFE']->sys_language_uid);
			$title = $pageArray['title'];
			unset($pageArray);
		} else {
			$sepcialPages = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pxafeuserbookmarks.']['settings.']['specialPages.'];
			$key = $this->pageid.'.';
			
			if(is_array($sepcialPages[$key])) {
				$tableName = $sepcialPages[$key]['tableName'];
				$titleField = $sepcialPages[$key]['titleField'];

				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					$titleField,
					$tableName,
					'uid='.$this->specialIdentificator,
					'',
					'',
					1
				);
				$resArray = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				$GLOBALS['TYPO3_DB']->sql_free_result($res);

				$title = $resArray[$titleField];
				unset($resArray);
			}
		}
		return $title;
	}

}
?>