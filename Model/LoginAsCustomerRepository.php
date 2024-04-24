<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bluethinkinc\LoginAsCustomer\Model;

use Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;
use Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerInterfaceFactory;
use Bluethinkinc\LoginAsCustomer\Api\Data\LoginAsCustomerSearchResultsInterfaceFactory;
use Bluethinkinc\LoginAsCustomer\Api\LoginAsCustomerRepositoryInterface;
use Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer as ResourceLoginAsCustomer;
use Bluethinkinc\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer\CollectionFactory
as LoginAsCustomerCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class LoginAsCustomerRepository implements LoginAsCustomerRepositoryInterface
{

    /**
     * @var LoginAsCustomer
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var LoginAsCustomerCollectionFactory
     */
    protected $loginAsCustomerCollectionFactory;

    /**
     * @var ResourceLoginAsCustomer
     */
    protected $resource;

    /**
     * @var LoginAsCustomerInterfaceFactory
     */
    protected $loginAsCustomerFactory;
    /**
     * @param ResourceLoginAsCustomer $resource
     * @param LoginAsCustomerInterfaceFactory $loginAsCustomerFactory
     * @param LoginAsCustomerCollectionFactory $loginAsCustomerCollectionFactory
     * @param LoginAsCustomerSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceLoginAsCustomer $resource,
        LoginAsCustomerInterfaceFactory $loginAsCustomerFactory,
        LoginAsCustomerCollectionFactory $loginAsCustomerCollectionFactory,
        LoginAsCustomerSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->loginAsCustomerFactory = $loginAsCustomerFactory;
        $this->loginAsCustomerCollectionFactory = $loginAsCustomerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $this->resource->save($loginAsCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the loginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return $loginAsCustomer;
    }

    /**
     * @inheritDoc
     */
    public function get($loginAsCustomerId)
    {
        $loginAsCustomer = $this->loginAsCustomerFactory->create();
        $this->resource->load($loginAsCustomer, $loginAsCustomerId);
        if (!$loginAsCustomer->getId()) {
            throw new NoSuchEntityException(__('LoginAsCustomer with id "%1" does not exist.', $loginAsCustomerId));
        }
        return $loginAsCustomer;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->loginAsCustomerCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $loginAsCustomerModel = $this->loginAsCustomerFactory->create();
            $this->resource->load($loginAsCustomerModel, $loginAsCustomer->getLoginascustomerId());
            $this->resource->delete($loginAsCustomerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the LoginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($loginAsCustomerId)
    {
        return $this->delete($this->get($loginAsCustomerId));
    }
}
