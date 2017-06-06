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
class Profesor extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nivelEstudios', 'especialidad'], 'required'],
            [['idProfesor', 'enComite', 'enIntegradora'], 'integer'],
            [['nivelEstudios'], 'string', 'max' => 50],
            [['especialidad'], 'string', 'max' => 80],
            [['idProfesor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idProfesor' => 'idUsuario']],
        ];
    }

    public function attributes() {
        return array_merge(parent::attributes(), [
            'idProfesor0.idUsuario0.nombre',
            'idProfesor0.idUsuario0.paterno',
            'idProfesor0.idUsuario0.materno',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idProfesor' => 'ID',
            'nivelEstudios' => 'Nivel Estudios',
            'especialidad' => 'Especialidad',
            'enComite' => 'En Comite',
            'enIntegradora' => 'En Integradora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComiteProfesors() {
        return $this->hasMany(ComiteProfesor::className(), ['idProfesor' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComites() {
        return $this->hasMany(Comite::className(), ['idComite' => 'idComite'])->viaTable('comite_profesor', ['idProfesor' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesor0() {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idProfesor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorGrupoPeriodos() {
        return $this->hasMany(ProfesorGrupoPeriodo::className(), ['idProfesor' => 'idProfesor']);
    }

    /**
     * 
     * @param \app\models\Persona $persona
     * @param \app\models\Usuario $usuario
     * @param \app\models\ProfesorGrupoPeriodo $profesorGrupoPeriodos
     * @param bool $validar
     * @return bool
     */
    public function registrar($persona, $usuario, $profesorGrupoPeriodos, $validar) {
        $transaccion = \Yii::$app->db->beginTransaction();
        try {
            if ($usuario->registrar($persona, $validar)) {
                $this->idProfesor = $usuario->idUsuario;

                if ($this->save($validar)) {
                    $guardoPgp = true;

                    if ($this->enIntegradora == 1) {
                        //ProfesorGrupoPeriodo::deleteAll(['idProfesor' => $this->idProfesor]);
                        foreach ($profesorGrupoPeriodos as $pgp) {
                            $pgp->idProfesor = $this->idProfesor;
                            if (!$pgp->save($validar)) {
                                $guardoPgp = false;
                                break;
                            }
                        }
                    }

                    if ($guardoPgp) {
                        $transaccion->commit();
                    } else {
                        $transaccion->rollBack();
                    }

                    return $guardoPgp;
                }
            }
            $transaccion->rollBack();
            return false;
        } catch (Exception $ex) {
            $transaccion->rollBack();
            throwException($exception);
            return false;
        }
    }
    
    public function toString() {
        return $this->nivelEstudios . ' ' . $this->idProfesor0->idUsuario0->toString();
    }

}
