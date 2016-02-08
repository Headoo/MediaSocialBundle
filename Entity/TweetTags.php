<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TweetTags
 *
 * @ORM\Table(name="twitter_tweet_tags")
 * @ORM\Entity
 */
class TweetTags extends Generic
{

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    // ...
    /**
     * @ORM\ManyToMany(targetEntity="Tweet", mappedBy="tags")
     **/
    private $tweets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return TweetTags
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
     * @return TweetTags
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
     * @return TweetTags
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
     * Add tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     *
     * @return TweetTags
     */
    public function addTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweets[] = $tweet;

        return $this;
    }

    /**
     * Remove tweet
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Tweet $tweet
     */
    public function removeTweet(\Headoo\MediaSocialApiBundle\Entity\Tweet $tweet)
    {
        $this->tweets->removeElement($tweet);
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
}
