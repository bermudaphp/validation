<?php


namespace App\Validator;


/**
 * Class Chain
 * @package App\Chain
 */
final class AllOf extends OneOf
{
    private bool $break;

    /**
     * AllOf constructor.
     * @param RuleInterface[] $rules
     * @param bool $break
     */
    public function __construct(iterable $rules = [], bool $break = false)
    {
        $this->break = $break;
        parent::__construct($rules);
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        $messages = [];

        foreach ($this as $rule)
        {
            if (($failure = $rule($value)) != [])
            {
                $messages = array_merge($messages, $failure);

                if ($this->break)
                {
                    return $messages;
                }
            }
        }

        return $messages;
    }

    /**
     * @param RuleInterface $rule
     * @param bool $break
     * @return static
     */
    public static function make(RuleInterface $rule, bool $break = false): self
    {
        return new self([$rule], $break);
    }
}