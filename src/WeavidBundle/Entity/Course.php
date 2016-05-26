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
    private $private = '1';

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
    private $course_lecture_association;

    /**
     * @var \WeavidBundle\Entity\User
     */
    private $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->course_lecture_association = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set private
     *
     * @param boolean $private
     *
     * @return Course
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
        $this->course_lecture_association[] = $courseLectureAssociation;

        return $this;
    }

    /**
     * Remove courseLectureAssociation
     *
     * @param \WeavidBundle\Entity\CourseLecture $courseLectureAssociation
     */
    public function removeCourseLectureAssociation(\WeavidBundle\Entity\CourseLecture $courseLectureAssociation)
    {
        $this->course_lecture_association->removeElement($courseLectureAssociation);
    }

    /**
     * Get courseLectureAssociation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourseLectureAssociation()
    {
        return $this->course_lecture_association;
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $courseLectureAssociation;


}
