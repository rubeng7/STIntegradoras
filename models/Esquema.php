<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "esquema".
 *
 * @property integer $idEsquema
 * @property string $nombre
 * @property string $noIntegradora
 * @property string $noFases
 * @property string $fechaCreacion
 * @property integer $idCarrera
 *
 * @property Entregable[] $entregables
 * @property Equipo[] $equipos
 * @property Carrera $idCarrera0
 */
class Esquema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'esquema';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'noIntegradora', 'noFases', 'fechaCreacion', 'idCarrera'], 'required'],
            [['noIntegradora', 'noFases'], 'string'],
            [['fechaCreacion'], 'safe'],
            [['idCarrera'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'noIntegradora', 'idCarrera'], 'unique', 'targetAttribute' => ['nombre', 'noIntegradora', 'idCarrera'], 'message' => 'The combination of Nombre, No Integradora and Id Carrera has already been taken.'],
            [['idCarrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['idCarrera' => 'idCarrera']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idEsquema' => 'Id Esquema',
            'nombre' => 'Nombre',
            'noIntegradora' => 'No Integradora',
            'noFases' => 'No Fases',
            'fechaCreacion' => 'Fecha Creacion',
            'idCarrera' => 'Id Carrera',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntregables()
    {
        return $this->hasMany(Entregable::className(), ['idEsquema' => 'idEsquema']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::className(), ['idEsquema' => 'idEsquema']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarrera0()
    {
        return $this->hasOne(Carrera::className(), ['idCarrera' => 'idCarrera']);
    }
}
