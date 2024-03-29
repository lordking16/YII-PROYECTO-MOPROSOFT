<?php

/**
 * This is the model base class for the table "project_user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProjectUser".
 *
 * Columns in table "project_user" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id_project
 * @property integer $id_user
 * @property string $assignment_Date
 *
 */
abstract class BaseProjectUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'project_user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ProjectUser|ProjectUsers', $n);
	}

	public static function representingColumn() {
		return array(
			'id_project',
			'id_user',
		);
	}

	public function rules() {
		return array(
			array('id_project, id_user, assignment_Date', 'required'),
			array('id_project, id_user', 'numerical', 'integerOnly'=>true),
			array('id_project, id_user, assignment_Date', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id_project' => null,
			'id_user' => null,
			'assignment_Date' => Yii::t('app', 'Assignment Date'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id_project', $this->id_project);
		$criteria->compare('id_user', $this->id_user);
		$criteria->compare('assignment_Date', $this->assignment_Date, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}