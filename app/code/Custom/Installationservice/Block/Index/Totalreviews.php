<?php

namespace Custom\Installationservice\Block\Index;

use Magento\Framework\View\Element\Template;
use Custom\Installationservice\Model\CustomReviewFactory;

class Totalreviews extends Template
{
    protected $customReviewFactory;

    public function __construct(
        Template\Context $context,
        CustomReviewFactory $customReviewFactory,
        array $data = []
    ) {
        $this->customReviewFactory = $customReviewFactory;
        parent::__construct($context, $data);
    }

    public function getCustomReviews()
    {
        $customReviewModel = $this->customReviewFactory->create();
        $collection = $customReviewModel->getCollection();
        return $collection;
    }
}
