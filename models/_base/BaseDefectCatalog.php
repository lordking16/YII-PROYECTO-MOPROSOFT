<?php

/**
 * This is the model base class for the table "defect_catalog".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DefectCatalog".
 *
 * Columns in table "defect_catalog" available as properties of the model,
 * followed by relations of table "defect_catalog" available as properties of the model.
 *
 * @property integer $id_typeDefect
 * @property integer $id_document
 * @property string $name
 * @property string $description
 * @property integer $activity_type
 *
 * @property Document $idDocument
 * @property ValidationDefect[] $validationDefects
 * @property VerificationDefect[] $verificationDefects
 */
abstract class BaseDefectCatalog extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'defect_catalog';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DefectCatalog|DefectCatalogs', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('id_document, name, description, activity_type', 'required'),
			array('id_document, activity_type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description', 'length', 'max'=>60),
			array('id_typeDefect, id_document, name, description, activity_type', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idDocument' => array(self::BELONGS_TO, 'Document', 'id_document'),
			'validationDefects' => array(self::HAS_MANY, 'ValidationDefect', 'id_typeDefect'),
			'verificationDefects' => array(self::HAS_MANY, 'VerificationDefect', 'id_typeDefect'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id_typeDefect' => Yii::t('app', 'Id Type Defect'),
			'id_document' => null,
			'name' => Yii::t('app', 'Name'),
			'description' => Yii::t('app', 'Description'),
			'activity_type' => Yii::t('app', 'Activity Type'),
			'idDocument' => null,
			'validationDefects' => null,
			'verificationDefects' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id_typeDefect', $this->id_typeDefect);
		$criteria->compare('id_document', $this->id_document);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('activity_type', $this->activity_type);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}