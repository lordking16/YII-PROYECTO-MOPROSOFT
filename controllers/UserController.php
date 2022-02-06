<?php

class UserController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'User'),
		));
	}

	public function actionCreate() {
		$model = new User;


		if (isset($_POST['User'])) {
			$model->setAttributes($_POST['User']);
			$relatedData = array(
//				'projects' => $_POST['User']['projects'] === '' ? null : $_POST['User']['projects'],
//				'validations' => $_POST['User']['validations'] === '' ? null : $_POST['User']['validations'],
//				'verifications' => $_POST['User']['verifications'] === '' ? null : $_POST['User']['verifications'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id_user));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'User');


		if (isset($_POST['User'])) {
			$model->setAttributes($_POST['User']);
//			$relatedData = array(
////				'projects' => $_POST['User']['projects'] === '' ? null : $_POST['User']['projects'],
////				'validations' => $_POST['User']['validations'] === '' ? null : $_POST['User']['validations'],
////				'verifications' => $_POST['User']['verifications'] === '' ? null : $_POST['User']['verifications'],
//				);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id_user));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'User')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('User');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new User('search');
		$model->unsetAttributes();

		if (isset($_GET['User']))
			$model->setAttributes($_GET['User']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}