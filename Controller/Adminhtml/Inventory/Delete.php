<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    const ADMIN_RESOURCE = 'RCFerreira_InventoryPrice::delete';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param InventoryPriceRepositoryInterface $inventoryPriceRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
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
        $id = (int) $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {

                $this->inventoryPriceRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the inventory.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a inventory to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
