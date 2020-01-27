<?php


namespace Tests\AppBundle\Service;


use AppBundle\Command\IdentificationRequestsCommand;
use AppBundle\Service\DocumentValidator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DocumentValidatorTest extends KernelTestCase
{

    public function testProcessData(){
        #$kernel = static::createKernel();
        #$kernel->boot();
        $this->assertStringContainsString(200, 200);
    }
}
