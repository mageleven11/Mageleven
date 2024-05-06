<?php
namespace Custom\Field\Controller\Account;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filesystem\Io\File;

class RegisterController extends Action
{
    protected $customerFactory;
    protected $accountManagement;
    protected $customerRepository;
    protected $resultJsonFactory;
    protected $file;

    public function __construct(
        Context $context,
        CustomerFactory $customerFactory,
        AccountManagementInterface $accountManagement,
        CustomerRepositoryInterface $customerRepository,
        JsonFactory $resultJsonFactory,
        File $file
    ) {
        parent::__construct($context);
        $this->customerFactory = $customerFactory;
        $this->accountManagement = $accountManagement;
        $this->customerRepository = $customerRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->file = $file;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                // File upload handling
                if (isset($_FILES['skype']) && is_array($_FILES['skype']) && !empty($_FILES['skype']['name'])) {
                    $uploadDir = 'pub/media/skype'; // Replace with your desired upload directory
                    $uploadedFile = $_FILES['skype'];
                    $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                    $newFileName = 'custom_filename.' . $fileExtension;

                    $this->file->mv($uploadedFile['tmp_name'], $uploadDir . '/' . $newFileName);
                }

                // Process user registration data
                $customer = $this->customerFactory->create();
                $customer->setEmail($data['email']);
                $customer->setFirstname($data['firstname']);
                $customer->setLastname($data['lastname']);
                $customer->setPassword($data['password']); // Corrected method name
                $customer->setSkype($data['skype']); // Corrected method name
                // Set other customer data fields based on your form fields

                // Save customer
                $customer = $this->accountManagement->createAccount($customer);
                $customer->setCustomAttribute('skype', $newFileName); // Assuming Skype Account is saved as a file name

                $this->customerRepository->save($customer);

                return $result->setData(['success' => true, 'message' => 'User registered successfully']);
            } catch (\Exception $e) {
                return $result->setData(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        return $result->setData(['success' => false, 'message' => 'Invalid data submitted.']);
    }
}
