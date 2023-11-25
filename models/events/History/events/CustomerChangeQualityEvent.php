<?php

namespace app\models\events\History\events;

use app\models\Customer;
use Yii;
use yii\db\ActiveRecord;

class CustomerChangeQualityEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_statuses_change';
    }

    public function getData(ActiveRecord $model): array
    {
        return [
            'model' => $model,
            'oldValue' => Customer::getQualityTextByQuality($model->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityTextByQuality($model->getDetailNewValue('quality')),
        ];
    }

    public function getEventText(): string
    {
       return Yii::t('app', 'Property changed');
    }
}