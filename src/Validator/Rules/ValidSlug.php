<?php

namespace ByRobots\WriteDown\Validator\Rules;

use ByRobots\Validation\AbstractRule;
use ByRobots\WriteDown\Slugs\Slugger;

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
     * @var \ByRobots\WriteDown\Slugs\Slugger
     */
    protected $slugger;

    /**
     * Set-up the rule.
     *
     * @param \ByRobots\WriteDown\Slugs\Slugger $slugger
     */
    public function __construct(Slugger $slugger)
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
