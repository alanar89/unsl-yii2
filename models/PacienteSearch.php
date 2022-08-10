<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;
use app\models\Usuarios;

/**
 * PacienteSearch represents the model behind the search form of `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dni', 'talla', 'peso'], 'integer'],
            [['fechanac', 'sexo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Paciente::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dni' => $this->dni,
            'fechanac' => $this->fechanac,
            'talla' => $this->talla,
            'peso' => $this->peso,
            'barrio'=> $this->barrio, 
            'ciudad'=> $this->ciudad, 
            'provincia'=> $this->provincia,
        ]);

        $query->andFilterWhere(['like', 'sexo', $this->sexo]);

        return $dataProvider;
    }

      public function searchnutricionista($params)
    {
       /* $n= \Yii::$app->user->identity->dni;
        $query = Paciente::find()->leftJoin('usuarios', 'usuarios.dni= pacientes.dni')->where(['dninutricionista' => $n]);*/
          // $query = Paciente::find()->leftJoin('usuarios', 'usuarios.dni= pacientes.dni');
        $n= \Yii::$app->user->identity->dni;
        $query =Paciente::find()->joinwith('usuarios')->where(['dninutricionista' => $n]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          'sort' => [
        'attributes' => ['dni','usuarios.nombre','usuarios.apellido','usuarios.email','usuarios.telefono',
        'fechanac','talla','peso'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            
           'id' => $this->id,
            'dni' => $this->dni,
            'fechanac' => $this->fechanac,
            'talla' => $this->talla,
            'peso' => $this->peso,
            'barrio'=> $this->barrio, 
            'ciudad'=> $this->ciudad, 
            'provincia'=> $this->provincia,
        ]);

        return $dataProvider;
    }

    //  public function searchLibre($params)
    // {
    //    /* $n= \Yii::$app->user->identity->dni;
    //     $query = Paciente::find()->leftJoin('usuarios', 'usuarios.dni= pacientes.dni')->where(['dninutricionista' => $n]);*/
    //       // $query = Paciente::find()->leftJoin('usuarios', 'usuarios.dni= pacientes.dni');
    //     $n= \Yii::$app->user->identity->dni;
    //     $query =Paciente::find()->joinwith('usuarios')->where(['dninutricionista' => Null]);
    //     // add conditions that should always apply here

    //     $libre = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $libre;
    //     }

    //     // grid filtering conditions
    //     $query->andFilterWhere([
            
    //        'id' => $this->id,
    //         'dni' => $this->dni,
    //         'fechanac' => $this->fechanac,
    //         'talla' => $this->talla,
    //         'peso' => $this->peso,
    //         'barrio'=> $this->barrio, 
    //         'ciudad'=> $this->ciudad, 
    //         'provincia'=> $this->provincia,
    //     ]);

    //     return $libre;
    // }
    public function searchLibre($params)
    {
        $n= \Yii::$app->user->identity->dni;
        $query =Paciente::find()->joinwith('usuarios')->where(['dninutricionista' => Null]);
        // add conditions that should always apply here

        $libre = new ActiveDataProvider([
            'query' => $query,
          'sort' => [
        'attributes' => ['dni','usuarios.nombre','usuarios.apellido','usuarios.email','usuarios.telefono',
        'fechanac','talla','peso'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $libre;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            
           'id' => $this->id,
            'dni' => $this->dni,
            'fechanac' => $this->fechanac,
            'talla' => $this->talla,
            'peso' => $this->peso,
        ]);

        return $libre;
    }
}
