<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';
    public $contentHeader = FALSE;
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
    
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all user to edit own profile
				'actions'=>array('edit'),
				'expression'=>'(UserModule::isAdmin() || Yii::app()->getModule(\'user\')->allowUserEditProfile)',
			),
			array('allow',  // allow all user view own profile
				'actions'=>array('profile','changepassword'),
				'users'=>array('@'), //autentificated users
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	    
    
	/**
	 * Shows a particular model.
	 */
	public function actionProfile($ajax = false)
	{

        if($ajax !== false 
                && $ajax == 'ppcn-person-contact-grid'
                && Yii::app()->hasModule('d2person')
        ){
            $view = Yii::app()->getModule('user')->view . '.profile._view_contacts';
            $this->renderPartial($view);
            return;
        }

        $model = $this->loadUser();        
        
        $view = 'profile';       
        
        if(Yii::app()->getModule('user')->view){
            $alt_view = Yii::app()->getModule('user')->view . '.profile.'.$view;
            if (is_readable(Yii::getPathOfAlias($alt_view) . '.php')) {
                $view = $alt_view;
                $this->layout=Yii::app()->getModule('user')->layout;
            }
        }
        
        if (DbrUser::isCustomerOfficeUser()) {
            $this->contentHeader = UserModule::t('Your profile');
            $this->layout='//layouts/ace';
            $this->render('ace_profile', array(
                'model' => $model,
                'profile' => $model->profile,
            ));
        } else {
            $this->render($view, array(
                'model' => $model,
                'profile' => $model->profile,
            ));
        }
    }


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
            
            $view = 'changepassword';       
            if(Yii::app()->getModule('user')->view){
                $alt_view = Yii::app()->getModule('user')->view . '.profile.'.$view;
                if (is_readable(Yii::getPathOfAlias($alt_view) . '.php')) {
                    $view = $alt_view;
                    $this->layout=Yii::app()->getModule('user')->layout;
                }
            }            
            
            if (DbrUser::isCustomerOfficeUser()) {
                $this->contentHeader = UserModule::t('Change password');
                $this->layout='//layouts/ace';
                $this->render('ace_changepassword', array(
                    'model' => $model,
                ));
            } else {
                $this->render($view, array(
                    'model' => $model,
                ));
            }            
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}