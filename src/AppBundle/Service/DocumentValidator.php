<?php


namespace AppBundle\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DocumentValidator
{
    /**
     * Const @var
     * ERROR CODE
     */
    const DOCUMENT_TYPE_IS_INVALID = 'document_type_is_invalid'; // - document type is not supported
    const DOCUMENT_IS_EXPIRED = 'document_is_expired'; // - document is expired
    const DOCUMENT_NUMBER_LENGTH_INVALID ='document_number_length_invalid'; // - document number length is invalid
    const DOCUMENT_NUMBER_INVALID = 'document_number_invalid'; // - document with this number cannot be used for identification
    const DOCUMENT_ISSUE_DATE_INVALID = 'document_issue_date_invalid'; // - document issued on non-working day
    const REQUEST_LIMIT_EXCEEDED = 'request_limit_exceeded'; // - limit of identification attempts is exceeded

    /**
     * @var LoggerInterface
     */
    private $logger;
    private $today;

    /**
     * DocumentValidator constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->today = date("Y-m-d");
    }

    /**
     * @param $value
     * @return string
     */
    public function processData($value)
    {
        switch ($value['countryCode'])
        {
            case 'de':
                // Code to be validated for DE
                return $this->deDocumentValidation($value['documentNumber'], $value['issueDate']) ;
                break;
            case 'es':
                // Code to be validated for ES
                return $this->esDocumentValidation($value['documentType'], $value['documentNumber'], $value['issueDate'] );
                break;
            case 'fr':
                // Code to be validated for FR
                return $this->frDocumentValidation($value['documentType']);
                break;
            case 'pl':
                // Code to be validated for PL
                return $this->plDocumentValidation($value['documentType'], $value['documentNumber'], $value['issueDate']);
                break;
            case 'it':
                // Code to be validated for IT
                return $this->itDocumentValidation($value['requestDate']);
                break;
            case 'uk':
                // Code to be validated for UK
                return $this->ukDocumentValidation($value['documentType'], $value['issueDate'] );
                break;
            default:
                // Code to be executed as default
                return null;
                break;
        }
    }

    /**
     * @param $documentNumber
     * @param $issueDate
     * @return string
     */
    public function deDocumentValidation($documentNumber, $issueDate){
        //expires after 10 years.
        $years = $this->getYearByDateDiff($issueDate);
        if ($years > 10) return self::DOCUMENT_IS_EXPIRED;
    }

    /**
     * @param $documentType
     * @param $documentNumber
     * @param $issueDate
     * @return string
     */
    public function esDocumentValidation($documentType, $documentNumber, $issueDate){
        // expires after 15 years
        //passports, containing serial numbers from 50001111 to 50009999
        $years = $this->getYearByDateDiff($issueDate);
        if ($years > 15) return self::DOCUMENT_IS_EXPIRED;
        # check document Type
        if ($documentType != 'passport') return self::DOCUMENT_TYPE_IS_INVALID;
        if ($this->inBetweenNumber($documentNumber, 50001111, 50009999) == false) return self::DOCUMENT_NUMBER_INVALID;
    }

    /**
     * @param $documentType
     * @return string
     */
    public function frDocumentValidation($documentType){
        //French drivers licence (any issue date).
        if ($documentType != 'drivers_license') return self::DOCUMENT_TYPE_IS_INVALID;
    }


    /**
     * @param $documentType
     * @param $documentNumber
     * @param $issueDate
     * @return string
     */
    public function plDocumentValidation($documentType, $documentNumber, $issueDate){
        //identified with residence permits, issued after 2015-06-01.
        // starting 2018-09-01, began to issue new identity cards
        // which have document number length of 10 symbols.

        /** @var TYPE_NAME $documentType */
        if ($documentType == 'residence_permit'){
            if('2015-06-01' > $issueDate) return self::DOCUMENT_ISSUE_DATE_INVALID;
        }

        /** @var TYPE_NAME $documentType */
        if ($documentType == 'identity_card'){
            if('2018-09-01' > $issueDate) return self::DOCUMENT_ISSUE_DATE_INVALID;
        }

        if(!preg_match('/^\d{10}$/', $documentNumber)) {
            return self::DOCUMENT_NUMBER_LENGTH_INVALID;
        }
    }

    /**
     * @param $requestDate
     * @param $documentNumber
     * @return string
     */
    public function itDocumentValidation($requestDate){
        // 2019-01-01 document office will be working overtime on Saturdays until 2019-01-31
        if ($this->inBetweenDate($requestDate, '2019-01-01', '2019-01-31')){
            $dt = strtotime($requestDate);
            $day = date("D", $dt);
            if ($day == 'Sun') return 'request_date_invalid';
        }else{
            return $this->isIssueDateValid($requestDate);
        }
    }


    /**
     * @param $documentType
     * @param $issueDate
     * @return string
     */
    public function ukDocumentValidation($documentType, $issueDate){
        // after 2019-01-01 only passports will be accepted as proof of identity
        if ($issueDate < '2019-01-01' && $documentType == 'passport') return self::DOCUMENT_ISSUE_DATE_INVALID;
    }



    /***** ========================= COMMON FOR ALL =========================== *****/


    /**
     * @param $documentNumber
     * @param $min
     * @param $max
     * @return mixed
     */
    public function inBetweenNumber($documentNumber, $min, $max){
        return filter_var(
            $documentNumber,
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'min_range' => $min,
                    'max_range' => $max
                )
            )
        );
    }

    /**
     * @param $date
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public function inBetweenDate($date, $startDate, $endDate){
        return (strtotime($date) > strtotime($startDate)) && (strtotime($date) < strtotime($endDate));
    }


    /**
     * @param $date
     * @return false|float
     */
    public function getYearByDateDiff($date){
        $diff = abs(strtotime($this->today) - strtotime($date));
        return floor($diff / (365*60*60*24));
    }

    /**
     * @param $issueDate
     * @return string
     */
    public function checkExpiration($issueDate){
        // all documents expire 5 years after issue
        if($this->today < $issueDate) return self::DOCUMENT_ISSUE_DATE_INVALID;
    }

    /**
     * @param $documentNumber
     * @return string
     */
    public function isDocumentNumberLengthValid($documentNumber){
        //all documents have document number consisting of 8 symbols
        if(!preg_match('/^\d{8}$/', $documentNumber)) return self::DOCUMENT_NUMBER_LENGTH_INVALID;
    }

    /**
     * @param $issueDate
     * @return string
     */
    public function isIssueDateValid($issueDate){
        // should be issued on workday
        $dt = strtotime($issueDate);
        $day = date("D", $dt);
        switch ($day){
            case 'Sun':
            case 'Sat':
                return self::DOCUMENT_ISSUE_DATE_INVALID;
                break;
            default:
                // Code to be executed as default
                return null;
                break;
        }
    }

}
