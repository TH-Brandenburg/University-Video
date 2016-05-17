<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videos
 *
 * @ORM\Table(name="videos", indexes={@ORM\Index(name="OWNER_ID_IDX", columns={"owner_id"})})
 * @ORM\Entity
 */
class Videos
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="released", type="boolean", nullable=false)
     */
    private $released = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean", nullable=false)
     */
    private $public = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="primary_video_url", type="string", length=255, nullable=false)
     */
    private $primaryVideoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="secondary_video_url", type="string", length=255, nullable=true)
     */
    private $secondaryVideoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    private $subtitle;

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
     * @ORM\Column(name="video_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videoId;

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
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Playlists", mappedBy="video")
     */
    private $playlist;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Categories", inversedBy="video")
     * @ORM\JoinTable(name="video_categories",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     *   }
     * )
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Lecturers", inversedBy="video")
     * @ORM\JoinTable(name="video_lecturers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="lecturer_id", referencedColumnName="lecturer_id")
     *   }
     * )
     */
    private $lecturer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Tags", inversedBy="video")
     * @ORM\JoinTable(name="video_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="tag_id")
     *   }
     * )
     */
    private $tag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->playlist = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lecturer = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Videos
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Videos
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set released
     *
     * @param boolean $released
     *
     * @return Videos
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Get released
     *
     * @return boolean
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Videos
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set primaryVideoUrl
     *
     * @param string $primaryVideoUrl
     *
     * @return Videos
     */
    public function setPrimaryVideoUrl($primaryVideoUrl)
    {
        $this->primaryVideoUrl = $primaryVideoUrl;

        return $this;
    }

    /**
     * Get primaryVideoUrl
     *
     * @return string
     */
    public function getPrimaryVideoUrl()
    {
        return $this->primaryVideoUrl;
    }

    /**
     * Set secondaryVideoUrl
     *
     * @param string $secondaryVideoUrl
     *
     * @return Videos
     */
    public function setSecondaryVideoUrl($secondaryVideoUrl)
    {
        $this->secondaryVideoUrl = $secondaryVideoUrl;

        return $this;
    }

    /**
     * Get secondaryVideoUrl
     *
     * @return string
     */
    public function getSecondaryVideoUrl()
    {
        return $this->secondaryVideoUrl;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Videos
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Videos
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
     * @return Videos
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
     * Get videoId
     *
     * @return integer
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set owner
     *
     * @param \WeavidBundle\Entity\Users $owner
     *
     * @return Videos
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
     * Add playlist
     *
     * @param \WeavidBundle\Entity\Playlists $playlist
     *
     * @return Videos
     */
    public function addPlaylist(\WeavidBundle\Entity\Playlists $playlist)
    {
        $this->playlist[] = $playlist;

        return $this;
    }

    /**
     * Remove playlist
     *
     * @param \WeavidBundle\Entity\Playlists $playlist
     */
    public function removePlaylist(\WeavidBundle\Entity\Playlists $playlist)
    {
        $this->playlist->removeElement($playlist);
    }

    /**
     * Get playlist
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * Add category
     *
     * @param \WeavidBundle\Entity\Categories $category
     *
     * @return Videos
     */
    public function addCategory(\WeavidBundle\Entity\Categories $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \WeavidBundle\Entity\Categories $category
     */
    public function removeCategory(\WeavidBundle\Entity\Categories $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add lecturer
     *
     * @param \WeavidBundle\Entity\Lecturers $lecturer
     *
     * @return Videos
     */
    public function addLecturer(\WeavidBundle\Entity\Lecturers $lecturer)
    {
        $this->lecturer[] = $lecturer;

        return $this;
    }

    /**
     * Remove lecturer
     *
     * @param \WeavidBundle\Entity\Lecturers $lecturer
     */
    public function removeLecturer(\WeavidBundle\Entity\Lecturers $lecturer)
    {
        $this->lecturer->removeElement($lecturer);
    }

    /**
     * Get lecturer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /**
     * Add tag
     *
     * @param \WeavidBundle\Entity\Tags $tag
     *
     * @return Videos
     */
    public function addTag(\WeavidBundle\Entity\Tags $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \WeavidBundle\Entity\Tags $tag
     */
    public function removeTag(\WeavidBundle\Entity\Tags $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }
}
