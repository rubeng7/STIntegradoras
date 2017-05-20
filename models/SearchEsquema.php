<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Esquema;

/**
 * SearchEsquema represents the model behind the search form about `app\models\Esquema`.
 */
class SearchEsquema extends Esquema
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idEsquema', 'idCarrera'], 'integer'],
            [['nombre', 'noIntegradora', 'noFases', 'fechaCreacion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Esquema::find();

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
            'idEsquema' => $this->idEsquema,
            'fechaCreacion' => $this->fechaCreacion,
            'idCarrera' => $this->idCarrera,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'noIntegradora', $this->noIntegradora])
            ->andFilterWhere(['like', 'noFases', $this->noFases]);

        return $dataProvider;
    }
}
