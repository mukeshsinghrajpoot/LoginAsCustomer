<?php
namespace Bluethinkinc\LoginAsCustomer\Plugin\Invoice;

use Magento\Sales\Block\Adminhtml\Order\Invoice\View;

class BtLoginButton
{

    public const INVOICES_VIEW="invoices_view";
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
     * Before Get BackUrl Function
     *
     * @param View $subject
     */
    public function beforeGetBackUrl(View $subject)
    {
        $customerId = $subject->getInvoice()->getOrder()->getCustomerId();
        $isAllowed  = $this->helper->isAllowed();
        $selectlayouts  = $this->helper->getSelectlayouts();
        $selectlayoutsdata=explode(',', $selectlayouts);
        $customerlayout= self::INVOICES_VIEW;
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
