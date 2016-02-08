<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tweets
 *
 * @ORM\Table(name="instagram", indexes={@ORM\Index(name="created_at", columns={"created_at"})})
 * @ORM\Entity
 */
class Instagram extends Generic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="instagram_id", type="string", length=30,  nullable=false)
     */
    private $instagramId;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="InstagramUser", inversedBy="instagram", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\InstagramMedia", mappedBy="instagram", cascade={"persist", "remove"})
     */
    protected $instagramMedia;


    /**
     * @var Instagram
     *
     * @ORM\ManyToOne(targetEntity="Headoo\MediaSocialApiBundle\Entity\InstagramCaption", inversedBy="instagram", cascade={"persist"})
     * @ORM\JoinColumn(name="caption_id", referencedColumnName="id", nullable=true)
     */
    protected $instagramCaption;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\InstagramComment", mappedBy="instagram", cascade={"persist", "remove"})
     */
    protected $instagramComment;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer",length=7, nullable=false)
     */
    private $likes;


    /**
     * @var string
     *
     * @ORM\Column(name="filter", type="string",length=100, nullable=false)
     */
    private $filter;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string",length=255, nullable=false)
     */
    private $link;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string",length=20, nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="InstagramTag", inversedBy="instagrams")
     * @ORM\JoinTable(name="instagrams_tags")
     **/
    private $tags;

    /**
     * @var int
     *
     * @ORM\Column(name="comments", type="integer",length=3, nullable=false)
     */
    private $comments;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instagramMedia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->instagramComment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set instagramId
     *
     * @param string $instagramId
     *
     * @return Instagram
     */
    public function setInstagramId($instagramId)
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    /**
     * Get instagramId
     *
     * @return string
     */
    public function getInstagramId()
    {
        return $this->instagramId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Instagram
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
     * Set likes
     *
     * @param integer $likes
     *
     * @return Instagram
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set filter
     *
     * @param string $filter
     *
     * @return Instagram
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Instagram
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Instagram
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set comments
     *
     * @param integer $comments
     *
     * @return Instagram
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return integer
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return Instagram
     */
    public function setImportedAt($importedAt)
    {
        $this->importedAt = $importedAt;

        return $this;
    }

    /**
     * Get importedAt
     *
     * @return \DateTime
     */
    public function getImportedAt()
    {
        return $this->importedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Instagram
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
     * Set user
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramUser $user
     *
     * @return Instagram
     */
    public function setUser(\Headoo\MediaSocialApiBundle\Entity\InstagramUser $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\InstagramUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add instagramMedia
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramMedia $instagramMedia
     *
     * @return Instagram
     */
    public function addInstagramMedia(\Headoo\MediaSocialApiBundle\Entity\InstagramMedia $instagramMedia)
    {
        $this->instagramMedia[] = $instagramMedia;

        return $this;
    }

    /**
     * Remove instagramMedia
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramMedia $instagramMedia
     */
    public function removeInstagramMedia(\Headoo\MediaSocialApiBundle\Entity\InstagramMedia $instagramMedia)
    {
        $this->instagramMedia->removeElement($instagramMedia);
    }

    /**
     * Get instagramMedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstagramMedia()
    {
        return $this->instagramMedia;
    }

    /**
     * Set instagramCaption
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption
     *
     * @return Instagram
     */
    public function setInstagramCaption(\Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption)
    {
        $this->instagramCaption = $instagramCaption;

        return $this;
    }

    /**
     * Get instagramCaption
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\InstagramCaption
     */
    public function getInstagramCaption()
    {
        return $this->instagramCaption;
    }

    /**
     * Add instagramComment
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramComment $instagramComment
     *
     * @return Instagram
     */
    public function addInstagramComment(\Headoo\MediaSocialApiBundle\Entity\InstagramComment $instagramComment)
    {
        $this->instagramComment[] = $instagramComment;

        return $this;
    }

    /**
     * Remove instagramComment
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramComment $instagramComment
     */
    public function removeInstagramComment(\Headoo\MediaSocialApiBundle\Entity\InstagramComment $instagramComment)
    {
        $this->instagramComment->removeElement($instagramComment);
    }

    /**
     * Get instagramComment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstagramComment()
    {
        return $this->instagramComment;
    }

    /**
     * Add tag
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramTag $tag
     *
     * @return Instagram
     */
    public function addTag(\Headoo\MediaSocialApiBundle\Entity\InstagramTag $tag)
    {
        if ($this->tags->contains($tag)) {
            return;
        }

        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramTag $tag
     */
    public function removeTag(\Headoo\MediaSocialApiBundle\Entity\InstagramTag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
