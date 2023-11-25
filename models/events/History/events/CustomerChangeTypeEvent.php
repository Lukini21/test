<?php

namespace app\models\events\History\events;

use app\models\Customer;
use Yii;
use yii\db\ActiveRecord;

class CustomerChangeTypeEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_statuses_change';
    }

    public function getData(ActiveRecord $model): array
    {
        return [
            'model' => $model,
            'oldValue' => Customer::getTypeTextByType($model->getDetailOldValue('type')),
            'newValue' => Customer::getTypeTextByType($model->getDetailNewValue('type'))
        ];
    }


    public function getEventText(): string
    {
        return Yii::t('app', 'Type changed');
    }
}