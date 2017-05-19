<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grupo;

/**
 * SearchGrupo represents the model behind the search form about `app\models\Grupo`.
 */
class SearchGrupo extends Grupo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupo', 'idCarrera'], 'integer'],
            [['cuatrimestre', 'letra', 'turno','idCarrera0.nombre','idCarrera0.idDivision0.nombre', 'idCarrera0.idDivision0.idDivision'], 'safe'],
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
        $query = Grupo::find()->with(['idCarrera0',]);
        $query->joinWith('idCarrera0');

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
            'idGrupo' => $this->idGrupo,
            'grupo.idCarrera' => $this->idCarrera,
            'carrera.idDivision' => $this['idCarrera0.idDivision0.idDivision']
        ]);

        $query->andFilterWhere(['like', 'cuatrimestre', $this->cuatrimestre])
            ->andFilterWhere(['like', 'letra', $this->letra])
            ->andFilterWhere(['like', 'turno', $this->turno]);

        return $dataProvider;
    }
}
