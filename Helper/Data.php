<?php
namespace Bluethinkinc\LoginAsCustomer\Helper;

use Magento\Customer\Model\Customer;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Psr\Log\LoggerInterface;
use Magento\Customer\Model\CustomerFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    public const CONFIG_MODULE_PATH = 'loginascustomer';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var AuthorizationInterface
     */
    protected $_authorization;

    /**
     * This is a inlineTranslation
     *
     * @var inlineTranslation $inlineTranslation
     */
    protected $inlineTranslation;
    /**
     * This is a transportBuilder
     *
     * @var transportBuilder $transportBuilder
     */
    protected $transportBuilder;
    /**
     * @var logger
     */
    protected $logger;
    /**
     * @var customer
     */
    protected $customer;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param AuthorizationInterface $authorization
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param LoggerInterface $logger
     * @param CustomerFactory $customer
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        AuthorizationInterface $authorization,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        LoggerInterface $logger,
        CustomerFactory $customer
    ) {
        $this->storeManager   = $storeManager;
        $this->_authorization = $authorization;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
        $this->customer = $customer;
        parent::__construct($context);
    }

    /**
     * This is a getConfig function
     *
     * @param  string $key
     * @param  null|int $store
     * @return null|string
     */
    public function getConfig($key, $store = null)
    {
        $store  = $this->storeManager->getStore($store);
        $result = $this->scopeConfig->getValue(
            'bluethink_admin_login_as_customer/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        return $result;
    }

    /**
     * This is isLoginnotification function
     *
     * @return boolean
     */
    public function isLoginnotification()
    {
        return $this->getConfig('general/login_notification_customer');
    }
    /**
     * This is a isSender function
     *
     * @return boolean
     */
    public function isSender()
    {
        return $this->getConfig('general/sender');
    }
    /**
     * This is isEmailTemplate function
     *
     * @return boolean
     */
    public function isEmailTemplate()
    {
        return $this->getConfig('general/email_template');
    }

    /**
     * This is isEnabled function
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getConfig('general/enabled');
    }
    
    /**
     * This is isAllowed function
     *
     * @return boolean
     */
    public function isAllowed()
    {
        return $this->isEnabled() && $this->_authorization->isAllowed('Bluethinkinc_LoginAsCustomer::allow');
    }

    /**
     * THis is getStore function
     *
     * @param Customer $customer
     *
     * @return StoreInterface|null
     * @throws NoSuchEntityException
     */
    public function getStore($customer)
    {
        if ($storeId = $customer->getStoreId()) {
            return $this->storeManager->getStore($storeId);
        }

        return $this->storeManager->getDefaultStoreView();
    }

    /**
     * This is a sendEmail
     *
     * @param customerdetails $customerdetails
     */
    public function sendEmail($customerdetails)
    {
        $admin_name = $customerdetails['admin_name'];
        $admin_email = $customerdetails['admin_email'];
        $customer_email = $customerdetails['customer_email'];
        $customer_name = $customerdetails['customer_name'];
        $store = $customerdetails['store'];
        $email_subject=$this->getEmailsubject();
            $this->logger->debug('Admin login as a customer start');
            $data = [
            'customer_name' => $customer_name,
            'admin_name' => $admin_name,
            'admin_email' => $admin_email,
            'customer_email' => $customer_email,
            'email_subject' => $email_subject
            ];
                $this->logger->debug('toEmail == ' . $customer_email);
                $this->inlineTranslation->suspend();
                $template = $this->getEmailTemplate();
                $this->logger->debug($template);
                $sender = $this->getEmailSender();
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($template)
                    ->setTemplateOptions(
                        [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $store
                        ]
                    )
                    ->setTemplateVars($data)
                    ->setFrom($sender)
                    ->addTo($customer_email)
                    ->getTransport();
        try {
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            //return 1;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
            $this->inlineTranslation->resume();
            $this->logger->debug('Admin login as a customer end');
    }
    /**
     * This is getEmailTemplate function
     *
     * @return boolean
     */
    public function getEmailTemplate()
    {
        return $this->getConfig('general/email_template');
    }
    /**
     * This is getEmailSender function
     *
     * @return boolean
     */
    public function getEmailSender()
    {
        return $this->getConfig('general/sender');
    }
    /**
     * This is getEmailEnable function
     *
     * @return boolean
     */
    public function getEmailEnable()
    {
        return $this->getConfig('general/login_notification_customer');
    }
     /**
      * This is getCustomerByEmail function
      *
      * @param string $email
      * @return boolean
      */
    public function getCustomerByEmail($email)
    {
        $websiteID = $this->storeManager->getStore()->getWebsiteId();
        $customer = $this->customer->create()->setWebsiteId($websiteID)->loadByEmail($email);
        return $customer->getId();
    }
    /**
     * This is getSelectlayouts function
     *
     * @return boolean
     */
    public function getSelectlayouts()
    {
        return $this->getConfig('general/select_option_bt_login');
    }
    /**
     * This is get email subject function
     *
     * @return boolean
     */
    public function getEmailsubject()
    {
        return $this->getConfig('general/notify_email_subject');
    }
}
