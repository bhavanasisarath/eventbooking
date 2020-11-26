<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private $seats;
	
	/**
     * @ORM\Column(type="array")
     */
    private $attendees;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->seats = 2;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Room
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param null|string $shortDescription
     *
     * @return Room
     */
    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return null|integer
     */
    public function getSeats(): ?int
    {
        return $this->seats;
    }

    /**
     * @param null|string $content
     *
     * @return Room
     */
    public function setSeats(?int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }
	
	/**
     * @return null|array
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param null|array $content
     *
     * @return Room
     */
    public function setAttendees(?array $attendees): self
    {
        $this->attendees = $attendees;

        return $this;
    }
}
