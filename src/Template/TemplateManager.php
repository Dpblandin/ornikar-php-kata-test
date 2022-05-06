<?php

namespace App\Template;

use App\Entity\Template;

class TemplateManager
{
    public function getTemplateComputed(Template $tpl, array $data)
    {
        return (new TemplateComputer())->render($tpl, $data);
    }
}
