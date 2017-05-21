<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property integer $idAlumno
 * @property string $matricula
 *
 * @property Usuario $idAlumno0
 * @property AlumnoGrupoPeriodo[] $alumnoGrupoPeriodos
 * @property EquipoAlumno[] $equipoAlumnos
 * @property Equipo[] $idEquipos
 */
class Alumno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alumno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idAlumno', 'matricula'], 'required'],
            [['idAlumno'], 'integer'],
            [['matricula'], 'string', 'max' => 9],
            [['matricula'], 'unique'],
            [['idAlumno'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idAlumno' => 'idUsuario']],
        ];
    }
    
    public function attributes() {
        return array_merge(parent::attributes(), [
            'idAlumno0.idUsuario0.nombre',
            'idAlumno0.idUsuario0.paterno',
            'idAlumno0.idUsuario0.materno',
            'cuatrimestre',
            'letra',
            'turno',
            'periodo'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idAlumno' => 'ID',
            'matricula' => 'Matricula',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlumno0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idAlumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnoGrupoPeriodos()
    {
        return $this->hasMany(AlumnoGrupoPeriodo::className(), ['idAlumno' => 'idAlumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoAlumnos()
    {
        return $this->hasMany(EquipoAlumno::className(), ['idAlumno' => 'idAlumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipos()
    {
        return $this->hasMany(Equipo::className(), ['idEquipo' => 'idEquipo'])->viaTable('equipo_alumno', ['idAlumno' => 'idAlumno']);
    }
}
