<?php

class ValidationController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Validation'),
		));
	}

	public function actionCreate() {
		$model = new Validation;


		if (isset($_POST['Validation'])) {
			$model->setAttributes($_POST['Validation']);
			$relatedData = array(
				'users' => $_POST['Validation']['users'] === '' ? null : $_POST['Validation']['users'],
				);

			if ($model->saveWithRelated($relatedData)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id_validation));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Validation');


		if (isset($_POST['Validation'])) {
			$model->setAttributes($_POST['Validation']);
			$relatedData = array(
				'users' => $_POST['Validation']['users'] === '' ? null : $_POST['Validation']['users'],
				);

			if ($model->saveWithRelated($relatedData)) {
				$this->redirect(array('view', 'id' => $model->id_validation));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Validation')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Validation');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Validation('search');
		$model->unsetAttributes();

		if (isset($_GET['Validation']))
			$model->setAttributes($_GET['Validation']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}