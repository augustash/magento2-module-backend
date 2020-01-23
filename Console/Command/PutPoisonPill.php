<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\MessageQueue\PoisonPill\PoisonPillPutInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Poison pill PUT class.
 */
class PutPoisonPill extends Command
{
    /**
     * https://devdocs.magento.com/guides/v2.3/extension-dev-guide/cli-cmds/cli-naming-guidelines.html
     */
    const COMMAND_NAME = 'queue:consumers:poison';

    /**
     * @var \Magento\Framework\MessageQueue\PoisonPill\PoisonPillPutInterface
     */
    protected $poisonPillPut;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\MessageQueue\PoisonPill\PoisonPillPutInterface $poisonPillPut
     * @param string|null $name
     */
    public function __construct(
        PoisonPillPutInterface $poisonPillPut,
        $name = null
    ) {
        $this->poisonPillPut = $poisonPillPut;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Deploys a poison pill to terminate the consumers.');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $version = $this->poisonPillPut->put();

        $output->writeln('The queue consumers have been poisoned.');
        $output->writeln(sprintf('The new poison pill version is: %s', $version));

        return Cli::RETURN_SUCCESS;
    }
}
