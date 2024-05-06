<?php
/**
 * @category  Mageleven
 * @package   Mageleven_ImageOptimizer
 * @author    Mageleven
 * @copyright Copyright (c) Mageleven (http://www.mageleven.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Mageleven\ImageOptimizer\Model\Config;

use Magento\Framework\Exception\LocalizedException;

class Paths extends \Magento\Framework\App\Config\Value
{
    /**
     * Validate and prepare data before saving config value.
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        
        $pattern = '/^[\p{L}\p{N}_,;:!&#\+\*\$\?\|\'\.\-\ \/]+$/iu';
        $validator = preg_match($pattern, $value);
        
        if (!$validator) {
            $message = __(
                'Please correct Paths: "%1".',
                $value
            );
            throw new LocalizedException($message);
        }
        
        return $this;
    }
}
