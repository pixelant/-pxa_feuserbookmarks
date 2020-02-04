<?php
declare(strict_types=1);

namespace Pixelant\PxaFeuserbookmarks\ViewHelpers;

use Pixelant\PxaFeuserbookmarks\Domain\Model\Bookmark;
use Pixelant\PxaFeuserbookmarks\Domain\Settings\AbleFetchSpecialPageConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * @package Pixelant\PxaFeuserbookmarks\ViewHelpers
 */
class BookmarkUrlViewHelper extends AbstractTagBasedViewHelper
{
    const IDENTIFICATOR_PLACEHOLDER = '###IDENTIFICATOR###';

    use AbleFetchSpecialPageConfiguration;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * View helper arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('bookmark', Bookmark::class, 'Bookmark object', true);
        $this->registerArgument('settings', 'array', 'Plugin settings', true);

        $this->registerUniversalTagAttributes();
    }

    /**
     * @return string Rendered link
     */
    public function render()
    {
        $this->settings = $this->arguments['settings'];
        /** @var Bookmark $bookmark */
        $bookmark = $this->arguments['bookmark'];

        $pageConfiguration = $this->getSpecialPageConfiguration($bookmark->getPageid());

        if ($pageConfiguration && !empty($pageConfiguration['urlParams'])) {
            $additionalParams = GeneralUtility::explodeUrl2Array(str_replace(
                self::IDENTIFICATOR_PLACEHOLDER,
                $bookmark->getSpecialIdentificator(),
                $pageConfiguration['urlParams']
            ));
        }

        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
        $uri = $uriBuilder->reset()
            ->setTargetPageUid($bookmark->getPageid())
            ->setArguments($additionalParams ?? [])
            ->build();

        if ((string)$uri !== '') {
            $this->tag->addAttribute('href', $uri);
            $this->tag->setContent($this->renderChildren());
            $this->tag->forceClosingTag(true);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }
        return $result;
    }
}
