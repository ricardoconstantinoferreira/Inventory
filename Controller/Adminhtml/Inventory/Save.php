<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;
use RCFerreira\InventoryPrice\Api\Data\InventoryPriceInterface;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'RCFerreira_InventoryPrice::save';

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param InventoryPriceRepositoryInterface $inventoryPriceRepository
     */
    public function __construct(
        Context $context,
        private DataPersistorInterface $dataPersistor,
        private InventoryPriceRepositoryInterface $inventoryPriceRepository,
        private InventoryPriceInterface $inventoryPrice
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id_id'] = null;
            }

            $id = (int) $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->inventoryPriceRepository->getById($id);

                    if (!empty($model->getId())) {
                        $this->inventoryPrice->setId($model->getId());
                    }

                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This inventory no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $this->inventoryPrice->setName($data['name']);
            $this->inventoryPrice->setAddress($data['address']);
            $this->inventoryPrice->setSku($data['sku']);
            $this->inventoryPrice->setPostcode($data['postcode']);
            $this->inventoryPrice->setPercentage((int) $data['percentage']);

            try {
                $data['entity_id'] = $this->inventoryPriceRepository->save($this->inventoryPrice);
                $this->messageManager->addSuccessMessage(__('You saved the inventory.'));
                return $this->processBlockReturn($data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processBlockReturn($data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['entity_id' => $data['entity_id']]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $this->inventoryPrice->setName($data['name']);
            $this->inventoryPrice->setAddress($data['address']);
            $this->inventoryPrice->setSku($data['sku']);
            $this->inventoryPrice->setPostcode($data['postcode']);
            $this->inventoryPrice->setPercentage((int) $data['percentage']);
            $this->inventoryPrice->setId(null);
            $id = $this->inventoryPriceRepository->save($this->inventoryPrice);

            $this->messageManager->addSuccessMessage(__('You duplicated the inventory.'));

            $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect;
    }
}
