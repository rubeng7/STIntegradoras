<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empresa;

/**
 * SearchEmpresa represents the model behind the search form about `app\models\Empresa`.
 */
class SearchEmpresa extends Empresa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idEmpresa', 'idDireccion'], 'integer'],
            [['nombre', 'giro', 'responsable', 'telefono', 'direccionCompleta',], 'safe'],
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
        $query = Empresa::find()->select(['empresa.*', 'CONCAT(calle, " ", numero, " ",'
                . ' ciudad, " ", municipio, " ", estado, " CP:", cp) as direccionCompleta'])
                ->innerJoinWith('idDireccion0');
        

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
            'idEmpresa' => $this->idEmpresa,
        ]);

        $direccionB = $this->idDireccion0;
        
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'giro', $this->giro])
            ->andFilterWhere(['like', 'responsable', $this->responsable])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'direccionCompleta', $this->direccionCompleta]);

        return $dataProvider;
    }
}
