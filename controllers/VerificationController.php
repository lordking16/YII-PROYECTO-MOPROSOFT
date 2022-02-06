<?php

class VerificationController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Verification'),
		));
	}

	public function actionCreate() {
		$model = new Verification;


		if (isset($_POST['Verification'])) {
			$model->setAttributes($_POST['Verification']);
			$relatedData = array(
				'users' => $_POST['Verification']['users'] === '' ? null : $_POST['Verification']['users'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
//					$this->redirect(array('view', 'id' => $model->id_verification));
                                        $this->redirect(array('verificationDefect/create', 'id_verification' => $model->id_verification));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Verification');


		if (isset($_POST['Verification'])) {
			$model->setAttributes($_POST['Verification']);
			$relatedData = array(
				'users' => $_POST['Verification']['users'] === '' ? null : $_POST['Verification']['users'],
				);

			if ($model->saveWithRelated($relatedData)) {
				$this->redirect(array('verificationDefect/create', 'id_verification' => $model->id_verification));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Verification')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Verification');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Verification('search');
		$model->unsetAttributes();

		if (isset($_GET['Verification']))
			$model->setAttributes($_GET['Verification']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
        
        public function actionStartVerification($id_verification){
            $model=$this->loadModel($id_verification, 'Verification');
            $model->start_verification=date(DATE_ISO8601);
            $model->save();
            $this->redirect(array('verificationDefect/create', 'id_verification' => $id_verification));
            
        }
        
        public function actionEndVerification($id_verification, $id_document){
            $model=$this->loadModel($id_verification, 'Verification');
            $model->end_verification=date(DATE_ISO8601);
            $model->save(); //guardar los la fecha de termino en la tabla verificacion
            
            //sentencias para verificar que todos los defectos hayan sido resueltos (solved=1)
             $connection=Yii::app()->db; // assuming you have configured a "db" connection
                    $sql="SELECT count(*)as noResueltos  FROM verification_defect WHERE id_verification=".$id_verification." AND solved=0;";
                    $solved=$connection->createCommand($sql);
                    $resuelto=$solved->query();
                    
                    foreach ($resuelto as $res) {
                       if($res["noResueltos"]==0){
                    //si no hay defectos que no hayan sido resueltos, cambia el status enable del siguiente documento
                    $sql="UPDATE document SET enable=1 WHERE id_document=".($id_document+1).";";
                    $enable=$connection->createCommand($sql);
                    $enable->query();
                       } 
                    }
            
            
            $this->redirect(array('administracion/seleccionarProyecto'));
            
        }
        

}