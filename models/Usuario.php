<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $idUsuario
 * @property string $username
 * @property string $password
 * @property string $rol
 * @property integer $activo
 *
 * @property Alumno $alumno
 * @property Profesor $profesor
 * @property Persona $idUsuario0
 * @property UsuarioPrivilegio[] $usuarioPrivilegios
 * @property Privilegio[] $idPrivilegios
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuario', 'username', 'password'], 'required'],
            [['idUsuario', 'activo'], 'integer'],
            [['rol'], 'string'],
            [['username', 'password'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['idUsuario' => 'idPersona']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'username' => 'Username',
            'password' => 'Password',
            'rol' => 'Rol',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumno::className(), ['idAlumno' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesor()
    {
        return $this->hasOne(Profesor::className(), ['idProfesor' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Persona::className(), ['idPersona' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioPrivilegios()
    {
        return $this->hasMany(UsuarioPrivilegio::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPrivilegios()
    {
        return $this->hasMany(Privilegio::className(), ['idPrivilegio' => 'idPrivilegio'])->viaTable('usuario_privilegio', ['idUsuario' => 'idUsuario']);
    }
}
