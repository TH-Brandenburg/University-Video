<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecturers
 *
 * @ORM\Table(name="lecturers", indexes={@ORM\Index(name="LECTURERS_USER_ID", columns={"user_id"})})
 * @ORM\Entity
 */
class Lecturers
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="lecturer_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $lecturerId;

    /**
     * @var \WeavidBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="WeavidBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Videos", mappedBy="lecturer")
     */
    private $video;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Lecturers
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Lecturers
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Lecturers
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get lecturerId
     *
     * @return integer
     */
    public function getLecturerId()
    {
        return $this->lecturerId;
    }

    /**
     * Set user
     *
     * @param \WeavidBundle\Entity\Users $user
     *
     * @return Lecturers
     */
    public function setUser(\WeavidBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WeavidBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add video
     *
     * @param \WeavidBundle\Entity\Videos $video
     *
     * @return Lecturers
     */
    public function addVideo(\WeavidBundle\Entity\Videos $video)
    {
        $this->video[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \WeavidBundle\Entity\Videos $video
     */
    public function removeVideo(\WeavidBundle\Entity\Videos $video)
    {
        $this->video->removeElement($video);
    }

    /**
     * Get video
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideo()
    {
        return $this->video;
    }
}
