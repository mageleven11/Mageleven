<?php

namespace Mageleven\Shopbrand\Model\System\Config;

class Link implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return array(
			array('value' => 0,				'label' => __('Shop By Brand Url')),
			array('value' => 1,				'label' => __('Quick Search Results')),
			array('value' => 2,				'label' => __('Advanced Search Results')),
			array('value' => 3,				'label' => __('Custom Extra Link')),
		);
	}
}

