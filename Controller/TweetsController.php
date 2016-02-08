<?php
namespace Headoo\MediaSocialApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class TweetsController extends Controller
{
    /**
     * @Route("/tweets/stats/byUrl", name="tweets_stats_by_url", requirements={
     *     "url": "^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$",
     *     "count": "\d+",
     * }, defaults={"count" = 20})
     * @Method({"GET", "POST"})
     * @ApiDoc(
     *  description="Get tweets stats for a specific URL",
     *  requirements={
     *      {
     *          "name"="url",
     *          "dataType"="string",
     *          "description"="URL to check for"
     *      }
     *  },
     *  parameters={
     *      {"name"="url", "dataType"="string", "required"=true, "description"="URL to check for"},
     *      {"name"="count", "dataType"="integer", "required"=false, "description"="Max count of tweets to check for"}
     *  }
     * )
     */
    public function statsByUrlAction(Request $request) {
        $url = $request->get('url');
        $count = $request->get('count', null);
        $tweetStats = $this->get('headoo.twitter.tweet_manager')->getStatsForTweetWithURL($url, $count);

        return new JsonResponse($tweetStats);
    }

    /**
     * @Route("/tweets/stats/byTag", name="tweets_stats_by_tag", requirements={
     *     "tag": "\w+",
     *     "count": "\d+",
     * }, defaults={"count" = 20})
     * @Method({"GET", "POST"})
     * @ApiDoc(
     *  description="Get tweets stats for a specific tag",
     *  requirements={
     *      {
     *          "name"="tag",
     *          "dataType"="string",
     *          "description"="Tag to check for"
     *      }
     *  },
     *  parameters={
     *      {"name"="tag", "dataType"="string", "required"=true, "description"="tag to check for"},
     *      {"name"="count", "dataType"="integer", "required"=false, "description"="Max count of tweets to check for"}
     *  }
     * )
     */
    public function statsByTagAction(Request $request) {
        $tag = $request->get('tag');
        $count = $request->get('count', null);
        $tweetStats = $this->get('headoo.twitter.tweet_manager')->getStatsForTweetWithTag($tag, $count);

        return new JsonResponse($tweetStats);
    }

    /**
     * @Route("/tweets/stats/byScreenName", name="tweets_stats_by_screenname", requirements={
     *     "screen_name": "\w+",
     *     "count": "\d+",
     * }, defaults={"count" = 20})
     * @Method({"GET", "POST"})
     * @ApiDoc(
     *  description="Get tweets stats for a specific screen name",
     *  requirements={
     *      {
     *          "name"="screen_name",
     *          "dataType"="string",
     *          "description"="Screen name to check for"
     *      }
     *  },
     *  parameters={
     *      {"name"="screen_name", "dataType"="string", "required"=true, "description"="screen name to check for"},
     *      {"name"="count", "dataType"="integer", "required"=false, "description"="Max count of tweets to check for"}
     *  }
     * )
     */
    public function statsByScreenNameAction(Request $request) {
        $screenName = $request->get('screen_name');
        $count = $request->get('count', null);
        $tweetStats = $this->get('headoo.twitter.tweet_manager')->getStatsForTweetWithScreenName($screenName, $count);

        return new JsonResponse($tweetStats);
    }
}