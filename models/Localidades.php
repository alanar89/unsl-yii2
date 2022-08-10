<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localidades".
 *
 * @property int $codpcia
 * @property int $coddpto
 * @property int $codloc
 * @property string $localidad
 *
 * @property Departamentos[] $departamentos
 * @property Provincia[] $codpcias
 */
class Localidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codpcia', 'coddpto', 'codloc', 'localidad'], 'required'],
            [['codpcia', 'coddpto', 'codloc'], 'integer'],
            [['localidad'], 'string', 'max' => 100],
            [['codpcia', 'coddpto', 'codloc'], 'unique', 'targetAttribute' => ['codpcia', 'coddpto', 'codloc']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codpcia' => 'Codpcia',
            'coddpto' => 'Coddpto',
            'codloc' => 'Codloc',
            'localidad' => 'Localidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasOne(Departamentos::className(), ['coddpto' => 'coddpto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodpcias()
    {
        return $this->hasOne(Provincia::className(), ['codpcia' => 'codpcia'])->viaTable('departamentos', ['coddpto' => 'coddpto']);
    }
}
