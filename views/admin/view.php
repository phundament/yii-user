<?php
//$this->breadcrumbs=array(
//	UserModule::t('Users')=>array('admin'),
//	$model->username,
//);


$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Update User'), 'url'=>array('update','id'=>$model->id)),
    array('label'=>UserModule::t('Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);

?>

<table class="toolbar"><tr>
    <td>
<?php
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t('Manage Users'),
                    "icon" => "icon-list-alt",
                    "url" => array("admin"),
                    //"visible" => Yii::app()->user->checkAccess("Company.*")
                ));

?>            
    </td>
    </tr>
</table>    
    
<div class="row">
	<div class="span3">
        <h2><?php echo UserModule::t('View User').' "'.$model->username.'"'; ?></h2>        

<?php
 
	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		'password',
		'email',
		'activkey',
		'create_at',
		'lastvisit_at',
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
    $defaultDetailView = Yii::app()->getModule('user')->defaultDetailView;
    $this->widget($defaultDetailView['path'], $defaultDetailView['options'] + array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
?>
    </div>
    <div class="span1"></div>
            <?php 
            /**
             * ROLES
             */
            ?>
            <div class="span3"> <!-- main inputs -->
                <h2><?php echo UserModule::t('Roles'); ?></h2>

            <?php 
            $form=$this->beginWidget('CActiveForm');
            $aChecked = Authassignment::model()->getUserRoles($model->id);
            if (count($aChecked) == 1){
                //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
                $aChecked = $aChecked[0];
            }
            $UserAdminRoles = Yii::app()->getModule('user')->UserAdminRoles;
            $list = array();
            foreach ($UserAdminRoles as $role_name){
                $list[$role_name] = $role_name;
            }
            echo CHtml::checkBoxList(
                    'user_role_name', 
                    $aChecked, 
                    $list,
                    array ( 'labelOptions'=>array('style'=>'display: inline'))
                    );
             
             
            /**
             * SYS companies
             */
            ?>                
                <h2><?php echo UserModule::t('Sys companies'); ?></h2>

            <?php 

            $aUserCompanies = CcucUserCompany::model()->getUserCompnies($model->id,CcucUserCompany::CCUC_STATUS_SYS);
            $aChecked = array();
            foreach($aUserCompanies as $UC){
                $aChecked[] = $UC->ccuc_ccmp_id;
            }


            if (count($aChecked) == 1){
                //kaut kads gljuks, nedrikst padot masivu ar vienu elementu
                $aChecked = $aChecked[0];
            }

            $list = array();
            if(UserModule::isAdmin()){
                //for admin get all sys companies
                $criteria = new CDbCriteria;
                $criteria->compare('t.ccxg_ccgr_id', 1); //1 - syscompany
                $model_ccxg = CcxgCompanyXGroup::model()->findAll($criteria);                
                foreach ($model_ccxg as $mCcxg) {
                    if (isset($mCcxg->ccxgCcmp->ccmp_name)) {
                        $list[$mCcxg->ccxg_ccmp_id] = $mCcxg->ccxgCcmp->ccmp_name;
                    }
                }            
                
            }else{
                //get user sys companies
                foreach (Yii::app()->sysCompany->getClientCompanies() as $mCcmp) {
                    $list[$mCcmp['ccmp_id']] = $mCcmp['ccmp_name'];
                }            
            }
            
            echo CHtml::checkBoxList(
                    'user_sys_ccmp_id', 
                    $aChecked, 
                    $list,
                    array ( 'labelOptions'=>array('style'=>'display: inline'))
                    );

    ?>

    <div class="form-actions">
        
    <?php
        echo CHtml::resetButton(Yii::t('D2companyModule.crud_static','Reset'), array(
			'class' => 'btn'
			));
        echo ' '.CHtml::submitButton(
                    Yii::t('D2companyModule.crud_static','Save'), 
                    array(
                        'class' => 'btn btn-primary',
                        'name'=>'save_user_roles'
                    )
                );
    ?>
    </div>    
<?php $this->endWidget(); ?>
</div>
</div>
