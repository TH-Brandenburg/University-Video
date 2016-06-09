<?php

namespace WeavidBundle\Entity;

/**
 * Lecture
 */
class Lecture
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lectureVideoAssociation;

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
     * @return Lecture
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
     * Set description
     *
     * @param string $description
     *
     * @return Lecture
     */
    public function setDescription( $description )
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
     * Set published
     *
     * @param boolean $published
     *
     * @return Lecture
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Is published
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Set createdAt
     *
     * @return Lecture
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
     * @param \DateTime $updatedAt
     *
     * @return Lecture
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
     * @return Lecture
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
     * @return Lecture
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
        return $user && $user->getId() == $this->owner->getId();
    }

    /**
     * Add lectureVideoAssociation
     *
     * @param \WeavidBundle\Entity\LectureVideo $lectureVideoAssociation
     *
     * @return Lecture
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

    /**
     * Get lectureVideoAssociation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLectureVideoAssociation()
    {
        return $this->lectureVideoAssociation;
    }
}
