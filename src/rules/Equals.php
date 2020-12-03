<?php

namespace Bermuda\Validation\Rules;


use function Bermuda\str_equals;


/**
 * Class Equals
 * @package Bermuda\Validation\Rules
 */
abstract class Equals implements RuleInterface
{
    use RuleTrait
    {
        validateNext as protected;
    }

    /**
     * @var mixed
     */
    protected $operand;

    /**
     * Equals constructor.
     * @param int|string|\DateTimeInterface
     */
    protected function __construct($operand)
    {
        $this->operand = $operand;
    }

    /**
     * @param string $operand
     * @param bool $caseInsensitive
     * @return static
     */
    public static function string(string $operand, bool $caseInsensitive = false): self
    {
        return new class($operand, $caseInsensitive) extends Equals
        {
            private bool $caseInsensitive;

            public function __construct(string $operand, bool $caseInsensitive)
            {
                parent::__construct($operand);
                $this->caseInsensitive = $caseInsensitive;
            }

            /**
             * @param $v
             * @return array
             */
            public function validate($v): array
            {
                $v = (string) $v;

                if (str_equals($v, $this->operand, $this->caseInsensitive))
                {
                    return $this->validateNext(null, $v);
                }

                return ['The value must be a string and equal to ' . $this->operand];
            }
        };
    }

    /**
     * @param $operand
     * @return static
     */
    public static function number($operand): self
    {
        if (!is_numeric($operand))
        {
            throw new \InvalidArgumentException('Operand must be a number');
        }

        return new class($operand) extends Equals
        {
            /**
             * @param $v
             * @return array
             */
            public function validate($v): array
            {
                return $this->operand == $v ? $this->validateNext(null, $v) : ['The value must be a number and equal to '. $this->operand];
            }
        };
    }

    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return static
     */
    public static function date(\DateTimeInterface $operand, string $format = 'Y-m-d H:i:s'): self
    {
        return new class($operand, $format) extends Equals
        {
            private string $format;

            public function __construct(\DateTimeInterface $operand, string $format)
            {
                $this->format = $format;
                parent::__construct($operand);
            }

            /**
             * @param \DateTimeInterface|string $v
             * @return array
             */
            public function validate($v): array
            {
                if ($v !instanceof \DateTimeInterface)
                {
                    $v = new \DateTime($v);
                }
                
                return $this->operand->format($this->format) == $v->format($this->format)
                    ? $this->validateNext(null, $v) :
                    [
                        'The value must be equal to '.
                        $this->operand->format($this->format)
                    ];
            }
        };
    }
}
