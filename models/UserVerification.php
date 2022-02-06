<?php

Yii::import('application.models._base.BaseUserVerification');

class UserVerification extends BaseUserVerification
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}