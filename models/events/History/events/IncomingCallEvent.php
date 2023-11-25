<?php

namespace app\models\events\History\events;

use app\models\Call;
use Yii;
use yii\db\ActiveRecord;

class IncomingCallEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getData(ActiveRecord $model): array
    {
        $call = $model->call;
        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return [
            'user' => $model->user,
            'content' => $call->comment ?? '',
            'body' => $this->getBodyText($model),
            'footerDatetime' => $model->ins_ts,
            'footer' => isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            'iconIncome' => $answered && $call->direction == Call::DIRECTION_INCOMING
        ];
    }

    public function getEventText(): string
    {
        return Yii::t('app', 'Incoming call');
    }

    public function getBodyText(ActiveRecord $model): string
    {
        $call = $model->call;

        return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
    }
}