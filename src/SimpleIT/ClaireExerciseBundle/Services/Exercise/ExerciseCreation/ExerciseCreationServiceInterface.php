<?php

namespace SimpleIT\ClaireExerciseBundle\Service\ExerciseCreation;

use SimpleIT\ClaireExerciseResourceBundle\Model\Resources\Exercise\Common\CommonItem;
use SimpleIT\ClaireExerciseResourceBundle\Model\Resources\ExerciseModel\Common\CommonModel;
use SimpleIT\ClaireExerciseBundle\Entity\User\User;
use SimpleIT\ClaireExerciseBundle\Entity\CreatedExercise\Answer;
use SimpleIT\ClaireExerciseBundle\Entity\CreatedExercise\Item;
use SimpleIT\ClaireExerciseBundle\Entity\CreatedExercise\StoredExercise;
use SimpleIT\ClaireExerciseBundle\Entity\ExerciseModel\OwnerExerciseModel;

/**
 * Interface for the services which manages the specific exercise
 * generation
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
interface ExerciseCreationServiceInterface
{
    /**
     * Generate an instance of exercise according to the input
     * exercise model entity.
     *
     * @param OwnerExerciseModel $oem The exercise model entity
     * @param CommonModel        $exerciseModel
     * @param User               $owner
     *
     * @return StoredExercise The instance of exercise
     */
    public function generateExerciseFromExerciseModel(
        OwnerExerciseModel $oem,
        CommonModel $exerciseModel,
        User $owner
    );

    /**
     * Inserts the correction in the item and adapt the solution to make it
     * unique and match as best the user's answer
     *
     * @param Item   $entityItem
     * @param Answer $answer
     *
     * @return Item
     */
    public function correct(Item $entityItem, Answer $answer);

    /**
     * Validate the answer to an item
     *
     * @param Item  $itemEntity
     * @param array $answer
     *
     * @throws \LogicException
     */
    public function validateAnswer(Item $itemEntity, array $answer);

    /**
     * Get Exercise object from entity
     *
     * @param Item $entityItem
     *
     * @return CommonItem
     */
    public function getItemFromEntity(Item $entityItem);
}