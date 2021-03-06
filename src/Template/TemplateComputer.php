<?php

namespace App\Template;

use App\Context\ApplicationContext;
use App\Entity\Learner;
use App\Entity\Template;
use App\Helper\Data;
use App\Template\Parsers\InstructorParser;
use App\Template\Parsers\LessonParser;
use App\Template\Parsers\UserParser;

class TemplateComputer
{
    protected array $parsers;
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->parsers = [
            LessonParser::class => fn () => Data::get($this->data, 'lesson'),
            InstructorParser::class => fn () => Data::get($this->data, 'lesson.instructorId'),
            UserParser::class => fn () => $this->getUser(),
        ];
    }

    public function render(Template $tpl): Template
    {
        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject);
        $replaced->content = $this->computeText($replaced->content);
        
        return $replaced;
    }

    private function getUser(): Learner
    {
        return Data::get($this->data, 'user', ApplicationContext::getInstance()->getCurrentUser());
    }

    private function computeText(string $text): string
    {
        foreach ($this->parsers as $parser => $params) {
            $text = (new $parser($params()))->replace($text);
        }

        return $text;
    }
}
