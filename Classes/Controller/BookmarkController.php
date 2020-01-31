<?php

namespace Pixelant\PxaFeuserbookmarks\Controller;

use Pixelant\PxaFeuserbookmarks\Domain\Model\Bookmark;
use Pixelant\PxaFeuserbookmarks\Domain\Repository\BookmarkRepository;
use Pixelant\PxaFeuserbookmarks\Domain\Settings\AbleFetchSpecialPageConfiguration;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\Exception\MissingArrayPathException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 *
 *
 * @package pxa_feuserbookmarks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BookmarkController extends ActionController
{
    use AbleFetchSpecialPageConfiguration;

    /**
     * @var \Pixelant\PxaFeuserbookmarks\Domain\Repository\BookmarkRepository
     */
    protected $bookmarkRepository;

    /**
     * Current logged in user uid
     *
     * @var int
     */
    protected $userUid = null;

    /**
     * Current page uid
     *
     * @var int
     */
    protected $currentPage = null;

    /**
     * @param BookmarkRepository $bookmarkRepository
     */
    public function injectBookmarkRepository(BookmarkRepository $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * Initialize on every action
     */
    public function initializeAction()
    {
        $userAspect = GeneralUtility::makeInstance(Context::class)->getAspect('frontend.user');
        $this->userUid = $userAspect->get('id');
        $this->currentPage = (int)$GLOBALS['TSFE']->id;
    }

    /**
     * Widget
     *
     * @return void
     */
    public function widgetAction()
    {
        if ($this->userUid) {
            $this->view->assign(
                'bookmarks',
                $this->bookmarkRepository->findBookmarksListByUser($this->userUid)
            );
        }
    }

    /**
     * Add to bookmarks form/button
     *
     * @return void
     */
    public function addAction()
    {
        $pageAllowed = !GeneralUtility::inList($this->settings['excludePages'] ?? '', $this->currentPage);

        if ($pageAllowed && $this->userUid) {
            $identificatorValue = $this->getIdentificatorValue();

            $bookmarks = $this->bookmarkRepository->findBookmarkByUserAndPageID(
                $this->userUid,
                $this->currentPage,
                $identificatorValue
            );

            $isPageFavorite = ($bookmarks->count() > 0);

            $this->view->assignMultiple([
                'isPageFavorite' => $isPageFavorite,
                'identificatorValue' => $identificatorValue
            ]);
        }
    }

    /**
     * action remove
     *
     * @param int $pageId pageId
     * @param int $identificatorValue special identificator
     * @param bool $ajax if call ajax
     * @return mixed|void
     */
    public function removeAction(int $pageId = null, int $identificatorValue = null, bool $ajax = null)
    {
        $pageId = $pageId ?? $this->currentPage;

        if ($this->userUid) {
            $bookmarks = $this->bookmarkRepository->findBookmarkByUserAndPageID(
                $this->userUid,
                $pageId,
                $identificatorValue
            );

            foreach ($bookmarks as $bookmark) {
                $this->bookmarkRepository->remove($bookmark);
            }
        }

        if ($ajax) {
            return json_encode([
                'status' => true,
                'text' => LocalizationUtility::translate('remove_from_favorites_success', $this->extensionName),
            ]);
        }

        $this->redirect('widget');
    }

    /**
     * Create new bookmark
     *
     * @param int $identificatorValue
     * @return string
     */
    public function newAction(int $identificatorValue = null)
    {
        $status = false;

        if ($this->userUid) {
            $bookmark = $this->objectManager->get(Bookmark::class);
            $bookmark->setFeuserid($this->userUid);
            $bookmark->setPageid($this->currentPage);

            if (!is_null($identificatorValue)) {
                $bookmark->setSpecialIdentificator($identificatorValue);
            }

            $this->bookmarkRepository->add($bookmark);
            $status = true;
        }

        $response = [
            'status' => $status,
            'text' => LocalizationUtility::translate('add_to_favorites_success', $this->extensionName)
        ];

        return json_encode($response);
    }

    /**
     * Get special identificator Value
     *
     * @return mixed
     */
    protected function getIdentificatorValue()
    {
        $configuration = $this->getSpecialPageConfiguration($this->currentPage);
        if ($configuration === null || empty($configuration['identificatorParam'])) {
            return null;
        }

        $params = GeneralUtility::_GET();
        ArrayUtility::mergeRecursiveWithOverrule($params, GeneralUtility::_POST());

        try {
            return ArrayUtility::getValueByPath($params, $configuration['identificatorParam'], '|');
        } catch (MissingArrayPathException $exception) {
            return null;
        }
    }
}
