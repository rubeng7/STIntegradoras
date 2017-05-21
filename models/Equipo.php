<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipo".
 *
 * @property integer $idEquipo
 * @property string $nombre
 * @property integer $idPeriodo
 * @property integer $idGrupo
 * @property integer $idProyecto
 * @property integer $idEsquema
 * @property integer $idComite
 *
 * @property Periodo $idPeriodo0
 * @property Grupo $idGrupo0
 * @property Proyecto $idProyecto0
 * @property Esquema $idEsquema0
 * @property Comite $idComite0
 * @property EquipoAlumno[] $equipoAlumnos
 * @property Alumno[] $idAlumnos
 * @property EquipoEntregable[] $equipoEntregables
 * @property Entregable[] $idEntregables
 */
class Equipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'idPeriodo', 'idGrupo', 'idProyecto', 'idEsquema', 'idComite'], 'required'],
            [['idPeriodo', 'idGrupo', 'idProyecto', 'idEsquema', 'idComite'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'idPeriodo', 'idGrupo'], 'unique', 'targetAttribute' => ['nombre', 'idPeriodo', 'idGrupo'], 'message' => 'The combination of Nombre, Id Periodo and Id Grupo has already been taken.'],
            [['idPeriodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['idPeriodo' => 'idPeriodo']],
            [['idGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::className(), 'targetAttribute' => ['idGrupo' => 'idGrupo']],
            [['idProyecto'], 'exist', 'skipOnError' => true, 'targetClass' => Proyecto::className(), 'targetAttribute' => ['idProyecto' => 'idProyecto']],
            [['idEsquema'], 'exist', 'skipOnError' => true, 'targetClass' => Esquema::className(), 'targetAttribute' => ['idEsquema' => 'idEsquema']],
            [['idComite'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['idComite' => 'idComite']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idEquipo' => 'ID',
            'nombre' => 'Nombre',
            'idPeriodo' => 'Periodo',
            'idGrupo' => 'Grupo',
            'idProyecto' => 'Proyecto',
            'idEsquema' => 'Esquema',
            'idComite' => 'Comite',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPeriodo0()
    {
        return $this->hasOne(Periodo::className(), ['idPeriodo' => 'idPeriodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupo0()
    {
        return $this->hasOne(Grupo::className(), ['idGrupo' => 'idGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProyecto0()
    {
        return $this->hasOne(Proyecto::className(), ['idProyecto' => 'idProyecto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEsquema0()
    {
        return $this->hasOne(Esquema::className(), ['idEsquema' => 'idEsquema']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComite0()
    {
        return $this->hasOne(Comite::className(), ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoAlumnos()
    {
        return $this->hasMany(EquipoAlumno::className(), ['idEquipo' => 'idEquipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlumnos()
    {
        return $this->hasMany(Alumno::className(), ['idAlumno' => 'idAlumno'])->viaTable('equipo_alumno', ['idEquipo' => 'idEquipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoEntregables()
    {
        return $this->hasMany(EquipoEntregable::className(), ['idEquipo' => 'idEquipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntregables()
    {
        return $this->hasMany(Entregable::className(), ['idEntregable' => 'idEntregable'])->viaTable('equipo_entregable', ['idEquipo' => 'idEquipo']);
    }
}
