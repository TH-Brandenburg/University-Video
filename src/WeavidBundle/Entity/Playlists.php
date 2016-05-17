<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Playlists
 *
 * @ORM\Table(name="playlists", indexes={@ORM\Index(name="OWNER_ID_IDX", columns={"owner_id"})})
 * @ORM\Entity
 */
class Playlists
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean", nullable=false)
     */
    private $private = '1';

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
     * @ORM\Column(name="playlist_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $playlistId;

    /**
     * @var \WeavidBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="WeavidBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="user_id")
     * })
     */
    private $owner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Videos", inversedBy="playlist")
     * @ORM\JoinTable(name="playlist_videos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="playlist_id", referencedColumnName="playlist_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     *   }
     * )
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
     * @return Playlists
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
     * Set private
     *
     * @param boolean $private
     *
     * @return Playlists
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Playlists
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
     * @return Playlists
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
     * Get playlistId
     *
     * @return integer
     */
    public function getPlaylistId()
    {
        return $this->playlistId;
    }

    /**
     * Set owner
     *
     * @param \WeavidBundle\Entity\Users $owner
     *
     * @return Playlists
     */
    public function setOwner(\WeavidBundle\Entity\Users $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \WeavidBundle\Entity\Users
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add video
     *
     * @param \WeavidBundle\Entity\Videos $video
     *
     * @return Playlists
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
