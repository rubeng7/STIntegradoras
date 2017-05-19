<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proyecto;
use app\models\Utilerias;

/**
 * SearchProyecto represents the model behind the search form about `app\models\Proyecto`.
 */
class SearchProyecto extends Proyecto {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idProyecto', 'idEmpresa'], 'integer'],
            [['nombre', 'descripcion', 'fechaInicio', 'limite', 'idEmpresa0.nombre',
            'fechaInicio1', 'fechaFin1', 'fechaInicio2', 'fechaFin2'], 'safe'],
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
        $query = Proyecto::find()->with('idEmpresa0');
        $query->joinWith('idEmpresa0');

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
            'idProyecto' => $this->idProyecto,
        ]);

        $query->andFilterWhere(['like', 'proyecto.nombre', $this->nombre])
                ->andFilterWhere(['like', 'empresa.nombre', $this['idEmpresa0.nombre']])
                ->andFilterWhere(['between', 'fechaInicio', Utilerias::getDateMysqlFromDateNormal($this->fechaInicio1), Utilerias::getDateMysqlFromDateNormal($this->fechaFin1)])
                ->andFilterWhere(['between', 'limite', Utilerias::getDateMysqlFromDateNormal($this->fechaInicio2), Utilerias::getDateMysqlFromDateNormal($this->fechaFin2)]);

        return $dataProvider;
    }

}
