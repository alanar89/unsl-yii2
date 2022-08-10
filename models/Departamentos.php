<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamentos".
 *
 * @property int $codpcia
 * @property int $coddpto
 * @property string $departamenos
 *
 * @property Localidades $coddpto0
 * @property Provincia $codpcia0
 */
class Departamentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codpcia', 'coddpto', 'departamenos'], 'required'],
            [['codpcia', 'coddpto'], 'integer'],
            [['departamenos'], 'string', 'max' => 200],
            [['codpcia', 'coddpto'], 'unique', 'targetAttribute' => ['codpcia', 'coddpto']],
            [['coddpto'], 'exist', 'skipOnError' => true, 'targetClass' => Localidades::className(), 'targetAttribute' => ['coddpto' => 'coddpto']],
            [['codpcia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['codpcia' => 'codpcia']],
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
            'departamenos' => 'Departamenos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoddpto0()
    {
        return $this->hasOne(Localidades::className(), ['coddpto' => 'coddpto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodpcia0()
    {
        return $this->hasOne(Provincia::className(), ['codpcia' => 'codpcia']);
    }

    public static function find()
    {
        return new NutricionistasQuery(get_called_class());
    }
}
