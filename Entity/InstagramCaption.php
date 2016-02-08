<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TweetMediaUrls
 *
 * @ORM\Table(name="instagram_captions", indexes={@ORM\Index(name="caption_id", columns={"caption_id"})})
 * @ORM\Entity
 */
class InstagramCaption extends Generic
{
    /**
     * @var integer
     * @ORM\Column(name="caption_id", type="string",length=30 , nullable=false)
     */
    private $captionId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\Instagram", mappedBy="instagramCaption", cascade={"persist", "remove"})
     */
    protected $instagram;


    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;


    /**
     * @var InstagramUser
     *
     * @ORM\ManyToOne(targetEntity="InstagramUser", inversedBy="instagramCaption", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instagram = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set captionId
     *
     * @param string $captionId
     *
     * @return InstagramCaption
     */
    public function setCaptionId($captionId)
    {
        $this->captionId = $captionId;

        return $this;
    }

    /**
     * Get captionId
     *
     * @return string
     */
    public function getCaptionId()
    {
        return $this->captionId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return InstagramCaption
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
     * Set text
     *
     * @param string $text
     *
     * @return InstagramCaption
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
     * @return InstagramCaption
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
     * @return InstagramCaption
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
     * @return InstagramCaption
     */
    public function addInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagram[] = $instagram;

        return $this;
    }

    /**
     * Remove instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     */
    public function removeInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagram->removeElement($instagram);
    }

    /**
     * Get instagram
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return InstagramCaption
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
