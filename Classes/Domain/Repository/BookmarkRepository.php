<?php

namespace Pixelant\PxaFeuserbookmarks\Domain\Repository;

use Pixelant\PxaFeuserbookmarks\Domain\Model\Bookmark;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;


/**
 *
 *
 * @package pxa_feuserbookmarks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BookmarkRepository extends FrontendUserRepository
{

    /**
     * Find bookmark for given page and user
     *
     * @param int $userId
     * @param int $pageId
     * @param int $identificatorValue
     * @return QueryResultInterface
     */
    public function findBookmarkByUserAndPageID(int $userId, int $pageId, $identificatorValue = null)
    {
        $query = $this->createQuery();
        $constraints[] = $query->equals('feuserid', $userId);
        $constraints[] = $query->equals('pageid', $pageId);

        if ($identificatorValue !== null) {
            $constraints[] = $query->equals('specialIdentificator', $identificatorValue);
        }

        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * Get bookmarks for user
     *
     * @param int $userUid
     * @return array
     */
    public function findBookmarksListByUser(int $userUid): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_pxafeuserbookmarks_domain_model_bookmark');

        $rows = $queryBuilder
            ->select('bookmarks.*')
            ->from('tx_pxafeuserbookmarks_domain_model_bookmark', 'bookmarks')
            ->join(
                'bookmarks',
                'pages',
                'pages',
                $queryBuilder->expr()->eq(
                    'bookmarks.pageid',
                    $queryBuilder->quoteIdentifier('pages.uid')
                )
            )
            ->where($queryBuilder->expr()->eq(
                'bookmarks.feuserid',
                $queryBuilder->createNamedParameter($userUid, \PDO::PARAM_INT)
            ))
            ->execute()
            ->fetchAll();

        if (!empty($rows)) {
            return $this->objectManager->get(DataMapper::class)->map(Bookmark::class, $rows);
        }

        return [];
    }
}
