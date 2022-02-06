<?php

Yii::import('application.models._base.BaseValidationDefect');

class ValidationDefect extends BaseValidationDefect
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}