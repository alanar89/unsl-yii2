<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nutricionista".
 *
 * @property int $id
 * @property int $dni
 * @property string $direccion
 * @property string $provincia
 * @property string $departamento
 * @property string $localidad
 *
 * @property Usuarios $dni0
 */
class Nutricionista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nutricionista';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'direccion', 'provincia', 'ciudad', 'barrio','centrodetrabajo'], 'required'],
            [['dni'], 'integer'],
            [['direccion'], 'string', 'max' => 300],
            [['provincia', 'ciudad', 'barrio','centrodetrabajo'], 'string', 'max' => 200],
            [['dni'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['dni' => 'dni']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'DNI',
            'direccion' => 'Dirección',
            'barrio' =>'Localidad', 
            'ciudad' => 'Departamento', 
            'provincia' => 'Provincia',
              'centrodetrabajo' => 'Centro de trabajo',
        ];
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

    /**
     * {@inheritdoc}
     * @return NutricionistaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NutricionistasQuery(get_called_class());
    }
}
