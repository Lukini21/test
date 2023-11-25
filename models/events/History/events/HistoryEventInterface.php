<?php

namespace app\models\events\History\events;

use yii\db\ActiveRecord;

interface HistoryEventInterface
{
    public function getTemplate(): string;
    public function getEventText(): string;
    public function getData(ActiveRecord $model): array;

}