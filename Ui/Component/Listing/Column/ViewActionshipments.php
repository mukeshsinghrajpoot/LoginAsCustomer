<?php
namespace Bluethinkinc\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Bluethinkinc\LoginAsCustomer\Helper\Data as HelperData;

class ViewActionshipments extends Column
{
    public const SHIPMENTS_GRID="shipments_grid";
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var HelperData
     */
    protected $helper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param HelperData $helper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        HelperData $helper,
        array $components = [],
        array $data = [],
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper     = $helper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $isAllowed = $this->helper->isAllowed();
        $selectlayouts  = $this->helper->getSelectlayouts();
        $selectlayoutsdata=explode(',', $selectlayouts);
        $customerlayout= self::SHIPMENTS_GRID;
        
        if (isset($dataSource['data']['items']) && $isAllowed && in_array($customerlayout, $selectlayoutsdata)) {
            $storeId = $this->context->getFilterParam('store_id');
            foreach ($dataSource['data']['items'] as &$item) {
                $customer_email=$item['customer_email'];
                $customer_id=$customerdata=$this->helper->getCustomerByEmail($customer_email);
                if ($customer_id) {
                    $item[$this->getData('name')]['entity_id'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'btloginascustomer/login/index',
                            ['customer_id' => $customer_id, 'store' => $storeId]
                        ),
                        'label' => __('Login As Customer'),
                        'hidden' => false,
                        'target' => '_blank',
                        '__disableTmpl' => true
                    ];
                }
            }
        }

        return $dataSource;
    }
}
