<?php

namespace app\models;
use Yii;
class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    
    public $dni;
    public $nombre;
    public $apellido;
    public $email;
    public $username;
    public $password;
    public $pass;
    public $telefono;
    public $authKey;
    public $activate;
    public $rol;

    public static function isUserNutricionista($id)
    {
       if (Usuarios::findOne(['dni' => $id, 'rol' => 3])){
        return true;
       } else {
        return false;
       }

    }

    public static function isUserInvestigador($id)
    {
       if (Usuarios::findOne(['dni' => $id, 'rol' => 2])){
        return true;
       } else {

        return false;
       }

    }

    public static function isUserSimple($id)
    {
       if (Usuarios::findOne(['dni' => $id, 'rol' => 1])){
       return true;
       } else {

       return false;
       }
    }

    /**
     * @inheritdoc
     */
    
    /* busca la identidad del usuario a través de su $id */

    public static function findIdentity($dni)
    {
        
        $user = Usuarios::find()
                ->where("dni=:dni", ["dni" => $dni])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    
    /* Busca la identidad del usuario a través del username */
    public static function findByEmail($email)
    {
        $users = Usuarios::find()
                ->where("email=:email", [":email" => $email])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->email, $email) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->dni;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
        return $this->authKey;
    }

     public static function findIdentityByAccessToken($token, $type = null)
    {
        
        $users = Usuarios::find()
                ->where("activate=:activate", [":activate" => 1])
                ->andWhere("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
        
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    
    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
        return true;

        // return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
       // return $password == $this->pass;
       if (Yii::$app->getSecurity()->validatePassword($password, $this->pass)) {
        
      return true;}
    }

    
}


