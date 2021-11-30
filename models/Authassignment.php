<?php

// auto-loading
Yii::setPathOfAlias('Authassignment', dirname(__FILE__));
Yii::import('Authassignment.*');

class Authassignment extends BaseAuthassignment
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array()
        );
    }

    public function rules()
    {
        return array_merge(
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    /**
     * get all user roles
     * @param int $user_id (no pprs_id)
     * @return array('role1','role2')
     */
    public function getUserRoles($user_id){
            $asigned_roles = $this->findAllByAttributes(['userid' => $user_id]);
            $aUserRoles = array();
            foreach($asigned_roles  as $modelAsignedRole){
                $aUserRoles[] = $modelAsignedRole->itemname;
            }        
            return $aUserRoles;
    }

    /**
     * get all role users
     * @param int $user_id (no pprs_id)
     * @return array(1,3) //pprs_id list
     */
    static public function getRoleUsers($role){
        
        $sql = "  
                SELECT DISTINCT 
                  p.person_id 
                FROM
                  AuthAssignment aa 
                  INNER JOIN users u 
                    ON aa.userid = u.id 
                  INNER JOIN `profiles` p 
                    ON u.id = p.user_id 
                WHERE itemname = :role 
                  AND `status` = :status -- User::STATUS_ACTIVE              
                ";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":role", $role, PDO::PARAM_STR);                
        $status = User::STATUS_ACTIVE;
        $rawData->bindParam(":status", $status, PDO::PARAM_INT);      
        $data = $rawData->queryAll();
        
        $pprs = array();
        foreach($data  as $row){
            $pprs[] = $row['person_id'];
        }        
        return $pprs;
    }

}
