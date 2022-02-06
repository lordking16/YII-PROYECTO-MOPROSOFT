<?php

Yii::import('application.models._base.BaseProjectUser');

class ProjectUser extends BaseProjectUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}