<?php

namespace common\db;

use Yii;
use Yii\base\Object;
use common\db\ActiveRecord;
/**
 * Class MetaFields
 * Класс содержащий описание полей модели
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */

abstract class MetaFields extends Object {

    /**
     * Вкладка формы по умолчанию
     */

    const DEFAULT_TAB = "default";

    /**
     * @var ActiveRecord модель - владелец
     */

    protected $owner;

    /**
     * @var array массив объектов полей модели
     */

    protected $fields;

    /**
     * Конструктор
     * @param ActiveRecord $owner
     */

    public function __construct(ActiveRecord $owner) {

        $this->owner = $owner;

    }

    /**
     * Возвращает массив объектов полей модели
     * @return array
     */

    public function getFields() {

        if($this->fields === null) {

            $this->fields = [];

            foreach($this->config() AS $config) {

                $this->fields[] = Yii::createObject($config["definition"], $config["params"]);

            }


        }

        return $this->fields;

    }

    /**
     * Возвращает поля по коду вкладки
     * @param string $tab код вкладки
     * @return array
     */

    public function getFieldsByTab($tab) {

        $fields = $this->getFields();

        $arr = [];

        foreach($fields AS $field) {

            if($field->tab == $tab)
                $arr[] = $field;

        }

        return $arr;
    }

    /**
     * Массив вкладок формы редактирования модели (key=>name)
     * @return array
     */

    public function tabs() {
        return [self::DEFAULT_TAB=>Yii::t('core', 'Element')];
    }

    /**
     * Данный метод должен возвращать массив конфигураций объектов для создания полей модели
     * через Yii::createObject()
     *
     * Пример конфигурации:
     *
     * return [
     *
     *      [
     *          "definition"=>[
     *              "class"=>common\db\fields\TextField::className(),
     *              "title"=>"Название",
     *          ],
     *          "params"=>[$this->owner, "title"]
     *      ],
     *
     * ];
     *
     * @return array
     */

    abstract protected function config();


}