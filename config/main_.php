<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Sitio Oficial ITVillahermosa',
        'theme'=>'plantilla',
	'timeZone'=>'America/Mexico_City',
        'sourceLanguage' => 'es',
        
                        // preloading 'log' y bootstrap component
	'preload'=>array('log','bootstrap'),
                        //'preload'=>array('log'),

                        // autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                //right
                'application.modules.rights.*',
		'application.modules.rights.components.*',
		
            
	),
                            //se agrega para subir archivos zea
        'aliases' => array(
		'xupload' => 'ext.xupload'
	),

	'modules'=>array(
                            // uncomment the following to enable the Gii tool
                            /*
                            'gii'=>array(
                                    'class'=>'system.gii.GiiModule',
                                    'password'=>'zea',
                                    // If removed, Gii defaults to localhost only. Edit carefully to taste.
                                    'ipFilters'=>array('127.0.0.1','::1'),
                            ),*/
                            //rights
            'rights'=>array(
                            //'debug'=>true,
                            //'install'=>true,
			'enableBizRuleData'=>true,
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
                         //right
                        'class'=>'RWebUser',
			// enable cookie-based authentication
                        // 'tableUsers' => 'usuario',
			'allowAutoLogin'=>true,
                        //'loginUrl'=>array('/user/login'),
		),
		'bootstrap' => array(
                        'class' => 'ext.bootstrap.components.Bootstrap',
                        'responsiveCss' => true,
                    ),
                'file'=>array(
			  'class'=>'application.extensions.cfile.CFile',
		 ),
                    
//                'authManager'=>array(
//			'class'=>'CDbAuthManager',
//			'connectionID'=>'db',
//		),
		
		
            

                // uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
             'db'=>array(
			//'connectionString' => 'mysql:host=172.16.24.184;dbname=itvhfinal',
                        'connectionString' => 'mysql:host=localhost;dbname=itvhfinal',
			'emulatePrepare' => true,
			# Edit made in Chapter 8, "Working with Databases":
			'enableParamLogging' => true,
			//'username' => 'test',
			//'password' => '_2013_2013',
                        'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		//ritghs
            'authManager'=>array(
                        'class'=>'RDbAuthManager',
                        'connectionID'=>'db',
                        'itemTable'=>'authitem',
			'itemChildTable'=>'authitemchild',
			'assignmentTable'=>'authassignment',
			'rightsTable'=>'rights',
                ),
        
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
                'request'=>array(
			'enableCsrfValidation'=>true,
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
                'anno'=>2014,
		'adminEmail'=>'computo@itvillahermosa.edu.mx',
                'nombreEvento'=>'Sitio Oficial del Itvillahermosa',
                'fechaActualizacion'=>'18/08/2013',
                'correoEncargado'=>'computo@itvillahermosa.edu.mx',
                'encryptionKey'=>'lvkj23mn5j25KJE5r', //zea
                'notaPorPagina'=>3, //zea
                'CAPTURADO'=>1, //actual
                'PUBLICADO'=>2,
                'ARCHIVADO'=>3,
                'CANCELADO'=>4,
        
	),
   
);