<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LoginAsCustomerRepositoryInterface
{

    /**
     * Save LoginAsCustomer
     *
     * @param \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
     * @return \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
    );

    /**
     * Retrieve LoginAsCustomer
     *
     * @param string $loginascustomerId
     * @return \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($loginascustomerId);

    /**
     * Retrieve LoginAsCustomer matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete LoginAsCustomer
     *
     * @param \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface $loginAsCustomer
    );

    /**
     * Delete LoginAsCustomer by ID
     *
     * @param string $loginascustomerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($loginascustomerId);
}
