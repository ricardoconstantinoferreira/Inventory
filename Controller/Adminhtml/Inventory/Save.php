<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;
use RCFErreira\InventoryPrice\Model\InventoryPriceFactory;

class Save extends Action implements HttpPostActionInterface
{

    public function __construct(
       Action\Context $context,
        private DataPersistorInterface $dataPersistor,
        private InventoryPriceRepositoryInterface $inventoryPriceRepository,
        private InventoryPriceFactory $inventoryPriceFactory
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if (empty($data['entity_id'])) {
                $data['entity_id_id'] = null;
            }

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->inventoryPriceRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This inventory no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->inventoryPriceRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the inventory.'));
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->inventoryPriceFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $this->inventoryPriceRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the inventory.'));

            $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect;
    }
}
