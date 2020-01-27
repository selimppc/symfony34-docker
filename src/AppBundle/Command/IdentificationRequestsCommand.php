<?php


namespace AppBundle\Command;


use AppBundle\Service\DocumentValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

/**
 * Class IdentificationRequestsCommand
 * @package AppBundle\Command
 */
class IdentificationRequestsCommand extends Command
{
    protected static $defaultName = 'identification-requests:process';
    private $logger;
    private $documentValidator;


    // change these options about the file to read
    private $cvsParsingOptions = array(
        'finder_in' =>__DIR__,
        'finder_name' => 'input.csv',
        'ignoreFirstLine' => true
    );

    /**
     * IdentificationRequestsCommand constructor.
     * @param LoggerInterface $logger
     * @param DocumentValidator $documentValidator
     */
    public function __construct(LoggerInterface $logger, DocumentValidator $documentValidator)
    {
        $this->logger = $logger;
        $this->documentValidator = $documentValidator;
        // you *must* call the parent constructor
        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        $this->addArgument('input.csv', InputArgument::REQUIRED, 'CSV file is required.')
            ->setDescription('Identification Request from CSV')
            ->setHelp('php bin/console identification-requests:process input.csv')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('... CSV Parsing ... ');

        // use the parseCSV() function
        $csv = $this->parseCSV();

        # process to validate
        $processing = $this->parsedDataToArray($csv, $output);

        # progressBar
        $progressbar = new ProgressBar($output);
        $progressbar->start(count($csv));
        $progressbar->advance($processing);
        $progressbar->finish();

        $io->title("\n... Good Bye ... ");
        return 0;
    }


    /**
     * @param $csv
     * @param $output
     */
    private function parsedDataToArray($csv, $output){
        $data = $this->identifyData($csv);
        $this->validationProcessor($data, $output);
    }

    /**
     * @param $data
     * @param $output
     */
    private function validationProcessor($data, $output)
    {
        foreach ($data as $value)
        {
           $res = $this->documentValidator->processData($value);

           if ($res != null ){
               $output->writeln($res.' - '. $value['countryCode']);
           }else{
               $output->writeln('valid - '.$value['countryCode']);
           }
        }
    }


    /**
     * @param $csv
     * @return array
     */
    private function identifyData($csv){
        $arr = array();

        # set all data into an array
        foreach ($csv as $line) {

            $data['requestDate'] = $line[0];
            $data['countryCode'] = $line[1];
            $data['documentType'] = $line[2];
            $data['documentNumber'] = $line[3];
            $data['issueDate'] = $line[4];
            $data['personalIdentificationNumber'] = $line[5];

            array_push($arr,$data);
        }

        # return data
        return $arr;
    }


    /**
     * Parse a csv file
     * @return array
     * @throws \Exception
     */
    private function parseCSV()
    {
        $ignoreFirstLine = $this->cvsParsingOptions['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->cvsParsingOptions['finder_in'])
            ->name($this->cvsParsingOptions['finder_name'])
            ->files();
        foreach ($finder as $file) {
            $csv = $file;
        }

        # check csv -> if empty return exception
        if(empty($csv)){
            throw new \Exception("NO CSV FILE");
        }

        # prepare CSV data
        $rows = array();
        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ",")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 1) {
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }

        # Return parse DATA
        return $rows;
    }

}
