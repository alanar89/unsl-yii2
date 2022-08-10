<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alimentos".
 *
 * @property int $id
 * @property string $codigo
 * @property string $alimento
 *
 * @property Registro[] $registros
 */
class Ali extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alimentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'alimento'], 'required'],
            [['codigo'], 'string', 'max' => 5],
            [['alimento'], 'string', 'max' => 400],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'alimento' => 'Alimento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::className(), ['idAlimento' => 'id']);
    }
}
