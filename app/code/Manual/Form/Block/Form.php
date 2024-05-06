<?php
namespace Manual\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Form extends Template
{
    protected $formData;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);

        // Your logic to retrieve dynamic data
        $this->formData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'company' => 'ABC Company',
            'phone' => '1234567890',
            'message' => 'Hi, there! I would like...',
        ];
    }

    public function getFormData()
    {
        return $this->formData;
    }
}
