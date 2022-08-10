<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro".
 *
 * @property int $id
 * @property int $dni
 * @property int $idAlimento
 * @property int $gramos
 * @property string $fecha
 * @property int $tipocomida
 *
 * @property Usuarios $dni0
 * @property Alimentos $alimento
 */
class Registro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'idAlimento', 'gramos', 'fecha', 'tipocomida'], 'required'],
            [['dni', 'idAlimento', 'gramos', 'tipocomida'], 'integer'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'Dni',
            'idAlimento' => 'Id Alimento',
            'gramos' => 'Gramos',
            'fecha' => 'Fecha',
            'tipocomida' => 'Tipocomida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Usuarios::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlimento()
    {
        return $this->hasOne(Alimentos::className(), ['id' => 'idAlimento']);
    }
}
