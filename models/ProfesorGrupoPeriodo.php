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
            [['idGrupo', 'idPeriodo'], 'required'],
            [['idProfesor', 'idGrupo', 'idPeriodo'], 'integer'],
            [['idProfesor'], 'exist', 'skipOnError' => true, 'targetClass' => Profesor::className(), 'targetAttribute' => ['idProfesor' => 'idProfesor']],
            [['idGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::className(), 'targetAttribute' => ['idGrupo' => 'idGrupo']],
            [['idPeriodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['idPeriodo' => 'idPeriodo']],
            [['idGrupo', 'idPeriodo'], 'unique', 'targetAttribute' => ['idProfesor', 'idGrupo', 'idPeriodo'],
                'message' => 'Este grupo ya esta asignado a este profesor en el periodo seleccionado'
            ],
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
    
    /**
     * 
     * @param ProfesorGrupoPeriodo $obj_1
     * @param ProfesorGrupoPeriodo $obj_2
     * @return int
     */
    public static function compare($obj_1, $obj_2) {
        /*$mismoIdProfesor = $obj_1->idProfesor == $obj_2->idProfesor;
        $mismoIdGrupo = $obj_1->idGrupo == $obj_2->idGrupo;
        $mismoIdPeriodo = $obj_1->idPeriodo == $obj_2->idPeriodo;
        
        if($mismoIdProfesor && $mismoIdGrupo && $mismoIdPeriodo) {
            return 0;
        } else {
            return -1;
        }*/
        
        return strcmp(spl_object_hash($obj_1), spl_object_hash($obj_2));
    }
    
    public static function eliminarMultiple($array_objetos) {
        foreach ($array_objetos as $objeto) {
            $objeto->delete();
        }
        return true;
    }
}
