<?php
//$this->breadcrumbs=array(
//	UserModule::t('Users')=>array('admin'),
//	UserModule::t('Create'),
//);

//$this->menu=array(
//    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
//);
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
<h1><?php echo UserModule::t("Create User"); ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>

    </div>
</div>