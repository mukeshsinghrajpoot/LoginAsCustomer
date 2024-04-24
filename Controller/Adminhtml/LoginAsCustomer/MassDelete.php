<?php

/**
 * Copyright © BluethinkInc All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bluethinkinc\LoginAsCustomer\Controller\Adminhtml\LoginAsCustomer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer\CollectionFactory;
use Bluethinkinc\LoginAsCustomer\Model\LoginAsCustomerFactory;

class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Bluethinkinc_LoginAsCustomer::loginascustomer_id';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * @var LoginAsCustomerFactory
     */
    protected $loginascustomerFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param LoginAsCustomerFactory $loginascustomerFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        LoginAsCustomerFactory $loginascustomerFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->loginascustomerFactory = $loginascustomerFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $job_application) {
            $result = $this->loginascustomerFactory->create()->load($job_application->getLoginascustomerId());
            $result->delete();
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /* @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
