<?php
    
	class ReportesController extends Controller{
            
                 //------------------------------------------------------------------------
                //INICIA FUNCIONES PARA MPDF
                //------------------------------------------------------------------------
                            
                //funcion para renderizar a la vista de Reportes de Cursos
//		public function actionPublicacion(){
//		$mPDF1 = Yii::app()->ePdf->mpdf();
//                $modelDocente = new Docente;
//                $mPDF1->WriteHTML($this->renderPartial('cursos',array(),true));
//                $mPDF1->Output('Programa de Cursos.pdf','D');	
//                }
        	
                //funcion para renderizar a la vista de Reportes de Instructores y sus cursos
                public function actionCursoInst(){
		$mPDF1 = Yii::app()->ePdf->mpdf();
                
                $mPDF1->WriteHTML($this->renderPartial('cursoInst',array(),true));
                $mPDF1->Output('Cursos-Instructores.pdf','D');	
                }
               
                //funcion para renderizar a la vista de Reportes de Docentes
                public function actionDocentes(){
		$mPDF1 = Yii::app()->ePdf->mpdf();
                $mPDF1->WriteHTML($this->renderPartial('docentes',array(),true));
                $mPDF1->Output('Docentes ITVH.pdf','D');	
                }
                                
                //funcion para renderizar a la vista de IndiceCapacitacion
                public function actionIndiceCapacitacion(){
		$mPDF1 = Yii::app()->ePdf->mpdf();
                $mPDF1->WriteHTML($this->renderPartial('indiceCapacitacion',array(),true));
                $mPDF1->Output('Indice de Capacitacion.pdf','D');	
                }
                
                //funcion para renderizar a la vista de IndicadorCalidad
//                 public function actionIndicadoresCalidad(){
//			
//		$mPDF1 = Yii::app()->ePdf->mpdf();
//                $encabezado='<img width="40%" src="images/logosep.jpg"/>
//                            <img src="images/logodgest.png"/>';
//                $mPDF1->setHTMLHeader($encabezado);
//                $mPDF1->WriteHTML($this->renderPartial('indicadorCalidad',array(),true));
//               $mPDF1->addPage(); //agregar una nueva pagina
//               $mPDF1->Output('Indicadores de Calidad.pdf','D');	
//                }
                //------------------------------------------------------------------------
                //INICIA FUNCIONES PARA PHPDOCX
                //------------------------------------------------------------------------
                
                 public function behaviors()
                {
                    return array(
                        'doccy'=>array(                                                                                                
                            'class' => 'application.extensions.doccy.Doccy',   
                            'options' => array(
                                       'templatePath' => 'kcfinder/uploads/files/formatos/',  // Path where docx templates are stored. Default value is controller`s view folder 
                                        //'outputPath' => 'path/to/output',  // Path where output files should be stored. Default value is application runtime folder 
                                        //'docxgenFolder' => 'docxgen-master',  // Name of the folder which holds docxgen library (must be in the extension folder). Default value is 'docxgen-master' 
                            ),
                        ),
                    );
                }
                
                //metodo para generar y descargar la Cédula de Inscripción
                
                public function actionCedula($id,$id_curso)
                {
                    $model_docente=$this->loadDocente($id);
                    $model_curso=$this->loadCurso($id_curso);
                    
                    //sentencias para extraer los datos de la unidad responsable
                    $connection=Yii::app()->db; // assuming you have configured a "db" connection
                    $sql="SELECT * FROM unidadresponsable WHERE id=$model_docente->fkunidadresponsable";
                    $unidad=$connection->createCommand($sql);
                    $datosunidad=$unidad->query();
                    
                    //sentencias para exraer los datos asignados del instructor que dara el curso
                    $sql_instructor="SELECT i.nombre,i.apellidopaterno,i.apellidomaterno FROM cursoinstructor ci
                    INNER JOIN instructor i ON i.id = ci.pkinstructor;";
                    $cmd =$connection->createCommand($sql_instructor);
                    $instructor=$cmd->query(); 
                    
                    $this->doccy->newFile('cedula inscripcion.docx'); //cargamos el template Cedula de inscripcion.docx de donde se agarrara el formato

                    //datos personales del docente
                    $this->doccy->phpdocx->assign("#apellidop#",$model_docente->apellidopaterno);
                    $this->doccy->phpdocx->assign("#apellidom#",$model_docente->apellidomaterno);
                    $this->doccy->phpdocx->assign("#nombre#",$model_docente->nombre);
                    $this->doccy->phpdocx->assign("#rfc#",$model_docente->rfc);
                    $this->doccy->phpdocx->assign("#telefono#",$model_docente->telefono);
                    $this->doccy->phpdocx->assign("#correo#",$model_docente->email);
        
                    //estudios académicos
                    $estudio=$model_docente->fknivelacademico;
                    if($estudio==1){
                        $this->doccy->phpdocx->assign("#a#","X");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");
                      }
                      elseif ($estudio==2){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","X");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");  
                      }
                      elseif ($estudio==3){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","X");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");  
                      }
                      elseif ($estudio==4){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","X");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");  
                      }
                      elseif ($estudio==5){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","X");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");  
                      }
                      elseif ($estudio==6){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","X");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","");  
                      }
                      elseif ($estudio==7){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","X");$this->doccy->phpdocx->assign("#h#","");  
                      }
                       elseif ($estudio==8){
                        $this->doccy->phpdocx->assign("#a#","");$this->doccy->phpdocx->assign("#b#","");
                        $this->doccy->phpdocx->assign("#c#","");$this->doccy->phpdocx->assign("#d#","");
                        $this->doccy->phpdocx->assign("#e#","");$this->doccy->phpdocx->assign("#f#","");
                        $this->doccy->phpdocx->assign("#g#","");$this->doccy->phpdocx->assign("#h#","X");  
                      }
                        
                        
                        $this->doccy->phpdocx->assign("#duracion#",$model_docente->duracioncarrera);

                        //datos laborales 
                        foreach($datosunidad as $tec) { //datos de la unidad responsable
                        $this->doccy->phpdocx->assign("#domiciliotec#",$tec["domicilio"]);
                        $this->doccy->phpdocx->assign("#teltec#",$tec["telefono"]);
                        }

                        $tipo_puesto=$model_docente->tipopuesto;
                        if ($tipo_puesto=="Base")
                        {
                            $this->doccy->phpdocx->assign("#1#","X");
                            $this->doccy->phpdocx->assign("#2#","");
                        }
                        else{
                            $this->doccy->phpdocx->assign("#1#","");
                            $this->doccy->phpdocx->assign("#2#","X");
                        }

                        $nivel_puesto=$model_docente->nivelpuesto;
                        if($nivel_puesto=="Funcionario"){
                             $this->doccy->phpdocx->assign("#3#","X");
                            $this->doccy->phpdocx->assign("#4#","");
                            $this->doccy->phpdocx->assign("#5#","");
                        }
                        elseif($nivel_puesto=="Enlace"){
                             $this->doccy->phpdocx->assign("#3#","");
                            $this->doccy->phpdocx->assign("#4#","X");
                            $this->doccy->phpdocx->assign("#5#","");
                        }
                        else{
                            $this->doccy->phpdocx->assign("#3#","");
                            $this->doccy->phpdocx->assign("#4#","");
                            $this->doccy->phpdocx->assign("#5#","X");
                        }

                        $this->doccy->phpdocx->assign("#unidad#",$model_docente->fkunidadresponsable0);
                        $this->doccy->phpdocx->assign("#area#",$model_docente->fkarea0);
                        $this->doccy->phpdocx->assign("#puesto#",$model_docente->puesto);
                        $this->doccy->phpdocx->assign("#jefe#",$model_docente->jefeinmediato);
                        $this->doccy->phpdocx->assign("#horario#",$model_docente->horario);

                        //datos del evento
                        foreach ($instructor as $rows){ //datos del instructor del curso
                            $nombre="".$rows["nombre"]." ".$rows["apellidopaterno"]." ".$rows["apellidomaterno"];
                            $this->doccy->phpdocx->assign("#instructor#",$nombre);
                        }
                        
                        //fecha de inicio del curso
                        $dia_inicio=substr($model_curso->fechainicio,8,2);
                        $mes_inicio=substr($model_curso->fechainicio,5,2);
                        $anio_inicio=substr($model_curso->fechainicio,0,4);
                        
                    $this->doccy->phpdocx->assign("#dia#",$dia_inicio);
                    $this->doccy->phpdocx->assign("#mes#",$mes_inicio);
                    $this->doccy->phpdocx->assign("#ano#",$anio_inicio);

                        $fecha_curso="".$dia_inicio."-".$mes_inicio."-".$anio_inicio." al ".substr($model_curso->fechafin,8,2)."-".substr($model_curso->fechafin,5,2)."-".substr($model_curso->fechafin,0,4);
                        $this->doccy->phpdocx->assign("#nombrecurso#",$model_curso->nombre);
                        $this->doccy->phpdocx->assign("#fecha#",$fecha_curso);
                        $this->doccy->phpdocx->assign("#hcurso#",$model_curso->horario);
                        $this->doccy->phpdocx->assign("#sede#",$model_curso->sede);


                       $this->renderDocx("Cedula de Inscripcion ".$model_docente->nombre." ".$model_docente->apellidopaterno." ".$model_docente->apellidomaterno.".docx", true); //descargamos el archivo word con el ombre especificado
                        }
    
                //metodo para generar y descargar la Cédula de Inscripción
                public function actionOficioComision($id,$id_curso)
                  {
                    $model_docente=$this->loadDocente($id); //cargamos el modelo del docente
                    $model_curso=$this->loadCurso($id_curso); //cargamos el modelo del curso
                    
                    $this->doccy->newFile('comisiones docentes.docx'); //cargamos el template
                   
                    $nombre_doc="".$model_docente->nombre." ".$model_docente->apellidopaterno." ".$model_docente->apellidomaterno;
                    $this->doccy->phpdocx->assign("#nombre#",$nombre_doc);
                    $this->doccy->phpdocx->assign("#curso#",$model_curso->nombre);
                    $this->doccy->phpdocx->assign("#finicio#",$model_curso->fechainicio);
                    $this->doccy->phpdocx->assign("#ffin#",$model_curso->fechafin);
                    $this->doccy->phpdocx->assign("#aula#",$model_curso->fkaula0);
                    
                    $this->renderDocx("comision para docentes.docx", true); //creamos el archivo y lo descargamos
                   }
                   
                   
            
                //funcion para crear y descargar la Constancia de Participación al curso   
                public function actionConstancia($id,$id_curso)
               {
                    $model_docente=$this->loadDocente($id);
                    $model_curso=$this->loadCurso($id_curso);
                    
                    //datos para extraer los datos del instructor
                     $connection=Yii::app()->db;
                     $sql_instructor="SELECT i.nombre,i.apellidopaterno,i.apellidomaterno FROM cursoinstructor ci
                                      INNER JOIN instructor i ON i.id = ci.pkinstructor;";
                     $cmd =$connection->createCommand($sql_instructor);
                     $instructor=$cmd->query();
                    
                   $this->doccy->newFile('Constancia de Participacion.docx'); //cargamos el template 
                   
                   $nombre_doc="".$model_docente->nombre." ".$model_docente->apellidopaterno." ".$model_docente->apellidomaterno;
                   $this->doccy->phpdocx->assign("#nombre#",$nombre_doc);
                   $this->doccy->phpdocx->assign("#curso#",$model_curso->nombre);
                   $dia_inicio=substr($model_curso->fechainicio,8,2);//utilizamos una parte del campo fechainicio para obtener el dia de inicio
                   $this->doccy->phpdocx->assign("#di#",$dia_inicio);
                   $dia_fin=substr($model_curso->fechafin,8,2); //utilizamos una parte del campo fechafin para obtener el dia de termino
                   $this->doccy->phpdocx->assign("#df#",$dia_fin);
                    
                   $dato_mes=substr($model_curso->fechainicio,5,2);//utilizamos una parte del campo fechainicio para obtener el mes
                   $mes="";
                   if($dato_mes==01){ $mes="Enero";} elseif($dato_mes==02){$mes="Febrero";}
                   elseif($dato_mes==03){ $mes="Marzo";} elseif($dato_mes==04){$mes="Abril";}
                   elseif($dato_mes==05){ $mes="Mayo";}  elseif($dato_mes==06){$mes="Junio";}
                   elseif($dato_mes==07){ $mes="Julio";} elseif($dato_mes==08){$mes="Agosto";}
                   elseif($dato_mes==09){ $mes="Septiembre";} elseif($dato_mes==10){$mes="Octubre";}
                   elseif($dato_mes==11){ $mes="Noviembre";} elseif($dato_mes==12){$mes="Diciembre";}
                   
                   $this->doccy->phpdocx->assign("#mes#",$mes);
                   
                   $anio=substr($model_curso->fechainicio,0,4);
                   $this->doccy->phpdocx->assign("#anio#",$anio);
                   $this->doccy->phpdocx->assign("#horas#",$model_curso->horas_curso);
                    
                    //fecha del sistema
                   $this->doccy->phpdocx->assign("#dia#",date("d"));
                   $this->doccy->phpdocx->assign("#mes2#",date("m"));
                   $this->doccy->phpdocx->assign("#anio2#",date("Y"));
                    
                    foreach ($instructor as $rows){
                     $nombre_inst="".$rows["nombre"]." ".$rows["apellidopaterno"]." ".$rows["apellidomaterno"];
                     $this->doccy->phpdocx->assign("#instructor#",$nombre_inst);
                    }
                    
                    $this->renderDocx("Constancia de Participacion ".$nombre_doc.".docx", true);//crea y descarga el archivo
                  }
            
                  
                  
                  //funcion para generar la lista de Asistencia a los curso
//                  public function actionListaAsistencia($model)
//                          
//                         
//                {           
//                       $id_curso=$model->curso;
//                       
//                    $connection=Yii::app()->db;
//                    //query para sacar la lista de docentes inscritos en un curso
//                    $sql_lista="SELECT d.nombre,d.apellidopaterno, d.apellidomaterno, d.rfc, d.puesto, d.tipopuesto, d.nivelpuesto,a.nombre as nombre_area  FROM cursodocente cd 
//                                      INNER JOIN docente d ON cd.pkdocente=d.nodocente
//                                      INNER JOIN area a ON d.fkarea=a.id WHERE cd.pkcurso=".$id_curso." ;";
//                    $d_lista =$connection->createCommand($sql_lista);
//                    $c_lista=$d_lista->query();
//
//                    $this->doccy->newFile('lista de asistencia.docx'); 
//                   
//                    //query para sacar los valores de los atributos del curso
//                    $sql_curso="SELECT c.nombre as nombre_curso,c.fechainicio,c.fechafin,c.horas_curso,c.sede,c.horario,c.fktipocurso,i.nombre as inst_nombre,i.apellidopaterno,i.apellidomaterno,i.rfc,i.curp FROM cursoinstructor ci 
//                                  INNER JOIN curso c ON ci.pkcurso=c.id
//                                  INNER JOIN instructor i ON ci.pkinstructor=i.id WHERE  c.id=5;";
//                    $d_curso =$connection->createCommand($sql_curso);
//                    $c_curso=$d_curso->query();
//                    
//                    $nombre_curso="";
//              
//                    foreach ($c_curso as $resultado){
//                        
//                        
//                        $nombre_i=$resultado["inst_nombre"]." ".$resultado["apellidopaterno"]." ".$resultado["apellidomaterno"];
//                        $fecha=$resultado["fechainicio"]." al ".$resultado["fechafin"]."";
//                        $this->doccy->phpdocx->assign("#curso#",$resultado["nombre_curso"]);
//                       
//                        //generacion del folio del curso
//                        $tipo_curso=$resultado["fktipocurso"];
//                        if ($tipo_curso==1)
//                            $dato1="AD";
//                        else
//                            $dato1="AP";
//                        
//                        $mes_inicio=  substr($resultado["fechainicio"],5,2);
//                        $anio_inicio=  substr($resultado["fechainicio"],0,4);
//                        $folio=$dato1."-".$mes_inicio."-".$anio_inicio;
//                        
//                        $this->doccy->phpdocx->assign("#folio#",$folio);        
//                        $this->doccy->phpdocx->assign("#instructor#",$nombre_i);
//                        $this->doccy->phpdocx->assign("#fecha#",$fecha);
//                        $this->doccy->phpdocx->assign("#duracion#",$resultado["horas_curso"]);
//                        $this->doccy->phpdocx->assign("#horario#",$resultado["horario"]);
//                        $this->doccy->phpdocx->assign("#sede#",$resultado["sede"]);
//                        $this->doccy->phpdocx->assign("#rfc#",$resultado["rfc"]);
//                        $this->doccy->phpdocx->assign("#curp#",$resultado["curp"]);
//
//                    }
//                    $contador=0; //variable para llevar el control de los registros
//                    $docentes=array(); //array para insertar los datos de los docentes
//        
//                    foreach ($c_lista as $l_docente){
//                        $contador++;
//                        $tpuesto=$l_docente["tipopuesto"];
//                        $npuesto=$l_docente["nivelpuesto"];
//                            if ($tpuesto=="Base"){
//                                $B1="X";
//                                $C1="";
//                                }
//                            else {
//                                $B1="";
//                                $C1="X";
//                            }
//
//                            if ($npuesto=="Funcionario"){
//                                $F1="X";
//                                $E1="";
//                                $O1="";
//                            }
//                            elseif ($npuesto=="Enlace") {
//                                $F1="";
//                                $E1="X";
//                                $O1="";
//                            }
//                            else
//                            {
//                              $F1="";
//                                $E1="";
//                            }
//                                $O1="X";  
//
//                        $docentes[$contador]= array("#l#"=>$contador,"#NOMBRE#"=>$l_docente['nombre'],"#AP#"=>$l_docente['apellidopaterno'],"#AM#"=>$l_docente['apellidomaterno'],"#RFC#"=>$l_docente['rfc'],"#PUESTO#"=>$l_docente['puesto'],"#AREA#"=>$l_docente["nombre_area"],"#B#"=>$B1,"#C1#"=>$C1,"#F1#"=>$F1,"#E1#"=>$E1,"#O1#"=>$O1);
//
//                    }
//
//                    $this->doccy->phpdocx->assignBlock("docentes",$docentes); //assignBlock, metodo para insertar varios registros en el template, repitiendo el patron establecido
//                    $this->renderDocx("lista del ".$nombre_curso.".docx", true); 
//                 }

             //funcion para crear y descargar el Programa de Capacitacion del Periodo Actual
              public function actionProgramaCapacitacion()
            {
                $this->doccy->newFile('programa de capacitacion.docx'); //cargamos el template
                
                //DATOS DE CURSOS ACTUALES
                $connection=Yii::app()->db;
                $sql_programa="SELECT c.id as id_curso, c.nombre as nombre_curso,c.objetivo,c.horas_curso,c.dirigido,c.observaciones,p.nombre as nombre_periodo,a.nombre as nombre_aula FROM curso c
                                INNER JOIN periodo p ON c.fkperiodo=p.id
                                INNER JOIN aula a ON c.fkaula=a.id WHERE p.status=1;";
                    $d_programa =$connection->createCommand($sql_programa);
                    $c_programa=$d_programa->query();
                    
                    $contador=0;
                    $programa=array();
                    $instructor="";
                    foreach($c_programa as $l_programa ){
                         $sql_inst="SELECT i.nombre,i.apellidopaterno,i.apellidomaterno FROM cursoinstructor ci
                                INNER JOIN instructor i ON ci.pkinstructor=i.id  WHERE ci.pkcurso=".$l_programa["id_curso"]."";
                            $d_inst =$connection->createCommand($sql_inst);
                            $c_inst=$d_inst->query();
                            
                             $contador++;
                            foreach($c_inst as $l_inst){
                                $instructor=$l_inst["nombre"]." ".$l_inst["apellidopaterno"]." ".$l_inst["apellidomaterno"];
                                
                            }
                            
                            $programa[$contador]=array("#c#"=>$contador,"#nombre#"=>$l_programa["nombre_curso"],"#objetivo#"=>$l_programa["objetivo"],"#periodo#"=>$l_programa["nombre_periodo"],"#aula#"=>$l_programa["nombre_aula"],"#horas#"=>$l_programa["horas_curso"],"#instructor#"=>$instructor,"#dirigido#"=>$l_programa["dirigido"],"#observaciones#"=>$l_programa["observaciones"]);
                            $periodo=$l_programa["nombre_periodo"];
                            $instructor="";
                    }
                            $this->doccy->phpdocx->assign("#periodo#",$periodo);
                            $this->doccy->phpdocx->assignBlock("curso",$programa);

                $this->renderDocx("Programa de Capacitacion ".$periodo.".docx", true); // use $forceDownload=false in order to (just) store file in the outputPath folder.
            }
            
            //funcion para crear y descargar el Indicador de Calidad
              public function actionIndic_Calidad()
            {
                $this->doccy->newFile('Indicadores calidad.docx'); //cargamos el template
                
                $connection=Yii::app()->db; // consulta para traer los datos
                  //Pagina 1
                
                //sentencias para obtener los datos de los docentes diferentes qu tomaron el curso
                $doc_capacitados="SELECT count(DISTINCT pkdocente) as doc_capacitados FROM cursodocente cd
                    INNER JOIN curso c ON cd.pkcurso=c.id
                    INNER JOIN periodo p ON c.fkperiodo=p.id 
                    WHERE p.status=1;";
                $d_capac=$connection->createCommand($doc_capacitados);
                $n_capac=$d_capac->query();
                
                //sentencias para obtener el numero de docentes exixtentes en la institución
                $num_doc="SELECT numdocentes FROM unidadresponsable WHERE sede=1;";
                $d_doc=$connection->createCommand($num_doc);
                $n_doc=$d_doc->query();
                
                //foraech para asignar a una variable el valor de los docentes capacitados
                foreach($n_capac as $r_capacitado){
                    $docentes_capac=$r_capacitado["doc_capacitados"];
                }
                                
                //foraech para asignar a una variable el valor del total de docentes en la institución
                foreach($n_doc as $r_total){
                    $total_docentes=$r_total["numdocentes"];
                }
                
                //operación aritmética para sacar el valor esperado ($docentes_capac/$total_docentes)x 100
                $valor_esp=($docentes_capac/$total_docentes)* 100;
                $valor_redondeado=round($valor_esp,2);
                
                //asignar el resultado en la pagina 1
                $this->doccy->phpdocx->assign("#doc#",$docentes_capac);
                $this->doccy->phpdocx->assign("#tot#",$total_docentes);
                $this->doccy->phpdocx->assign("#res#",$valor_redondeado);


                //PAGINA 2
                //DATOS DE AREAS ACADEMICAS
                
                $sql="SELECT a.id, a.nombre FROM area a";
                $datos_area=$connection->createCommand($sql);
                $consulta=$datos_area->query();
                
                $total=0;
                $contador=0;
                $areas=array();
            foreach ($consulta as $area){
                $contador++;
                
                 $doc="SELECT count(DISTINCT pkdocente)as num_doc FROM cursodocente cd
                        INNER JOIN docente d ON cd.pkdocente=d.nodocente 
                        INNER JOIN curso c ON cd.pkcurso=c.id
                        INNER JOIN periodo p ON c.fkperiodo=p.id 
                        WHERE p.status=1 AND d.fkarea=".$area["id"]." AND d.fkhorasdocencia<>1;";
                    $num_doc=$connection->createCommand($doc);
                    $c_docentes=$num_doc->query();
                    foreach ($c_docentes as $numero){
                        $numero=$numero["num_doc"];
                        $total+=$numero;
                         
                        $areas[$contador]=array("#nombre#"=>$area["nombre"],"#numero#"=>$numero);                    
                        }
                   }
                 $numero=0;
                
                 //operacion aritmetica
                 $valor_final=round(($total/$total_docentes)*100,2);
                 $this->doccy->phpdocx->assignBlock("area",$areas); 
                 $this->doccy->phpdocx->assign("#total#",$total);
                 $this->doccy->phpdocx->assign("#esperado#",$valor_final);

                $this->renderDocx("Indicador de Calidad.docx", true); // use $forceDownload=false in order to (just) store file in the outputPath folder.
            }
          
            //funcion para cargar el modelo del Docente
            public function loadDocente($id)
                {
                        $model_docente=Docente::model()->findByPk($id);
                        if($model_docente===null)
                                throw new CHttpException(404,'The requested page does not exist.');
                        return $model_docente;
                }
                
            //funcion para cargar el modelo del Curso
                public function loadCurso($id_curso)
                {
                        $model_curso=Curso::model()->findByPk($id_curso);
                        if($model_curso===null)
                                throw new CHttpException(404,'The requested page does not exist.');
                        return $model_curso;
                }

    
        }
   ?>