<?php

namespace app\models\events;

use yii\db\ActiveRecord;

abstract class BaseEvent
{

    protected $event;
    protected $model;

    private $interface;
    private $defaultEventClass = 'DefaultEvent';

    public function __construct(ActiveRecord $model)
    {
        $this->model = $model;
        $this->event = $model->event;
        $modelPath = explode('\\', get_class($model));
        $modelName = array_pop($modelPath);

        $path = 'app\models\events\\' . $modelName . '\events\\';
        $class = $path . ucfirst(str_replace('_', '', ucwords($this->event, '_'))) . 'Event';
        $this->interface = $path . "{$modelName}EventInterface";


        if (class_exists($class)) {
            $this->setClass($class);
        } elseif (class_exists($path . $this->defaultEventClass)) {
            $this->setClass($path . $this->defaultEventClass);
        }
    }

    private function setClass($class)
    {
        $event = new $class();
        if ($event instanceof $this->interface) {
            $this->event = $event;
        } else {
            throw new \Exception("Class $class must implement $this->interface");
        }
    }

    public function getTemplate()
    {
        return $this->event->getTemplate();
    }

    public function getData()
    {
        return $this->event->getData($this->model);
    }

    public function getEventText()
    {
        return $this->event->getEventText();
    }

    abstract public function getTemplateData(): array;
}