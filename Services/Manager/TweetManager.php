<?php

namespace Headoo\MediaSocialApiBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use Headoo\MediaSocialApiBundle\Entity\Tweet;
use TwitterAPIExchange;

class TweetManager extends GenericManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    private $twitterApiUrl      = 'https://api.twitter.com/1.1/';
    private $searchApi          = 'search/tweets.json';
    private $statusApi          = 'statuses/user_timeline.json';
    private $requestMethod      = 'GET';
    private $numberTweet        = 20;
    private $currentApiUrl;

    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;

    /**
     * Maximum count param value for Twitter API
     */
    const MAX_TWEET_COUNT = 100;
    /**
     * Maximum calls to do to next page for a search
     */
    const MAX_NEXT_PAGE_COUNT = 6;


    /**
     *
     * {@inheritdoc }
     */
    public function __construct($oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret)
    {

        $this->oauth_access_token          = $oauth_access_token;
        $this->oauth_access_token_secret   = $oauth_access_token_secret;
        $this->consumer_key                = $consumer_key;
        $this->consumer_secret             = $consumer_secret;
    }

    /*
     * Settings for connexion with Twitter
     *
     *
     * @return array $settings
     */
    private function _settingsConnection($settings=null)
    {
        $_settings = $settings;
        if(!$_settings)
        {
            $_settings = array(
                'oauth_access_token'        => $this->oauth_access_token ,
                'oauth_access_token_secret' => $this->oauth_access_token_secret,
                'consumer_key'              => $this->consumer_key,
                'consumer_secret'           => $this->consumer_secret
            );
        }

        return $_settings;
    }

    public function testSettingsConnectionReturn(){
        
        return $this->_settingsConnection();
    }
    
    /**
     * Sets/checks the max Tweets to get as result
     *
     * @param int $number
     */
    private function setMaxTweets($number = null) {
        if($number) {
            if($number < 0) {
                $number = 15;
            }
            if($number > self::MAX_TWEET_COUNT) {
                $number = self::MAX_TWEET_COUNT;
            }
            $this->numberTweet = $number;
        }
    }

    /*
     * Search tweet with multiple tags
     *
     * @param array $tags;
     * @param int $number
     *
     * @return array $_ar
     */
    public function searchTweetWithTags(array $tags, $number=null)
    {
        $_ar = array();
        foreach($tags as $tag)
        {
            $_ar[$tag] = $this->searchTweetWithTag($tag, $number);
        }

        return $_ar;
    }

    /*
     * Search tweet with just one tag
     *
     * @param string $tag;
     * @param int $number
     *
     * @return array
     */
    public function searchTweetWithTag($tag , $number=null, $settings=null)
    {
        $this->setMaxTweets($number);

        $getfield = '?q=' . $tag .  '&count=' . $this->numberTweet;

        $this->currentApiUrl = $this->twitterApiUrl . $this->searchApi;

        $tweets = $this->getTweetsList($settings, $getfield);
        if(!$tweets) {
            return null;
        }

        $data['medias'] = array();
        if(isset($tweets->search_metadata->next_results)) {
            $data['next_url'] = $tweets->search_metadata->next_results;
            $this->getMoreTweets($data, $settings);
        }
        $data['medias'] = array_merge($data['medias'], $this->insertMultiple($tweets->statuses));

        return $data;
    }

    /**
     * Get stats for the specified tag
     *
     * @param $tag
     * @param null $number
     *
     * @return array An associative array with the keys tweetsCount, retweetsCount and favoriteCount if all is OK
     */
    public function getStatsForTweetWithTag($tag , $number=null) {
        $data = $this->searchTweetWithURL($tag, $number);
        if(!is_array($data)) {
            return $data;
        }

        if(isset($data['medias']) && !empty($data['medias'])) {
            return $this->countTweetsData($data['medias']);
        }

        return array();
    }

    /*
     * Search tweet with the specified URL
     *
     * @param string $urlToSearch;
     * @param int $number
     *
     * @return array
     */
    public function searchTweetWithURL($urlToSearch , $number=null, $settings=null)
    {
        if(mb_strlen($urlToSearch) > 1000) {
            throw new \InvalidArgumentException('The given URL ("' . $urlToSearch . '") is more than 1000 chars long!');
        }
        if(!filter_var($urlToSearch, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('The given URL ("' . $urlToSearch . '") is invalid!');
        }
        $this->setMaxTweets($number);

        $getfield = '?q=' . $urlToSearch .  '&count=' . $this->numberTweet;

        $this->currentApiUrl = $this->twitterApiUrl.$this->searchApi;

        $tweets = $this->getTweetsList($settings, $getfield);
        return $tweets;

        // below Bad code

        if(!$tweets) {
            return null;
        }

        $data['medias'] = array();
        if(isset($tweets->search_metadata->next_results)) {
            // @TODO: Find a better way to get more tweets than with the next_url (see https://dev.twitter.com/rest/public/timelines)
            $data['next_url'] = $tweets->search_metadata->next_results;
            $this->getMoreTweets($data, $settings);
        }


        return $data;
    }

    /**
     * Get stats for the specified URL
     *
     * @param $url
     * @param null $number
     *
     * @return array An associative array with the keys tweetsCount, retweetsCount and favoriteCount if all is OK
     */
    public function getStatsForTweetWithURL($url , $number=null) {
        $data = $this->searchTweetWithURL($url, $number);

        if(isset($data['statuses']) && !empty($data['statuses'])) {
            return $this->countTweetsData($data['statuses']);
        }

        return [
            'tweetsCount' => 0,
            'retweetsCount' => 0,
            'favoriteCount' => 0,
        ];

;
    }

    /*
    * Return all tweets from a User with the screen name
    *
    * @param string $tag;
    * @param int $number
    *
    * @return array
    */
    public function searchTweetWithScreenName($screenName , $number=null, $settings=null)
    {
        $this->setMaxTweets($number);

        $getfield = '?screen_name=' . $screenName . '&count=' . $this->numberTweet;
        $this->currentApiUrl = $this -> twitterApiUrl . $this -> statusApi;

        $tweets = $this->getTweetsList($settings, $getfield);
        if(!$tweets) {
            return null;
        }

        $data['medias'] = array();
        if(isset($tweets->search_metadata->next_results)) {
            // @TODO: Find a better way to get more tweets than with the next_url (see https://dev.twitter.com/rest/public/timelines)
            $data['next_url'] = $tweets->search_metadata->next_results;
            $this->getMoreTweets($data, $settings);
        }
        $data['medias'] = array_merge($data['medias'], $this->insertMultiple($tweets->statuses));

        return $data;
    }

    /**
     * Get stats for the specified screen name
     *
     * @param $screenName
     * @param null $number
     *
     * @return array An associative array with the keys tweetsCount, retweetsCount and favoriteCount if all is OK
     */
    public function getStatsForTweetWithScreenName($screenName , $number=null) {
        $data = $this->searchTweetWithScreenName($screenName, $number);
        if(!is_array($data)) {
            return $data;
        }

        if(isset($data['medias']) && !empty($data['medias'])) {
            return $this->countTweetsData($data['medias']);
        }

        return array();
    }

    /**
     * Retrieve a list of Tweets from Twitter API
     * @param array $settings
     * @param string $getField Get part of the URL
     * @return mixed|null
     */
    private function getTweetsList($settings, $getField) {
        
        $_settings = $this->_settingsConnection($settings);

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getField)
            ->buildOauth($this->twitterApiUrl.$this->searchApi, $this->requestMethod)
            ->performRequest();

        $tweets = json_decode($response, true);

        return $tweets;
    }

    /**
     * Get more tweets by cycling through the search "next_url" query param
     * @param $data \DateInterval
     * @param $settings
     */
    private function getMoreTweets(&$data, $settings) {
        // TODO : éventuellement implémenté possibilité d'aller voir les pages suivantes.
        return;
        $nextPageCount = 0;
        do {
            $retrievedData = $this->insertFromURL($data['next_url'], $settings);
            $data['medias'] = array_merge($data['medias'], $retrievedData['medias']);
            $data['next_url'] = (isset($retrievedData['next_url']) && !empty($retrievedData['next_url'])) ? $retrievedData['next_url'] : null;
            $nextPageCount++;
            $morePagesAvailable = isset($data['next_url']) && !empty($data['next_url']);
        } while($morePagesAvailable && $nextPageCount <= self::MAX_NEXT_PAGE_COUNT);
    }

    /**
     * Do the counts based on a list of Tweet
     *
     * @param $tweets List of tweets to make stats for
     * @return array An associative array with the keys tweetsCount, retweetsCount and favoriteCount
     */
    private function countTweetsData($tweets) {
        $tweetsCount = 0;
        $retweetsCount = 0;
        $favoriteCount = 0;
        /** @var Tweet $tweet */
        foreach($tweets as $tweet) {
            $tweetsCount++;
//TODO
//            $retweetsCount += $tweet->getRetweetCount();
//            $favoriteCount += $tweet->getFavoriteCount();
        }

        return array(
            'tweetsCount' => $tweetsCount,
            'retweetsCount' => $retweetsCount,
            'favoriteCount' => $favoriteCount,
        );
    }

    /**
     * Search tweet with url next !
     *
     * @param string $url;
     * @param $settings
     *
     * @return array
     */
    public function insertFromURL($url, $settings=null)
    {
        $getfield = $url;

        $tweets = $this->getTweetsList($settings, $getfield);

        if(isset($tweets->search_metadata->next_results)) {
            $data['next_url'] = $tweets->search_metadata->next_results;
        }

        return $data;
    }

    public function testPrivateGetTweetsList($settings, $getField) {

        if(!is_array($settings) or empty($settings)) {
            throw new \InvalidArgumentException("settings not an filled array");
        }

        if(!is_string($getField) or empty($getField)) {
            throw new \InvalidArgumentException("getField not an filled string");
        }


        return $this->getTweetsList($settings, $getField);
    }
}


    