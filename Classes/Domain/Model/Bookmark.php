<?php

namespace Pixelant\PxaFeuserbookmarks\Domain\Model;

use Pixelant\PxaFeuserbookmarks\Domain\Service\BookmarkTitle;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 *
 *
 * @package pxa_feuserbookmarks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Bookmark extends AbstractEntity
{
    /**
     * @var BookmarkTitle
     */
    protected $bookmarkTitle;

    /**
     * @var integer
     */
    protected $feuserid;

    /**
     * @var integer
     */
    protected $pageid;

    /**
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
     * @param BookmarkTitle $bookmarkTitle
     */
    public function injectBookmarkTitle(BookmarkTitle $bookmarkTitle)
    {
        $this->bookmarkTitle = $bookmarkTitle;
    }

    /**
     * @return int
     */
    public function getFeuserid(): int
    {
        return $this->feuserid;
    }

    /**
     * @param int $feuserid
     */
    public function setFeuserid(int $feuserid): void
    {
        $this->feuserid = $feuserid;
    }

    /**
     * @return int
     */
    public function getPageid(): int
    {
        return $this->pageid;
    }

    /**
     * @param int $pageid
     */
    public function setPageid(int $pageid): void
    {
        $this->pageid = $pageid;
    }

    /**
     * @return int
     */
    public function getSpecialIdentificator(): int
    {
        return $this->specialIdentificator;
    }

    /**
     * @param int $specialIdentificator
     */
    public function setSpecialIdentificator(int $specialIdentificator): void
    {
        $this->specialIdentificator = $specialIdentificator;
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->bookmarkTitle->get($this);
    }
}
