<?php

namespace app\models;
use app\models\Employee;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $employee_id,$name,$password;
    public $identity_card, $role;
    public $employee_number,$unit_id,$dep_id,$position,$rank_id,$sex,$politics_status,$mobile,$email, $is_work,$authKey,$accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user  = Employee::find()->where(["employee_id"=>$id])->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $condition = [
            "or",
            ["employee_number" => $username], 
            ["email" => $username], 
            ["identity_card" => $username]            
        ];
        $user = Employee::find()->andFilterWhere($condition)->one();
        
        if ($user) {
            return new static($user);
        }
     

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->employee_id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5(md5($password));
    }
}
