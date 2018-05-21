<?php

namespace ByRobots\WriteDown\Validator\Rules;

use ByRobots\Validation\AbstractRule;
use ByRobots\WriteDown\Slugs\GenerateSlug;

class ValidSlug extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected $name = 'valid_slug';

    /**
     * @inheritDoc
     */
    protected $messages = [
        'en' => 'is not valid',
    ];

    /**
     * Generates slugs.
     *
     * @var \ByRobots\WriteDown\Slugs\GenerateSlug
     */
    protected $slugger;

    /**
     * Set-up the rule.
     *
     * @param \ByRobots\WriteDown\Slugs\GenerateSlug $slugger
     */
    public function __construct(GenerateSlug $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @inheritDoc
     */
    public function validate($field, array $input, array $params = null): bool
    {
        return $input[$field] === $this->slugger->slug($input[$field]);
    }
}
