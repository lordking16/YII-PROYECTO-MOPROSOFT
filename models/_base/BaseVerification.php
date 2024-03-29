<?php

/**
 * This is the model base class for the table "verification".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Verification".
 *
 * Columns in table "verification" available as properties of the model,
 * followed by relations of table "verification" available as properties of the model.
 *
 * @property integer $id_verification
 * @property integer $id_document
 * @property string $verification_Date
 * @property string $place
 *
 * @property User[] $users
 * @property Document $idDocument
 * @property VerificationDefect[] $verificationDefects
 */
abstract class BaseVerification extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'verification';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Verification|Verifications', $n);
	}

	public static function representingColumn() {
		return 'id_verification';
	}

	public function rules() {
		return array(
			array('id_verification, id_document, place', 'required'),
			array('id_verification, id_document', 'numerical', 'integerOnly'=>true),
			array('place', 'length', 'max'=>60),
			array('id_verification, id_document, start_verification, end_verification, place', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'users' => array(self::MANY_MANY, 'User', 'user_verification(id_verification, id_user)'),
			'idDocument' => array(self::BELONGS_TO, 'Document', 'id_document'),
			'verificationDefects' => array(self::HAS_MANY, 'VerificationDefect', 'id_verification'),
		);
	}

	public function pivotModels() {
		return array(
			'users' => 'UserVerification',
		);
	}

	public function attributeLabels() {
		return array(
			'id_verification' => Yii::t('app', 'Id Verification'),
			'id_document' => null,
			//'start_verification' => Yii::t('app', 'Start Verification'),
                        //'end_verification' => Yii::t('app', ' End Verification'),
			'place' => Yii::t('app', 'Place'),
			'users' => null,
			'idDocument' => null,
			'verificationDefects' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id_verification', $this->id_verification);
		$criteria->compare('id_document', $this->id_document);
		$criteria->compare('start_verification_Date', $this->start_verification, true);
                $criteria->compare('end_verification_Date', $this->end_verification, true);
		$criteria->compare('place', $this->place, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}