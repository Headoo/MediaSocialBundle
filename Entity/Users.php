<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Users
 *
 * @ORM\Table(name="twitter_users", indexes={@ORM\Index(name="user_name", columns={"name"}), @ORM\Index(name="screen_name", columns={"screen_name"}), @ORM\Index(name="description", columns={"description"})})
 * @ORM\Entity
 */
class Users extends Generic
{
    /**
     * @var integer
     * @ORM\Column(name="user_id", type="bigint", nullable=false)
     */
    private $userId;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Tweet", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $tweet;


    /**
     * @var string
     *
     * @ORM\Column(name="screen_name", type="string", length=20, nullable=false)
     */
    private $screenName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_image_url", type="string", length=200, nullable=true)
     */
    private $profileImageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=30, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="followers_count", type="integer", nullable=true)
     */
    private $followersCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="statuses_count", type="integer", nullable=true)
     */
    private $statusesCount;

    /**
     * @var string
     *
     * @ORM\Column(name="time_zone", type="string", length=40, nullable=true)
     */
    private $timeZone;


    /**
     * @var string
     *
     * @ORM\Column(name="profile_background_image_url", type="string", nullable=true, length=255)
     */
    private $profileBackgroundImageUrl;


    /**
     * @var string
     *
     * @ORM\Column(name="favourites_count", type="bigint", nullable=true)
     */
    private $friendsCount;

    /**
     * @var string
     *
     * @ORM\Column(name="listed_count", type="bigint", nullable=true)
     */
    private $listedCount;

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
     * Set screenName
     *
     * @param string $screenName
     * @return Users
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;

        return $this;
    }

    /**
     * Get screenName
     *
     * @return string 
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set profileImageUrl
     *
     * @param string $profileImageUrl
     * @return Users
     */
    public function setProfileImageUrl($profileImageUrl)
    {
        $this->profileImageUrl = $profileImageUrl;

        return $this;
    }

    /**
     * Get profileImageUrl
     *
     * @return string 
     */
    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Users
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Users
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Users
     */
    public function setDescription($description)
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Users
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
     * Set followersCount
     *
     * @param integer $followersCount
     * @return Users
     */
    public function setFollowersCount($followersCount)
    {
        $this->followersCount = $followersCount;

        return $this;
    }

    /**
     * Get followersCount
     *
     * @return integer 
     */
    public function getFollowersCount()
    {
        return $this->followersCount;
    }

    /**
     * Set friendsCount
     *
     * @param integer $friendsCount
     * @return Users
     */
    public function setFriendsCount($friendsCount)
    {
        $this->friendsCount = $friendsCount;

        return $this;
    }

    /**
     * Get friendsCount
     *
     * @return integer 
     */
    public function getFriendsCount()
    {
        return $this->friendsCount;
    }

    /**
     * Set statusesCount
     *
     * @param integer $statusesCount
     * @return Users
     */
    public function setStatusesCount($statusesCount)
    {
        $this->statusesCount = $statusesCount;

        return $this;
    }

    /**
     * Get statusesCount
     *
     * @return integer 
     */
    public function getStatusesCount()
    {
        return $this->statusesCount;
    }

    /**
     * Set timeZone
     *
     * @param string $timeZone
     * @return Users
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone
     *
     * @return string 
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importedAt =  new \DateTime();
        $this->updatedAt =  new \DateTime();
    }

    /**
     * Add tweets
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweets
     * @return Users
     */
    public function addTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweets)
    {
        $this->tweets[] = $tweets;

        return $this;
    }

    /**
     * Remove tweets
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweets
     */
    public function removeTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweets)
    {
        $this->tweets->removeElement($tweets);
    }

    /**
     * Get tweets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTweets()
    {
        return $this->tweets;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Users
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Set profileBackgroundImageUrl
     *
     * @param string $profileBackgroundImageUrl
     *
     * @return Users
     */
    public function setProfileBackgroundImageUrl($profileBackgroundImageUrl)
    {
        $this->profileBackgroundImageUrl = $profileBackgroundImageUrl;

        return $this;
    }

    /**
     * Get profileBackgroundImageUrl
     *
     * @return string
     */
    public function getProfileBackgroundImageUrl()
    {
        return $this->profileBackgroundImageUrl;
    }

    /**
     * Set listedCount
     *
     * @param integer $listedCount
     *
     * @return Users
     */
    public function setListedCount($listedCount)
    {
        $this->listedCount = $listedCount;

        return $this;
    }

    /**
     * Get listedCount
     *
     * @return integer
     */
    public function getListedCount()
    {
        return $this->listedCount;
    }

    /**
     * Set tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     *
     * @return Users
     */
    public function setTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweet = $tweet;

        return $this;
    }

    /**
     * Get tweet
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Tweet
     */
    public function getTweet()
    {
        return $this->tweet;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return Users
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
     * @return Users
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
}
