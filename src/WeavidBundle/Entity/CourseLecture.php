<?php

namespace WeavidBundle\Entity;

/**
 * CourseLecture
 */
class CourseLecture
{
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
     * @var \WeavidBundle\Entity\CourseLecture
     */
    private $previous_lecture;

    /**
     * @var \WeavidBundle\Entity\Course
     */
    private $course;

    /**
     * @var \WeavidBundle\Entity\Lecture
     */
    private $lecture;


    /**
     * Set private
     *
     * @param boolean $private
     *
     * @return CourseLecture
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
     * @return CourseLecture
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
     * @return CourseLecture
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
     * Set previousLecture
     *
     * @param \WeavidBundle\Entity\CourseLecture $previousLecture
     *
     * @return CourseLecture
     */
    public function setPreviousLecture(\WeavidBundle\Entity\CourseLecture $previousLecture = null)
    {
        $this->previous_lecture = $previousLecture;

        return $this;
    }

    /**
     * Get previousLecture
     *
     * @return \WeavidBundle\Entity\CourseLecture
     */
    public function getPreviousLecture()
    {
        return $this->previous_lecture;
    }

    /**
     * Set course
     *
     * @param \WeavidBundle\Entity\Course $course
     *
     * @return CourseLecture
     */
    public function setCourse(\WeavidBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \WeavidBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set lecture
     *
     * @param \WeavidBundle\Entity\Lecture $lecture
     *
     * @return CourseLecture
     */
    public function setLecture(\WeavidBundle\Entity\Lecture $lecture = null)
    {
        $this->lecture = $lecture;

        return $this;
    }

    /**
     * Get lecture
     *
     * @return \WeavidBundle\Entity\Lecture
     */
    public function getLecture()
    {
        return $this->lecture;
    }
    /**
     * @var \WeavidBundle\Entity\CourseLecture
     */
    private $previousLecture;

    /**
     * @var \WeavidBundle\Entity\CourseLecture
     */
    private $nextLecture;


    /**
     * Set nextLecture
     *
     * @param \WeavidBundle\Entity\CourseLecture $nextLecture
     *
     * @return CourseLecture
     */
    public function setNextLecture(\WeavidBundle\Entity\CourseLecture $nextLecture = null)
    {
        $this->nextLecture = $nextLecture;

        return $this;
    }

    /**
     * Get nextLecture
     *
     * @return \WeavidBundle\Entity\CourseLecture
     */
    public function getNextLecture()
    {
        return $this->nextLecture;
    }
}
