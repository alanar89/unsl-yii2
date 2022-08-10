<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property int $codpcia
 * @property string $provincia
 *
 * @property Departamentos[] $departamentos
 * @property Localidades[] $coddptos
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codpcia', 'provincia'], 'required'],
            [['codpcia'], 'integer'],
            [['provincia'], 'string', 'max' => 100],
            [['codpcia'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codpcia' => 'Codpcia',
            'provincia' => 'Provincia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasMany(Departamentos::className(), ['codpcia' => 'codpcia']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoddptos()
    {
        return $this->hasMany(Localidades::className(), ['coddpto' => 'coddpto'])->viaTable('departamentos', ['codpcia' => 'codpcia']);
    }
}
