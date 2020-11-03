<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
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
        parent::__construct($context);
        $this->indexerFactory = $indexerFactory;
    }

    /**
     * {@inheritdoc}
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
                $indexer = $this->indexerFactory->create()
                    ->load($indexerId);
                $indexer->reindexAll();
            }
            $endTime = \microtime(true) - $startTime;
            $this->messageManager->addSuccessMessage(__(
                '%1 indexer(s) have been rebuilt successfully in %2 seconds',
                \count($indexerIds),
                \gmdate('s', $endTime)
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
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        if ($this->_request->getActionName() == 'massReindex') {
            return $this->_authorization->isAllowed('Magento_Indexer::changeMode');
        }

        return false;
    }
}
