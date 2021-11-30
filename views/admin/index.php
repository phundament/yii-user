<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<table class="toolbar"><tr>
    <td>
<?php
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => UserModule::t('Create User'),
                    "icon" => "icon-plus",
                    "url" => array("create"),
                    //"visible" => Yii::app()->user->checkAccess("Company.*")
                ));

?>            
    </td>
    </tr>
</table>    

<h1><?php echo UserModule::t("Manage Users"); ?></h1>
<div class="row">
<div class="span10">

<?php $defaultGridView = Yii::app()->getModule('user')->defaultGridView; ?>
<?php $this->widget($defaultGridView['path'], $defaultGridView['options'] + array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			//'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			//'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'class'=>$defaultGridView['buttonColumn'],
		),
	),
)); ?>
</div>