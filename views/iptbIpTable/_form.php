<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#iptb-ip-table-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'iptb-ip-table-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span12">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = UserModule::t('Id')) != 'tooltip.iptb_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'iptb_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'iptb_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = UserModule::t('Name')) != 'tooltip.iptb_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'iptb_name', array('size' => 60, 'maxlength' => 255));
                            echo $form->error($model,'iptb_name')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'iptb_from') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = UserModule::t('IP From')) != 'tooltip.iptb_from')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'iptb_from', array('size' => 15, 'maxlength' => 15));
                            echo $form->error($model,'iptb_from')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'iptb_to') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = UserModule::t('IP To')) != 'tooltip.iptb_to')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'iptb_to', array('size' => 15, 'maxlength' => 15));
                            echo $form->error($model,'iptb_to')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'iptb_status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = UserModule::t('IP Status')) != 'tooltip.iptb_status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'iptb_status', $model->getEnumFieldLabels('iptb_status'));
                            echo $form->error($model,'iptb_status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

            </div>
    <div class="row">
        
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(UserModule::t('Save'), array(
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ));
                
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
