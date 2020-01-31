<?php
declare(strict_types=1);

namespace Pixelant\PxaFeuserbookmarks\Domain\Service;

use Pixelant\PxaFeuserbookmarks\Domain\Model\Bookmark;
use Pixelant\PxaFeuserbookmarks\Domain\Settings\AbleFetchSpecialPageConfiguration;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * @package Pixelant\PxaFeuserbookmarks\Domain\Service
 */
class BookmarkTitle
{
    use AbleFetchSpecialPageConfiguration;

    /**
     * Plugin settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Init
     *
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function __construct(ConfigurationManagerInterface $configurationManager)
    {
        $this->settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'PxaFeuserbookmarks'
        );
    }


    /**
     * Return title for bookmark
     *
     * @param Bookmark $bookmark
     * @return string
     */
    public function get(Bookmark $bookmark): string
    {
        if ($bookmark->getSpecialIdentificator()) {
            return $this->getSpecialTitle($bookmark);
        }

        return $this->getPageTitle($bookmark);
    }

    /**
     * Get regular page title for bookmark
     *
     * @param Bookmark $bookmark
     * @return string
     */
    protected function getPageTitle(Bookmark $bookmark): string
    {
        $page = $this->getPageRepository()->getPage($bookmark->getPageid());
        return $page ? $this->getPageRepository()->getPageOverlay($page)['title'] : '';
    }

    /**
     * Get special bookmark title, like for example news records
     *
     * @param Bookmark $bookmark
     * @return string
     */
    protected function getSpecialTitle(Bookmark $bookmark): string
    {
        $pageConfiguration = $this->getSpecialPageConfiguration($bookmark->getPageid());
        $field = $pageConfiguration['titleField'];
        $table = $pageConfiguration['tableName'];

        if ($field && $table) {
            $row = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable($table)
                ->select(
                    ['*'],
                    $table,
                    ['uid' => $bookmark->getSpecialIdentificator()]
                )
                ->fetch();

            if (is_array($row)) {
                $row = $this->overlayRecord($table, $row);

                return $row[$field];
            }
        }

        return '';
    }

    /**
     * Language uid
     *
     * @return int
     */
    protected function getLanguageId(): int
    {
        return GeneralUtility::makeInstance(Context::class)->getAspect('language')->getId();
    }

    /**
     * @return PageRepository
     */
    protected function getPageRepository(): PageRepository
    {
        if (TYPO3_MODE === 'FE') {
            return $GLOBALS['TSFE']->sys_page;
        }

        return GeneralUtility::makeInstance(PageRepository::class);
    }

    /**
     * Overlay record if language layer
     *
     * @param string $table
     * @param array $row
     * @return array
     */
    protected function overlayRecord(string $table, array $row): array
    {
        $languageId = $this->getLanguageId();
        if ($languageId > 0) {
            $row = $this->getPageRepository()->getRecordOverlay($table, $row, $languageId);
        }

        return $row;
    }
}
