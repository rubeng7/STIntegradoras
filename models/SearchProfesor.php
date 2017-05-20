<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profesor;

/**
 * SearchProfesor represents the model behind the search form about `app\models\Profesor`.
 */
class SearchProfesor extends Profesor {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idProfesor', 'enComite', 'enIntegradora'], 'integer'],
            [
                [
                    'nivelEstudios', 'especialidad',
                    'idProfesor0.idUsuario0.nombre',
                    'idProfesor0.idUsuario0.paterno',
                    'idProfesor0.idUsuario0.materno',
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Profesor::find();
        $query->innerJoinWith('idProfesor0')->innerJoinWith('idProfesor0.idUsuario0');

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
            'idProfesor' => $this->idProfesor,
            'enComite' => $this->enComite,
            'enIntegradora' => $this->enIntegradora,
        ]);

        $query->andFilterWhere(['like', 'nivelEstudios', $this->nivelEstudios])
                ->andFilterWhere(['like', 'especialidad', $this->especialidad])
                ->andFilterWhere(['like', 'nombre', $this['idProfesor0.idUsuario0.nombre']])
                ->andFilterWhere(['like', 'paterno', $this['idProfesor0.idUsuario0.paterno']])
                ->andFilterWhere(['like', 'materno', $this['idProfesor0.idUsuario0.materno']]);

        return $dataProvider;
    }

}
