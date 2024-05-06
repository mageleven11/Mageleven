<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Mageleven\LazyLoad\Plugin\Mageleven\WebP\Api;

use Mageleven\LazyLoad\Model\Config;

/**
 * Class WebPPlugin
 */
class HtmlParserInterfacePlugin
{

    /**
     * @var Config
     */
    private $config;

    /**
     * WebPPlugin constructor.
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param $subject
     * @param callable $proceed
     * @param $imagePath
     * @param $htmlTag
     * @return mixed|string|string[]|null
     */
    public function aroundGetNewHtmlTag($subject, callable $proceed, $imagePath, $image)
    {
        if (!$this->config->getEnabled() || !$this->config->getIsJavascriptLazyLoadMethod()) {
            return $proceed($imagePath, $image);
        }

        $originImagePath = $imagePath;

        if (strpos($imagePath, 'Mageleven_LazyLoad/images/pixel.jpg')) {

            $doStr = 'data-original="';
            $p1 = strpos($image, $doStr);

            if ($p1 !== false) {
                $p1 += strlen($doStr);
                $p2 = strpos($image, '"', $p1);
                if ($p2 !== false) {
                    $imagePath = substr($image, $p1, $p2 - $p1);
                }
            }
        }

        $html = $proceed($imagePath, $image);

        if ($originImagePath != $imagePath) {

            if (strpos($html, '<picture') !== false) {
                $tmpSrc = 'TMP_SRC';
                $pixelSrc = 'srcset="' . $originImagePath . '"';

                $html = str_replace($pixelSrc, $tmpSrc, $html);

                $html = preg_replace('#<source([^>]*)(?:\ssrcset="([^"]*)")([^>]*)?>#isU', '<source ' . $pixelSrc .
                    ' data-originalset="$2" $1 $3/>', $html);

                $html = str_replace($tmpSrc, $pixelSrc, $html);
            }
        }

        return $html;
    }
}
