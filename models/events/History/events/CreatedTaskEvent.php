<?php

namespace app\models\events\History\events;

use Yii;
use yii\db\ActiveRecord;

class CreatedTaskEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getData(ActiveRecord $model): array
    {
        $task = $model->task;

        return [
            'user' => $model->user,
            'body' => $this->getBodyText($model),
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $model->ins_ts,
            'footer' => isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        ];
    }

    public function getEventText(): string
    {
        return Yii::t('app', 'Task created');
    }

    public function getBodyText(ActiveRecord $model): string
    {
        $task = $model->task;

        return $this->getEventText() . ": " . ($task->title ?? '');
    }
}