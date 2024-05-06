<?php
namespace Mageleven\Contributors\Block\Adminhtml\Allcontactsupporttype\Edit;

use Magento\Backend\Block\Widget\Context;
use Mageleven\Contributors\Api\AllcontactsupporttypeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allcontactsupporttypeRepository;
    
    public function __construct(
        Context $context,
        AllcontactsupporttypeRepositoryInterface $allcontactsupporttypeRepository
    ) {
        $this->context = $context;
        $this->allcontactsupporttypeRepository = $allcontactsupporttypeRepository;
    }

    public function getContactsupporttypeId()
    {
        try {
            return $this->allcontactsupporttypeRepository->getById(
                $this->context->getRequest()->getParam('cs_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}