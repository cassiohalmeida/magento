<?php


namespace Cassio\ColorChange\Console\Command;


use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ColorChangeCommand extends Command
{

    /**
     * Color HEX code.
     */
    const HEX_ARGUMENT = 'hex';

    /**
     * Store ID
     */
    const STORE_VIEW_ID_ARGUMENT = 'store-view-id';

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ScopeConfigInterface;
     */
    protected $_configWriter;

    /**
     * ColorChangeCommand constructor.
     * @param StoreManagerInterface $storeManager
     * @param WriterInterface $configWriter
     */
    public function __construct(StoreManagerInterface $storeManager, WriterInterface $configWriter)
    {
        $this->_storeManager = $storeManager;
        $this->_configWriter = $configWriter;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('cassio:change-color')
            ->setDescription('It changes the buttons color using the given HEX and Store View ID.')
            ->addArgument(self::HEX_ARGUMENT, InputArgument::REQUIRED, 'The HEX code of the color.')
            ->addArgument(self::STORE_VIEW_ID_ARGUMENT, InputArgument::REQUIRED, 'The Store View ID.');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hex = $input->getArgument(self::HEX_ARGUMENT);
        $storeId = $input->getArgument(self::STORE_VIEW_ID_ARGUMENT);
        try {
            $store = $this->_storeManager->getStore($storeId);
            $this->_configWriter->save('cassio/colorchange/hex', '#' . $hex, ScopeInterface::SCOPE_STORES, $store->getId());
        } catch (NoSuchEntityException $exception) {
            return $output->writeln('No store found with this ID');
        }
        $output->writeln('Hexa color saved!');
    }
}
