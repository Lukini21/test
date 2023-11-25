<?php

namespace app\models\events\History\events;

use Yii;
use yii\db\ActiveRecord;

class UpdatedTaskEvent implements HistoryEventInterface
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
            'body' => $this->getEventText() . ": " . ($task->title ?? ''),
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $model->ins_ts,
            'footer' => isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        ];
    }

    public function getEventText(): string
    {
        return Yii::t('app', 'Task updated');
    }
}