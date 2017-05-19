<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "carrera".
 *
 * @property integer $idCarrera
 * @property string $nivel
 * @property string $nombre
 * @property string $descripcion
 * @property integer $idDivision
 *
 * @property Division $idDivision0
 * @property Esquema[] $esquemas
 * @property Grupo[] $grupos
 */
class Carrera extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nivel', 'nombre', 'idDivision'], 'required'],
            [['nivel'], 'string'],
            [['idDivision'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['idDivision'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['idDivision' => 'idDivision']]
        ];
    }
    
    public function attributes() {
        return array_merge(parent::attributes(), ['idDivision0.nombre']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCarrera' => 'ID',
            'nivel' => 'Nivel de Estudios',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'idDivision' => 'División',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDivision0()
    {
        return $this->hasOne(Division::className(), ['idDivision' => 'idDivision']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsquemas()
    {
        return $this->hasMany(Esquema::className(), ['idCarrera' => 'idCarrera']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos()
    {
        return $this->hasMany(Grupo::className(), ['idCarrera' => 'idCarrera']);
    }
    
    public static function listaCarrerasCombo() {
        $carreras = Carrera::find()->asArray()->all();
        return ArrayHelper::map($carreras, 'idCarrera', 'nombre');
    }
    
    public static function getListaConDivCombo() {
        //$carreras = Carrera::find()->asArray()->all();
        $carreras = Carrera::find()->joinWith('idDivision0')->asArray()->all();
        return ArrayHelper::map($carreras, 'idCarrera', 'nombre','idDivision0.nombre');
    }
}
