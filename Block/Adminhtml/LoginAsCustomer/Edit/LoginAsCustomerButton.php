<?php
namespace Bluethinkinc\LoginAsCustomer\Block\Adminhtml\LoginAsCustomer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class LoginAsCustomerButton extends GenericButton implements ButtonProviderInterface
{
    public const CUSTOMER_VIEW ='customer_view';
    /**
     * @var helper
     */
    protected $helper;

    /**
     * Button constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Bluethinkinc\LoginAsCustomer\Helper\Data $helper
    ) {
        $this->helper = $helper;
        parent::__construct($context, $registry);
    }

    /**
     * Get get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        $customerlayout= self::CUSTOMER_VIEW;
        $customerId = $this->getCustomerId();
        $isAllowed  = $this->helper->isAllowed();
        $selectlayouts  = $this->helper->getSelectlayouts();
        $selectlayoutsdata=explode(',', $selectlayouts);
        $data       = [];
        if ($customerId && $isAllowed && in_array($customerlayout, $selectlayoutsdata)) {
            $data = [
                'label'      => __('Login as Customer'),
                'on_click'   => sprintf("window.open('%s');", $this->getLoginUrl()),
                'sort_order' => 60
            ];
        }

        return $data;
    }

    /**
     * Get Login Url
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->getUrl('btloginascustomer/login/index', ['customer_id' => $this->getCustomerId()]);
    }
}
