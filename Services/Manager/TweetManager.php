<?php

namespace Headoo\MediaSocialApiBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use Headoo\MediaSocialApiBundle\Entity\Tweet;
use JoseiOgr\TwitterAPIPHP\Connector\TwitterAPIExchange;

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

    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;


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
    private function _settingsConnexion($settings=null)
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
            $_ar[$tag] = self::searchTweetWithTag($tag, $number);
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
        if($number)
            $this->numberTweet = $number;

        $_settings = self::_settingsConnexion($settings);

        $getfield = '?q=' . $tag . '&count=' . $number;

        $url = $this -> twitterApiUrl . $this -> searchApi;

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $this -> requestMethod)
            ->performRequest();

        $tweets = json_decode($response);

        if(self::_checkErrorsConnections($tweets))
            return self::_checkErrorsConnections($tweets);

        if(isset($tweets->search_metadata->next_results))
            $data['next_url']   = $tweets->search_metadata->next_results;
        $data['medias']     = self::insertMultiple($tweets->statuses);

        return $data;
    }

    /*
     * Search tweet with the specified URL
     *
     * @param string $tag;
     * @param int $number
     *
     * @return array
     */
    public function searchTweetWithURl($url , $number=null, $settings=null)
    {
        if($number)
            $this->numberTweet = $number;

        $_settings = self::_settingsConnexion($settings);

        $getfield = '?q=' . $url . '&count=' . $number;

        $url = $this -> twitterApiUrl . $this -> searchApi;

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $this -> requestMethod)
            ->performRequest();

        $tweets = json_decode($response);

        if(self::_checkErrorsConnections($tweets))
            return self::_checkErrorsConnections($tweets);

        if(isset($tweets->search_metadata->next_results))
            $data['next_url']   = $tweets->search_metadata->next_results;
        $data['medias']     = self::insertMultiple($tweets->statuses);

        return $data;
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
        if($number)
            $this->numberTweet = $number;

        $_settings = self::_settingsConnexion($settings);

        $getfield = '?screen_name=' . $screenName . '&count=' . $number;
        $url = $this -> twitterApiUrl . $this -> statusApi;

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $this -> requestMethod)
            ->performRequest();

        $tweets = json_decode($response);

        if(self::_checkErrorsConnections($tweets))
            return self::_checkErrorsConnections($tweets);

        $data['next_url']   = $tweets->search_metadata->next_results;
        $data['medias']     = self::insertMultiple($tweets->statuses);

        return $data;
    }



    /**
     * Insert multiple tweets
     *
     * @param array $tweets;
     *
     * @return array $tweets
     */
    public function insertMultiple(array $tweets)
    {
        $_tweets = array();

        foreach($tweets as $tweet)
        {
            $_tweets[] = self::insert($tweet);
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
    public function insert($_tweet)
    {
        $this->_fieldsMappedToDB = array('tweetId'=>'id', 'text'=>'text', 'source'=>'source', 'truncated'=>'truncated', 'favorited'=>'favorited', 'retweetet'=>'retweeted', 'lang' => 'lang', 'retweetCount'=>'retweet_count', 'favoriteCount'=>'favorite_count');
        $this->entityClass = 'Tweet';

        $tweet = self::isEntityExists($_tweet->id, 'TweetId');

        $tweet->setCreatedAt(new \DateTime(date( 'Y-m-d H:i:s', str_replace("+0000",'',strtotime($_tweet->created_at))) ));
        $tweet = self::mapObjectToEntity($tweet, $_tweet);

        $user = $this->_createUser($_tweet->user);
        $tweet->setUser($user);

        if(isset($_tweet->retweeted_status))
        {
            $fromRetweet = self::insert($_tweet->retweeted_status);
            $tweet->setRetweet($fromRetweet);
        }

        $this->em->persist($tweet);
        $this->em->flush();

        if(isset($_tweet->entities->media))
            $this->_createMedia($_tweet->entities->media, $tweet);

        if(isset($_tweet->entities->hashtags))
            $this->_createTags($_tweet->entities->hashtags, $tweet);

        if($_tweet->place)
            $place = $this->_createPlace($_tweet->place, $tweet);

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
        $twitterUser                = self::isEntityExists($_user->id, 'UserId');
        $twitterUser                = self::mapObjectToEntity($twitterUser, $_user);

        $twitterUser->setCreatedAt(new \DateTime(date( 'Y-m-d H:i:s', str_replace("+0000",'',strtotime($_user->created_at))) ));

        $this->em->persist($twitterUser);
        $this->em->flush();

        return $twitterUser;
    }

    /**
     * Create Media
     *
     * @param array $_medias;
     *
     * @return
     */
    private function _createMedia($_medias, $tweet)
    {
        $this->entityClass = 'TweetMediaUrls';
        $this->_fieldsMappedToDB = array('MediaUrl'=>'media_url', 'MediaId'=>'id', 'DisplayUrl'=>'display_url', 'Type'=>'type');

        foreach($_medias as $_media)
        {
            $media = self::isEntityExists($_media->id, 'mediaId');

            $media = self::mapObjectToEntity($media, $_media);

            $media->setTweet($tweet);

            $this->em->persist($media);
        }

        $this->em->flush();

    }

    /**
     * Create Tags
     *
     * @param array $_tags;
     *
     * @return nothing
     */
    private function _createTags($_tags, $tweet)
    {
        $this->entityClass = 'TweetTags';
        $this->_fieldsMappedToDB = array('text'=>'text');

        foreach($_tags as $_tag)
        {
            $tag = self::isEntityExists($_tag->text, 'text');
            $tag = self::mapObjectToEntity($tag, $_tag);

            $tweet->addTag($tag);

            $this->em->persist($tweet);
            $this->em->persist($tag);


            $tweet->addTag($tag);
        }

        $this->em->flush();
    }


    /**
     * Create a Place on table twitter
     *
     * @return Place
     */
    private function _createPlace($_place, $tweet)
    {
        $this->entityClass = 'TweetPlace';
        $this->_fieldsMappedToDB = array('placeId'=>'id','url'=>'url','PlaceType'=>'place_type','name'=>'name', 'fullName'=>'full_name','countryCode'=>'country_code','country' => 'country');

        $place = self::isEntityExists($_place->id, 'PlaceId');
        $place = self::mapObjectToEntity($place, $_place);

        $place->setTweet($tweet);

        $this->em->persist($place);
        $this->em->flush();

        return $place;
    }

    /**
     * Check if errors for connections
     *
     * @return Error
     */
    private function _checkErrorsConnections($data = null)
    {
        if(!$this->oauth_access_token)
            return 'No Twitter Key  @t headoo_media_social_api.twitter_access.oauth_access_token in your config.yml';

        if(!$this->oauth_access_token_secret)
            return 'No Twitter Key  @t headoo_media_social_api.twitter_access.oauth_access_token_secret in your config.yml';

        if(!$this->consumer_key)
            return 'No Twitter Key  @t headoo_media_social_api.twitter_access.consumer_key in your config.yml';

        if(!$this->consumer_secret)
            return 'No Twitter Key  @t headoo_media_social_api.twitter_access.consumer_secret in your config.yml';

        if($data && isset($data->errors) && count($data->errors) > 0)
            return 'code error:' . $data->errors[0]->code. ':' . $data->errors[0]->message;
    }


    /*
     * Search tweet with url next !
     *
     * @param string $tag;
     * @param int $number
     *
     * @return array
     */
    public function insertFromURL($url, $settings=null)
    {
        $_settings = self::_settingsConnexion($settings);

        $getfield = $url;

        $url = $this -> twitterApiUrl . $this -> searchApi;

        $twitter = new TwitterAPIExchange($_settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $this -> requestMethod)
            ->performRequest();

        $tweets = json_decode($response);

        if(self::_checkErrorsConnections($tweets))
            return self::_checkErrorsConnections($tweets);

        if(isset($tweets->search_metadata->next_results))
            $data['next_url']   = $tweets->search_metadata->next_results;
        $data['medias']     = self::insertMultiple($tweets->statuses);

        return $data;
    }

}