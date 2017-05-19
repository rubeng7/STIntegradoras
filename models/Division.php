<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "division".
 *
 * @property integer $idDivision
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Carrera[] $carreras
 * @property Persona[] $personas
 */
class Division extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDivision' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarreras()
    {
        return $this->hasMany(Carrera::className(), ['idDivision' => 'idDivision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['idDivision' => 'idDivision']);
    }
    
    public static function listaDivisionesCombo() {
        $divisiones = Division::find()->asArray()->all();
        return ArrayHelper::map($divisiones, 'idDivision', 'nombre');
    }
    
    public static function listaDivisionesNombreCombo() {
        $divisiones = Division::find()->asArray()->all();
        return ArrayHelper::map($divisiones, 'nombre', 'nombre');
    }
}
