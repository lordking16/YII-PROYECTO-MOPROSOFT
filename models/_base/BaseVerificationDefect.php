<?php

/**
 * This is the model base class for the table "verification_defect".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "VerificationDefect".
 *
 * Columns in table "verification_defect" available as properties of the model,
 * followed by relations of table "verification_defect" available as properties of the model.
 *
 * @property integer $id_defect
 * @property integer $id_verification
 * @property integer $id_typeDefect
 * @property string $find_Date
 * @property string $correction_Date
 * @property string $correction_Time
 * @property integer $solved
 *
 * @property DefectCatalog $idTypeDefect
 * @property Verification $idVerification
 */
abstract class BaseVerificationDefect extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'verification_defect';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'VerificationDefect|VerificationDefects', $n);
	}

	public static function representingColumn() {
		return 'find_Date';
	}

	public function rules() {
		return array(
			array('id_defect, id_verification, id_typeDefect', 'required'),
			array('id_defect, id_verification, id_typeDefect, solved', 'numerical', 'integerOnly'=>true),
			array('correction_Time', 'length', 'max'=>45),
			array('find_Date, correction_Date', 'safe'),
			array('find_Date, correction_Date, correction_Time, solved', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id_defect, id_verification, id_typeDefect, find_Date, correction_Date, correction_Time, solved', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idTypeDefect' => array(self::BELONGS_TO, 'DefectCatalog', 'id_typeDefect'),
			'idVerification' => array(self::BELONGS_TO, 'Verification', 'id_verification'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id_defect' => Yii::t('app', 'Id Defect'),
			'id_verification' => null,
			'id_typeDefect' => null,
			'find_Date' => Yii::t('app', 'Find Date'),
			'correction_Date' => Yii::t('app', 'Correction Date: Y-M-D H:M:S'),
			'correction_Time' => Yii::t('app', 'Correction Time: Y-M-D H:M:S'),
			'solved' => Yii::t('app', 'Solved'),
			'idTypeDefect' => null,
			'idVerification' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id_defect', $this->id_defect);
		$criteria->compare('id_verification', $this->id_verification);
		$criteria->compare('id_typeDefect', $this->id_typeDefect);
		$criteria->compare('find_Date', $this->find_Date, true);
		$criteria->compare('correction_Date', $this->correction_Date, true);
		$criteria->compare('correction_Time', $this->correction_Time, true);
		$criteria->compare('solved', $this->solved);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}