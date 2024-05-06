<?php
namespace Mageleven\Career\Controller\Adminhtml\Allcareer;

use Magento\Backend\App\Action\Context;
use Mageleven\Career\Api\AllcareerRepositoryInterface as AllcareerRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Mageleven\Career\Api\Data\AllcareerInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $allcareerRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        AllcareerRepository $allcareerRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->allcareerRepository = $allcareerRepository;
        $this->jsonFactory = $jsonFactory;
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Mageleven_Career::save');
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

        foreach (array_keys($postItems) as $careerId) {
            $career = $this->allcareerRepository->getById($careerId);
            try {
                $careerData = $postItems[$careerId];
                $extendedCareerData = $career->getData();
                $this->setCareerData($career, $extendedCareerData, $careerData);
                $this->allcareerRepository->save($career);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithCareerId($career, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithCareerId($career, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithCareerId(
                    $career,
                    __('Something went wrong while saving the career.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithCareerId(AllcareerInterface $career, $errorText)
    {
        return '[Career ID: ' . $career->getId() . '] ' . $errorText;
    }

    public function setCareerData(\Mageleven\Career\Model\Allcareer $career, array $extendedCareerData, array $careerData)
    {
        $career->setData(array_merge($career->getData(), $extendedCareerData, $careerData));
        return $this;
    }
}
