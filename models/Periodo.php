<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodo".
 *
 * @property integer $idPeriodo
 * @property string $mesInicio
 * @property string $mesFin
 * @property integer $anio
 *
 * @property AlumnoGrupoPeriodo[] $alumnoGrupoPeriodos
 * @property Comite[] $comites
 * @property Equipo[] $equipos
 * @property ProfesorGrupoPeriodo[] $profesorGrupoPeriodos
 */
class Periodo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mesInicio', 'mesFin', 'anio'], 'required'],
            [['mesInicio', 'mesFin'], 'string'],
            [['anio'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPeriodo' => 'Id Periodo',
            'mesInicio' => 'Mes Inicio',
            'mesFin' => 'Mes Fin',
            'anio' => 'Año',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnoGrupoPeriodos()
    {
        return $this->hasMany(AlumnoGrupoPeriodo::className(), ['idPeriodo' => 'idPeriodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComites()
    {
        return $this->hasMany(Comite::className(), ['idPeriodo' => 'idPeriodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::className(), ['idPeriodo' => 'idPeriodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorGrupoPeriodos()
    {
        return $this->hasMany(ProfesorGrupoPeriodo::className(), ['idPeriodo' => 'idPeriodo']);
    }
    
    public static function mapeaPeriodos(){
        $periodos = Periodo::find()->orderBy('anio')->all();
        $arrayPeriodos = [];
        foreach ($periodos as $periodo) {
            $mesI = Utilerias::getNombreMes($periodo->mesInicio);
            $mesF = Utilerias::getNombreMes($periodo->mesFin);
            $año = $periodo->anio;
            
            $arrayPeriodos[$periodo->idPeriodo] = $mesI . ' - ' . $mesF . ' ' . $año;
        }
        
        return $arrayPeriodos;
    }
}
