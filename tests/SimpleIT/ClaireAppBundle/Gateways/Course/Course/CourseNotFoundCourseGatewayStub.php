<?php

namespace SimpleIT\ClaireAppBundle\Gateways\Course\Course;

use SimpleIT\ApiResourcesBundle\Course\CourseResource;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CourseNotFoundCourseGatewayStub implements CourseGateway
{
    /**
     * @return CourseResource[]
     */
    public function findAllStatus($courseIdentifier)
    {
        throw new CourseNotFoundException();
    }

    /**
     * @return CourseResource
     */
    public function findPublished($courseIdentifier)
    {
        throw new CourseNotFoundException();
    }

    /**
     * @return CourseResource
     */
    public function findWaitingForPublication($courseId)
    {
        throw new CourseNotFoundException();
    }

    /**
     * @return CourseResource
     */
    public function findDraft($courseId)
    {
        throw new CourseNotFoundException();
    }

    public function updateToWaitingForPublication($courseId)
    {
        throw new CourseNotFoundException();
    }

    public function updateToPublished($courseId)
    {
        throw new CourseNotFoundException();
    }

}
