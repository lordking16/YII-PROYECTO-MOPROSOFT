<?php

class VerificationDefectController extends GxController {
    
    public function actionCreate($id_verification) {
        
        $this->render("create", array('id_verification' => $id_verification));
    }
    
    public function actionCreateDefect($id_verification, $id_document) {
        
        $model = new VerificationDefect;

        if (isset($_POST['VerificationDefect'])) {
			$model->setAttributes($_POST['VerificationDefect']);
			
                        if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
//					$this->redirect(array('view', 'id' => $model->id_verification));
                                        $this->redirect(array('verificationDefect/create', 'id_verification' => $id_verification));
			}
		}

		$this->render('createDefect', array( 'model' => $model, 'id_verification'=>$id_verification, 'id_document'=>$id_document));
    }
    
    public function actionUpdateDefect($id_defect, $id_verification , $id_document) {
		$model = VerificationDefect::model()->findByPk(array(
                                                                    'id_defect' => $id_defect,
                                                                    'id_verification' =>1,
                                                                    ));


		if (isset($_POST['VerificationDefect'])) {
                        
                        $model->setAttributes($_POST['VerificationDefect']);
                        
                        $find=new DateTime($model->find_Date);
                        $correction=new DateTime($model->correction_Date);
                        $diff=$find->diff($correction);
                        $model->correction_Time=($diff->format("%d days, %h hours and %i minuts"));
			
                        if ($model->save()) {
				$this->redirect(array('verificationDefect/create', 'id_verification' => $id_verification));
			}
		}

		$this->render('updateDefect', array(
				'model' => $model,
                                'id_document'=>$id_document,
                                'id_verification' => $id_verification,
				));
	}
        
        public function actionVerificationChecklist($id_verification, $id_document){
            $this->render('verificationChecklist', array('id_verification' => $id_verification,'id_document'=>$id_document));  }
   
}

    ?>

