<?php

// src/Document/CustomerDocument.php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class CustomerDocument
{
    /**
     * @MongoDB\Id
     */
    protected $uid;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $firstName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $secondName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $address;

        /**
     * @MongoDB\Field(type="int")
     */
    protected $permitNumber;

    public function getId()
    {
        return $this->uid;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getSecondName()
    {
        return $this->secondName;
    }

    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPermitNumber ()
    {
        return $this->permitNumber;
    }

    public function setPermitNumber ($permitNumber)
    {
        $this->permitNumber = $permitNumber;
    }

}
