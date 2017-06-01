<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "direccion".
 *
 * @property integer $idDireccion
 * @property string $calle
 * @property integer $numero
 * @property string $ciudad
 * @property string $municipio
 * @property string $estado
 * @property integer $cp
 *
 * @property Empresa[] $empresas
 */
class Direccion extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'direccion';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['calle', 'numero', 'ciudad', 'municipio', 'estado'], 'required'],
            [['numero', 'cp'], 'integer'],
            [['calle'], 'string', 'max' => 255],
            [['ciudad', 'municipio'], 'string', 'max' => 200],
            [['estado'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idDireccion' => 'Id Direccion',
            'calle' => 'Calle',
            'numero' => 'Número',
            'ciudad' => 'Ciudad',
            'municipio' => 'Municipio',
            'estado' => 'Estado',
            'cp' => 'CP',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas() {
        return $this->hasMany(Empresa::className(), ['idDireccion' => 'idDireccion']);
    }

    public function toString() {
        return $this->calle . ' ' . $this->numero . ' ' .
                $this->ciudad . ' ' . $this->municipio . ' ' .
                $this->estado . ' CP: ' . $this->cp;
    }

}
