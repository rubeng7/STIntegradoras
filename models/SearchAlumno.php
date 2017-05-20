<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alumno;

/**
 * SearchAlumno represents the model behind the search form about `app\models\Alumno`.
 */
class SearchAlumno extends Alumno {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idAlumno'], 'integer'],
            [
                [
                    'matricula',
                    'idAlumno0.idUsuario0.nombre',
                    'idAlumno0.idUsuario0.paterno',
                    'idAlumno0.idUsuario0.materno',
                    'cuatrimestre',
                    'letra',
                    'turno',
                    'periodo'
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
        $query = Alumno::find()->select('*');
        $query->innerJoinWith('idAlumno0')->innerJoinWith('idAlumno0.idUsuario0')
                ->innerJoinWith('alumnoGrupoPeriodos')->innerJoinWith('alumnoGrupoPeriodos.idGrupo0')
                ->innerJoinWith('alumnoGrupoPeriodos.idPeriodo0');

        // add conditions that should always apply here
        //$this['periodo'] = 1;
        
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
            'idAlumno' => $this->idAlumno,
            'cuatrimestre' => $this['cuatrimestre'],
            'letra' => $this['letra'],
            'turno' => $this['turno'],
            'periodo.idPeriodo' => $this['periodo']
        ]);

        $query->andFilterWhere(['like', 'matricula', $this->matricula])
                ->andFilterWhere(['like', 'nombre', $this['idAlumno0.idUsuario0.nombre']])
                ->andFilterWhere(['like', 'paterno', $this['idAlumno0.idUsuario0.paterno']])
                ->andFilterWhere(['like', 'materno', $this['idAlumno0.idUsuario0.materno']]);

        return $dataProvider;
    }

}
