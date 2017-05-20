<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesor".
 *
 * @property integer $idProfesor
 * @property string $nivelEstudios
 * @property string $especialidad
 * @property integer $enComite
 * @property integer $enIntegradora
 *
 * @property ComiteProfesor[] $comiteProfesors
 * @property Comite[] $idComites
 * @property Usuario $idProfesor0
 * @property ProfesorGrupoPeriodo[] $profesorGrupoPeriodos
 */
class Profesor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProfesor', 'nivelEstudios', 'especialidad'], 'required'],
            [['idProfesor', 'enComite', 'enIntegradora'], 'integer'],
            [['nivelEstudios'], 'string', 'max' => 50],
            [['especialidad'], 'string', 'max' => 80],
            [['idProfesor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idProfesor' => 'idUsuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idProfesor' => 'Id Profesor',
            'nivelEstudios' => 'Nivel Estudios',
            'especialidad' => 'Especialidad',
            'enComite' => 'En Comite',
            'enIntegradora' => 'En Integradora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComiteProfesors()
    {
        return $this->hasMany(ComiteProfesor::className(), ['idProfesor' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComites()
    {
        return $this->hasMany(Comite::className(), ['idComite' => 'idComite'])->viaTable('comite_profesor', ['idProfesor' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesor0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorGrupoPeriodos()
    {
        return $this->hasMany(ProfesorGrupoPeriodo::className(), ['idProfesor' => 'idProfesor']);
    }
}
