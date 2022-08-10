<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "investigador".
 *
 * @property int $id
 * @property int $dni
 * @property string $universidad
 * @property string $facultad
 *
 * @property Usuarios $dni0
 */
class Investigador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'investigador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'universidad', 'facultad'], 'required'],
            [['dni'], 'integer'],
            [['universidad', 'facultad'], 'string', 'max' => 200],
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
            'universidad' => 'Universidad',
            'facultad' => 'Facultad',
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
}
