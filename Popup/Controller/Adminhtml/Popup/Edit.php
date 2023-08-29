<?php

declare(strict_types=1);

namespace MageMastery\Popup\Controller\Adminhtml\Popup;

use MageMastery\Popup\Api\PopupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{
    public function __construct(
        Context $context,
        private readonly PopupRepositoryInterface $popupRepository,
        private readonly DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $popupId = (int) $this->getRequest()->getParam('popup_id');
        try{
            $popup = $this->popupRepository->getById($popupId);
            $this->dataPersistor->set('magemastery_popup_popup', $popup->getData());
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage(__('The popup with id %1 does not exists', $popupId));
        }


        $page->setActiveMenu('MageMastery_Popup::popup');
        $page->addBreadcrumb(__('Popups'), __('Popups'));
        $page->addBreadcrumb($popup->getPopupId() ? $popup->getName() : __('New Popup'), __('New Popup'));
        $page->getConfig()->getTitle()->prepend($popup->getPopupId() ? $popup->getName() : __('New Popup'), __('New Popup'));

        return $page;
    }
}
