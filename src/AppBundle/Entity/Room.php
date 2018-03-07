<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="rooms")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="nbOfPersons", type="smallint")
     */
    private $nbOfPersons;

    /**
     * @var int
     *
     * @ORM\Column(name="roomNumber", type="smallint", unique=true)
     */
    private $roomNumber;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reservation", mappedBy="room")
     */

    private $reservations;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nbOfPersons
     *
     * @param integer $nbOfPersons
     *
     * @return Room
     */
    public function setNbOfPersons($nbOfPersons)
    {
        $this->nbOfPersons = $nbOfPersons;

        return $this;
    }

    /**
     * Get nbOfPersons
     *
     * @return int
     */
    public function getNbOfPersons()
    {
        return $this->nbOfPersons;
    }

    /**
     * Set roomNumber
     *
     * @param integer $roomNumber
     *
     * @return Room
     */
    public function setRoomNumber($roomNumber)
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    /**
     * Get roomNumber
     *
     * @return int
     */
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }

    /**
     * @return ArrayCollection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param ArrayCollection $reservations
     * @return Room
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Room
     */
    public function addReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }
}
