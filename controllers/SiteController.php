<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
       //public $layout='//layouts/column1';
        
        public function init()
        {
           if(Yii::app()->user->isGuest){
              Yii::app()->theme = 'plantilla';
           }else{
              Yii::app()->theme = 'plantilla';
              $this->layout="//layouts/column2";
           }
           parent::init();
        }
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			'moprosoft'=>array(
				'class'=>'CViewAction',
				'basePath'=>'moprosoft',
			),
                    
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
             $this->layout="//layouts/column1";
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
                
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
             

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
                        {   //el metodo getId() trae el num del role del usuario 
                            if((Yii::app()->user->role)==1)
                            {    
                            $this->redirect('/moprosoft/administracion/index');                           
                            }
                            else 
                            {
                            $this->redirect('/moprosoft/administracion/seleccionarProyecto');    
                            }
                        }
				
		}
                // display the login form
		$this->render('login',array('model'=>$model));    
                
		}
                           
                     

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
       
	
	# Added by LEU to try random things:
//	public function actionTest() {
//		if (true) {
//			Yii::app()->user->setFlash('success', 
//				'The thing you just did worked.');
//		} else {
//			Yii::app()->user->setFlash('error', 
//				'The thing you just did DID NOT work.');
//		}
//		$data = NULL;
//		$this->render('test', array('data'=> $data));
//	}
        
}