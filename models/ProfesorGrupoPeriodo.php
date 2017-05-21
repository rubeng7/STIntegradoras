<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesor_grupo_periodo".
 *
 * @property integer $idProfesor
 * @property integer $idGrupo
 * @property integer $idPeriodo
 *
 * @property Profesor $idProfesor0
 * @property Grupo $idGrupo0
 * @property Periodo $idPeriodo0
 */
class ProfesorGrupoPeriodo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesor_grupo_periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProfesor', 'idGrupo', 'idPeriodo'], 'required'],
            [['idProfesor', 'idGrupo', 'idPeriodo'], 'integer'],
            [['idProfesor'], 'exist', 'skipOnError' => true, 'targetClass' => Profesor::className(), 'targetAttribute' => ['idProfesor' => 'idProfesor']],
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
            'idProfesor' => 'Id Profesor',
            'idGrupo' => 'Id Grupo',
            'idPeriodo' => 'Id Periodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesor0()
    {
        return $this->hasOne(Profesor::className(), ['idProfesor' => 'idProfesor']);
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
