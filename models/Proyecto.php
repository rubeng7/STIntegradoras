<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto".
 *
 * @property integer $idProyecto
 * @property string $nombre
 * @property string $descripcion
 * @property string $fechaInicio
 * @property string $limite
 * @property integer $idEmpresa
 *
 * @property Equipo[] $equipos
 * @property Empresa $idEmpresa0
 */
class Proyecto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'fechaInicio', 'limite', 'idEmpresa'], 'required'],
            [['fechaInicio', 'limite'], 'safe'],
            [['fechaInicio', 'limite', 'fechaInicio1', 'fechaFin1', 'fechaInicio2', 'fechaFin2'], 'date', 'format' => 'php:d/m/Y'],
            [['idEmpresa'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['idEmpresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idEmpresa' => 'idEmpresa']],
        ];
    }

    public function attributes() {
        return array_merge(parent::attributes(), ['idEmpresa0.nombre', 'fechaInicio1', 'fechaFin1', 'fechaInicio2', 'fechaFin2']);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idProyecto' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'fechaInicio' => 'Fecha Inicio',
            'limite' => 'Fecha Limite',
            'idEmpresa' => 'Empresa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::className(), ['idProyecto' => 'idProyecto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpresa0()
    {
        return $this->hasOne(Empresa::className(), ['idEmpresa' => 'idEmpresa']);
    }
}
