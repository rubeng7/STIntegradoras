<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property integer $idPersona
 * @property string $nombre
 * @property string $paterno
 * @property string $materno
 * @property integer $idDivision
 *
 * @property Division $idDivision0
 * @property Usuario $usuario
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'paterno', 'materno', 'idDivision'], 'required'],
            [['idDivision'], 'integer'],
            [['nombre', 'paterno', 'materno'], 'string', 'max' => 80],
            [['idDivision'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['idDivision' => 'idDivision']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPersona' => 'Id Persona',
            'nombre' => 'Nombre',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'idDivision' => 'Id Division',
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idPersona']);
    }
}
