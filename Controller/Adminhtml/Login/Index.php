<?php
namespace Bluethinkinc\LoginAsCustomer\Controller\Adminhtml\Login;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url;
use Bluethinkinc\LoginAsCustomer\Helper\Data;
use Bluethinkinc\LoginAsCustomer\Model\LoginAsCustomerFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Bluethinkinc_LoginAsCustomer::allow';

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Bluethinkinc\LoginAsCustomer\Model\LoginAsCustomerFactory
     */
    protected $loginAsCustomerFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezoneInterface;

    /**
     * @param Context $context
     * @param LoginAsCustomerFactory $loginAsCustomerFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Bluethinkinc\LoginAsCustomer\Helper\Data $helper
     * @param TimezoneInterface $timezoneInterface
     */
    public function __construct(
        Context $context,
        LoginAsCustomerFactory $loginAsCustomerFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Bluethinkinc\LoginAsCustomer\Helper\Data $helper,
        TimezoneInterface $timezoneInterface
    ) {
        parent::__construct($context);
        $this->loginAsCustomerFactory = $loginAsCustomerFactory;
        $this->authSession         = $authSession;
        $this->_orderRepository    = $orderRepository;
        $this->_customerRepository = $customerRepository;
        $this->helper              = $helper;
        $this->timezoneInterface = $timezoneInterface;
    }

    /**
     * Get Current User
     *
     * @return \Magento\User\Model\User
     */
    public function getCurrentUser()
    {
        return $this->authSession->getUser();
    }

    /**
     * This is execute function
     *
     * @return ResponseInterface|ResultInterface
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function execute()
    {
        try {
            $params   = $this->getRequest()->getParams();
            $customer = $this->_customerRepository->getById($params['customer_id']);
            $store  = $this->helper->getStore($customer);
            $customer_name=$customer->getFirstName().' '.$customer->getLastName();
            $customerdetails = ['admin_name' =>
             $this->getCurrentUser()->getUsername(),
             'admin_email' => $this->getCurrentUser()->getEmail(),
             'customer_email'=>$customer->getEmail(),
             'store'=>$customer->getStoreId(),
             'customer_name' =>$customer_name];
            $getEmailEnable=$this->helper->getEmailEnable();
            if ($getEmailEnable) {
                $this->helper->sendEmail($customerdetails);
            }
            $log      = $this->loginAsCustomerFactory->create();
            $log->setCustomerId($customer->getId())
            ->setFirstName($customer->getFirstName())
            ->setLastName($customer->getLastName())
            ->setEmail($customer->getEmail())
            ->setAdminId($this->getCurrentUser()->getId())
            ->setAdminName($this->getCurrentUser()->getUsername())
            ->setAdminEmail($this->getCurrentUser()->getEmail())
            ->setWebsiteId($store->getWebsiteId())
            ->setGroup($customer->getGroupId())
            ->setLoginDateTime($this->getStoreDateTime())
            ->save();
            $params = [
                'customer_id' => $customer->getId(),
                'admin_key'   => $this->authSession->getSessionId()
            ];
            $key      = base64_encode(json_encode($params));
            $loginUrl = $this->_objectManager->create(Url::class)
                ->setScope($store)
                ->getUrl('btloginascustomer/login/index', ['key' => $key, '_nosid' => true]);
            return $this->getResponse()->setRedirect($loginUrl);

        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Customer does not exist.'));
            return $this->_redirect('customer');
        }

        $this->messageManager->addErrorMessage(__('An unspecified error occurred. Please contact us for assistance.'));
        return $this->_redirect('customer');
    }
    /**
     * Get Store DateTime
     *
     * @return datetime
     */
    public function getStoreDateTime()
    {
        $formatDate = $this->timezoneInterface->formatDate();
        // you can also get format wise date and time
        $dateTime = $this->timezoneInterface->date()->format('Y-m-d H:i:s');
        $date = $this->timezoneInterface->date()->format('Y-m-d');
        $time = $this->timezoneInterface->date()->format('H:i');
        return $dateTime;
    }
}
