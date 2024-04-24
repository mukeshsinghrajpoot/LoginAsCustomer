<?php
namespace Bluethinkinc\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Bluethinkinc\LoginAsCustomer\Helper\Data as HelperData;

class Actions extends Column
{
    public const CUSTOMER_GRID="customer_grid";
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
        $customerlayout= self::CUSTOMER_GRID;
        if (isset($dataSource['data']['items']) && $isAllowed && in_array($customerlayout, $selectlayoutsdata)) {
            $storeId = $this->context->getFilterParam('store_id');

            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['customer_id'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'btloginascustomer/login/index',
                        ['customer_id' => $item['entity_id'], 'store' => $storeId]
                    ),
                    'label' => __('Login As Customer'),
                    'hidden' => false,
                    'target' => '_blank',
                    '__disableTmpl' => true
                ];
            }
        }

        return $dataSource;
    }
}
