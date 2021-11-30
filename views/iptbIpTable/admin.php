<?php
$this->setPageTitle(
    UserModule::t('IP Tables')
    . ' - '
    . UserModule::t('Manage')
);

?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('User.IptbIpTable.*') || Yii::app()->user->checkAccess('User.IptbIpTable.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo UserModule::t('IP Tables');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('IptbIpTable.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'iptb-ip-table-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                //varchar(255)
                'class' => 'editable.EditableColumn',
                'name' => 'iptb_name',
                'editable' => array(
                    'url' => $this->createUrl('/user/iptbIpTable/editableSaver'),
                    'placement' => 'right',
                )
            ),
            array(
                //varchar(15)
                'class' => 'editable.EditableColumn',
                'name' => 'iptb_from',
                'editable' => array(
                    'url' => $this->createUrl('/user/iptbIpTable/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(15)
                'class' => 'editable.EditableColumn',
                'name' => 'iptb_to',
                'editable' => array(
                    'url' => $this->createUrl('/user/iptbIpTable/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'iptb_status',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/user/iptbIpTable/editableSaver'),
                        'source' => $model->getEnumFieldLabels('iptb_status'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('iptb_status'),
                ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'FALSE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("User.IptbIpTable.Delete")'),
                ),
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("iptb_id" => $data->iptb_id))',
                'deleteConfirmation'=>Yii::t('','Do you want to delete this item?'),                    
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);

Yii::endProfile('IptbIpTable.view.grid');