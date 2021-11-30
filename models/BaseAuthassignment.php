<?php

/**
 * This is the model base class for the table "AuthAssignment".
 *
 * Columns in table "AuthAssignment" available as properties of the model:
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * Relations of table "AuthAssignment" available as properties of the model:
 * @property Authitem $itemname0
 */
abstract class BaseAuthassignment extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AuthAssignment';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('itemname, userid', 'required'),
                array('bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
                array('itemname, userid', 'length', 'max' => 64),
                array('bizrule, data', 'safe'),
                array('itemname, userid, bizrule, data', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->itemname;
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
                'itemname0' => array(self::BELONGS_TO, 'Authitem', 'itemname'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'itemname' => Yii::t('model', 'Itemname'),
            'userid' => Yii::t('model', 'Userid'),
            'bizrule' => Yii::t('model', 'Bizrule'),
            'data' => Yii::t('model', 'Data'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.itemname', $this->itemname, false);
        $criteria->compare('t.userid', $this->userid, false);
        $criteria->compare('t.bizrule', $this->bizrule, true);
        $criteria->compare('t.data', $this->data, true);


        return $criteria;

    }

}
