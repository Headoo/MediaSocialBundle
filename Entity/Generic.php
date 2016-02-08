<?php

namespace Headoo\MediaSocialApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/*
 * @ORM\MappedSuperclass
 */
abstract class Generic
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @var \Datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="imported_at")
     */
    protected $importedAt;

    /**
     * @var \Datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set created
     *
     * @param \DateTime $imported
     * @return Menu
     */
    public function setImported($imported)
    {
        $this->importedAt = $imported;

        return $this;
    }

    /**
     * Get imported
     *
     * @return \DateTime
     */
    public function getImported()
    {
        return $this->importedAt;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Menu
     */
    public function setUpdated($updated)
    {
        $this->updatedAt = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updatedAt;
    }




}