<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property integer $idGrupo
 * @property string $cuatrimestre
 * @property string $letra
 * @property string $turno
 * @property integer $idCarrera
 *
 * @property AlumnoGrupoPeriodo[] $alumnoGrupoPeriodos
 * @property Equipo[] $equipos
 * @property Carrera $idCarrera0
 * @property ProfesorGrupoPeriodo[] $profesorGrupoPeriodos
 */
class Grupo extends \yii\db\ActiveRecord {

    const ARRAY_CUATRIMESTRES = [
        '1' => '1°', '2' => '2°', '3' => '3°',
        '4' => '4°', '5' => '5°', '6' => '6°',
        '7' => '7°', '8' => '8°', '9' => '9°',
        '10' => '10°', '11' => '11°', '12' => '12°',
    ];
    const ARRAY_GRUPOS = [
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'E' => 'E',
        'F' => 'F',
        'G' => 'G',
        'H' => 'H',
        'I' => 'I',
        'J' => 'J',
        'K' => 'K',
    ];
    const ARRAY_TURNOS = [
        'Matutino' => 'Matutino',
        'Vespertino' => 'Vespertino',
        'Nocturno' => 'Nocturno'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'grupo';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cuatrimestre', 'letra', 'turno', 'idCarrera'], 'required'],
            [['cuatrimestre', 'letra', 'turno'], 'string'],
            [['idCarrera'], 'integer'],
            [['cuatrimestre', 'letra', 'turno', 'idCarrera'], 'unique', 'targetAttribute' => ['cuatrimestre', 'letra', 'turno', 'idCarrera'], 'message' => 'The combination of Cuatrimestre, Letra, Turno and Id Carrera has already been taken.'],
            [['idCarrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['idCarrera' => 'idCarrera']],
        ];
    }

    public function attributes() {
        return array_merge(parent::attributes(), ['idCarrera0.idDivision0.nombre', 'idCarrera0.nombre', 'idCarrera0.idDivision0.idDivision',]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idGrupo' => 'ID',
            'cuatrimestre' => 'Cuatrimestre',
            'letra' => 'Grupo',
            'turno' => 'Turno',
            'idCarrera' => 'Carrera',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnoGrupoPeriodos() {
        return $this->hasMany(AlumnoGrupoPeriodo::className(), ['idGrupo' => 'idGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos() {
        return $this->hasMany(Equipo::className(), ['idGrupo' => 'idGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarrera0() {
        return $this->hasOne(Carrera::className(), ['idCarrera' => 'idCarrera']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorGrupoPeriodos() {
        return $this->hasMany(ProfesorGrupoPeriodo::className(), ['idGrupo' => 'idGrupo']);
    }
    
    /**
     * 
     * @param \app\models\Grupo $grupo
     */
    public static function getIdentidadCompleta($grupo) {
        return $grupo->cuatrimestre . ' ' . $grupo->letra . ' ' . $grupo->turno;
    }
    
    public function toString() {
        return $this->cuatrimestre . ' ' . $this->letra . ' ' . $this->turno;
    }

}
