<?php


namespace AppBundle\Service;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class LoadMetadata
{
    /**
     * @param ClassMetadata $metadata
     * @return ClassMetadata
     */
    public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        return $metadata->addPropertyConstraint('notInRangeMessage', new Assert\Range([
            'min' => 1,
            'max' => 9,
            'value' => 5
        ]));
    }
}
