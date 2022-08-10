<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agua".
 *
 * @property int $idpaciente
 * @property int $id
 * @property int $cantidad
 * @property string $fecha
 *
 * @property Pacientes $paciente
 */
class Agua extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpaciente', 'cantidad', 'fecha'], 'required'],
            [['idpaciente', 'cantidad'], 'integer'],
            [['fecha'], 'safe'],
            [['idpaciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['idpaciente' => 'dni']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpaciente' => 'Idpaciente',
            'id' => 'ID',
            'cantidad' => 'Cantidad',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['dni' => 'idpaciente']);
    }

}
