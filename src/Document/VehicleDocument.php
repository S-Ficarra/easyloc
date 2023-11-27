<?php

// src/Document/VehicleDocument.php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @MongoDB\Field(type="string", strategy="set")
     * @Assert\Regex(pattern="/^[A-Z]{2}\d{3}[A-Z]{2}$/", message="Le format de la plaque d'immatriculation doit être AA123AA.")
     */
    protected $licencePlate;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\Regex(
     *      pattern="/^[^<>&]*$/",
     *      message="Les balises HTML ne sont pas autorisées."
     * )
     */
    protected $informations;

    /**
     * @MongoDB\Field(type="int")
     * @Assert\Length(
     *      max = 6,
     *      maxMessage = "La valeur du kilométrage ne peut pas dépasser {{ limit }} chiffres."
     * )
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
