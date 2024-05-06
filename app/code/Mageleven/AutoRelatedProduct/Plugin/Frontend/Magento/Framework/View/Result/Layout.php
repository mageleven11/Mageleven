<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Mageleven\AutoRelatedProduct\Plugin\Frontend\Magento\Framework\View\Result;

use Mageleven\AutoRelatedProduct\Block\RelatedProductList;
use Mageleven\AutoRelatedProduct\Api\ConfigInterface as Config;
use Magento\Framework\View\Result\Layout as SubjectLayout;
use Mageleven\AutoRelatedProduct\Api\PositionsInterface;
use Magento\Framework\App\RequestInterface;
use Mageleven\AutoRelatedProduct\Model\RuleManager;

class Layout
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var PositionsInterface
     */
    private $positionOptions;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var RuleManager
     */
    private $ruleManager;

    /**
     * @param Config $config
     * @param PositionsInterface $positionOptions
     * @param RequestInterface $request
     * @param RuleManager $ruleManager
     */
    public function __construct(
        Config                     $config,
        PositionsInterface         $positionOptions,
        RequestInterface           $request,
        RuleManager                $ruleManager
    ) {
        $this->positionOptions = $positionOptions;
        $this->config = $config;
        $this->request = $request;
        $this->ruleManager = $ruleManager;
    }

    /**
     * @param Layout $subject
     * @param $response
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeRenderResult(SubjectLayout $subject, $response)
    {
        if (!$this->config->isEnabled()) {
            return null;
        }

        /* @var $layout \Magento\Framework\View\Layout */
        $layout = $subject->getLayout();

        $currentLayout = (string)$this->request->getFullActionName();

        $containers = [
            'content.top',
            'content.bottom',
        ];

        $parentsArray = [];
        $options = $this->positionOptions->toOptionArray();

        for ($i = 0; $i < count($options); $i++) {
            if (is_array($options[$i]['value'])) {
                foreach ($options[$i]['value'] as $item) {
                    if (isset($item['parent'])) {
                        $parentsArray[$item['parent']][][$item['value']] = $item['value'];
                    }
                }
            }
        }

        $layoutElements = [];
        foreach ($parentsArray as $blockName => $positions) {
            if ($layout->getBlock($blockName)) {
                $layoutElements[] = $blockName;
            }
        }

        foreach ($containers as $container) {
            if (!$layout->isContainer($container)) {
                continue;
            }
            $layoutElements[] = $container;
        }

        foreach ($layoutElements as $layoutElement) {
            foreach ($parentsArray[$layoutElement] as $position) {
                $containerName = $layout->getParentName($layoutElement);

                if (!$containerName || !$this->isBlockAvailableOnCurrentPageType($position, $currentLayout)) {
                    continue;
                }

                if (!$rule = $this->ruleManager->getRuleForPosition($position)) {
                    continue;
                }

                $after = str_contains($rule->getBlockPosition(), 'after');
                $ruleBlockName = $rule->getRuleBlockIdentifier();
                $layout
                    ->addBlock(RelatedProductList::class, $ruleBlockName, $containerName)
                    ->setData('rule', $rule);
                $layout->reorderChild($containerName, $ruleBlockName, $layoutElement, $after);
            }
        }
    }

    /**
     * Check block position page type is the same as current page type [category | product | cart]
     * @param array $position
     * @param string $currentLayout
     * @return bool
     */
    private function isBlockAvailableOnCurrentPageType(array $position, string $currentLayout): bool
    {
        $position = array_shift($position);
        $position = explode('_', $position)[0];
        $currentLayout = explode('_', $currentLayout)[1];

        return (bool)($position === $currentLayout);
    }
}
