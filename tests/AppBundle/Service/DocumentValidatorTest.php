<?php


namespace Tests\AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DocumentValidatorTest extends WebTestCase
{

    public function testProcessData(){
        $kernel = static::createKernel();
        $kernel->boot();


        #$this->assertEqual('200',200);
    }
}
