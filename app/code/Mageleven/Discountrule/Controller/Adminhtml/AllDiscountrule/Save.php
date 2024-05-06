<?php

namespace Mageleven\Discountrule\Controller\Adminhtml\Alldiscountrule;

use Magento\Backend\App\Action;
use Mageleven\Discountrule\Model\Alldiscountrule;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Mageleven\Discountrule\Model\AlldiscountruleFactory
     */
    private $alldiscountruleFactory;

    /**
     * @var \Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface
     */
    private $alldiscountruleRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Mageleven\Discountrule\Model\AlldiscountruleFactory $alldiscountruleFactory
     * @param \Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface $alldiscountruleRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Mageleven\Discountrule\Model\AlldiscountruleFactory $alldiscountruleFactory = null,
        \Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface $alldiscountruleRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->alldiscountruleFactory = $alldiscountruleFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Discountrule\Model\AlldiscountruleFactory::class);
        $this->alldiscountruleRepository = $alldiscountruleRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface::class);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Mageleven_Discountrule::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Alldiscountrule::STATUS_ENABLED;
            }
            if (empty($data['discountrule_id'])) {
                $data['discountrule_id'] = null;
            }

            /** @var \Mageleven\Discountrule\Model\Alldiscountrule $model */
            $model = $this->alldiscountruleFactory->create();

            $id = $this->getRequest()->getParam('discountrule_id');
            if ($id) {
                try {
                    $model = $this->alldiscountruleRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This discountrule no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'discountrule_alldiscountrule_prepare_save',
                ['alldiscountrule' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->alldiscountruleRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the discountrule.'));
                $this->dataPersistor->clear('discountrule_alldiscountrule');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['discountrule_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the discountrule.'));
            }

            $this->dataPersistor->set('discountrule_alldiscountrule', $data);
            return $resultRedirect->setPath('*/*/edit', ['discountrule_id' => $this->getRequest()->getParam('discountrule_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
