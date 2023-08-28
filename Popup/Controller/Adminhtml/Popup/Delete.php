<?php

declare(strict_types=1);

namespace MageMastery\Popup\Controller\Adminhtml\Popup;

use MageMastery\Popup\Api\PopupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @param Context $context
     * @param PopupRepositoryInterface $popupRepository
     */
    public function __construct(
        Context $context,
        private readonly PopupRepositoryInterface $popupRepository
    )
    {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $popupId = (int)$this->getRequest()->getParam('popup_id', 0);

        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$popupId){
            $this->messageManager->addWarningMessage(__('The popup with provided id was not found'));

            return $result->setPath('magemastery_popup/popup/index');
        }

        try {
            $popup = $this->popupRepository->getById($popupId);

            if(!$popup->getPopupId()){
                $this->messageManager->addWarningMessage(__('The popup with provided id was not found'));

                return $result->setPath('magemastery_popup/popup/index');
            } else {
                $this->popupRepository->delete($popup);
                $this->messageManager->addSuccessMessage(__('The popup has been deleted'));

                return $result->setPath('magemastery_popup/popup/index');
            }

        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong while processing the operation'));

            return $result->setPath('magemastery_popup/popup/index');
        }
    }
}