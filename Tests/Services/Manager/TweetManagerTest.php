<?php
// Usage :  php phpunit.phar --bootstrap vendor/autoload.php Tests/Services/Manager/TweetManagerTest.php

namespace Headoo\MediaSocialBundle\Tests\Services\Manager;

require(__DIR__."/../../../parameters.php");

use \Headoo\MediaSocialApiBundle\Services\Manager\TweetManager;

class TweetManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TweetManager
     */
    protected $oTweetManager;
    
    protected function setUp()
    {

        // TODO : make better config mechanism
        GLOBAL $parameters;

        $this->TweetManager = new TweetManager(
            $parameters['twitter']['oauth_access_token'],
            $parameters['twitter']['oauth_access_token_secret'],
            $parameters['twitter']['consumer_key'],            
            $parameters['twitter']['consumer_secret']
            );
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */

    public function testThatgetStatsForTweetWithURLRequiresOneParameter()
    {

        $this->TweetManager->getStatsForTweetWithURL();
    }


    public function testStatsForTweetWithURLForVariousUrl()
    {

        $this->assertInternalType('array', $this->TweetManager->getStatsForTweetWithURL("http://google.com"));

    }


    public function testGetStatsForTweetWithURLReturnsArray()
    {
        $array = $this->TweetManager->getStatsForTweetWithURL("http://google.com");
        $this->assertInternalType('array', $array);
    }


    public function testPrivateGetTweetsList()
    {
        $settings = $this->TweetManager->testSettingsConnectionReturn();
        $getField = '?q=' . "http://google.com" .  '&count=20';
        
        $this->assertInternalType('array', $this->TweetManager->testPrivateGetTweetsList($settings, $getField));
    }

    public function testSearchTweetWithPopularURL() {
        $this->assertInternalType('array', $this->TweetManager->searchTweetWithURL("http://google.com"));
    }

    public function testStatsForTweetForPopularUrl()
    {
        $array = $this->TweetManager->getStatsForTweetWithURL("http://google.com");
        $this->assertGreaterThan(0, $array['tweetsCount']);
    }

    public function testSettings() {
        $settings = $this->TweetManager->testSettingsConnectionReturn();
        $this->assertInternalType('array', $settings);
        $this->assertEquals(4, count($settings));


        foreach ($settings as $setting) {
            $this->assertInternalType('string', $setting);
            $this->assertNotEmpty($setting);
        }
    }


    public function testStrlen() {
         mb_internal_encoding('UTF-8');
        $string = "💩💩🐩";
        $this->assertEquals(mb_strlen($string), 3);
        $this->assertEquals(strlen($string), 12);
    }

    
    /**
     * @return EntityManager
     */
    private function getEntityManagerDouble()
    {
        return $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'findOneByTweetId','persist', 'flush'), array(), '', false);
    }
}