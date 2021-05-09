<?php


namespace Office365;

use Office365\Runtime\Actions\CreateEntityQuery;
use Office365\Runtime\ClientObject;
use Office365\Runtime\ClientObjectCollection;
use Office365\Runtime\ClientRuntimeContext;
use Office365\Runtime\ResourcePath;

class EntityCollection extends ClientObjectCollection
{
    public function __construct(ClientRuntimeContext $ctx, ResourcePath $resourcePath = null, $itemTypeName = null)
    {
        parent::__construct($ctx, $resourcePath,null, $itemTypeName);
    }

    /**
     * @param string $id
     * @return Entity
     */
    function getById($id)
    {
        /** @var Entity $entity */
        $entity = $this->createType();
        $entity->resourcePath = new ResourcePath($id, $this->getResourcePath());
        return $entity;
    }

    /**
     * A generic way to create a new resource
     * @return Entity
     */
    public function add(){
        /** @var Entity $entity */
        $entity = $this->createType();
        $this->addChild($entity);
        $qry = new CreateEntityQuery($entity);
        $this->getContext()->addQueryAndResultObject($qry,$entity);
        return $entity;
    }

    /**
     * Returns the value at specified offset
     *
     * @param int|string Entity could be addressed by id/userPrincipalName or by index offset
     * @access public
     * @return ClientObject
     * @abstracting ArrayAccess
     */
    public function offsetGet($offset)
    {
        if(is_int($offset))
            return parent::offsetGet($offset);
        return new Entity($this->getContext(),new ResourcePath($offset, $this->getResourcePath()));
    }

}