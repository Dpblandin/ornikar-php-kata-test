<?php

namespace App\Template\Parsers;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;

class LessonParser implements ReplaceText
{
    protected ?Lesson $lesson;

    public function __construct(?Lesson $lesson = null)
    {
        $this->lesson = $lesson instanceof Lesson
            ? LessonRepository::getInstance()->getById($lesson->id)
            : null;
    }
    public function replace(string $text): string
    {
        if (! $this->lesson) {
            return $text;
        }

        $meetingPoint = MeetingPointRepository::getInstance()->getById($this->lesson->meetingPointId);

        $text = str_replace('[lesson:start_date]', $this->lesson->start_time->format('d/m/Y'), $text);

        $text = str_replace('[lesson:start_time]', $this->lesson->start_time->format('H:i'), $text);

        $text = str_replace('[lesson:end_time]', $this->lesson->end_time->format('H:i'), $text);

        $text = str_replace(
            '[lesson:summary_html]',
            Lesson::renderHtml($this->lesson),
            $text
        );
        $text = str_replace(
            '[lesson:summary]',
            Lesson::renderText($this->lesson),
            $text
        );

        if ($meetingPoint) {
            $text = str_replace('[lesson:meeting_point]', $meetingPoint->name, $text);
        }

        return $text;
    }
}
