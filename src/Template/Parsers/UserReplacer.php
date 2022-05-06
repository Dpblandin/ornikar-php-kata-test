<?php

namespace App\Template\Parsers;

use App\Entity\Learner;

class UserReplacer implements ReplaceText
{
    protected Learner $user;

    public function __construct(Learner $user)
    {
        $this->user = $user;
    }

    public function replace(string $text): string
    {
        return str_replace('[user:first_name]', ucfirst(strtolower($this->user->firstname)), $text);
    }
}
