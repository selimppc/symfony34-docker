<?php


namespace Tests\AppBundle\Command;

use AppBundle\Command\IdentificationRequestsCommand;
use AppBundle\Service\DocumentValidator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
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
//        $loggerMock = $this->getMockBuilder(LoggerInterface::class)
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        $documentValidatorMock = $this->getMockBuilder(DocumentValidator::class)
//            ->disableOriginalConstructor()
//            ->getMock();


        $kernel      = self::bootKernel();
        $application = new Application($kernel);

        $eCommand = self::$kernel->getContainer()->get(
            IdentificationRequestsCommand::class
        );

        $application->add($eCommand);

        $command       = $application->find('identification-requests:process');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command' => $command->getName(),
                'input.csv' => 'input.csv'
            ]
        );

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('valid', $output);
    }

}
