<?php

Yii::import('application.models._base.BaseVerification');

class Verification extends BaseVerification
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}