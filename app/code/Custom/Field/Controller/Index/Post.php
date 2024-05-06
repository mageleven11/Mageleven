<?php
namespace Custom\Field\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Request\DataPersistorInterface; // Highlighted line
use Magento\Framework\Message\ManagerInterface; // Add this line

class Post extends \Magento\Contact\Controller\Index\Post
{
    protected $resultRedirect;
    protected $contactsConfig;
    protected $mail;
    protected $dataPersistor; // Highlighted line
    protected $messageManager; // Add this line


    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor, // Highlighted line
        ManagerInterface $messageManager, // Add this line

        ResultFactory $resultFactory
    ) {
        $this->contactsConfig = $contactsConfig;
        $this->mail = $mail;
        $this->dataPersistor = $dataPersistor; // Highlighted line
        $this->resultRedirect = $resultFactory;
        $this->messageManager = $messageManager; // Add this line
        parent::__construct($context, $contactsConfig, $mail, $dataPersistor);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect('contact/index');
            return;
        }


        $this->sendEmail($post);
        $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));

        // Your form processing logic here
        $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
        // Redirect to the previous page
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
    protected function sendEmail($post)
        {
            $this->mail->send(
                $post['email'],
                ['data' => $post]
            );
        }
}
