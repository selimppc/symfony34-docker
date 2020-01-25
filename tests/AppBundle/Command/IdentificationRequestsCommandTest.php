<?php


namespace Tests\AppBundle\Command;

use AppBundle\Command\IdentificationRequestsCommand;
use AppBundle\Service\DocumentValidator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * Class IdentificationRequestsCommandTest
 * @package Tests\AppBundle\Command
 */
class IdentificationRequestsCommandTest extends KernelTestCase
{
    const IDENTITY_REQUESTS_PROCESS = "identification-requests:process";

    /** @var LoggerInterface */
    private $loggerMock;

    /** @var DocumentValidator */
    private $documentValidatorMock;
    /** @var CommandTester */
    private $commandTester;

    /**
     * Test Execute
     */
    public function testExecute()
    {
        $loggerMock = $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $documentValidatorMock = $this->documentValidatorMock = $this->getMockBuilder(DocumentValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new IdentificationRequestsCommand($loggerMock, $documentValidatorMock));

        $command = $application->find(IDENTITY_REQUESTS_PROCESS);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'input.csv' => 'input.csv',
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('', $output);


    }

}
