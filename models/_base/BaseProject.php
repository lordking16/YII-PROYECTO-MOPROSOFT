<?php

/**
 * This is the model base class for the table "project".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Project".
 *
 * Columns in table "project" available as properties of the model,
 * followed by relations of table "project" available as properties of the model.
 *
 * @property integer $id_project
 * @property string $name
 * @property string $start_Date
 * @property string $end_Date
 * @property string $responsible
 * @property string $costumer
 * @property double $amount
 *
 * @property Document[] $documents
 * @property User[] $users
 */
abstract class BaseProject extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'project';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Project|Projects', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, start_Date, end_Date, responsible, costumer, amount', 'required'),
			array('amount', 'numerical'),
			array('name', 'length', 'max'=>70),
			array('responsible, costumer', 'length', 'max'=>50),
			array('id_project, name, start_Date, end_Date, responsible, costumer, amount', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'documents' => array(self::HAS_MANY, 'Document', 'id_project'),
			'users' => array(self::MANY_MANY, 'User', 'project_user(id_project, id_user)'),
		);
	}

	public function pivotModels() {
		return array(
			'users' => 'ProjectUser',
		);
	}

	public function attributeLabels() {
		return array(
			'id_project' => Yii::t('app', 'Id Project'),
			'name' => Yii::t('app', 'Name'),
			'start_Date' => Yii::t('app', 'Start Date'),
			'end_Date' => Yii::t('app', 'End Date'),
			'responsible' => Yii::t('app', 'Responsible'),
			'costumer' => Yii::t('app', 'Costumer'),
			'amount' => Yii::t('app', 'Amount'),
			'documents' => null,
			'users' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id_project', $this->id_project);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('start_Date', $this->start_Date, true);
		$criteria->compare('end_Date', $this->end_Date, true);
		$criteria->compare('responsible', $this->responsible, true);
		$criteria->compare('costumer', $this->costumer, true);
		$criteria->compare('amount', $this->amount);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}