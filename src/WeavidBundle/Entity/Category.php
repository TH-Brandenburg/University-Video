<?php

namespace WeavidBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categories
 */
class Category
{
    /**
     * @var string
     */
    private $label;

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
     * @var \WeavidBundle\Entity\Category
     */
    private $parent;

    /**
     * @var ArrayCollection
     */
    private $children;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $video;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set label
     *
     * @param string $label
     *
     * @return Category
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
     * Set createdAt
     *
     * @return Category
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
     * @return Category
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
     * Get categoryId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set parent
     *
     * @param \WeavidBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\WeavidBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \WeavidBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add video
     *
     * @param \WeavidBundle\Entity\Video $video
     *
     * @return Category
     */
    public function addVideo(\WeavidBundle\Entity\Video $video)
    {
        $this->video[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \WeavidBundle\Entity\Video $video
     */
    public function removeVideo(\WeavidBundle\Entity\Video $video)
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

    /**
     * Get children
     *
     * @return ArrayCollection|Category
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children !== null && !$this->children->isEmpty();
    }
}
