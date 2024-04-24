<?php
namespace Bluethinkinc\LoginAsCustomer\Plugin;

use Magento\Shipping\Block\Adminhtml\View;

class ShipmentBtLoginButton
{

    public const SHIPMENTS_VIEW="shipments_view";
    /**
     * @var \Bluethinkinc\LoginAsCustomer\Helper\Data
     */
    protected $helper;

    /**
     * @param \Bluethinkinc\LoginAsCustomer\Helper\Data $helper
     */
    public function __construct(
        \Bluethinkinc\LoginAsCustomer\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }
    /**
     * Before Get BackUrl function
     *
     * @param View $subject
     */
    public function beforeGetBackUrl(View $subject)
    {
        $customerId = $subject->getShipment()->getOrder()->getCustomerId();
        $isAllowed  = $this->helper->isAllowed();
        $selectlayouts  = $this->helper->getSelectlayouts();
        $selectlayoutsdata=explode(',', $selectlayouts);
        $customerlayout= self::SHIPMENTS_VIEW;
        if ($customerId && $isAllowed && in_array($customerlayout, $selectlayoutsdata)) {
            $subject->addButton('bt_login_as_customer', [
                'label'    => __('Login as Customer'),
                'on_click' => sprintf(
                    "window.open('%s');",
                    $subject->getUrl(
                        'btloginascustomer/login/index',
                        ['customer_id' => $customerId]
                    )
                )
            ], 60);
        }
    }
}
