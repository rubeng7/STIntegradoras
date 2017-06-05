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
            [['nombre','idGrupo0.idCarrera0.idCarrera', 'nombreCompletoGrupo'], 'safe'],
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
        $query = Equipo::find()->select(['equipo.*','grupo.*','CONCAT(cuatrimestre, " ", letra, " ", turno)'
                . '  as nombreCompletoGrupo']);
        $query->innerJoinWith('idGrupo0');

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
            'idProyecto' => $this->idProyecto,
            'idComite' => $this->idComite,
            'grupo.idCarrera' => $this['idGrupo0.idCarrera0.idCarrera'],
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
                ->andFilterWhere(['like', 'nombreCompletoGrupo', $this->nombreCompletoGrupo]);

        return $dataProvider;
    }
}
