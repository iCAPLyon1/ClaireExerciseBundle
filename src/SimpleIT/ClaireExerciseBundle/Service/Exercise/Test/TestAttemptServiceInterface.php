<?php

namespace SimpleIT\ClaireExerciseBundle\Service\Exercise\Test;

use SimpleIT\CoreBundle\Exception\NonExistingObjectException;
use SimpleIT\ClaireExerciseBundle\Entity\Test\TestAttempt;
use SimpleIT\Utils\Collection\CollectionInformation;
use SimpleIT\Utils\Collection\PaginatorInterface;

/**
 * Service which manages the test attempts
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
interface TestAttemptServiceInterface
{
    /**
     * Find a test attempt by its id
     *
     * @param int $testAttemptId Test attempt Id
     *
     * @throws NonExistingObjectException
     * @return TestAttempt
     */
    public function get($testAttemptId);

    /**
     * Add a new test attempt to the database.
     *
     * @param int $testId
     * @param int $userId
     *
     * @return TestAttempt
     */
    public function add($testId, $userId);

    /**
     * Get all the test attempts
     *
     * @param CollectionInformation $collectionInformation
     * @param int                   $userId
     * @param int                   $testId
     *
     * @return PaginatorInterface
     */
    public function getAll(
        $collectionInformation = null,
        $userId = null,
        $testId = null
    );
}
