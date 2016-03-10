<?php

namespace Headoo\MediaSocialApiBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use Headoo\MediaSocialApiBundle\Entity\InstagramUser;
use Headoo\MediaSocialApiBundle\Entity\InstagramMedia;
use Headoo\MediaSocialApiBundle\Entity\Tweet;
use MetzWeb\Instagram\Instagram;

class InstagramManager extends GenericManager
{
    /**
     * @var EntityManager
     */
    protected $entityClass;
    protected $em;

    private $numberElements    = 20;

    //We can Map here all fields we will use for create the Instagram entity
    protected $_fieldsMappedToDB = array();


    /**
     *
     * {@inheritdoc }
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }


    /*
     * Search instagram with multiple tags
     *
     * @param array $tags;
     * @param int $number
     *
     * @return array $_ar
     */
    public function searchInstagramWithTags(array $tags, $number=null, $accessToken=null)
    {
        if($accessToken)
            $_accesToken = $accessToken;
        else
            $_accesToken = $this->access_token;

        $_ar = array();
        foreach($tags as $tag)
        {
            $_ar[$tag] = self::searchInstagramWithTag($tag, $number,$_accesToken);
        }

        return $_ar;
    }

    /*
     * Search intagram with just one tag
     *
     * @param string $tag;
     * @param int $number
     * @param string $accessToken
     *
     * @return array
     */
    public function searchInstagramWithTag($tag , $number=null, $accessToken=null)
    {
        if($number)
            $this->numberElements = $number;

        if($accessToken)
            $_accesToken = $accessToken;
        else
            $_accesToken = $this->access_token;

        $instagram  = new Instagram($_accesToken);
        $medias     = $instagram->getTagMedia($tag, $number);

        if(self::_checkErrorsConnections($medias))
        {
            return self::_checkErrorsConnections($medias);
        }


        if(isset($medias->pagination->next_url))
        {
            $data['next_url']   = $medias->pagination->next_url;
        }

        $data['medias']     = self::insertMultiple($medias->data);
        return $data;
    }


    /**
     * Insert multiple tweets
     *
     * @param array $tweets;
     *
     * @return array $tweets
     */
    public function insertMultiple(array $instagrams)
    {
        $_instagrams = array();

        foreach($instagrams as $instagram)
        {
            $_instagrams[] = self::insert($instagram);
        }

        return $_instagrams;
    }

    /**
     * Insert a Instagram with the user who belongs to
     *
     * @param object $_instagram;
     *
     * @return Tweet
     */
    public function insert($_instagram)
    {
        //We can Map here all fields we will use for create the Instagram entity
        $this->_fieldsMappedToDB    = array('instagramId'=>'id','filter' => 'filter','Link' =>'link','Type' =>'type','likes'=>'likes->count','comments'=>'comments->count' );

        $this->entityClass          = 'Instagram';
        $instagram                  = self::isEntityExists($_instagram->id, 'InstagramId');

        $instagram->setCreatedAt(\DateTime::createFromFormat('U', $_instagram->created_time));
        $instagram                  = self::mapObjectToEntity($instagram, $_instagram);
        $instagramUser              = self::_createUser($_instagram->user);
        $instagram->setUser($instagramUser);

        if($_instagram->caption)
        {
            $instagramCaption           = self::_createCaption($_instagram->caption, $instagram);
            $instagram->setInstagramCaption($instagramCaption);
        }


        $this->em->persist($instagram);
        $this->em->flush();


        if(isset($_instagram->images)  || isset($_instagram->videos ))
            $instagramMedia  = self::_createMedia($_instagram, $instagram);

        self::_createTags($_instagram, $instagram);
        self::_createComments($_instagram, $instagram);

        return $instagram;
    }

    /**
     * Create user
     *
     * @param object $_user;
     *
     * @return InstagramUser user
     */
    private function _createUser($_user)
    {
        //Set user
        $this->_fieldsMappedToDB    = array('userId' => 'id', 'username'=>'username', 'profilePicture'=>'profile_picture', 'fullname'=>'full_name');
        $this->entityClass          = 'InstagramUser';
        $instagramUser              = self::isEntityExists($_user->id, 'UserId');
        $instagramUser              = self::mapObjectToEntity($instagramUser, $_user);
        $this->em->persist($instagramUser);
        $this->em->flush();

        return $instagramUser;
    }

    /**
     * Create user
     *
     * @param object $_caption;
     *
     * @return InstagramCaption $instagramCaption
     */
    private function _createCaption($_caption, $instagram)
    {
        $this->_fieldsMappedToDB    = array('text' => 'text', 'captionId'=>'id');
        $this->entityClass          = 'InstagramCaption';
        $instagramCaption           = self::isEntityExists($_caption->id, 'CaptionId');
        $instagramCaption->setCreatedAt(\DateTime::createFromFormat('U', $_caption->created_time));
        $instagramCaption           = self::mapObjectToEntity($instagramCaption, $_caption);

        $user = self::_createUser($_caption->from);
        $instagramCaption->setuser($user);

        $this->em->persist($instagramCaption);
        $this->em->flush();

        return $instagramCaption;
    }


    /**
     * Create Media
     *
     * @param object $_instagram;
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram;
     *
     * @return null
     */
    private function _createMedia($_instagram, \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        //We check if we have video or photo
        if(isset($_instagram ->videos))
            self::_createMediaVideo($_instagram, $instagram);

        $_media = $_instagram->images;
        $this->entityClass          = 'InstagramMedia';
        // NO ID FOR INSTAGRAM MEDIA, SO WE NEED TO CHECK FROM URL LOW RESOLUTION
        $instagramMedia             = self::isEntityExists($_media->low_resolution->url, 'mediaUrlLow');

        $this->_fieldsMappedToDB    = array('mediaUrlLow' => 'low_resolution->url', 'mediaUrlLowWidth'=>'low_resolution->width', 'mediaUrlLowheight'=>'low_resolution->height',
                                            'mediaUrlThumbnail' => 'thumbnail->url', 'mediaUrlThumbnailWidth'=>'thumbnail->width', 'mediaUrlThumbnailheight'=>'thumbnail->height',
                                            'mediaUrlStandard' => 'standard_resolution->url', 'mediaUrlStandardWidth'=>'standard_resolution->width', 'mediaUrlStandardheight'=>'standard_resolution->height');

        $instagramMedia             = self::mapObjectToEntity($instagramMedia, $_media);
        $instagramMedia->setInstagram($instagram);


        $this->em->persist($instagramMedia);
        $this->em->flush();
    }


    /**
     * Create Media Video
     *
     * @param object $_instagram;
     *
     * @return Object $media
     */
    private function _createMediaVideo($_instagram, $instagram)
    {
        $this->entityClass          = 'InstagramMedia';
        $_media                     = $_instagram->videos;

        $this->_fieldsMappedToDB    = array('mediaUrlLow' => 'low_resolution->url', 'mediaUrlLowWidth'=>'low_resolution->width', 'mediaUrlLowheight'=>'low_resolution->height',
            'mediaUrlStandard' => 'standard_resolution->url', 'mediaUrlStandardWidth'=>'standard_resolution->width', 'mediaUrlStandardheight'=>'standard_resolution->height');

        // NO ID FOR INSTAGRAM MEDIA, SO WE NEED TO CHECK FROM URL LOW RESOLUTION IF EXISTS
        $instagramMedia             = self::isEntityExists($_media->low_resolution->url, 'mediaUrlLow');
        $instagramMedia             = self::mapObjectToEntity($instagramMedia, $_media);
        $instagramMedia->setInstagram($instagram);


        $this->em->persist($instagramMedia);
        $this->em->flush();
    }



    /**
     * Check if errors for connections
     *
     * @return Error
     */
    private function _createTags($_instagram, $instagram)
    {
        foreach($_instagram->tags as $tag)
        {
            $this->entityClass          = 'InstagramTag';
            $instagramTag               = self::isEntityExists($tag, 'Text');

            $instagramTag->setText($tag);

            $instagram->addTag($instagramTag);
            $this->em->persist($instagram);

            $this->em->persist($instagramTag);
        }

        $this->em->flush();
    }


    /**
     * Insert comments in DB
     *
     * @return Error
     */
    private function _createComments($_instagram, $instagram)
    {
        foreach($_instagram->comments->data as $comment)
        {
            $this->_fieldsMappedToDB    = array('commentId' => 'id', 'text'=>'text');
            $this->entityClass          = 'InstagramComment';
            $instagramComment           = self::isEntityExists($comment->id, 'CommentId');
            $instagramComment->setCreatedAt(\DateTime::createFromFormat('U', $comment->created_time));
            $instagramComment           = self::mapObjectToEntity($instagramComment, $comment);

            $instagramComment->setInstagram($instagram);

            $user = self::_createUser($comment->from);
            $instagramComment->setuser($user);

            $this->em->persist($instagramComment);
        }
        $this->em->flush();
    }

    /**
     * Check connection problem
     *
     * @return Error
     */
    private function _checkErrorsConnections($data = null)
    {
        /*if(!$this->access_token)
            return 'No instagram Key  @t headoo_media_social_api.instagram_access.access_token in your config.yml';*/

        if($data && $data->meta->code !==200 )
            return $data->meta->error_type . ':' . $data->meta->error_message;
    }



    /**
     * Insert multiple instagram from URL
     *
     * @param $url
     *
     * @return array $instagram
     */
    public function insertFromURL($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $medias = json_decode($response);

        curl_close($ch);

        $data['next_url']   = $medias->pagination->next_url;
        $data['medias']     = self::insertMultiple($medias->data);
        $data['curl']       = $ch;
        return $data;
    }
}