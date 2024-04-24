<?php
namespace Bluethinkinc\LoginAsCustomer\Controller\Login;

use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Bluethinkinc\LoginAsCustomer\Helper\Data;

class Index extends Action
{
    /**
     * @var AccountRedirect
     */
    protected $accountRedirect;

    /**
     * @var SessionFactory
     */
    protected $session;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param SessionFactory $customerSession
     * @param AccountRedirect $accountRedirect
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        SessionFactory $customerSession,
        AccountRedirect $accountRedirect,
        Data $helper
    ) {
        $this->session         = $customerSession;
        $this->accountRedirect = $accountRedirect;
        $this->helper          = $helper;
        parent::__construct($context);
    }

    /**
     * This is execute function
     *
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /*Login new customer as requested on the admin interface*/
        try {

            $key     = $this->getRequest()->getParam('key');
            $session = $this->session->create();
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            $params  = json_decode(base64_decode($key), true);
            // phpcs:ignore Magento2.Security.LanguageConstruct.ExitUsage
            $sessionCollection = $this->_objectManager->create(
                \Magento\Security\Model\ResourceModel\AdminSessionInfo\Collection::class
            );
            $sessionCollection->addFieldToFilter('session_id', $params['admin_key'])->addFieldToFilter('status', 1);

            /* Logout any currently logged in customer */
            if ($session->isLoggedIn()) {
                $session->logout();
            }

            $session->loginById($params['customer_id']);
            $session->regenerateId();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account');
            $this->messageManager->addSuccessMessage(__('You are login as a customer.'));
            return $resultRedirect;
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        return $this->accountRedirect->getRedirect();
    }
}
