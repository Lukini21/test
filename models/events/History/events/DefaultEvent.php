<?php

namespace app\models\events\History\events;

use yii\db\ActiveRecord;

class DefaultEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getData(ActiveRecord $model): array
    {
        return [
            'user' => $model->user,
            'body' => $model->event,
            'bodyDatetime' => $model->ins_ts,
            'iconClass' => 'fa-gear bg-purple-light'
        ];
    }

    public function getEventText(): string
    {
        return '';
    }
}