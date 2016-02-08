<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweets
 *
 * @ORM\Table(name="twitter_tweets", indexes={@ORM\Index(name="created_at", columns={"created_at"}),@ORM\Index(name="tweet_id", columns={"tweet_id"})})
 * @ORM\Entity
 */
class Tweet extends Generic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tweet_id", type="bigint", nullable=false)
     */
    private $tweetId;

    /**
     * @var Tweets
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="tweet", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls", mappedBy="tweet", cascade={"persist", "remove"})
     */
    protected $tweetMediaUrl;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Headoo\MediaSocialApiBundle\Entity\TweetPlace", mappedBy="tweet", cascade={"persist", "remove"})
     */
    protected $tweetPlace;


    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=160, nullable=false)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;


    /**
     * @var boolean
     *
     * @ORM\Column(name="retweetet", type="boolean", nullable=false)
     */
    private $retweetet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="favorited", type="boolean", nullable=false)
     */
    private $favorited;

    /**
     * @var boolean
     *
     * @ORM\Column(name="truncated", type="boolean", nullable=false)
     */
    private $truncated;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=2, nullable=true)
     */
    private $lang;

    /**
     * @ORM\ManyToMany(targetEntity="TweetTags", inversedBy="tweets")
     * @ORM\JoinTable(name="twitter_tweets_tags")
     **/
    private $tags;

    /**
     * @var integer
     *
     * @ORM\Column(name="retweet_count", type="integer", length=3, nullable=false)
     */
    private $retweetCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="favorite_count", type="integer", length=3, nullable=false)
     */
    private $favoriteCount;

    /**
     * @ORM\OneToMany(targetEntity="Tweet", mappedBy="retweet")
     **/
    private $tweet;

    /**
     * @ORM\ManyToOne(targetEntity="Tweet", inversedBy="tweet")
     * @ORM\JoinColumn(name="retweet_id", referencedColumnName="id")
     **/
    private $retweet;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweetMediaUrls = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tweetPlace = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tweetId
     *
     * @param integer $tweetId
     *
     * @return Tweet
     */
    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;

        return $this;
    }

    /**
     * Get tweetId
     *
     * @return integer
     */
    public function getTweetId()
    {
        return $this->tweetId;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Tweet
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tweet
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
     * Set source
     *
     * @param string $source
     *
     * @return Tweet
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set retweetet
     *
     * @param boolean $retweetet
     *
     * @return Tweet
     */
    public function setRetweetet($retweetet)
    {
        $this->retweetet = $retweetet;

        return $this;
    }

    /**
     * Get retweetet
     *
     * @return boolean
     */
    public function getRetweetet()
    {
        return $this->retweetet;
    }

    /**
     * Set favorited
     *
     * @param boolean $favorited
     *
     * @return Tweet
     */
    public function setFavorited($favorited)
    {
        $this->favorited = $favorited;

        return $this;
    }

    /**
     * Get favorited
     *
     * @return boolean
     */
    public function getFavorited()
    {
        return $this->favorited;
    }

    /**
     * Set truncated
     *
     * @param boolean $truncated
     *
     * @return Tweet
     */
    public function setTruncated($truncated)
    {
        $this->truncated = $truncated;

        return $this;
    }

    /**
     * Get truncated
     *
     * @return boolean
     */
    public function getTruncated()
    {
        return $this->truncated;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return Tweet
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return Tweet
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
     * @return Tweet
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
     * @param \Headoo\MediaSocialApiBundle\Entity\Users $user
     *
     * @return Tweet
     */
    public function setUser(\Headoo\MediaSocialApiBundle\Entity\Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set place
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetPlace $user
     *
     * @return Tweet
     */
    public function setPlace(\Headoo\MediaSocialApiBundle\Entity\TweetPlace $place)
    {
        $this->tweetPlace = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\TweetPlace
     */
    public function getPlace()
    {
        return $this->tweetPlace;
    }


    /**
     * Add tag
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetTags $tag
     *
     * @return Tweet
     */
    public function addTag(\Headoo\MediaSocialApiBundle\Entity\TweetTags $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetTags $tag
     */
    public function removeTag(\Headoo\MediaSocialApiBundle\Entity\TweetTags $tag)
    {
        $this->tags->removeElement($tag);
    }


    /**
     * Set tweetMediaUrl
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl
     *
     * @return Tweet
     */
    public function setTweetMediaUrl(\Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl)
    {
        $this->tweetMediaUrl = $tweetMediaUrl;

        return $this;
    }

    /**
     * Get tweetMediaUrl
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls
     */
    public function getTweetMediaUrl()
    {
        return $this->tweetMediaUrl;
    }

    /**
     * Set tweetPlace
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace
     *
     * @return Tweet
     */
    public function setTweetPlace(\Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace)
    {
        $this->tweetPlace = $tweetPlace;

        return $this;
    }

    /**
     * Get tweetPlace
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\TweetPlace
     */
    public function getTweetPlace()
    {
        return $this->tweetPlace;
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

    /**
     * Add tweetMediaUrl
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl
     *
     * @return Tweet
     */
    public function addTweetMediaUrl(\Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl)
    {
        $this->tweetMediaUrl[] = $tweetMediaUrl;

        return $this;
    }

    /**
     * Remove tweetMediaUrl
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl
     */
    public function removeTweetMediaUrl(\Headoo\MediaSocialApiBundle\Entity\TweetMediaUrls $tweetMediaUrl)
    {
        $this->tweetMediaUrl->removeElement($tweetMediaUrl);
    }

    /**
     * Add tweetPlace
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace
     *
     * @return Tweet
     */
    public function addTweetPlace(\Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace)
    {
        $this->tweetPlace[] = $tweetPlace;

        return $this;
    }

    /**
     * Remove tweetPlace
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace
     */
    public function removeTweetPlace(\Headoo\MediaSocialApiBundle\Entity\TweetPlace $tweetPlace)
    {
        $this->tweetPlace->removeElement($tweetPlace);
    }

    /**
     * Set retweetCount
     *
     * @param integer $retweetCount
     *
     * @return Tweet
     */
    public function setRetweetCount($retweetCount)
    {
        $this->retweetCount = (int)$retweetCount;

        return $this;
    }

    /**
     * Get retweetCount
     *
     * @return integer
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * Set favoriteCount
     *
     * @param integer $favoriteCount
     *
     * @return Tweet
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = (int)$favoriteCount;

        return $this;
    }

    /**
     * Get favoriteCount
     *
     * @return integer
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * Set retweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $retweet
     *
     * @return Tweet
     */
    public function setRetweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $retweet = null)
    {
        $this->retweet = $retweet;

        return $this;
    }

    /**
     * Get retweet
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Tweet
     */
    public function getRetweet()
    {
        return $this->retweet;
    }

    /**
     * Add tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     *
     * @return Tweet
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

    /**
     * Get tweet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTweet()
    {
        return $this->tweet;
    }
}
