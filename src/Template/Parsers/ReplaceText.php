<?php

namespace App\Template\Parsers;

interface ReplaceText
{
    public function replace(string $text): string;
}
