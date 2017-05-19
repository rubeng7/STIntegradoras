<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $idEmpresa
 * @property string $nombre
 * @property string $giro
 * @property string $responsable
 * @property string $telefono
 * @property integer $idDireccion
 *
 * @property Direccion $idDireccion0
 * @property Proyecto[] $proyectos
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'responsable', 'telefono', 'idDireccion'], 'required'],
            [['idDireccion'], 'integer'],
            [['nombre', 'giro'], 'string', 'max' => 80],
            [['responsable'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 50],
            [['idDireccion'], 'exist', 'skipOnError' => true, 'targetClass' => Direccion::className(), 'targetAttribute' => ['idDireccion' => 'idDireccion']],
        ];
    }
    
    public function attributes() {
        return array_merge(parent::attributes(), ['direccionCompleta',]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idEmpresa' => 'ID',
            'nombre' => 'Nombre o Razón Social',
            'giro' => 'Giro',
            'responsable' => 'Nombre del responsable',
            'telefono' => 'Teléfono',
            'idDireccion' => 'Dirección',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDireccion0()
    {
        return $this->hasOne(Direccion::className(), ['idDireccion' => 'idDireccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectos()
    {
        return $this->hasMany(Proyecto::className(), ['idEmpresa' => 'idEmpresa']);
    }
}
