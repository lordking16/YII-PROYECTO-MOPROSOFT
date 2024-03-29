<?php

/**
 * This is the model base class for the table "usuario".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Usuario".
 *
 * Columns in table "usuario" available as properties of the model,
 * followed by relations of table "usuario" available as properties of the model.
 *
 * @property integer $id
 * @property integer $fkdocente
 * @property string $username
 * @property string $contrasena
 * @property integer $fktipousuario
 *
 * @property Tipousuario $fktipousuario0
 * @property Docente $fkdocente0
 */
abstract class BaseUsuario extends GxActiveRecord {
	
	public $password;
	public $password_repeat;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'usuario';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Usuario|Usuarios', $n);
	}
	public function afterSave() 
	{ 
		$usuario=$this->fktipousuario; 
		if($usuario==1) 
			$rol="docente"; 
		else if ($usuario==2)
		{
			$rol="Jefe Depto";
		}
		else if ($usuario==3)
		{
			$rol="Admin2";
		} 
		else $rol="comunicacion"; // Assign the auth role: 
		
		if (!Yii::app()->authManager->isAssigned($rol,$this->id)) 
		{ 
			Yii::app()->authManager->assign($rol, $this->id); 
		} 
	return parent::afterSave(); 
	}

	public static function representingColumn() {
		return 'username';
	}

	public function rules() {
		return array(
			array('fkdocente, username, fktipousuario', 'required'),
			array('fkdocente, fktipousuario', 'numerical', 'integerOnly'=>true),
			//array('username','length', 'max'=>32),
			array('password','length','max'=>32),
			array('password','compare'),
			array('password_repeat','safe'),
			array('id, fkdocente, username,contrasena, fktipousuario', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'fktipousuario0' => array(self::BELONGS_TO, 'Tipousuario', 'fktipousuario'),
			'fkdocente0' => array(self::BELONGS_TO, 'Docente', 'fkdocente'),
		);
	}
	public function hash($value)
	{
		return crypt($value);
	}
	
	public function beforesave()
	{
		if(parent::beforeSave())
		{
			$this->contrasena= $this->hash($this->password);
			return true;
		}
		return false;	
	}
        
//        public function afterSave() {
//		// Assign the auth role:
//	 	if (!Yii::app()->authManager->isAssigned($this->fktipousuario,$this->id)) {
//		  	Yii::app()->authManager->assign($this->fktipousuario, $this->id);
//	   	}
//		return parent::afterSave();
//	}
	
	
	public function check($value)
	{
		$new_hash= crypt($value,$this->contrasena);
		if($new_hash==$this->contrasena)
		{
			return true;
		}
		return false;
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'fkdocente' => null,
			'username' => Yii::t('app', 'Usuario'),
			//'contrasena' => Yii::t('app', 'Contrasena'),
			'password'=>'password',
			'password_repeat'=>'Repite Password',
			'fktipousuario' => null,
			'fktipousuario0' => null,
			'fkdocente0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('fkdocente', $this->fkdocente);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('contrasena', $this->contrasena, true);
		$criteria->compare('fktipousuario', $this->fktipousuario);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}