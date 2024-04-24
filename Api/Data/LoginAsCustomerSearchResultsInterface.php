<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Api\Data;

interface LoginAsCustomerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get LoginAsCustomer list.
     *
     * @return \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface[]
     */
    public function getItems();

    /**
     * Set admin_id list.
     *
     * @param \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
