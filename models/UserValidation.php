<?php

Yii::import('application.models._base.BaseUserValidation');

class UserValidation extends BaseUserValidation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}