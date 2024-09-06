<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'RCFerreira_InventoryPrice::save';


    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param InventoryPriceRepositoryInterface $inventoryPriceRepository
     */
    public function __construct(
        Action\Context $context,
        private \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        private \Magento\Framework\Registry $registry,
        private InventoryPriceRepositoryInterface $inventoryPriceRepository
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('RCFerreira_InventoryPrice::menu')
            ->addBreadcrumb(__('Inventory Price'), __('Inventory Price'))
            ->addBreadcrumb(__('Manage Inventory Price'), __('Manage Inventory Price'));

//        $resultPage->getConfig()->getTitle()->prepend((__('Listing Inventory Insert')));
        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = (int) $this->getRequest()->getParam('entity_id');
        $inventoryPrice = "";

        // 2. Initial checking
        if ($id) {
            $inventoryPrice = $this->inventoryPriceRepository->getById($id);
            if (!$inventoryPrice->getId()) {
                $this->messageManager->addErrorMessage(__('This inventory no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Inventory') : __('New Inventory'),
            $id ? __('Edit Inventory') : __('New Inventory')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Pages'));

        $resultPage->getConfig()->getTitle()
            ->prepend((!empty($inventoryPrice)) ? $inventoryPrice->getName() : __('New Inventory'));

        return $resultPage;
    }
}

