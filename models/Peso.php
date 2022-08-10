<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peso".
 *
 * @property int $id
 * @property int $dni
 * @property double $peso
 * @property string $fecha
 *
 * @property Pacientes $dni0
 */
class Peso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'peso', 'fecha'], 'required'],
            [['dni'], 'integer'],
            [['peso'], 'double'],
            [['peso'], 'validarpeso'],
            [['fecha'], 'safe'],
            [['dni'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['dni' => 'dni']],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function validarpeso($attribute, $params){
        if ($this->peso < 20) {
              $this->addError($attribute, 'Ingrese un peso mayor a 20');
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'Dni',
            'peso' => 'Peso',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Pacientes::className(), ['dni' => 'dni']);
    }
     public function getPacientes()
    {
        return $this->hasOne(Paciente::className(), ['dni' => 'dni']);
    }
}
