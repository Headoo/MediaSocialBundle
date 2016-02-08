<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Instagram User
 *
 * @ORM\Table(name="instagram_users")
 * @ORM\Entity
 */
class InstagramUser extends Generic
{
    /**
     * @var integer
     * @ORM\Column(name="user_id", type="bigint", nullable=false)
     */
    private $userId;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\Instagram", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $instagram;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\InstagramCaption", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $instagramCaption;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\InstagramComment", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $instagramComment;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=200, nullable=true)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_picture", type="string", length=200, nullable=true)
     */
    private $profilePicture;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instagram = new \Doctrine\Common\Collections\ArrayCollection();
        $this->instagramCaption = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return InstagramUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return InstagramUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return InstagramUser
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set profilePicture
     *
     * @param string $profilePicture
     *
     * @return InstagramUser
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return InstagramUser
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
     * @return InstagramUser
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
     * @return InstagramUser
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
     * Add instagramCaption
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption
     *
     * @return InstagramUser
     */
    public function addInstagramCaption(\Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption)
    {
        $this->instagramCaption[] = $instagramCaption;

        return $this;
    }

    /**
     * Remove instagramCaption
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption
     */
    public function removeInstagramCaption(\Headoo\MediaSocialApiBundle\Entity\InstagramCaption $instagramCaption)
    {
        $this->instagramCaption->removeElement($instagramCaption);
    }

    /**
     * Get instagramCaption
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return InstagramUser
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
}
