<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Controller\Adminhtml\Inventory;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    public const ADMIN_RESOURCE = 'RCFerreira_InventoryPrice::save';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
