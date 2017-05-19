<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite".
 *
 * @property integer $idComite
 * @property string $nombre
 * @property string $descripcion
 * @property integer $idPeriodo
 *
 * @property Periodo $idPeriodo0
 * @property ComiteProfesor[] $comiteProfesors
 * @property Profesor[] $idProfesors
 * @property Equipo[] $equipos
 */
class Comite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'idPeriodo'], 'required'],
            [['idPeriodo'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 255],
            [['nombre', 'idPeriodo'], 'unique', 'targetAttribute' => ['nombre', 'idPeriodo'], 'message' => 'The combination of Nombre and Id Periodo has already been taken.'],
            [['idPeriodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['idPeriodo' => 'idPeriodo']],
        ];
    }
    
    
    public function attributes() {
        return array_merge(parent::attributes(), ['periodoC',]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idComite' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'idPeriodo' => 'Periodo',
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
    public function getComiteProfesors()
    {
        return $this->hasMany(ComiteProfesor::className(), ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesors()
    {
        return $this->hasMany(Profesor::className(), ['idProfesor' => 'idProfesor'])->viaTable('comite_profesor', ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::className(), ['idComite' => 'idComite']);
    }
}
