<?php

// src/Document/VehicleDocument.php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class VehicleDocument
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $licencePlate;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $informations;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $km;

    public function getId()
    {
        return $this->id;
    }

    public function getLicencePlate()
    {
        return $this->licencePlate;
    }

    public function setLicencePlate($licencePlate)
    {
        $this->licencePlate = $licencePlate;
    }

    public function getInformations()
    {
        return $this->informations;
    }

    public function setInformations($informations)
    {
        $this->informations = $informations;
    }

    public function getKm()
    {
        return $this->km;
    }

    public function setKm($km)
    {
        $this->km = $km;
    }

}
