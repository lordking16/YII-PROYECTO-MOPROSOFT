<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    
    # Edits suggested in Chapter 11, "User Authentication and Authorization":
	private $_id;
        private $role;
      
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
			public function authenticate()
		{
			$user= user::model()->findByAttributes(
			array(
			'username'=> $this->username));
			if($user===null)
			{
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
			elseif($user->check($this->password)){
				$this->_id=$user->id_user;
                                $this->setState('role',$user->role);
				$this->errorCode=self::ERROR_NONE;
			}
			else
			{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			return!$this->errorCode;
		}
	# Edits suggested in Chapter 11, "User Authentication and Authorization":
	public function getId() {
		return $this->_id;
	}
}