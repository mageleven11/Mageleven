<?php
/**
 * Mageleven
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageleven.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageleven.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category  Mageleven
 * @package   Mageleven_SocialLogin
 * @copyright Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license   https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\SocialLogin\Model\Providers;

use Hybridauth\Provider\MicrosoftGraph as MicrosoftGraphLib;

/**
 * Class MicrosoftGraph
 * @package Mageleven\SocialLogin\Model\Providers
 */
class MicrosoftGraph extends MicrosoftGraphLib
{

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        $this->config->set('tenant', 'consumers');

        parent::initialize();
    }
}
