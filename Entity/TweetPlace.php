<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TweetTags
 *
 * @ORM\Table(name="twitter_tweet_places")
 * @ORM\Entity
 */
class TweetPlace extends Generic
{

    /**
     * @var integer
     *
     * @ORM\Column(name="place_id", type="bigint", nullable=false)
     */
    private $placeId;


    /**
     * @var integer
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="place_type", type="string", length=100, nullable=false)
     */
    private $placeType;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=100, nullable=false)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=4, nullable=false)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=false)
     */
    private $country;

    /**
     * @var Tweet
     *
     * @ORM\ManyToOne(targetEntity="Tweet", inversedBy="tweetPlace", cascade={"persist"})
     * @ORM\JoinColumn(name="tweet_id", referencedColumnName="id", nullable=true)
     */
    protected $tweet;


    /**
     * Set placeId
     *
     * @param integer $placeId
     *
     * @return TweetPlace
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;

        return $this;
    }

    /**
     * Get placeId
     *
     * @return integer
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**getTweets
     * Set url
     *
     * @param string $url
     *
     * @return TweetPlace
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
     * Set placeType
     *
     * @param string $placeType
     *
     * @return TweetPlace
     */
    public function setPlaceType($placeType)
    {
        $this->placeType = $placeType;

        return $this;
    }

    /**
     * Get placeType
     *
     * @return string
     */
    public function getPlaceType()
    {
        return $this->placeType;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TweetPlace
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
     * Set fullName
     *
     * @param string $fullName
     *
     * @return TweetPlace
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return TweetPlace
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return TweetPlace
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return TweetPlace
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
     * @return TweetPlace
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
     * Set tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     *
     * @return TweetPlace
     */
    public function setTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweet = $tweet;

        return $this;
    }

    /**
     * Get tweet
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Tweets
     */
    public function getTweet()
    {
        return $this->tweet;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweet = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     *
     * @return TweetPlace
     */
    public function addTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweet[] = $tweet;

        return $this;
    }

    /**
     * Remove tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     */
    public function removeTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweet->removeElement($tweet);
    }
}
