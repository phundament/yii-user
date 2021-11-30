<?php

/**
 * This is the model base class for the table "authitem".
 *
 * Columns in table "authitem" available as properties of the model:
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * Relations of table "authitem" available as properties of the model:
 * @property Authassignment[] $authassignments
 * @property Authitemchild[] $authitemchildren
 * @property Authitemchild[] $authitemchildren1
 * @property Rights[] $rights
 * @property StfaFlowAccess[] $stfaFlowAccesses
 */
abstract class BaseAuthitem extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AuthItem';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('name, type', 'required'),
                array('description, bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
                array('type', 'numerical', 'integerOnly' => true),
                array('name', 'length', 'max' => 64),
                array('description, bizrule, data', 'safe'),
                array('name, type, description, bizrule, data', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->description;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'authassignments' => array(self::HAS_MANY, 'Authassignment', 'itemname'),
                'authitemchildren' => array(self::HAS_MANY, 'Authitemchild', 'child'),
                'authitemchildren1' => array(self::HAS_MANY, 'Authitemchild', 'parent'),
                'rights' => array(self::HAS_MANY, 'Rights', 'itemname'),
                'stfaFlowAccesses' => array(self::HAS_MANY, 'StfaFlowAccess', 'stfa_authitem'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('model', 'Name'),
            'type' => Yii::t('model', 'Type'),
            'description' => Yii::t('model', 'Description'),
            'bizrule' => Yii::t('model', 'Bizrule'),
            'data' => Yii::t('model', 'Data'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.bizrule', $this->bizrule, true);
        $criteria->compare('t.data', $this->data, true);


        return $criteria;

    }

}
