<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var _idFieldName
     */
    protected $_idFieldName = 'loginascustomer_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Bluethinkinc\LoginAsCustomer\Model\LoginAsCustomer::class,
            \Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer::class
        );
    }
}
