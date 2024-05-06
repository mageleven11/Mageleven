<?php
namespace Mageleven\Contributors\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper 
{
    protected $allNewsFactory;
    protected $resultPageFactory;
    protected $allcontactsupporttypeFactory;
    protected $faqFactory;

    public function __construct
    (
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mageleven\Contributors\Model\AllcontactsupporttypeFactory $allcontactsupporttypeFactory,
        \Sparsh\Faq\Model\FaqFactory $faqFactory
        
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->allcontactsupporttypeFactory = $allcontactsupporttypeFactory;
        $this->faqFactory = $faqFactory;
    }

    public function getContactSupportType()
    {
        $allcontactsupporttype = $this->allcontactsupporttypeFactory->create();
        $contactsupporttypeCollection = $allcontactsupporttype->getCollection();
        return $contactsupporttypeCollection;
    }

    public function getContactSupportFaq()
    {
        $allcontactsupportfaq = $this->faqFactory->create();
        $contactsupportfaqCollection = $allcontactsupportfaq->getCollection()->addFieldToFilter('faq_category_id',2)->addFieldToFilter('is_active',1);
        return $contactsupportfaqCollection;
    }

    public function getAffiliateFaq()
    {
        $allcontactsupportfaq = $this->faqFactory->create();
        $contactsupportfaqCollection = $allcontactsupportfaq->getCollection()->addFieldToFilter('faq_category_id',3)->addFieldToFilter('is_active',1);
        return $contactsupportfaqCollection;
    }

    public function getAllFaq()
    {
        $allcontactsupportfaq = $this->faqFactory->create();
        $contactsupportfaqCollection = $allcontactsupportfaq->getCollection()->addFieldToFilter('is_active',1);
        return $contactsupportfaqCollection;
    }
}