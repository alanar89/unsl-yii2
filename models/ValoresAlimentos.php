<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table 11".
 *
 * @property string $Codigo
 * @property string $Unidades
 * @property string $FactorCorrec
 * @property string $Agua
 * @property string $Energia
 * @property string $Proteinas
 * @property string $Lipidos
 * @property string $Acidos Grasos Saturados
 * @property string $Acidos Grasos Monoinsaturados
 * @property string $Acidos Grasos Poliinsaturados
 * @property int $Colesterol
 * @property string $Hidratos de Carbono
 * @property string $Fibra
 * @property string $Cenizas
 * @property string $Sodio
 * @property string $Potasio
 * @property string $Calcio
 * @property string $Fosforo
 * @property string $Hierro
 * @property string $Zinc
 * @property string $Niacina
 * @property string $Folatos
 * @property string $Vitamina A
 * @property string $Tiamina B1
 * @property string $Riboflavina B2
 * @property string $Vitamina B12
 * @property string $Vitamina C
 * @property int $Vitamina D
 */
class ValoresAlimentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'valores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Codigo'], 'required'],
            [['Colesterol', 'VitaminaD'], 'integer'],
            [['Codigo', 'FactorCorrec'], 'string', 'max' => 4],
            [['Unidades'], 'string', 'max' => 24],
            [['Agua', 'Proteinas', 'Lipidos', 'HidratosdeCarbono', 'Fibra', 'Cenizas', 'Hierro', 'Zinc', 'Niacina', 'TiaminaB1', 'RiboflavinaB2', 'VitaminaB12'], 'string', 'max' => 5],
            [['Energia', 'AcidosGrasosSaturados', 'AcidosGrasosMonoinsaturados', 'AcidosGrasosPoliinsaturados', 'Potasio', 'Calcio', 'Fosforo', 'Folatos', 'VitaminaA', 'VitaminaC'], 'string', 'max' => 6],
            [['Sodio'], 'string', 'max' => 7],
            [['Codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Codigo' => 'Codigo',
            'Unidades' => 'Unidades',
            'FactorCorrec' => 'Factor Correc',
            'Agua' => 'Agua',
            'Energia' => 'Energia',
            'Proteinas' => 'Proteinas',
            'Lipidos' => 'Lipidos',
            'AcidosGrasosSaturados' => 'Acidos  Grasos  Saturados',
            'AcidosGrasosMonoinsaturados' => 'Acidos  Grasos  Monoinsaturados',
            'AcidosGrasosPoliinsaturados' => 'Acidos  Grasos  Poliinsaturados',
            'Colesterol' => 'Colesterol',
            'HidratosdeCarbono' => 'Hidratos De  Carbono',
            'Fibra' => 'Fibra',
            'Cenizas' => 'Cenizas',
            'Sodio' => 'Sodio',
            'Potasio' => 'Potasio',
            'Calcio' => 'Calcio',
            'Fosforo' => 'Fosforo',
            'Hierro' => 'Hierro',
            'Zinc' => 'Zinc',
            'Niacina' => 'Niacina',
            'Folatos' => 'Folatos',
            'VitaminaA' => 'Vitamina  A',
            'TiaminaB1' => 'Tiamina  B1',
            'RiboflavinaB2' => 'Riboflavina  B2',
            'VitaminaB12' => 'Vitamina  B12',
            'VitaminaC' => 'Vitamina  C',
            'VitaminaD' => 'Vitamina  D',
        ];
    }
}
