<?php
namespace Headoo\MediaSocialBundle\Tests\Services\Manager;

use \Headoo\MediaSocialApiBundle\Services\Manager\TweetManager;

class TweetManagerTest extends \PHPUnit_Framework_TestCase
{
    const ACCESS_TOKEN = '';
    const ACCESS_TOKEN_SECRET = '';
    const CONSUMER_KEY = '';
    const CONSUMER_SECRET = '';
    
    
    /**
     * @var TweetManager
     */
    protected $oTweetManager;
    
    protected function setUp()
    {
        $this->oTweetManager = new TweetManager(
            $this->getEntityManagerDouble(),
            self::ACCESS_TOKEN,
            self::ACCESS_TOKEN_SECRET,
            self::CONSUMER_KEY,
            self::CONSUMER_SECRET
        );
    }
    
    public function testSearchTweetWithURLReturnArray()
    {
        die(var_dump($this->oTweetManager));
    }
    
    /**
     * @return EntityManager
     */
    private function getEntityManagerDouble()
    {
        return $this->getMock('Doctrine\ORM\EntityManager');
    }
}