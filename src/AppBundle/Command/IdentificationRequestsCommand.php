<?php


namespace AppBundle\Command;


use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IdentificationRequestsCommand extends Command
{
    protected static $defaultName = 'identification-requests:process';
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        // you *must* call the parent constructor
        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Identification Request from CSV')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('php bin/console identification-requests:process input.csv')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}