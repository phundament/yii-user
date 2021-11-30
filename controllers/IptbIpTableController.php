<?php


class IptbIpTableController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    
    public $menu_route = "user/iptbIpTable";  


    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
         return array(
            array(
                'allow',
                'actions' => array('create', 'admin',  'editableSaver', 'delete'),
                'roles' => array('User.IptbIpTable.*'),
            ),
            array(
                'allow',
                'actions' => array('admin'), // let the user view the grid
                'roles' => array('User.IptbIpTable.View'),
            ),
            array(
                'allow',
                'actions' => array('editableSaver'),
                'roles' => array('User.IptbIpTable.Update'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('User.IptbIpTable.Delete'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView($iptb_id, $ajax = false)
    {
        $model = $this->loadModel($iptb_id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        )
                    );
        }else{
            $this->render('view', array('model' => $model,));
        }
    }

    public function actionCreate()
    {
        $model = new IptbIpTable;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'iptb-ip-table-form');

        if (isset($_POST['IptbIpTable'])) {
            $model->attributes = $_POST['IptbIpTable'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('admin'));
                    }
                }
            } catch (Exception $e) {
                $model->addError('iptb_id', $e->getMessage());
            }
        } elseif (isset($_GET['IptbIpTable'])) {
            $model->attributes = $_GET['IptbIpTable'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('IptbIpTable'); // classname of model to be updated
        $es->update();
    }

    public function actionDelete($iptb_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($iptb_id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, UserModule::t('Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new IptbIpTable('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['IptbIpTable'])) {
            $model->attributes = $_GET['IptbIpTable'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = IptbIpTable::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, UserModule::t('The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'iptb-ip-table-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
