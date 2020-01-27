<?php


namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

class BaseCommandTester extends KernelTestCase
{

    /**
     * @var
     */
    private $application;

    /**
     * to set test environment and initiate application kernel
     */
    public function setUp()
    {
        /**
         * get test env
         */
        $dotenv = new Dotenv();
        $dotenv->load('path-to-env-directory');

        /**
         * boot kernel
         */
        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
        parent::setUp();
    }

    /**
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }


}