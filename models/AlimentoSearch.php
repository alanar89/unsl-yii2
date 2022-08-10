<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ali;
use app\models\ValoresAlimentos;

/**
 * AliSearch represents the model behind the search form of `app\models\Ali`.
 */
class AlimentoSearch extends Ali{
	 public function search($params)
    {
        $query = Ali::find();

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
            'codigo' => $this->Codigo,
            'alimento' => $this->Alimento,
           
       ]);

        // $query->andFilterWhere(['like', 'sexo', $this->sexo]);

        return $dataProvider;
    }
}