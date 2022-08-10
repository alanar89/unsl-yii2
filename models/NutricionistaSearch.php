<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nutricionista;
use app\models\Usuarios;



/**
 * NutricionistaSearch represents the model behind the search form of `app\models\Nutricionista`.
 */
class NutricionistaSearch extends Nutricionista
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dni'], 'integer'],
            [['direccion', 'provincia', 'ciudad', 'barrio','centrodetrabajo'], 'safe'],
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
        $query = Nutricionista::find();

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
        ]);

        $query->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'provincia', $this->provincia])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'barrio', $this->barrio])
               ->andFilterWhere(['like', 'centrodetrabajo', $this->centrodetrabajo]);

        return $dataProvider;
    }
     public function searchNutricionista($params)
    {
        $query = Nutricionista::find();

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
        ]);

        $query->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'provincia', $this->provincia])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'barrio', $this->barrio])
               ->andFilterWhere(['like', 'centrodetrabajo', $this->centrodetrabajo]);

        return $dataProvider;
    }
}



