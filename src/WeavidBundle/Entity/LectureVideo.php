<?php

namespace WeavidBundle\Entity;

/**
 * LectureVideo
 */
class LectureVideo
{

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
     * @var \WeavidBundle\Entity\Video
     */
    private $video;

    /**
     * @var \WeavidBundle\Entity\Lecture
     */
    private $lecture;

    /**
     * @var \WeavidBundle\Entity\LectureVideo
     */
    private $previousLectureVideo;

    /**
     * @var \WeavidBundle\Entity\LectureVideo
     */
    private $nextLectureVideo;


    /**
     * Set createdAt
     *
     * @return LectureVideo
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
     * @return LectureVideo
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
     * Set previousVideo
     *
     * @param \WeavidBundle\Entity\LectureVideo $previousLectureVideo
     *
     * @return LectureVideo
     */
    public function setPreviousLectureVideo(\WeavidBundle\Entity\LectureVideo $previousLectureVideo = null)
    {
        if($this->getId() != $previousLectureVideo->getId()){
            $this->previousLectureVideo = $previousLectureVideo;
        }

        return $this;
    }

    /**
     * Get previousVideo
     *
     * @return \WeavidBundle\Entity\LectureVideo
     */
    public function getPreviousLectureVideo()
    {
        return $this->previousLectureVideo;
    }

    /**
     * Set nextVideo
     *
     * @param \WeavidBundle\Entity\LectureVideo $nextLectureVideo
     *
     * @return LectureVideo
     */
    public function setNextLectureVideo(\WeavidBundle\Entity\LectureVideo $nextLectureVideo = null)
    {
        $nextLectureVideo->setPreviousLectureVideo($this->nextLectureVideo);

        return $this;
    }

    /**
     * Get nextVideo
     *
     * @return \WeavidBundle\Entity\LectureVideo
     */
    public function getNextLectureVideo()
    {
        return $this->nextLectureVideo;
    }

    /**
     * Has nextLectureVideo
     *
     * @return bool
     */
    public function hasNextLectureVideo()
    {
        return $this->getNextLectureVideo() instanceof LectureVideo;
    }

    /**
     * Set video
     *
     * @param \WeavidBundle\Entity\Video $video
     *
     * @return LectureVideo
     */
    public function setVideo(\WeavidBundle\Entity\Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \WeavidBundle\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set lecture
     *
     * @param \WeavidBundle\Entity\Lecture $lecture
     *
     * @return LectureVideo
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
     * Get last video in lecture
     *
     * @return \WeavidBundle\Entity\LectureVideo
     */
    public function getLastLectureVideo()
    {
        $lastLectureVideo = $this;
        while($lastLectureVideo->hasNextLectureVideo()){
            $lastLectureVideo = $lastLectureVideo->getNextLectureVideo();
        }
        return $lastLectureVideo;
    }

}
