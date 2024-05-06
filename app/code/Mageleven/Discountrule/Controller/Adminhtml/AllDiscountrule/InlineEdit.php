<?php
namespace Mageleven\Discountrule\Controller\Adminhtml\Alldiscountrule;

use Magento\Backend\App\Action\Context;
use Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface as AlldiscountruleRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Mageleven\Discountrule\Api\Data\AlldiscountruleInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $alldiscountruleRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        AlldiscountruleRepository $alldiscountruleRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->alldiscountruleRepository = $alldiscountruleRepository;
        $this->jsonFactory = $jsonFactory;
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
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $discountruleId) {
            $discountrule = $this->alldiscountruleRepository->getById($discountruleId);
            try {
                $discountruleData = $postItems[$discountruleId];
                $extendedDiscountruleData = $discountrule->getData();
                $this->setDiscountruleData($discountrule, $extendedDiscountruleData, $discountruleData);
                $this->alldiscountruleRepository->save($discountrule);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithDiscountruleId($discountrule, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithDiscountruleId($discountrule, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithDiscountruleId(
                    $discountrule,
                    __('Something went wrong while saving the discountrule.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithDiscountruleId(AlldiscountruleInterface $discountrule, $errorText)
    {
        return '[Discountrule ID: ' . $discountrule->getId() . '] ' . $errorText;
    }

    public function setDiscountruleData(\Mageleven\Discountrule\Model\Alldiscountrule $discountrule, array $extendedDiscountruleData, array $discountruleData)
    {
        $discountrule->setData(array_merge($discountrule->getData(), $extendedDiscountruleData, $discountruleData));
        return $this;
    }
}
