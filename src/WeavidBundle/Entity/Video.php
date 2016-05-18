<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videos
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="OWNER_ID_IDX", columns={"owner_id"})})
 * @ORM\Entity
 */
class Video
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
    private $released = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean", nullable=false)
     */
    private $public = false;

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
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \WeavidBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="WeavidBundle\Entity\User", inversedBy="videos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Playlist", mappedBy="video")
     */
    private $playlist;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Category", inversedBy="video")
     * @ORM\JoinTable(name="video_categories",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Lecturer", inversedBy="video")
     * @ORM\JoinTable(name="video_lecturers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id")
     *   }
     * )
     */
    private $lecturer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeavidBundle\Entity\Tag", inversedBy="video")
     * @ORM\JoinTable(name="video_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
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
     * @return Video
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
     * @return Video
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
     * @return Video
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Is released
     *
     * @return boolean
     */
    public function isReleased()
    {
        return $this->released;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Video
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Is public
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * Set primaryVideoUrl
     *
     * @param string $primaryVideoUrl
     *
     * @return Video
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
     * @return Video
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
     * @return Video
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
     * @return Video
     */
    public function setCreatedAt()
    {
        $this->createdAt = $this->createdAt ?? new \DateTime();
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
     * @return Video
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt ?? new \DateTime();
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set owner
     *
     * @param \WeavidBundle\Entity\User $owner
     *
     * @return Video
     */
    public function setOwner(\WeavidBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \WeavidBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add playlist
     *
     * @param \WeavidBundle\Entity\Playlist $playlist
     *
     * @return Video
     */
    public function addPlaylist(\WeavidBundle\Entity\Playlist $playlist)
    {
        $this->playlist[] = $playlist;

        return $this;
    }

    /**
     * Remove playlist
     *
     * @param \WeavidBundle\Entity\Playlist $playlist
     */
    public function removePlaylist(\WeavidBundle\Entity\Playlist $playlist)
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
     * @param \WeavidBundle\Entity\Category $category
     *
     * @return Video
     */
    public function addCategory(\WeavidBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \WeavidBundle\Entity\Category $category
     */
    public function removeCategory(\WeavidBundle\Entity\Category $category)
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
     * @param \WeavidBundle\Entity\Lecturer $lecturer
     *
     * @return Video
     */
    public function addLecturer(\WeavidBundle\Entity\Lecturer $lecturer)
    {
        $this->lecturer[] = $lecturer;

        return $this;
    }

    /**
     * Remove lecturer
     *
     * @param \WeavidBundle\Entity\Lecturer $lecturer
     */
    public function removeLecturer(\WeavidBundle\Entity\Lecturer $lecturer)
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
     * @param \WeavidBundle\Entity\Tag $tag
     *
     * @return Video
     */
    public function addTag(\WeavidBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \WeavidBundle\Entity\Tag $tag
     */
    public function removeTag(\WeavidBundle\Entity\Tag $tag)
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
