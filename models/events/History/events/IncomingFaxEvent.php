<?php

namespace app\models\events\History\events;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class IncomingFaxEvent implements HistoryEventInterface
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getData(ActiveRecord $model): array
    {
        $fax = $model->fax;

        return [
            'user' => $model->user,
            'body' => $this->getBodyText($model),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ]),
            'footerDatetime' => $model->ins_ts,
            'iconClass' => 'fa-fax bg-green'
        ];
    }

    public function getEventText(): string
    {
        return  Yii::t('app', 'Incoming fax');
    }

    public function getBodyText(ActiveRecord $model): string
    {
        $fax = $model->fax;

        return 'Incoming fax - ' .
            (isset($fax->document) ? Html::a(
                Yii::t('app', 'view document'),
                $fax->document->getViewUrl(),
                [
                    'target' => '_blank',
                    'data-pjax' => 0
                ]
            ) : '');
    }
}