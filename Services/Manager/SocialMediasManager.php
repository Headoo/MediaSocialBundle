<?php

namespace Headoo\MediaSocialApiBundle\Services\Manager;

use MetzWeb\Instagram\Instagram;

class SocialMediasManager extends GenericManager
{
    /**
     * @var EntityManager
     */

    private $numberElements    = 20;

    protected $tweetManager;
    protected $instagramManager;

    /**
     *
     * {@inheritdoc }
     */
    public function __construct(TweetManager $tweetManager, InstagramManager $instagramManager)
    {
        $this->tweetManager     = $tweetManager;
        $this->instagramManager = $instagramManager;
    }


    /*
     * Search instagram and twitter with multiple tags
     *
     * @param array $tags;
     * @param int $number
     *
     * @return array $_ar
     */
    public function searchMediasWithTags(array $tags, $number=null)
    {
        if($number)
            $this->numberElements = $number;

        $_ar = array();
        $_ar['instagram'] = $this->instagramManager->searchInstagramWithTags($tags, $this->numberElements);
        $_ar['twiter']    = $this->tweetManager->searchTweetWithTags($tags, $number);

        return $_ar;
    }

    /*
     * Search intagram with just one tag
     *
     * @param string $tag;
     * @param int $number
     *
     * @return array
     */
    public function searchMediasWithTag($tag , $number=null)
    {
        if($number)
            $this->numberElements = $number;

        $instagram = new Instagram('85670c857e314427a9fc5aac80962646');
        $medias = $instagram->getTagMedia($tag, $this->numberElements);

        dump($medias);

        return self::insertMultiple($medias->data);
    }

}