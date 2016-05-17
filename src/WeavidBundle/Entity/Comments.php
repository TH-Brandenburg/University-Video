<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="VIDEO_ID_IDX", columns={"video_id"}), @ORM\Index(name="CREATOR_ID_IDX", columns={"creator_id"})})
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleted = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean", nullable=false)
     */
    private $approved = '1';

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
     * @ORM\Column(name="comment_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentId;

    /**
     * @var \WeavidBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="WeavidBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_id", referencedColumnName="user_id")
     * })
     */
    private $creator;

    /**
     * @var \WeavidBundle\Entity\Videos
     *
     * @ORM\ManyToOne(targetEntity="WeavidBundle\Entity\Videos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     * })
     */
    private $video;



    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comments
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Comments
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     *
     * @return Comments
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comments
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
     * @return Comments
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
     * Get commentId
     *
     * @return integer
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set creator
     *
     * @param \WeavidBundle\Entity\Users $creator
     *
     * @return Comments
     */
    public function setCreator(\WeavidBundle\Entity\Users $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \WeavidBundle\Entity\Users
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set video
     *
     * @param \WeavidBundle\Entity\Videos $video
     *
     * @return Comments
     */
    public function setVideo(\WeavidBundle\Entity\Videos $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \WeavidBundle\Entity\Videos
     */
    public function getVideo()
    {
        return $this->video;
    }
}
