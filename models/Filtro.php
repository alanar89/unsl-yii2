<?php

namespace app\models;
use Yii;
use yii\base\model;

class Filtro extends model
{
            public $edaddesde;
            public $edadhasta;
            public $imcdesde;
            public $imchasta;
            public $peso;
            public $sexo;
            public $fecha;
            public $fechadesde;
            public $fechahasta;
            public $barrio;
            public $ciudad;
            public $provincia;
            public $actividadfisica;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sexo', 'edaddesde','edadhasta','barrio','ciudad','provincia','actividadfisica', 'imcdesde', 'imchasta'] ,'integer'],
            [['fecha','fechahasta','fechadesde'], 'safe'],
            [['fechahasta', 'fechadesde'], 'fechafiltro'],
            [['edadhasta', 'edaddesde'], 'edadfiltro'],
        ];
    }
      public function fechafiltro($attribute, $params){
        $fecha_desde = strtotime($this->fechadesde);
        $fecha_hasta = strtotime($this->fechahasta);
        if($fecha_desde > $fecha_hasta){
            $this->addError($attribute, 'Ingrese una fecha de nacimiento anterior a la actual');
        }  
    }
 
    public function edadfiltro($attribute, $params){
        
        if($edaddesde > $edadhasta){
            $this->addError($attribute, 'Seleccione un periodo correcto');
        }  
        if($edaddesde < 0 || $edadhasta < 0){
            $this->addError($attribute, 'El rango de edades debe ser numeros positivos');
        }
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'edaddesde' => 'Desde',
            'edadhasta' => 'Hasta',
            'imcdesde' => 'Desde',
            'imchasta' => 'Hasta',
            'peso' => 'Peso',
            'sexo' => 'Sexo',
            'localidad' =>'Localidad', 
            'ciudad' => 'Departamento', 
            'barrio' => 'Provincia',
            'actividadfisica' => 'Actividad',

        ];
    }
}