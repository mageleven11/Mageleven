<?php
namespace Mageleven\Contributors\Controller\Adminhtml\Allcontactsupporttype;

use Magento\Backend\App\Action;
use Mageleven\Contributorss\Model\Allcontactsupporttype;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    
    private $allcontactsupporttypeFactory;

    
    private $allcontactsupporttypeRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Mageleven\Contributors\Model\AllcontactsupporttypeFactory $allcontactsupporttypeFactory = null,
        \Mageleven\Contributors\Api\AllcontactsupporttypeRepositoryInterface $allcontactsupporttypeRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allcontactsupporttypeFactory = $allcontactsupporttypeFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Contributors\Model\AllcontactsupporttypeFactory::class);
        $this->allcontactsupporttypeRepository = $allcontactsupporttypeRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Contributors\Api\AllcontactsupporttypeRepositoryInterface::class);
        parent::__construct($context);
    }
    
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mageleven_Contributors::save');
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
                $data['status'] = Allcontactsupporttype::STATUS_ENABLED;
            }
            if (empty($data['cs_id'])) {
                $data['cs_id'] = null;
            }

            
            $model = $this->allcontactsupporttypeFactory->create();

            $id = $this->getRequest()->getParam('cs_id');
            if ($id) {
                try {
                    $model = $this->allcontactsupporttypeRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This type no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'contributors_allcontactsupporttype_prepare_save',
                ['allcontactsupporttype' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allcontactsupporttypeRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the type.'));
                $this->dataPersistor->clear('contributors_allcontactsupporttype');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['cs_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the type.'));
            }

            $this->dataPersistor->set('contributors_allcontactsupporttype', $data);
            return $resultRedirect->setPath('*/*/edit', ['cs_id' => $this->getRequest()->getParam('cs_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}