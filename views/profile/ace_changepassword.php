<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");?>

<div class="crud-form">
<?php 
    
Yii::app()->bootstrap->registerAssetCss('../select2/select2.css');
Yii::app()->bootstrap->registerAssetJs('../select2/select2.js');
Yii::app()->clientScript->registerScript('crud/variant/update','$(".crud-form select").select2();');

$form=$this->beginWidget('TbActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 
echo $form->errorSummary($model);
?>

<?php echo $form->errorSummary($model); ?>
	
<div class="control-group">
    <div class='control-label'>
        <?php echo $form->labelEx($model,'oldPassword'); ?>
    </div>
    <div class='controls'>
        <?php echo $form->passwordField($model,'oldPassword'); ?>
        <?php echo $form->error($model,'oldPassword'); ?>
	</div>
</div>
	
<div class="control-group">
    <div class='control-label'>
    	<?php echo $form->labelEx($model,'password'); ?>
    </div>
    <div class='controls'>
    	<?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
        <p class="hint">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
        </p>
	</div>
</div>
	
<div class="control-group">
    <div class='control-label'>
    	<?php echo $form->labelEx($model,'verifyPassword'); ?>
    </div>
    <div class='controls'>
    	<?php echo $form->passwordField($model,'verifyPassword'); ?>
        <?php echo $form->error($model,'verifyPassword'); ?>
	</div>
</div>
<p class="alert">
    <?php echo UserModule::t('Fields with <span class="required">*</span> are required.');?>
</p>	


<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>UserModule::t("Save"),
        'buttonType'=>'submit', 
        'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        //'size'=>'large', // null, 'large', 'small' or 'mini'
        'icon'=>'icon-ok',
        'htmlOptions'=> array('class' => 'btn btn-small btn-primary'),
    )); ?>                                                            
    
</div>


<?php $this->endWidget(); ?>
</div>