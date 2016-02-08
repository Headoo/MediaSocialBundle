<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instagram Tag
 *
 * @ORM\Table(name="instagram_comments")
 * @ORM\Entity
 */
class InstagramComment extends Generic
{
    /**
     * @var integer
     * @ORM\Column(name="comment_id", type="bigint", nullable=false)
     */
    private $commentId;


    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var Instagram
     *
     * @ORM\ManyToOne(targetEntity="Instagram", inversedBy="instagramComment", cascade={"persist"})
     * @ORM\JoinColumn(name="instagram_id", referencedColumnName="id", nullable=true)
     */
    protected $instagram;

    /**
     * @var InstagramUser
     *
     * @ORM\ManyToOne(targetEntity="InstagramUser", inversedBy="instagramComment", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instagrams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return InstagramTag
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
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return InstagramTag
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
     * @return InstagramTag
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
     * Add instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     *
     * @return InstagramTag
     */
    public function addInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagrams[] = $instagram;

        return $this;
    }

    /**
     * Remove instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     */
    public function removeInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagrams->removeElement($instagram);
    }

    /**
     * Get instagrams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstagrams()
    {
        return $this->instagrams;
    }

    /**
     * Set commentId
     *
     * @param integer $commentId
     *
     * @return InstagramComment
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;

        return $this;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return InstagramComment
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
     * Set instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     *
     * @return InstagramComment
     */
    public function setInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram = null)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Instagram
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set user
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramUser $user
     *
     * @return InstagramComment
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
}
