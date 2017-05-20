<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Equipo;

/**
 * SearchEquipo represents the model behind the search form about `app\models\Equipo`.
 */
class SearchEquipo extends Equipo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idEquipo', 'idPeriodo', 'idGrupo', 'idProyecto', 'idEsquema', 'idComite'], 'integer'],
            [['nombre'], 'safe'],
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
        $query = Equipo::find();

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
            'idEquipo' => $this->idEquipo,
            'idPeriodo' => $this->idPeriodo,
            'idGrupo' => $this->idGrupo,
            'idProyecto' => $this->idProyecto,
            'idEsquema' => $this->idEsquema,
            'idComite' => $this->idComite,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
