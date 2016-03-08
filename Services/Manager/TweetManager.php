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
    public function __construct(EntityManager $em, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret)
    {
        parent::__construct($em);

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

        $this->currentApiUrl = $this -> twitterApiUrl . $this -> searchApi;

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
        if(filter_var($urlToSearch, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('The given URL ("' . $urlToSearch . '") is invalid!');
        }
        $this->setMaxTweets($number);

        $getfield = '?q=' . $urlToSearch .  '&count=' . $this->numberTweet;

        $this->currentApiUrl = $this -> twitterApiUrl . $this -> searchApi;

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
     * Get stats for the specified URL
     *
     * @param $url
     * @param null $number
     *
     * @return array An associative array with the keys tweetsCount, retweetsCount and favoriteCount if all is OK
     */
    public function getStatsForTweetWithURL($url , $number=null) {
        $data = $this->searchTweetWithURL($url, $number);
        if(!is_array($data)) {
            return $data;
        }

        if(isset($data['medias']) && !empty($data['medias'])) {
            return $this->countTweetsData($data['medias']);
        }

        return array();
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
        if(empty($this->currentApiUrl)) {
            return null;
        }
        $_settings = $this->_settingsConnection($settings);

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getField)
            ->buildOauth($this->currentApiUrl, $this -> requestMethod)
            ->performRequest();

        $tweets = json_decode($response);

        // @TODO: Improve error catching
        try {
            $this->_checkErrorsConnections($tweets);
        } catch(\Exception $e) {
            return null;
        }

        return $tweets;
    }

    /**
     * Get more tweets by cycling through the search "next_url" query param
     * @param $data \DateInterval
     * @param $settings
     */
    private function getMoreTweets(&$data, $settings) {
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
            $retweetsCount += $tweet->getRetweetCount();
            $favoriteCount += $tweet->getFavoriteCount();
        }

        return array(
            'tweetsCount' => $tweetsCount,
            'retweetsCount' => $retweetsCount,
            'favoriteCount' => $favoriteCount,
        );
    }


    /**
     * Insert multiple tweets
     *
     * @param array $tweets;
     *
     * @return array $tweets
     */
    private function insertMultiple(array $tweets)
    {
        $_tweets = array();

        foreach($tweets as $tweet)
        {
            $_tweets[] = $this->insert($tweet);
        }

        return $_tweets;
    }

    /**
     * Insert a Tweet with the user who belongs the tweet
     *
     * @param object $_tweet;
     *
     * @return Tweet
     */
    private function insert($_tweet)
    {
        $this->_fieldsMappedToDB = array('tweetId'=>'id', 'text'=>'text', 'source'=>'source', 'truncated'=>'truncated', 'favorited'=>'favorited', 'retweetet'=>'retweeted', 'lang' => 'lang', 'retweetCount'=>'retweet_count', 'favoriteCount'=>'favorite_count');
        $this->entityClass = 'Tweet';

        $tweet = $this->isEntityExists($_tweet->id, 'TweetId');

        $tweet->setCreatedAt(new \DateTime(date( 'Y-m-d H:i:s', str_replace("+0000",'',strtotime($_tweet->created_at))) ));
        $tweet = $this->mapObjectToEntity($tweet, $_tweet);

        $user = $this->_createUser($_tweet->user);
        $tweet->setUser($user);

        if(isset($_tweet->retweeted_status))
        {
            $fromRetweet = $this->insert($_tweet->retweeted_status);
            $tweet->setRetweet($fromRetweet);
        }

        $this->em->persist($tweet);
        $this->em->flush();

        if(isset($_tweet->entities->media))
            $this->_createMedia($_tweet->entities->media, $tweet);

        if(isset($_tweet->entities->hashtags))
            $this->_createTags($_tweet->entities->hashtags, $tweet);

        if($_tweet->place)
            $this->_createPlace($_tweet->place, $tweet);

        $this->em->flush();

        return $tweet;
    }


    /**
     * Create user
     *
     * @param object $_user;
     *
     * @return User user
     */
    private function _createUser($_user)
    {
        $this->_fieldsMappedToDB    = array('userId' => 'id', 'name'=>'name', 'screenName'=>'screen_name', 'location'=>'location',
                                            'description'=>'description','url'=>'url','FollowersCount'=>'followers_count', 'FriendsCount'=>'friends_count',
                                            'listedCount'=>'listed_count', 'TimeZone'=>'time_zone', 'ProfileBackgroundImageUrl'=>'profile_background_image_url',
                                            'ProfileImageUrl'=>'profile_image_url');

        $this->entityClass          = 'Users';
        $twitterUser                = $this->isEntityExists($_user->id, 'UserId');
        $twitterUser                = $this->mapObjectToEntity($twitterUser, $_user);

        $twitterUser->setCreatedAt(new \DateTime(date( 'Y-m-d H:i:s', str_replace("+0000",'',strtotime($_user->created_at))) ));

        $this->em->persist($twitterUser);
        $this->em->flush();

        return $twitterUser;
    }

    /**
     * Create Media
     *
     * @param array $_medias Array of media ids;
     *
     * @return true
     */
    private function _createMedia($_medias, $tweet)
    {
        $this->entityClass = 'TweetMediaUrls';
        $this->_fieldsMappedToDB = array('MediaUrl'=>'media_url', 'MediaId'=>'id', 'DisplayUrl'=>'display_url', 'Type'=>'type');

        foreach($_medias as $_media)
        {
            $media = $this->isEntityExists($_media->id, 'mediaId');
            $media = $this->mapObjectToEntity($media, $_media);

            $media->setTweet($tweet);

            $this->em->persist($media);
        }

        $this->em->flush();

        return true;
    }

    /**
     * Create Tags
     *
     * @param array $_tags Array of tags;
     *
     * @return true
     */
    private function _createTags($_tags, $tweet)
    {
        $this->entityClass = 'TweetTags';
        $this->_fieldsMappedToDB = array('text'=>'text');

        foreach($_tags as $_tag)
        {
            $tag = $this->isEntityExists($_tag->text, 'text');
            $tag = $this->mapObjectToEntity($tag, $_tag);

            $tweet->addTag($tag);

            $this->em->persist($tweet);
            $this->em->persist($tag);


            $tweet->addTag($tag);
        }

        $this->em->flush();

        return true;
    }


    /**
     * Create a Place on table twitter
     *
     * @return TweetPlace
     */
    private function _createPlace($_place, $tweet)
    {
        $this->entityClass = 'TweetPlace';
        $this->_fieldsMappedToDB = array('placeId'=>'id','url'=>'url','PlaceType'=>'place_type','name'=>'name', 'fullName'=>'full_name','countryCode'=>'country_code','country' => 'country');

        $place = $this->isEntityExists($_place->id, 'PlaceId');
        $place = $this->mapObjectToEntity($place, $_place);

        $place->setTweet($tweet);

        $this->em->persist($place);
        $this->em->flush();

        return $place;
    }

    /**
     * Check if errors for connections
     *
     * @param null $data
     * @throws \Exception|\InvalidArgumentException
     */
    private function _checkErrorsConnections($data = null)
    {
        if(!$this->oauth_access_token)
            throw new \InvalidArgumentException('No Twitter Key  @t headoo_media_social_api.twitter_access.oauth_access_token in your config.yml');

        if(!$this->oauth_access_token_secret)
            throw new \InvalidArgumentException('No Twitter Key  @t headoo_media_social_api.twitter_access.oauth_access_token_secret in your config.yml');

        if(!$this->consumer_key)
            throw new \InvalidArgumentException('No Twitter Key  @t headoo_media_social_api.twitter_access.consumer_key in your config.yml');

        if(!$this->consumer_secret)
            throw new \InvalidArgumentException('No Twitter Key  @t headoo_media_social_api.twitter_access.consumer_secret in your config.yml');

        if($data && isset($data->errors) && count($data->errors) > 0)
            throw new \Exception('code error:' . $data->errors[0]->code. ':' . $data->errors[0]->message);
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
        $data['medias'] = isset($tweets->statuses) ? $this->insertMultiple($tweets->statuses) : array();

        return $data;
    }

}