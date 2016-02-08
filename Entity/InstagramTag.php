<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instagram Tag
 *
 * @ORM\Table(name="instagram_tags")
 * @ORM\Entity
 */
class InstagramTag extends Generic
{

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    // ...
    /**
     * @ORM\ManyToMany(targetEntity="Instagram", mappedBy="tags")
     **/
    private $instagrams;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instagrams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return InstagramTag
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
     * @return InstagramTag
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
     * @return InstagramTag
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
     * Add instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     *
     * @return InstagramTag
     */
    public function addInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagrams[] = $instagram;

        return $this;
    }

    /**
     * Remove instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     */
    public function removeInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram)
    {
        $this->instagrams->removeElement($instagram);
    }

    /**
     * Get instagrams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstagrams()
    {
        return $this->instagrams;
    }
}
