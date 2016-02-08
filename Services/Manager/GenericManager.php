<?php

namespace Headoo\MediaSocialApiBundle\Services\Manager;

use Doctrine\ORM\EntityManager;

abstract class GenericManager
{
    protected $em;
    protected $entityClass;
    protected $bundleName           = 'HeadooMediaSocialApiBundle';
    protected $entityBundleName     = 'Headoo\\MediaSocialApiBundle\\Entity\\';

    //We can Map here all fields we will use for create the entity
    protected $_fieldsMappedToDB;


    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Load entity with the associated id
     *
     * @param integer $id
     */
    public function get($id)
    {
        return $this->getRepository()->findOneById($id);
    }

    /**
     * Save entity
     *
     * @param object $entity
     * @param bool $andFlush
     */
    public function save($entity, $andFlush = true)
    {
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * Removes entity
     *
     * @param object $entity
     */
    public function destroy($entity, $andFlush = false)
    {
        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * Get the entity repository
     *
     */
    public function getRepository()
    {
        return $this->em->getRepository($this->bundleName . ':' . $this->entityClass);
    }



    /**
     * Check if object is in database
     *
     * @return Object
     */
    public function isEntityExists($id, $searchField)
    {
        //We create function for search in DB
        $searchfunction   = 'findOneBy' . ucfirst($searchField);
        $entity = $this->getRepository()->$searchfunction($id);
        if($entity) {
            return $entity;
        }
        else {
            $_class= $this->entityBundleName . $this->entityClass;
            $entity = new $_class();
        }

        return $entity;
    }

    /**
     * Map object to entity
     *
     * @return object $entity
     */
    public function mapObjectToEntity($entity, $object)
    {
        foreach ( $this->_fieldsMappedToDB as $fieldsFunction => $fieldsObject)
        {
            //There problem when you dynamically want to access sub property. We have to use this function
            $property = self::accessSubproperty($object,$fieldsObject);
            $savefunction   = 'set' . ucfirst($fieldsFunction);

            $entity -> $savefunction($property);
        }

        return $entity;
    }

    /**
     * For access subproperty in object dynamically
     *
     * @return string, object property $tmp
     */
    function accessSubproperty($object, $accessString) {
        $parts = explode('->', $accessString);
        $tmp = $object;
        while(count($parts)) {
            $tmp = $tmp->{array_shift($parts)};
        }
        return $tmp;
    }

}