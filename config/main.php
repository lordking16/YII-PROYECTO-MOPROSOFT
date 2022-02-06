
<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CENIDET',
        'theme'=>'plantilla',
	'timeZone'=>'America/Mexico_City',
        //'sourceLanguage' => 'es',
	'language'=>'es_es',
        //'theme'=>'blackboot',
	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
	//linea de abajo es para colocar que controller sera el predeterminado
	//'defaultController' => 'principal_publico',
        //'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*', // giix components
		 //'application.modules.user.models.*',
	        //'application.modules.user.components.*',
                //right
                'application.modules.rights.*',
		'application.modules.rights.components.*',
		
               // 'application.modules.srbac.controllers.SBaseController', //agregamos para srbac zea
	),
        'aliases' => array(
		'xupload' => 'ext.xupload'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'generatorPaths' => array('ext.giix-core', // giix generators
			),
			'password'=>'moprosoft',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
            //rights
            'rights'=>array(
			//'debug'=>true,
			'install'=>false,
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
    
                'ePdf' => array(
                    'class'         => 'ext.yii-pdf.EYiiPdf',
                    'params'        => array(
                        'mpdf'     => array(
                           'librarySourcePath' => 'application.vendors.mpdf.*',
                            'constants'         => array(
                                '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                            ),
                            'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                        ),
                        'HTML2PDF' => array(
                            'librarySourcePath' => 'application.vendors.html2pdf.*',
                            'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                        )
                    ),
                ),

                   'bootstrap' => array(
                        'class' => 'ext.bootstrap.components.Bootstrap',
                        'responsiveCss' => true,
                    ),
                'file'=>array(
			  'class'=>'application.extensions.cfile.CFile',
		 ),
                 
                // uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
                     'urlSuffix'=>'.jsp',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		
		// uncomment the following to use a MySQL database
             'db'=>array(
			 'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;dbname=moprosoft',
                       // 'connectionString' => 'mysql:host=localhost;dbname=itvhfinal',
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
//            'authManager'=>array(
//                        'class'=>'RDbAuthManager',
//                        'connectionID'=>'db',
//                        'itemTable'=>'authitem',
//			'itemChildTable'=>'authitemchild',
//			'assignmentTable'=>'authassignment',
//			'rightsTable'=>'rights',
//                ),
        
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
                'request'=>array(
			'enableCsrfValidation'=>true,
		),
		//Inicia LOG
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
		//Ternmina LOG
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
   
);