<?php

namespace SimpleIT\ClaireAppBundle\Services\Course;

use SimpleIT\ApiResourcesBundle\Course\CourseResource;
use SimpleIT\ApiResourcesBundle\Course\MetadataResource;
use SimpleIT\ClaireAppBundle\Repository\Course\MetadataByCourseRepository;
use SimpleIT\ClaireAppBundle\Repository\Course\MetadataByPartRepository;
use SimpleIT\Utils\ArrayUtils;
use SimpleIT\Utils\Collection\CollectionInformation;

/**
 * Class MetadataService
 *
 * @author Romain Kuzniak <romain.kuzniak@simple-it.fr>
 */
class MetadataService
{
    /**
     * @var  MetadataByPartRepository
     */
    private $metadataByPartRepository;

    /**
     * @var  MetadataByCourseRepository
     */
    private $metadataByCourseRepository;

    /**
     * Set metadataByPartRepository
     *
     * @param MetadataByPartRepository $metadataByPartRepository
     */
    public function setMetadataByPartRepository($metadataByPartRepository)
    {
        $this->metadataByPartRepository = $metadataByPartRepository;
    }

    /**
     * Set metadataByCourseRepository
     *
     * @param \SimpleIT\ClaireAppBundle\Repository\Course\MetadataByCourseRepository $metadataByCourseRepository
     */
    public function setMetadataByCourseRepository($metadataByCourseRepository)
    {
        $this->metadataByCourseRepository = $metadataByCourseRepository;
    }

    /**
     * Get metadatas from a course
     *
     * @param string                $courseIdentifier      Course id | slug
     * @param CollectionInformation $collectionInformation Collection information
     *
     * @return string
     */
    public function getAllFromCourse(
        $courseIdentifier,
        CollectionInformation $collectionInformation = null
    )
    {
        return $this->metadataByCourseRepository->findAll(
            $courseIdentifier,
            $collectionInformation
        );
    }

    /**
     * Get metadatas from a course to edit
     *
     * @param string                $courseIdentifier      Course id | slug
     * @param string                $status                Status
     * @param CollectionInformation $collectionInformation Collection information
     *
     * @return string
     */
    public function getAllFromCourseToEdit(
        $courseIdentifier,
        $status,
        CollectionInformation $collectionInformation
    )
    {
        $collectionInformation->addFilter(CourseResource::STATUS, $status);

        return $this->metadataByCourseRepository->findAll(
            $courseIdentifier,
            $collectionInformation
        );
    }

    /**
     * Get information from a course
     *
     * @param int|string            $courseIdentifier      Course id | slug
     * @param CollectionInformation $collectionInformation Collection information
     *
     * @return array
     */
    public function getInformationsFromCourse($courseIdentifier, $collectionInformation)
    {
        $metadatas = $this->getAllFromCourse($courseIdentifier, $collectionInformation);

        return $this->prepareMetadatas($metadatas);
    }

    /**
     * Get information from a course with status different of published
     *
     * @param int                   $courseId              Course id
     * @param string                $status                Status
     * @param CollectionInformation $collectionInformation Collection information
     *
     * @return array
     */
    public function getInformationsFromCourseToEdit(
        $courseId,
        $status,
        $collectionInformation
    )
    {
        $metadatas = $this->getAllFromCourseToEdit(
            $courseId,
            $status,
            $collectionInformation
        );

        return $this->prepareMetadatas($metadatas);
    }

    /**
     * Format metadatas
     *
     * @param array $metadatas Matadatas
     *
     * @return array
     */
    private function prepareMetadatas(array $metadatas = array())
    {
        $information = array();
        $difficulty = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_DIFFICULTY
        );
        $information[MetadataResource::COURSE_METADATA_DIFFICULTY] = $difficulty;
        $aggregateRating = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_AGGREGATE_RATING
        );
        $information[MetadataResource::COURSE_METADATA_AGGREGATE_RATING] = $aggregateRating;
        $timeRequired = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_TIME_REQUIRED
        );
        if (!is_null($timeRequired)) {
            $timeRequired = new \DateInterval($timeRequired);
        }
        $information[MetadataResource::COURSE_METADATA_TIME_REQUIRED] = $timeRequired;

        return $information;
    }

    /**
     * Get metadatas from a part
     *
     * @param string $courseIdentifier Course id | slug
     * @param string $partIdentifier   Part id | slug
     *
     * @return string
     */
    public function getAllFromPart($courseIdentifier, $partIdentifier)
    {
        return $this->metadataByPartRepository->findAll($courseIdentifier, $partIdentifier);
    }

    /**
     * Get informations from a course
     *
     * @param int | string $courseIdentifier Course id | slug
     * @param int | string $partIdentifier   Part id | slug
     *
     * @return array
     */
    public function getInformationsFromPart($courseIdentifier, $partIdentifier)
    {
        $metadatas = $this->getAllFromPart($courseIdentifier, $partIdentifier);
        $courseMetadatas = null;
        $information = array();

        /*
         * Difficulty
         */
        $difficulty = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_DIFFICULTY
        );
        if (is_null($difficulty)) {
            $courseMetadatas = $this->getAllFromCourse($courseIdentifier);
            $difficulty = ArrayUtils::getValue(
                $courseMetadatas,
                MetadataResource::COURSE_METADATA_DIFFICULTY
            );
        }
        $information[MetadataResource::COURSE_METADATA_DIFFICULTY] = $difficulty;

        /*
         * Aggregate Rating
         */
        $aggregateRating = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_AGGREGATE_RATING
        );
        if (is_null($aggregateRating)) {
            if (is_null($courseMetadatas)) {
                $courseMetadatas = $this->getAllFromCourse($courseIdentifier);
            }
            $aggregateRating = ArrayUtils::getValue(
                $courseMetadatas,
                MetadataResource::COURSE_METADATA_AGGREGATE_RATING
            );
        }
        $information[MetadataResource::COURSE_METADATA_AGGREGATE_RATING] = $aggregateRating;

        /*
         * Time required
         */
        $timeRequired = ArrayUtils::getValue(
            $metadatas,
            MetadataResource::COURSE_METADATA_TIME_REQUIRED
        );
        if (is_null($timeRequired)) {
            if (is_null($courseMetadatas)) {
                $courseMetadatas = $this->getAllFromCourse($courseIdentifier);
            }
            $timeRequired = ArrayUtils::getValue(
                $courseMetadatas,
                MetadataResource::COURSE_METADATA_TIME_REQUIRED
            );
        }
        if (!is_null($timeRequired)) {
            $timeRequired = new \DateInterval($timeRequired);
        }
        $information[MetadataResource::COURSE_METADATA_TIME_REQUIRED] = $timeRequired;

        return $information;
    }

    /**
     * Add metadatas to a course
     *
     * @param string $courseIdentifier Course id | slug
     * @param array  $metadatas        Metadatas (key => value)
     *
     * @return string
     */
    public function addToCourse($courseIdentifier, $metadatas)
    {
        return $this->metadataByCourseRepository->insert(
            $courseIdentifier,
            $metadatas
        );
    }

    /**
     * Add metadatas to a part
     *
     * @param string $courseIdentifier Course id | slug
     * @param string $partIdentifier   Part id | slug
     * @param array  $metadatas        Metadatas (key => value)
     *
     * @return string
     */
    public function addToPart($courseIdentifier, $partIdentifier, $metadatas)
    {
        return $this->metadataByPartRepository->insert(
            $courseIdentifier,
            $partIdentifier,
            $metadatas
        );
    }

    /**
     * Save metadatas from a course
     *
     * @param string $courseIdentifier Course id | slug
     * @param array  $metadatas        Metadatas (key => value)
     *
     * @return string
     */
    public function saveFromCourse(
        $courseIdentifier,
        $metadatas
    )
    {
        $collectionInformation = new CollectionInformation();
        $collectionInformation->addFilter(CourseResource::STATUS, CourseResource::STATUS_DRAFT);
        $metadatasToUpdate = $this->metadataByCourseRepository->findAll(
            $courseIdentifier,
            $collectionInformation
        );
        $parameters = array('status' => $collectionInformation->getFilter(CourseResource::STATUS));
        foreach ($metadatas as $key => $value) {
            if (array_key_exists($key, $metadatasToUpdate)) {
                $metadatasToUpdate = $this->metadataByCourseRepository->update(
                    $courseIdentifier,
                    array($key => $value),
                    $parameters
                );
            } else {
                $metadatasToUpdate = $this->metadataByCourseRepository->insert(
                    $courseIdentifier,
                    array($key => $value),
                    $parameters
                );
            }
        }

        return $metadatasToUpdate;
    }

    /**
     * Save metadatas from a part
     *
     * @param string $courseIdentifier Course id | slug
     * @param string $partIdentifier   Part id | slug
     * @param array  $metadatas        Metadatas (key => value)
     *
     * @return string
     */
    public function saveFromPart($courseIdentifier, $partIdentifier, $metadatas)
    {
        $metadatasToUpdate = $this->metadataByPartRepository->findAll(
            $courseIdentifier,
            $partIdentifier
        );
        foreach ($metadatas as $key => $value) {
            if (array_key_exists($key, $metadatasToUpdate)) {
                $metadatasToUpdate = $this->metadataByPartRepository->update(
                    $courseIdentifier,
                    $partIdentifier,
                    array($key => $value)
                );
            } else {
                $metadatasToUpdate = $this->metadataByPartRepository->insert(
                    $courseIdentifier,
                    $partIdentifier,
                    array($key => $value)
                );
            }
        }

        return $metadatasToUpdate;
    }
}
