<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Model;

use Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;
use Magento\Framework\Model\AbstractModel;

class LoginAsCustomer extends AbstractModel implements LoginAsCustomerInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer::class);
    }

    /**
     * @inheritDoc
     */
    public function getLoginascustomerId()
    {
        return $this->getData(self::LOGINASCUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLoginascustomerId($loginascustomerId)
    {
        return $this->setData(self::LOGINASCUSTOMER_ID, $loginascustomerId);
    }

    /**
     * @inheritDoc
     */
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * @inheritDoc
     */
    public function getAdminName()
    {
        return $this->getData(self::ADMIN_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setAdminName($adminName)
    {
        return $this->setData(self::ADMIN_NAME, $adminName);
    }

    /**
     * @inheritDoc
     */
    public function getAdminEmail()
    {
        return $this->getData(self::ADMIN_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setAdminEmail($adminEmail)
    {
        return $this->setData(self::ADMIN_EMAIL, $adminEmail);
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function getFirstName()
    {
        return $this->getData(self::FIRST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstName($firstName)
    {
        return $this->setData(self::FIRST_NAME, $firstName);
    }

    /**
     * @inheritDoc
     */
    public function getLastName()
    {
        return $this->getData(self::LAST_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastName($lastName)
    {
        return $this->setData(self::LAST_NAME, $lastName);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getGroup()
    {
        return $this->getData(self::GROUP);
    }

    /**
     * @inheritDoc
     */
    public function setGroup($group)
    {
        return $this->setData(self::GROUP, $group);
    }

    /**
     * @inheritDoc
     */
    public function getLoginDateTime()
    {
        return $this->getData(self::LOGIN_DATE_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setLoginDateTime($loginDateTime)
    {
        return $this->setData(self::LOGIN_DATE_TIME, $loginDateTime);
    }
}
