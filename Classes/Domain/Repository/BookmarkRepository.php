<?php
namespace Pixelant\PxaFeuserbookmarks\Domain\Repository;
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
class BookmarkRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository {

	/** 
	 * find bookmark
	 *
	 * @param int $userId
	 * @param int $pageId
	 * @param int $identificatorValue
	 * @param boolean $isPageSpecial
	 * @return TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
	 */
	public function findBookmarkByFeuserAndPageID($userId,$pageId,$isPageSpecial,$identificatorValue) {
		$query = $this->createQuery();
		$constraints[] = $query->equals('feuserid',$userId);
		$constraints[] = $query->equals('pageid',$pageId);

		if($isPageSpecial) {			
			$constraints[] = $query->equals('specialIdentificator',$identificatorValue);			
		}

		return $query->matching($query->logicalAnd($constraints))->execute();
				        
	}

	/**
	 * get lsit off bookmarks
	 *
	 * @return TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
	 */
	public function getBookmarksList() {
		$query = $this->createQuery();
        $query->statement($this->buildSelectStatement());

        return $query->execute();
	}

	/**
     * Build statement for fetching bookmarks ordered by pagetitle
     *
     * @param $arguments array
     * @return void
     */
    private function buildSelectStatement() {
        
        $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		
        $selectStatement = "SELECT tx_pxafeuserbookmarks_domain_model_bookmark.* FROM tx_pxafeuserbookmarks_domain_model_bookmark INNER JOIN pages ON pages.uid = tx_pxafeuserbookmarks_domain_model_bookmark.pageid ";
       
       	$selectWhere = " WHERE tx_pxafeuserbookmarks_domain_model_bookmark.feuserid = " . $userId;
        $selectWhere.= " AND tx_pxafeuserbookmarks_domain_model_bookmark.deleted = 0 ";
		$selectWhere.= " AND tx_pxafeuserbookmarks_domain_model_bookmark.hidden = 0 ";
        $selectWhere.= " AND pages.deleted = 0 ";
		$selectWhere.= " AND pages.hidden = 0 ";
        
        return $selectStatement . $selectWhere . " ORDER BY pages.crdate DESC";

    }
}
?>