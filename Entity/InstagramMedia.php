<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstagramMediaUrls
 *
 * @ORM\Table(name="instagram_medias")
 * @ORM\Entity
 */
class InstagramMedia extends Generic
{


    /**
     * @var Intagram
     *
     * @ORM\ManyToOne(targetEntity="Instagram", inversedBy="instagramMedia", cascade={"persist"})
     * @ORM\JoinColumn(name="instagram_id", referencedColumnName="id", nullable=true)
     */
    protected $instagram;


    /**
     * @var string
     *
     * @ORM\Column(name="media_url_low", type="string", length=255, nullable=false)
     */
    private $mediaUrlLow;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_low_width", type="string", length=4, nullable=false)
     */
    private $mediaUrlLowWidth;

    /**
    * @var string
    *
    * @ORM\Column(name="media_url_low_height", type="string", length=4, nullable=false)
    */
    private $mediaUrlLowHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_thumbnail", type="string", length=255, nullable=true)
     */
    private $mediaUrlThumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_thumbnail_width", type="string", length=4, nullable=true)
     */
    private $mediaUrlThumbnailWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_thumbnail_height", type="string", length=4, nullable=true)
     */
    private $mediaUrlThumbnailHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_standard", type="string", length=255, nullable=false)
     */
    private $mediaUrlStandard;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_standard_width", type="string", length=4, nullable=false)
     */
    private $mediaUrlStandardWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url_standard_height", type="string", length=4, nullable=false)
     */
    private $mediaUrlStandardHeight;



    /**
     * Set mediaUrlLow
     *
     * @param string $mediaUrlLow
     *
     * @return InstagramMedia
     */
    public function setMediaUrlLow($mediaUrlLow)
    {
        $this->mediaUrlLow = $mediaUrlLow;

        return $this;
    }

    /**
     * Get mediaUrlLow
     *
     * @return string
     */
    public function getMediaUrlLow()
    {
        return $this->mediaUrlLow;
    }

    /**
     * Set mediaUrlLowWidth
     *
     * @param string $mediaUrlLowWidth
     *
     * @return InstagramMedia
     */
    public function setMediaUrlLowWidth($mediaUrlLowWidth)
    {
        $this->mediaUrlLowWidth = $mediaUrlLowWidth;

        return $this;
    }

    /**
     * Get mediaUrlLowWidth
     *
     * @return string
     */
    public function getMediaUrlLowWidth()
    {
        return $this->mediaUrlLowWidth;
    }

    /**
     * Set mediaUrlLowHeight
     *
     * @param string $mediaUrlLowHeight
     *
     * @return InstagramMedia
     */
    public function setMediaUrlLowHeight($mediaUrlLowHeight)
    {
        $this->mediaUrlLowHeight = $mediaUrlLowHeight;

        return $this;
    }

    /**
     * Get mediaUrlLowHeight
     *
     * @return string
     */
    public function getMediaUrlLowHeight()
    {
        return $this->mediaUrlLowHeight;
    }

    /**
     * Set mediaUrlThumbnail
     *
     * @param string $mediaUrlThumbnail
     *
     * @return InstagramMedia
     */
    public function setMediaUrlThumbnail($mediaUrlThumbnail)
    {
        $this->mediaUrlThumbnail = $mediaUrlThumbnail;

        return $this;
    }

    /**
     * Get mediaUrlThumbnail
     *
     * @return string
     */
    public function getMediaUrlThumbnail()
    {
        return $this->mediaUrlThumbnail;
    }

    /**
     * Set mediaUrlThumbnailWidth
     *
     * @param string $mediaUrlThumbnailWidth
     *
     * @return InstagramMedia
     */
    public function setMediaUrlThumbnailWidth($mediaUrlThumbnailWidth)
    {
        $this->mediaUrlThumbnailWidth = $mediaUrlThumbnailWidth;

        return $this;
    }

    /**
     * Get mediaUrlThumbnailWidth
     *
     * @return string
     */
    public function getMediaUrlThumbnailWidth()
    {
        return $this->mediaUrlThumbnailWidth;
    }

    /**
     * Set mediaUrlThumbnailHeight
     *
     * @param string $mediaUrlThumbnailHeight
     *
     * @return InstagramMedia
     */
    public function setMediaUrlThumbnailHeight($mediaUrlThumbnailHeight)
    {
        $this->mediaUrlThumbnailHeight = $mediaUrlThumbnailHeight;

        return $this;
    }

    /**
     * Get mediaUrlThumbnailHeight
     *
     * @return string
     */
    public function getMediaUrlThumbnailHeight()
    {
        return $this->mediaUrlThumbnailHeight;
    }

    /**
     * Set mediaUrlStandard
     *
     * @param string $mediaUrlStandard
     *
     * @return InstagramMedia
     */
    public function setMediaUrlStandard($mediaUrlStandard)
    {
        $this->mediaUrlStandard = $mediaUrlStandard;

        return $this;
    }

    /**
     * Get mediaUrlStandard
     *
     * @return string
     */
    public function getMediaUrlStandard()
    {
        return $this->mediaUrlStandard;
    }

    /**
     * Set mediaUrlStandardWidth
     *
     * @param string $mediaUrlStandardWidth
     *
     * @return InstagramMedia
     */
    public function setMediaUrlStandardWidth($mediaUrlStandardWidth)
    {
        $this->mediaUrlStandardWidth = $mediaUrlStandardWidth;

        return $this;
    }

    /**
     * Get mediaUrlStandardWidth
     *
     * @return string
     */
    public function getMediaUrlStandardWidth()
    {
        return $this->mediaUrlStandardWidth;
    }

    /**
     * Set mediaUrlStandardHeight
     *
     * @param string $mediaUrlStandardHeight
     *
     * @return InstagramMedia
     */
    public function setMediaUrlStandardHeight($mediaUrlStandardHeight)
    {
        $this->mediaUrlStandardHeight = $mediaUrlStandardHeight;

        return $this;
    }

    /**
     * Get mediaUrlStandardHeight
     *
     * @return string
     */
    public function getMediaUrlStandardHeight()
    {
        return $this->mediaUrlStandardHeight;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return InstagramMedia
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
     * @return InstagramMedia
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
     * Set instagram
     *
     * @param \Headoo\MediaSocialApiBundle\Entity\Instagram $instagram
     *
     * @return InstagramMedia
     */
    public function setInstagram(\Headoo\MediaSocialApiBundle\Entity\Instagram $instagram = null)
    {

        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return \Headoo\MediaSocialApiBundle\Entity\Instagram
     */
    public function getInstagram()
    {
        return $this->instagram;
    }
}
