<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;

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
        private InventoryPriceRepositoryInterface $inventoryPriceRepository
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

    /**
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $model->setData($data);
            $model->setId(null);
            $this->inventoryPriceRepository->save($model);
            $id = $model->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the inventory.'));

            $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect;
    }
}
