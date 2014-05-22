<?php
namespace SimpleIT\ClaireExerciseBundle\Model\Resources;

use JMS\Serializer\Annotation as Serializer;
use SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\CommonResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ResourceResource
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ResourceResource extends SharedResource
{
    /**
     * @const RESOURCE_NAME = 'Exercise Resource'
     */
    const RESOURCE_NAME = 'Exercise Resource';

    /**
     * @const MULTIPLE_CHOICE_QUESTION = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\MultipleChoiceQuestionResource'
     */
    const MULTIPLE_CHOICE_QUESTION_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\MultipleChoiceQuestionResource';

    /**
     * @const PICTURE = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\PictureResource'
     */
    const PICTURE_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\PictureResource';

    /**
     * @const SEQUENCE = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\SequenceResource'
     */
    const SEQUENCE_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\SequenceResource';

    /**
     * @const OPEN_ENDED_QUESTION = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\OpenEndedQuestionResource'
     */
    const OPEN_ENDED_QUESTION = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\OpenEndedQuestionResource';

    /**
     * @const TEXT = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\TextResource'
     */
    const TEXT_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\TextResource';

    /**
     * @var int $id Id of resource
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list", "resource_list"})
     * @Assert\Blank(groups={"create","edit"})
     */
    protected $id;

    /**
     * @var string $type
     * @Serializer\Type("string")
     * @Serializer\Groups({"details", "list", "resource_list"})
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Blank(groups={"edit"})
     */
    protected $type;

    /**
     * @var CommonResource $content
     * @Serializer\Type("SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\CommonResource")
     * @Serializer\Groups({"details"})
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid
     */
    protected $content;

    /**
     * @var array $requiredExerciseResources
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     * @Assert\NotNull(groups={"create"})
     */
    private $requiredExerciseResources;

    /**
     * @var array $requiredKnowledges
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     * @Assert\NotNull(groups={"create"})
     */
    private $requiredKnowledges;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list", "resource_list"})
     * @Assert\Blank(groups={"create", "edit"})
     */
    protected $author;

    /**
     * @var int $owner
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list", "resource_list"})
     * @Assert\Blank(groups={"create", "edit"})
     */
    protected $owner;

    /**
     * @var bool $public
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"details","list", "resource_list"})
     * @Assert\NotNull(groups={"create"})
     */
    protected $public;

    /**
     * @var bool $archived
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"details","list", "resource_list"})
     * @Assert\Null(groups={"create"})
     */
    protected $archived;

    /**
     * @var array
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     */
    protected $metadata;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details"})
     */
    protected $parent;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "resource_list"})
     */
    protected $forkFrom;

    /**
     * Set content
     *
     * @param \SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\CommonResource $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return \SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseResource\CommonResource
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set requiredExerciseResources
     *
     * @param array $requiredExerciseResources
     */
    public function setRequiredExerciseResources($requiredExerciseResources)
    {
        $this->requiredExerciseResources = $requiredExerciseResources;
    }

    /**
     * Get requiredExerciseResources
     *
     * @return array
     */
    public function getRequiredExerciseResources()
    {
        return $this->requiredExerciseResources;
    }

    /**
     * Set requiredKnowledges
     *
     * @param array $requiredKnowledges
     */
    public function setRequiredKnowledges($requiredKnowledges)
    {
        $this->requiredKnowledges = $requiredKnowledges;
    }

    /**
     * Get requiredKnowledges
     *
     * @return array
     */
    public function getRequiredKnowledges()
    {
        return $this->requiredKnowledges;
    }

    /**
     * Return the item serialization class corresponding to the type
     *
     * @param string $type
     *
     * @return string
     * @throws \LogicException
     */
    public function getClass($type = null)
    {
        if ($type === null)
        {
            $type = $this->type;
        }

        switch ($type) {
            case CommonResource::MULTIPLE_CHOICE_QUESTION:
                $class = self::MULTIPLE_CHOICE_QUESTION_CLASS;
                break;
            case CommonResource::PICTURE:
                $class = self::PICTURE_CLASS;
                break;
            case CommonResource::SEQUENCE:
                $class = self::SEQUENCE_CLASS;
                break;
            case CommonResource::TEXT:
                $class = self::TEXT_CLASS;
                break;
            case CommonResource::OPEN_ENDED_QUESTION:
                $class = self::OPEN_ENDED_QUESTION;
                break;
            default:
                throw new \LogicException('Unknown type');
        }

        return $class;
    }
}
