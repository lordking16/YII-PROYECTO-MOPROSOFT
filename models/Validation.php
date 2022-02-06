<?php

Yii::import('application.models._base.BaseValidation');

class Validation extends BaseValidation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}