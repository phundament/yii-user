<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

?>
<div class="span7">
        
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
        
<?php 
        $this->widget(
            'TbAceDetailView', 
            array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'name' => 'username',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'create_at',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'lastvisit_at',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'status',
                        'value' => CHtml::encode(User::itemAlias("UserStatus",$model->status)),
                        
                    ),
                    

                )
            )
        );
?>
      
        

</div>