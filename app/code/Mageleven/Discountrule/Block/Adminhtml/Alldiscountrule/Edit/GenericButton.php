<?php

namespace Mageleven\Discountrule\Block\Adminhtml\Alldiscountrule\Edit;

use Magento\Backend\Block\Widget\Context;
use Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $alldiscountruleRepository;
    
    public function __construct(
        Context $context,
        AlldiscountruleRepositoryInterface $alldiscountruleRepository
    ) {
        $this->context = $context;
        $this->alldiscountruleRepository = $alldiscountruleRepository;
    }

    public function getDiscountruleId()
    {
        try {
            return $this->alldiscountruleRepository->getById(
                $this->context->getRequest()->getParam('discountrule_id')
            )->getId();
        }
		catch (NoSuchEntityException $e) {
        
		}
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
