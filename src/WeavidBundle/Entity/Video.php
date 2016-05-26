<?php

namespace WeavidBundle\Entity;

/**
 * Videos
 */
class Video
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $released = true;

    /**
     * @var boolean
     */
    private $public = false;

    /**
     * @var string
     */
    private $primaryVideoUrl;

    /**
     * @var string
     */
    private $secondaryVideoUrl;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \WeavidBundle\Entity\User
     */
    private $owner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lectureVideoAssociation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lecturer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tag;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comment;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lectureVideoAssociation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category                = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lecturer                = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag                     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comment                 = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Is owner
     *
     * @param User $user
     *
     * @return bool
     */
    public function isOwner(\WeavidBundle\Entity\User $user = null)
    {
        return $user && $user->getId() == $this->getOwner()->getId();
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

    /**
     * @return \Doctrine\Common\Collections\Collection|Comment
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $comment
     *
     * @return $this
     */
    public function setComment( $comment ) {
        $this->comment = $comment;
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
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Add comment
     *
     * @param \WeavidBundle\Entity\Comment $comment
     *
     * @return Video
     */
    public function addComment(\WeavidBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \WeavidBundle\Entity\Comment $comment
     */
    public function removeComment(\WeavidBundle\Entity\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get playlist
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLectureVideoAssociation()
    {
        return $this->lectureVideoAssociation;
    }

    /**
     * Add lectureVideoAssociation
     *
     * @param \WeavidBundle\Entity\LectureVideo $lectureVideoAssociation
     *
     * @return Video
     */
    public function addLectureVideoAssociation(\WeavidBundle\Entity\LectureVideo $lectureVideoAssociation)
    {
        $this->lectureVideoAssociation[] = $lectureVideoAssociation;

        return $this;
    }

    /**
     * Remove lectureVideoAssociation
     *
     * @param \WeavidBundle\Entity\LectureVideo $lectureVideoAssociation
     */
    public function removeLectureVideoAssociation(\WeavidBundle\Entity\LectureVideo $lectureVideoAssociation)
    {
        $this->lectureVideoAssociation->removeElement($lectureVideoAssociation);
    }
}
