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
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    const ES_INVITADO = 0;
    const ACCESO_DENEGADO = 1;
    const ACCESO_PERMITIDO = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'password'], 'required'],
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
    public function attributeLabels() {
        return [
            'idUsuario' => 'Id Usuario',
            'username' => 'Nombre de usuario',
            'password' => 'Contraseña',
            'rol' => 'Rol',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno() {
        return $this->hasOne(Alumno::className(), ['idAlumno' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesor() {
        return $this->hasOne(Profesor::className(), ['idProfesor' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0() {
        return $this->hasOne(Persona::className(), ['idPersona' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioPrivilegios() {
        return $this->hasMany(UsuarioPrivilegio::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPrivilegios() {
        return $this->hasMany(Privilegio::className(), ['idPrivilegio' => 'idPrivilegio'])->viaTable('usuario_privilegio', ['idUsuario' => 'idUsuario']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     * Esta función creo que no la usaré.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $users = static::find()->where(['username' => $username])->all();
        foreach ($users as $user) {
            if (strcasecmp($user->username, $username) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->idUsuario;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        //return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        //return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === $password;
    }

    public static function puede($privilegio) {
        $usuario = Yii::$app->user->identity;
        if (Yii::$app->user->isGuest) {
            return static::ES_INVITADO;
        }
        $privilegios = $usuario->idPrivilegios;
        $mapaPrivilegios = ArrayHelper::map($privilegios, 'nombre', 'nombre');
        if (in_array($privilegio, $mapaPrivilegios, true)) {
            return static::ACCESO_PERMITIDO;
        } else {
            return static::ACCESO_DENEGADO;
        }
    }

    public static function verificarPrivilegio($privilegio, $esModal = false, $esCombo = false) {
        $resp = static::puede($privilegio);
        if ($resp == static::ACCESO_PERMITIDO) {
            return true;
        } else if ($resp == static::ES_INVITADO) {
            return Yii::$app->response->redirect(Url::toRoute(['site/login']), '301')->send();
        } else {
            if ($esModal || $esCombo) {
                return false;
            } else {
                return Yii::$app->response->redirect(Url::toRoute(['site/denegar']), '301')->send();
            }
        }
    }
    
    /**
     * 
     * @param \app\models\Persona $persona
     * @param bool $validar
     * @return bool
     */
    public function registrar($persona, $validar) {
        $transaccion = \Yii::$app->db->beginTransaction();
        try {
            if ($persona->save($validar)) {
                $this->idUsuario = $persona->idPersona;
                if ($this->save($validar)) {
                    $transaccion->commit();
                    return true;
                }
            }
            $transaccion->rollBack();
            // Lanzar alertas
            
            return false;
        } catch (Exception $ex) {
            $transaccion->rollBack();
            // Lanzar alertas
            throwException($exception);
            return false;
        }
        
    }

}
