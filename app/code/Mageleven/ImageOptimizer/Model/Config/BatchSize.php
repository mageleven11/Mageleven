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

class BatchSize extends \Magento\Framework\App\Config\Value
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
        
        $pattern = '/^[0-9]+$/';
        $validator = preg_match($pattern, $value);
        
        if (!$validator || $value < 1) {
            $message = __(
                'Please correct Batch Size: "%1".',
                $value
            );
            throw new LocalizedException($message);
        }
        
        return $this;
    }
}
