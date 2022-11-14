<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Indexer\Model\IndexerFactory;

/**
 * Re-index controller mass-action.
 */
class MassReindex extends Action
{
    /**
     * @var \Magento\Indexer\Model\IndexerFactory
     */
    protected $indexerFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Indexer\Model\IndexerFactory $indexerFactory
     */
    public function __construct(
        Context $context,
        IndexerFactory $indexerFactory
    ) {
        $this->indexerFactory = $indexerFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result.
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/list');
        $indexerIds = $this->getRequest()->getParam('indexer_ids');

        if (!\is_array($indexerIds)) {
            $this->messageManager->addErrorMessage(__('Please select indexers'));
            return $resultRedirect;
        }

        try {
            $startTime = \microtime(true);
            foreach ($indexerIds as $indexerId) {
                $indexer = $this->indexerFactory->create()->load($indexerId);
                $indexer->reindexAll();
            }
            $duration = \microtime(true) - $startTime;
            $this->messageManager->addSuccessMessage(__(
                '%1 indexer(s) have been rebuilt successfully in %2 seconds',
                \count($indexerIds),
                \sprintf('%0.2f', $duration)
            ));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __("Couldn't reindex because of an error.")
            );
        }

        return $resultRedirect;
    }

    /**
     * Determines whether current user is allowed to access Action.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        if ($this->_request->getActionName() == 'massReindex') {
            return $this->_authorization->isAllowed('Magento_Indexer::changeMode');
        }

        return false;
    }
}
