<?php

namespace App\Template\Parsers;

use App\Entity\Instructor;
use App\Repository\InstructorRepository;

class InstructorParser implements ReplaceText
{
    protected ?Instructor $instructor;

    public function __construct(?int $instructorId = null)
    {
        $this->instructor = InstructorRepository::getInstance()->getById($instructorId);
    }

    public function replace(string $text): string
    {
        if (!$this->instructor instanceof Instructor) {
            return str_replace('[instructor_link]', '', $text);
        }

        $text = str_replace(
            '[lesson:instructor_name]',
            $this->instructor->firstname,
            $text
        );

        return str_replace(
            '[instructor_link]',
            'instructors/'.$this->instructor->id.'-'.urlencode($this->instructor->firstname),
            $text
        );
    }
}
