<?php

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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_PxaFeuserbookmarks_Domain_Model_Bookmark.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Website User Bookmarks
 *
 * @author Mats Svensson <mats@pixelant.se>
 */
class Tx_PxaFeuserbookmarks_Domain_Model_BookmarkTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_PxaFeuserbookmarks_Domain_Model_Bookmark
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_PxaFeuserbookmarks_Domain_Model_Bookmark();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getFeuseridReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getFeuserid()
		);
	}

	/**
	 * @test
	 */
	public function setFeuseridForIntegerSetsFeuserid() { 
		$this->fixture->setFeuserid(12);

		$this->assertSame(
			12,
			$this->fixture->getFeuserid()
		);
	}
	
	/**
	 * @test
	 */
	public function getPageidReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPageid()
		);
	}

	/**
	 * @test
	 */
	public function setPageidForIntegerSetsPageid() { 
		$this->fixture->setPageid(12);

		$this->assertSame(
			12,
			$this->fixture->getPageid()
		);
	}
	
	/**
	 * @test
	 */
	public function getParamsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setParamsForStringSetsParams() { 
		$this->fixture->setParams('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getParams()
		);
	}
	
}
?>