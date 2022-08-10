<?php

namespace app\models;

use Yii;
use DateTime;
/**
 * This is the model class for table "pacientes".
 *
 * @property int $id
 * @property int $dni
 * @property string $fechanac
 * @property int $talla
 * @property int $peso
 * @property string $sexo
 * 
 *
 * @property Usuarios $dni0
 */
class Paciente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pacientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'fechanac', 'talla', 'peso', 'sexo', 'domicilio', 'barrio', 'ciudad', 'provincia'], 'required'],
            [['dni',  'barrio', 'ciudad', 'provincia','dninutricionista'], 'integer'],
            [['peso','talla',],'double'],
            [['peso'], 'validarpeso'],
            [['fechanac','domicilio'], 'safe'],
            [['sexo',  'domicilio'], 'string', 'max' => 30],
            [['fechanac'], 'validarfechanac'],
             [['dni'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['dni' => 'dni']],
        ];
    }

      public function validarpeso($attribute, $params){
        if ($this->peso < 20) {
              $this->addError($attribute, 'Ingrese un peso mayor a 20');
        }
    }
  
    public function validarfechanac($attribute, $params){
        $fecha_actual = strtotime(date("Y-m-d H:i:s"));
        $fecha_nacimiento = strtotime($this->fechanac);
        
        if($fecha_actual < $fecha_nacimiento){
            $this->addError($attribute, 'Ingrese una fecha de nacimiento anterior a la actual');
        }  
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'DNI',
            'fechanac' => 'Fecha de nacimiento',
            'talla' => 'Altura Cm',
            'peso' => 'Peso',
            'sexo' => 'Sexo',
            'barrio' =>'Localidad', 
            'ciudad' => 'Departamento', 
            'provincia' => 'Provincia',
            'actividadfisica' => 'Actividad',
            'dninutricionista'=>'Nutricionista'
        ];
    }

    public function actionEdad ($fecha){
        $cumpleanos = new DateTime($fecha);
        $hoy = new DateTime();
        $annos = $hoy->diff($cumpleanos);
        return $annos->y;
    }

    public function actionImc($altura, $peso){
        $altura=$altura /100;
        return $peso / pow($altura, 2);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Usuarios::className(), ['dni' => 'dni']);
    }

 public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['dni' => 'dni']);
    }
     public function getPesos()
    {
        return $this->hasOne(Peso::className(), ['dni' => 'dni']);
    }

      public function getAguas()
    {
        return $this->hasOne(Agua::className(), ['idpaciente' => 'dni']);
    }
    /**
     * {@inheritdoc}
     * @return PacientesQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new PacientesQuery(get_called_class());
    // }

    public static function find()
    {
        return new PacientesQuery(get_called_class());
    }
}
