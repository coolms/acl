<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Resource;

use Zend\Permissions\Acl\Resource\GenericResource,
    Zend\Permissions\Acl\Resource\ResourceInterface,
    CmsAcl\Exception\InvalidResourceException;

/**
 * Base resource object
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class HierarchicalResource extends GenericResource implements HierarchicalResourceInterface
{
    /**
     * @var ResourceInterface
     */
    protected $parent;

    /**
     * @param string                        $resourceId
     * @param ResourceInterface|string|null $parent
     */
    public function __construct($resourceId, $parent = null)
    {
        parent::__construct($resourceId);
        $this->setParent($parent);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ResourceInterface|string|null $parent
     * @throws InvalidResourceException
     * @return Role
     */
    public function setParent($parent)
    {
        if (is_string($parent)) {
            $this->parent = new GenericResource($parent);
            return $this;
        }

        if (null === $parent || $parent instanceof ResourceInterface) {
            $this->parent = $parent;
            return $this;
        }

        throw InvalidResourceException::invalidResourceInstance($parent);
    }
}
