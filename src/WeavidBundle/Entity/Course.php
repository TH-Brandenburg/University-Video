<?php

namespace WeavidBundle\Entity;

/**
 * Course
 */
class Course
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var boolean
     */
    private $published = true;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $courseLectureAssociation;

    /**
     * @var \WeavidBundle\Entity\User
     */
    private $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseLectureAssociation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Course
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Course
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->published;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Course
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
     * @return Course
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add courseLectureAssociation
     *
     * @param \WeavidBundle\Entity\CourseLecture $courseLectureAssociation
     *
     * @return Course
     */
    public function addCourseLectureAssociation(\WeavidBundle\Entity\CourseLecture $courseLectureAssociation)
    {
        $this->courseLectureAssociation[] = $courseLectureAssociation;

        return $this;
    }

    /**
     * Remove courseLectureAssociation
     *
     * @param \WeavidBundle\Entity\CourseLecture $courseLectureAssociation
     */
    public function removeCourseLectureAssociation(\WeavidBundle\Entity\CourseLecture $courseLectureAssociation)
    {
        $this->courseLectureAssociation->removeElement($courseLectureAssociation);
    }

    /**
     * Get courseLectureAssociation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseLectureAssociation()
    {
        return $this->courseLectureAssociation;
    }

    /**
     * Set owner
     *
     * @param \WeavidBundle\Entity\User $owner
     *
     * @return Course
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
    public function isOwner(\WeavidBundle\Entity\User $user)
    {
        return $this->owner->getId() == $user->getId();
    }

}
