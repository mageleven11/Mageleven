<?php
namespace Magecomp\Mobileloginfree\Model\Api;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Backend\App\ConfigInterface;
use Magento\Customer\Model\CustomerAuthUpdate;
use Magento\Framework\Stdlib\DateTime;
use Magento\Integration\Model\Oauth\TokenFactory;
use Magecomp\Mobileloginfree\Helper\Data;


class Mobilelogin implements \Magecomp\Mobileloginfree\Api\MobileloginfreeInterface
{

    protected $_helperdata;
    protected $backendConfig;
    protected $encryptor;
    private $customerAuthUpdate;
    protected $dateTime;
    protected $tokenModelFactory;
    protected $customerRegistry;
    const LOCKOUT_THRESHOLD_PATH = 'customer/password/lockout_threshold';
    const MAX_FAILURES_PATH = 'customer/password/lockout_failures';


    public function __construct(Data $helper,
                                TokenFactory $tokenModelFactory,
                                Encryptor $encryptor,
                                CustomerRegistry $customerRegistry,
                                ConfigInterface $backendConfig,
                                CustomerAuthUpdate $customerAuthUpdate,
                                DateTime $dateTime

    ) {
          $this->_helperdata=$helper;
          $this->tokenModelFactory = $tokenModelFactory;
          $this->encryptor = $encryptor;
          $this->customerRegistry = $customerRegistry;
          $this->backendConfig = $backendConfig;
          $this->customerAuthUpdate = $customerAuthUpdate;
        $this->dateTime = $dateTime;
    }

    public function getLogin($mobileEmail, $password)
    {
        try {
            if (empty($mobileEmail) || empty($password)) {
                return array(array("status"=>false, "message"=>__("Invalid parameter list.")));
            }

            $response = array();

            if (is_numeric($mobileEmail)) {
                $collection = $this->_helperdata->checkCustomerExists($mobileEmail, "mobile");
            } else {
                $collection = $this->_helperdata->checkCustomerExists($mobileEmail, "email");
            }

            if (count($collection) == 0) {
                return array(array("status"=>false, "message"=>__("Customer does not exist.")));
            } else {
                $customerItem = $collection->getFirstItem();
                $customerId = $customerItem->getId();
            }

            if($this->authenticate($customerId, $password)) {
                $token = $this->tokenModelFactory->create()->createCustomerToken($customerId)->getToken();
                $response['status'] = true;
                $response['token'] = $token;
            } else {
                $response = array("status"=>false, "message"=>__("Customer does not exists."));
            }

            return array($response);
        } catch (\Exception $e) {
            throw new AuthenticationException(__($e->getMessage()));
        }
    }

    public function authenticate($customerId, $password)
    {
        $customerSecure = $this->customerRegistry->retrieveSecureData($customerId);
        $hash = $customerSecure->getPasswordHash() ?? '';
        if (!$this->encryptor->validateHash($password, $hash)) {
            $this->processAuthenticationFailure($customerId);
            if ($this->isLocked($customerId)) {
                throw new LocalizedException(__('The account is locked.'));
            }

            throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
        }

        return true;
    }
    protected function getLockThreshold()
    {
        return $this->backendConfig->getValue(self::LOCKOUT_THRESHOLD_PATH) * 60;
    }
    protected function getMaxFailures()
    {
        return $this->backendConfig->getValue(self::MAX_FAILURES_PATH);
    }
    public function processAuthenticationFailure($customerId)
    {
        $now = new \DateTime();
        $lockThreshold = $this->getLockThreshold();
        $maxFailures =  $this->getMaxFailures();
        $customerSecure = $this->customerRegistry->retrieveSecureData($customerId);

        if (!($lockThreshold && $maxFailures)) {
            return;
        }

        $failuresNum = (int)$customerSecure->getFailuresNum() + 1;

        $firstFailureDate = $customerSecure->getFirstFailure();
        if ($firstFailureDate) {
            $firstFailureDate = new \DateTime($firstFailureDate);
        }

        $lockThreshInterval = new \DateInterval('PT' . $lockThreshold . 'S');
        $lockExpires = $customerSecure->getLockExpires();
        $lockExpired = ($lockExpires !== null) && ($now > new \DateTime($lockExpires));

        if (1 === $failuresNum || !$firstFailureDate || $lockExpired) {
            $customerSecure->setFirstFailure($this->dateTime->formatDate($now));
            $failuresNum = 1;
            $customerSecure->setLockExpires(null);

        } elseif ($failuresNum >= $maxFailures) {
            $customerSecure->setLockExpires($this->dateTime->formatDate($now->add($lockThreshInterval)));
        }

        $customerSecure->setFailuresNum($failuresNum);
        $this->customerAuthUpdate->saveAuth($customerId);
    }

    public function isLocked($customerId)
    {
        $currentCustomer = $this->customerRegistry->retrieve($customerId);
        return $currentCustomer->isCustomerLocked();
    }
}
