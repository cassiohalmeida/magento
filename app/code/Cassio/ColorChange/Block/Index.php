<?php

namespace Cassio\ColorChange\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Template
{

    /**
     * HEX config path.
     */
    const HEX_PATH = 'cassio/colorchange/hex';

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        Template\Context $context,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed|null
     */
    public function getHexColor()
    {
        try {
            return $this->_scopeConfig->getValue(self::HEX_PATH, ScopeInterface::SCOPE_STORES, $this->getStoreId());
        } catch (NoSuchEntityException $exception) {
            return null;
        }
    }

    /**
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId(): int
    {
        return $this->_storeManager->getStore()->getStoreId();
    }
}
