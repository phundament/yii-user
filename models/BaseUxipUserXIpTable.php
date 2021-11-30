<?php

/**
 * This is the model base class for the table "uxip_user_x_ip_table".
 *
 * Columns in table "uxip_user_x_ip_table" available as properties of the model:
 * @property integer $uxip_user_id
 * @property integer $uxip_iptb_id
 *
 * Relations of table "uxip_user_x_ip_table" available as properties of the model:
 * @property Users $uxipUser
 * @property IptbIpTable $uxipIptb
 */
abstract class BaseUxipUserXIpTable extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'uxip_user_x_ip_table';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('uxip_user_id, uxip_iptb_id', 'required'),
                array('uxip_user_id, uxip_iptb_id', 'numerical', 'integerOnly' => true),
                array('uxip_user_id, uxip_iptb_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->uxip_user_id;
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
                'uxipUser' => array(self::BELONGS_TO, 'Users', 'uxip_user_id'),
                'uxipIptb' => array(self::BELONGS_TO, 'IptbIpTable', 'uxip_iptb_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'uxip_user_id' => UserModule::t('User Id'),
            'uxip_iptb_id' => UserModule::t('IP Id'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.uxip_user_id', $this->uxip_user_id);
        $criteria->compare('t.uxip_iptb_id', $this->uxip_iptb_id);


        return $criteria;

    }

}
