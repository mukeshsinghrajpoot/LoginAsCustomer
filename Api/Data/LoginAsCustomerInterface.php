<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Api\Data;

interface LoginAsCustomerInterface
{

    public const ADMIN_NAME = 'admin_name';
    public const LAST_NAME = 'last_name';
    public const LOGIN_DATE_TIME = 'login_date_time';
    public const EMAIL = 'email';
    public const GROUP = 'group';
    public const ADMIN_EMAIL = 'admin_email';
    public const ADMIN_ID = 'admin_id';
    public const LOGINASCUSTOMER_ID = 'loginascustomer_id';
    public const FIRST_NAME = 'first_name';
    public const CUSTOMER_ID = 'customer_id';
    public const WEBSITE_ID = 'website_id';

    /**
     * Get loginascustomer_id
     *
     * @return string|null
     */
    public function getLoginascustomerId();

    /**
     * Set loginascustomer_id
     *
     * @param string $loginascustomerId
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setLoginascustomerId($loginascustomerId);

    /**
     * Get admin_id
     *
     * @return string|null
     */
    public function getAdminId();

    /**
     * Set admin_id
     *
     * @param string $adminId
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setAdminId($adminId);

    /**
     * Get admin_name
     *
     * @return string|null
     */
    public function getAdminName();

    /**
     * Set admin_name
     *
     * @param string $adminName
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setAdminName($adminName);

    /**
     * Get admin_email
     *
     * @return string|null
     */
    public function getAdminEmail();

    /**
     * Set admin_email
     *
     * @param string $adminEmail
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setAdminEmail($adminEmail);

    /**
     * Get website_id
     *
     * @return string|null
     */
    public function getWebsiteId();

    /**
     * Set website_id
     *
     * @param string $websiteId
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Get customer_id
     *
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     *
     * @param string $customerId
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get first_name
     *
     * @return string|null
     */
    public function getFirstName();

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setFirstName($firstName);

    /**
     * Get last_name
     *
     * @return string|null
     */
    public function getLastName();

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setLastName($lastName);

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setEmail($email);

    /**
     * Get group
     *
     * @return string|null
     */
    public function getGroup();

    /**
     * Set group
     *
     * @param string $group
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setGroup($group);

    /**
     * Get login_date_time
     *
     * @return string|null
     */
    public function getLoginDateTime();

    /**
     * Set login_date_time
     *
     * @param string $loginDateTime
     * @return \Bluethinkinc\LoginAsCustomer\LoginAsCustomer\Api\Data\LoginAsCustomerInterface
     */
    public function setLoginDateTime($loginDateTime);
}
