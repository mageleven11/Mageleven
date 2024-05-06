<?php
namespace Mageleven\Shopbrand\Block\Widget;
// use Magento\Framework\App\Filesystem\DirectoryList;

class Brand extends \Mageleven\Shopbrand\Block\Brand implements \Magento\Widget\Block\BlockInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const DEFAULT_CACHE_TAG = 'MAGELEVEN_BRAND_WIDGET';

    protected function _construct()
    {
        $data = $this->_helper->getConfigModule('general');
        //$dataConvert = array('infinite', 'vertical', 'autoplay', 'centerMode');
        if(isset($data['slide'])){
            $data['vertical-Swiping'] = $data['vertical'];
            $breakpoints = $this->getResponsiveBreakpoints();
            $responsive = '[';
            $num = count($breakpoints);
            foreach ($breakpoints as $size => $opt) {
                $item = (int) $data[$opt];
                $responsive .= '{"breakpoint": '.$size.', "settings": {"slidesToShow": '.$item.'}}';
                $num--;
                if($num) $responsive .= ', ';
            }
            $responsive .= ']';
            $data['slides-To-Show'] = $data['visible'];
            $data['autoplay-Speed'] = $data['autoplay_speed'];
            $data['swipe-To-Slide'] = 'true';
            $data['responsive'] = $responsive;
        }

        $data['selector'] = 'alo-slider'.md5(rand());
        $this->addData($data);

        parent::_construct();

    }

    protected function getCacheLifetime()
    {
        return parent::getCacheLifetime() ?: 86400;
    }

    public function getCacheKeyInfo()
    {
        $keyInfo     =  parent::getCacheKeyInfo();
        $keyInfo[]   =  $this->_storeManager->getStore()->getStoreId();
        return $keyInfo;
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::DEFAULT_CACHE_TAG, self::DEFAULT_CACHE_TAG . '_' . $this->_storeManager->getStore()->getStoreId()];
    }

    public function getBrands()
    {
        return $this->getBrandCollection();
    }

    public function getUrlBrand($brand)
    { 
        return $this->_helper->getLinkBrand($brand);
    }

}
