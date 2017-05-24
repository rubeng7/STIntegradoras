<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Periodo;

/**
 * SearchPeriodo represents the model behind the search form about `app\models\Periodo`.
 */
class SearchPeriodo extends Periodo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPeriodo', 'anio'], 'integer'],
            [['mesInicio', 'mesFin'], 'safe'],
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
        $query = Periodo::find();

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
            'idPeriodo' => $this->idPeriodo,
            'anio' => $this->anio,
        ]);

        $query->andFilterWhere(['like', 'mesInicio', $this->mesInicio])
            ->andFilterWhere(['like', 'mesFin', $this->mesFin]);

        return $dataProvider;
    }
}
