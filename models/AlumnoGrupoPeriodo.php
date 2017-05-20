<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno_grupo_periodo".
 *
 * @property integer $idAlumno
 * @property integer $idGrupo
 * @property integer $idPeriodo
 *
 * @property Alumno $idAlumno0
 * @property Grupo $idGrupo0
 * @property Periodo $idPeriodo0
 */
class AlumnoGrupoPeriodo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alumno_grupo_periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idAlumno', 'idGrupo', 'idPeriodo'], 'required'],
            [['idAlumno', 'idGrupo', 'idPeriodo'], 'integer'],
            [['idAlumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumno::className(), 'targetAttribute' => ['idAlumno' => 'idAlumno']],
            [['idGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::className(), 'targetAttribute' => ['idGrupo' => 'idGrupo']],
            [['idPeriodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['idPeriodo' => 'idPeriodo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idAlumno' => 'Id Alumno',
            'idGrupo' => 'Id Grupo',
            'idPeriodo' => 'Id Periodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlumno0()
    {
        return $this->hasOne(Alumno::className(), ['idAlumno' => 'idAlumno']);
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
    public function getIdPeriodo0()
    {
        return $this->hasOne(Periodo::className(), ['idPeriodo' => 'idPeriodo']);
    }
}
