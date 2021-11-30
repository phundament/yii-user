<?php

/**
 * This is the model base class for the table "iptb_ip_table".
 *
 * Columns in table "iptb_ip_table" available as properties of the model:
 * @property integer $iptb_id
 * @property string $iptb_name
 * @property string $iptb_from
 * @property string $iptb_to
 * @property string $iptb_status
 *
 * Relations of table "iptb_ip_table" available as properties of the model:
 * @property UxipUserXIpTable[] $uxipUserXIpTables
 */
abstract class BaseIptbIpTable extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const IPTB_STATUS_ACTIVE = 'active';
    const IPTB_STATUS_INACTIVE = 'inactive';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'iptb_ip_table';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('iptb_name, iptb_from, iptb_to, iptb_status', 'required'),
                array('iptb_name', 'length', 'max' => 255),
                array('iptb_from, iptb_to', 'length', 'max' => 15),
                array('iptb_from, iptb_to', 'is_valid_ip'),
                array('iptb_status', 'length', 'max' => 8),
                array('iptb_id, iptb_name, iptb_from, iptb_to, iptb_status', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->iptb_name;
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
                'uxipUserXIpTables' => array(self::HAS_MANY, 'UxipUserXIpTable', 'uxip_iptb_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'iptb_id' => UserModule::t('Id'),
            'iptb_name' => UserModule::t('Name'),
            'iptb_from' => UserModule::t('IP From'),
            'iptb_to' => UserModule::t('IP To'),
            'iptb_status' => UserModule::t('Status'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'iptb_status' => array(
               self::IPTB_STATUS_ACTIVE => UserModule::t('Active'),
               self::IPTB_STATUS_INACTIVE => UserModule::t('Inactive'),
           ),
            );
        return $this->enum_labels;
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }

    public function getEnumColumnLabel($column){
        return $this->getEnumLabel($column,$this->$column);
    }
    

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.iptb_id', $this->iptb_id);
        $criteria->compare('t.iptb_name', $this->iptb_name, true);
        $criteria->compare('t.iptb_from', $this->iptb_from, true);
        $criteria->compare('t.iptb_to', $this->iptb_to, true);
        $criteria->compare('t.iptb_status', $this->iptb_status);


        return $criteria;

    }
    
    public function is_valid_ip($attribute)
    {
        
        $pattern = '#^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$#';
        
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, UserModule::t('Enter a valid IP address'));
        }
        
    }

}
