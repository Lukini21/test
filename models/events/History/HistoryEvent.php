<?php

namespace app\models\events\History;


use app\models\events\BaseEvent;

/**
 * Extends BaseEvent for History model events
 */
class HistoryEvent extends BaseEvent
{
    public function getTemplateData(): array
    {
        return [$this->getTemplate(), $this->getData()];
    }
}