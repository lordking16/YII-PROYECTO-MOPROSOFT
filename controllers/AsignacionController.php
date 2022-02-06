<?php

        

class AsignacionController extends GxController {
    
    
    public function actionAsignar() {
        
        $model = new ProjectUser;
        
        if (isset($_POST['ProjectUser'])) {
			$model->setAttributes($_POST['ProjectUser']);
			
			if ($model->save()) {
				
					$this->redirect(array('admin'));
			}
		}

       $this->render("asignar", array('model'=>$model));
    }
    
    public function actionAdmin(){
        
        $this->render("admin");
    }
    
    public function actionDelete($project,$user){
                    
                     $connection=Yii::app()->db; // assuming you have configured a "db" connection
                    $sql="delete from project_user where id_project=".$project." and id_user=".$user."";
                    $delete=$connection->createCommand($sql);
                    $delRegistro=$delete->query();
                    
                    $this->render("admin");   
    }
}

    ?>

