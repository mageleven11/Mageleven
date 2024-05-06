<?php
namespace Custom\Field\Model;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\CustomerFactory;

abstract class Account implements AccountManagementInterface
{
    protected $customerFactory;
    protected $customerRepository;

    public function __construct(
        CustomerFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    public function createAccount(CustomerInterface $customer, $password = null, $redirectUrl = '')
    {
        $customerModel = $this->customerFactory->create();
        $customerModel->setWebsiteId(1); // Set the appropriate website ID
        $customerModel->setEmail($customer->getEmail());
        $customerModel->setFirstname($customer->getFirstname());
        $customerModel->setLastname($customer->getLastname());

        // Set other customer attributes based on your form data

        $this->customerRepository->save($customerModel);

        return $customerModel;
    }
}
