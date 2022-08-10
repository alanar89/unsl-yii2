<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $dni
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property int $telefono
 * @property string $pass
 * @property int $rol
 * @property Investigador[] $investigadors
 * @property Nutricionista[] $nutricionistas
 * @property Pacientes[] $pacientes
 * @property Registro[] $registros
 * @property int $rol
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'dni','nombre', 'apellido', 'email', 'telefono', 'pass'], 'required'],
            [['dni'],'match', 'pattern' => "/^[0-9]{7,8}$/", 'message' => 'Introdusca el DNI sin puntos'],
            [['dni','rol'],'integer'],
           [['nombre', 'apellido','telefono'], 'string', 'max' => 80],
           [['nombre','apellido'],'match', 'pattern' => "/^[a-z\s\á\é\í\ó\ú]+$/i", 'message' => 'Sólo se aceptan letras'],
           [['telefono'], 'validartelefono'],
            [['email'], 'string', 'max' => 200],
            [['pass'], 'string', 'max' => 20, 'min' => 4, 'on'=> 'act'],
            [['dni','email'], 'unique'],
            /*[['dni'],'validardni'],*/
             
            [['email'], 'email'],
        ];
    }
public function validardni($attribute, $params){

        if (!(strlen($this->dni) == 7 || strlen($this->dni) == 8 )) {
              $this->addError($attribute, 'El DNI debe tener 7 u 8 numeros');
        }
    }
public function validartelefono($attribute, $params){
    if (!(strlen($this->telefono) >= 7 && strlen($this->telefono) <= 15 )) {
              $this->addError($attribute, 'Ingrese un telefono valido');
        }
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dni' => 'DNI',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'telefono' => 'Teléfono',
            'pass' => 'Contraseña',
            'rol'=>'rol',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvestigadors()
    {
        return $this->hasMany(Investigador::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNutricionistas()
    {
        return $this->hasMany(Nutricionista::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasOne(Paciente::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::className(), ['dni' => 'dni']);
    }

    /**
     * {@inheritdoc}
     * @return UsuariosQuery the active query used by this AR class.
     */

    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }
    
}
