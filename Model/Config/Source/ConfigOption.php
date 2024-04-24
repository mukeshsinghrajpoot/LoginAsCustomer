<?php

namespace Bluethinkinc\LoginAsCustomer\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ConfigOption implements OptionSourceInterface
{
    /**
     * This is to Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'customer_grid', 'label' => __('Customer Grid')],
            ['value' => 'customer_view', 'label' => __('Customer View')],
            ['value' => 'orders_grid', 'label' => __('Orders Grid')],
            ['value' => 'orders_view', 'label' => __('Orders View')],
            ['value' => 'invoices_grid', 'label' => __('Invoices Grid')],
            ['value' => 'invoices_view', 'label' => __('Invoices View')],
            ['value' => 'shipments_grid', 'label' => __('Shipments Grid')],
            ['value' => 'shipments_view', 'label' => __('Shipments View')],
            ['value' => 'credit_memos_grid', 'label' => __('Credit Memos Grid')],
            ['value' => 'credit_memos_view', 'label' => __('Credit Memos View')]
        ];
    }
}
