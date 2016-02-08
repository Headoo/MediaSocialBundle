<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TweetMediaUrls
 *
 * @ORM\Table(name="twitter_tweet_media_urls")
 * @ORM\Entity
 */
class TweetMediaUrls extends Generic
{
    /**
     * @var integer
     * @ORM\Column(name="media_id", type="bigint", nullable=false)
     */
    private $mediaId;


    /**
     * @var Tweet
     *
     * @ORM\ManyToOne(targetEntity="Tweet", inversedBy="tweetMediaUrl", cascade={"persist"})
     * @ORM\JoinColumn(name="tweet_id", referencedColumnName="id", nullable=true)
     */
    protected $tweet;


    /**
     * @var string
     *
     * @ORM\Column(name="media_url", type="string", length=140, nullable=false)
     */
    private $mediaUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="display_url", type="string", length=140, nullable=false)
     */
    private $displayUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="expanded_url", type="string", length=140, nullable=false)
     */
    private $expandedUrl = '';


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=140, nullable=false)
     */
    private $type = '';


    /**
     * Set mediaUrl
     *
     * @param string $mediaUrl
     *
     * @return TweetMediaUrls
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;

        return $this;
    }

    /**
     * Get mediaUrl
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    /**
     * Set displayUrl
     *
     * @param string $displayUrl
     *
     * @return TweetMediaUrls
     */
    public function setDisplayUrl($displayUrl)
    {
        $this->displayUrl = $displayUrl;

        return $this;
    }

    /**
     * Get displayUrl
     *
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->displayUrl;
    }

    /**
     * Set expandedUrl
     *
     * @param string $expandedUrl
     *
     * @return TweetMediaUrls
     */
    public function setExpandedUrl($expandedUrl)
    {
        $this->expandedUrl = $expandedUrl;

        return $this;
    }

    /**
     * Get expandedUrl
     *
     * @return string
     */
    public function getExpandedUrl()
    {
        return $this->expandedUrl;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return TweetMediaUrls
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
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return TweetMediaUrls
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
     * @return TweetMediaUrls
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
     * @return TweetMediaUrls
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
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return TweetMediaUrls
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
}
