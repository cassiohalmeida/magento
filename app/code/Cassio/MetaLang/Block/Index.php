<?php

namespace Cassio\MetaLang\Block;

use Magento\Cms\Model\Page;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Template
{

    /**
     * Locale path.
     */
    const LOCAL_PATH = 'general/locale/code';

    /**
     * @var Page
     */
    protected $_page;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Index constructor.
     * @param Context $context
     * @param Page $page
     * @param StoreManagerInterface $storeManager
     * @param $data
     */
    public function __construct(
        Context $context,
        Page $page,
        StoreManagerInterface $storeManager,
        $data
    ) {
        parent::__construct($context, $data);
        $this->_page = $page;
        $this->_storeManager = $storeManager;
    }

    /**
     * If the page is used in more than one store.
     * @return bool
     */
    public function isUsedInMultipleStores(): bool
    {
        return count($this->getStores()) > 1;
    }

    /**
     * @param $storeId
     * @return string teh store locale code
     * @throws NoSuchEntityException
     */
    public function getStoreLocaleCode($storeId)
    {
        return $this->getStore($storeId)->getConfig(self::LOCAL_PATH, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param $storeId
     * @return string the store base URL
     * @throws NoSuchEntityException
     */
    public function getStorePageUrl($storeId): string
    {
        return $this->getStore($storeId)->getBaseUrl() . $this->_page->getData('identifier');
    }

    /**
     * @return array
     */
    public function getStores(): array
    {
        return $this->_page->getStores();
    }

    /**
     * @param $storeId
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    protected function getStore($storeId): StoreInterface
    {
        return $this->_storeManager->getStore($storeId);
    }
}
