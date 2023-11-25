<?php

namespace app\models\events\History\events;

use app\models\Sms;
use Yii;
use yii\db\ActiveRecord;

class IncomingSmsEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getData(ActiveRecord $model): array
    {
        return [
            'user' => $model->user,
            'body' => $model->sms->message ? $model->sms->message : '',
            'footer' => $model->sms->direction == Sms::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $model->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $model->sms->phone_to ?? ''
                ]),
            'iconIncome' => $model->sms->direction == Sms::DIRECTION_INCOMING,
            'footerDatetime' => $model->ins_ts,
            'iconClass' => 'icon-sms bg-dark-blue'
        ];
    }

    public function getEventText(): string
    {
        return Yii::t('app', 'Incoming message');
    }
}