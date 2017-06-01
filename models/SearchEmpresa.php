<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empresa;

/**
 * SearchEmpresa represents the model behind the search form about `app\models\Empresa`.
 */
class SearchEmpresa extends Empresa {

    public $direccionCompleta;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idEmpresa', 'idDireccion'], 'integer'],
            [['nombre', 'giro', 'responsable', 'telefono', 'direccionCompleta',], 'safe'],
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
        $query = Empresa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /**
         * Setup your sorting attributes
         * Note: This is setup before the $this->load($params) 
         * statement below
         */
        $dataProvider->setSort([
            'attributes' => [
                'nombre',
                'giro',
                'responsable',
                'telefono',
                'direccionCompleta' => [
                    'asc' => ["CONCAT(calle, ' ', numero, ' ', ciudad, ' ', municipio, ' ', estado, ' CP:', cp)" => SORT_ASC],
                    'desc' => ["CONCAT(calle, ' ', numero, ' ', ciudad, ' ', municipio, ' ', estado, ' CP:', cp)" => SORT_DESC],
                    'label' => 'Dirección',
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['idDireccion0']);
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
                ->andFilterWhere(['like', 'giro', $this->giro])
                ->andFilterWhere(['like', 'responsable', $this->responsable])
                ->andFilterWhere(['like', 'telefono', $this->telefono]);

        $query->joinWith(['idDireccion0' => function ($q) {
                $q->where("CONCAT(calle, ' ', numero, ' ', ciudad, ' ', municipio, ' ', estado, ' CP:', cp) LIKE '%" .
                        $this->direccionCompleta . "%'");
            }]);

        return $dataProvider;
    }

}
