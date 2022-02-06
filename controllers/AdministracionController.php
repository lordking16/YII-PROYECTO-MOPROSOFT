<?php

class AdministracionController extends GxController {
    
    public function actionIndex() {
        
        $this->render("index");
    }
    public function actionSeleccionarProyecto() {
        
        $this->render("seleccionarProyecto");
    }
    public function actionSeleccionarDocumento($project, $phase) {
        
        $this->render('seleccionarDocumento', array('project'=>$project, 'phase'=>$phase));
    }
}

    ?>

