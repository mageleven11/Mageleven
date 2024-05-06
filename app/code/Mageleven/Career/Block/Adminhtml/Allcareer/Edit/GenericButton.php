<?php

namespace Mageleven\Career\Block\Adminhtml\Allcareer\Edit;

use Magento\Backend\Block\Widget\Context;
use Mageleven\Career\Api\AllcareerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allcareerRepository;
    
    public function __construct(
        Context $context,
        AllcareerRepositoryInterface $allcareerRepository
    ) {
        $this->context = $context;
        $this->allcareerRepository = $allcareerRepository;
    }

    public function getCareerId()
    {
        try {
            return $this->allcareerRepository->getById(
                $this->context->getRequest()->getParam('career_id')
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
