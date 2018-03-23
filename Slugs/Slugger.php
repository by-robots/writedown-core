<?php

namespace WriteDown\Slugs;

class Slugger
{
    /**
     * Take a string and convert it to a URL friendly slug.
     *
     * @param $string $input
     *
     * @return string
     */
    public function slug($input)
    {
        // Remove punctuation, but leave hyphens
        $input = preg_replace('/[^\w\s-]/', '', $input);

        // Change underscores and spaces to hyphens
        $input = str_replace([' ', '_'], '-', $input);

        // Remove double hyphens
        while (strpos($input, '--') !== false) {
            $input = str_replace('--', '-', $input);
        }

        // Remove leading and trailing hyphens
        $input = ltrim($input, '-');
        $input = rtrim($input, '-');

        // Return the generated slug with all lower case letters
        return strtolower($input);
    }
}
