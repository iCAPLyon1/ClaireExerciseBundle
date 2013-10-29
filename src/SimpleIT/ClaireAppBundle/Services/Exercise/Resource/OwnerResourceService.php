<?php

namespace SimpleIT\ClaireAppBundle\Services\Exercise\Resource;

use SimpleIT\ApiResourcesBundle\Course\CourseResource;
use SimpleIT\ApiResourcesBundle\Exercise\OwnerResourceResource;
use SimpleIT\ClaireAppBundle\Repository\Exercise\Resource\OwnerResourceRepository;
use SimpleIT\Utils\Collection\CollectionInformation;

/**
 * Class OwnerResourceService
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class OwnerResourceService
{
    /**
     * @var  OwnerResourceRepository
     */
    private $ownerResourceRepository;

    /**
     * Set OwnerResourceRepository
     *
     * @param OwnerResourceRepository $OwnerResourceRepository
     */
    public function setOwnerResourceRepository($OwnerResourceRepository)
    {
        $this->ownerResourceRepository = $OwnerResourceRepository;
    }

    /**
     * Get all owner resources
     *
     * @param CollectionInformation $collectionInformation Collection information
     *
     * @return \SimpleIT\Utils\Collection\PaginatedCollection
     */
    public function getAll(CollectionInformation $collectionInformation = null)
    {
        return $this->ownerResourceRepository->findAll($collectionInformation);
    }

    /**
     * Get an owner resource
     *
     * @param int | string $courseIdentifier Course id | slug
     * @param array        $parameters       Parameters
     *
     * @return \SimpleIT\ApiResourcesBundle\Course\CourseResource
     */
    public function get($courseIdentifier, array $parameters = array())
    {
        return $this->ownerResourceRepository->find($courseIdentifier, $parameters);
    }

    /**
     * Save a part content
     *
     * @param        $ownerResourceId
     * @param array  $ownerResource
     *
     * @return mixed
     */
    public function saveContent($ownerResourceId, array $ownerResource)
    {
        return $this->ownerResourceRepository->update(
            $ownerResourceId,
            $this->createResourceFromArray($ownerResource)
        );
    }

    /**
     * Create a resource from an array
     *
     * @param array $array
     *
     * @return OwnerResourceResource
     */
    private function createResourceFromArray(array $array)
    {
        $resource = new OwnerResourceResource();
        $resource->setMetadata($array['metadata']);
        $resource->setPublic($array['public']);

        return $resource;
    }
}
