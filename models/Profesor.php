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
        // Inicio de una transacción
        $transaccion = \Yii::$app->db->beginTransaction();

        try {
            // Intentar registrar al usuario
            if ($usuario->registrar($persona, $validar)) {

                // Asignar id al profesor
                $this->idProfesor = $usuario->idUsuario;

                // Intentar guardar el profesor
                if ($this->save($validar)) {

                    // Variable de guardia
                    $guardoPgp = true;

                    // Verificar si el profesor es un profesor de integradora
                    if ($this->enIntegradora == 1) {

                        // Recorrer el arreglo de profesores grupos periodos
                        foreach ($profesorGrupoPeriodos as $pgp) {

                            // Asignar id e intentar guardar el ProfesorGrupoPeriodo
                            $pgp->idProfesor = $this->idProfesor;
                            if (!$pgp->save($validar)) {
                                $guardoPgp = false;
                                break;
                            }
                        }
                    }

                    // Verificar si todo se realizo bien
                    if ($guardoPgp) {
                        // Todo salio bien, hacer commit
                        $transaccion->commit();
                    } else {
                        // Algo salio mal, hacer rollBack
                        $transaccion->rollBack();
                        Utilerias::setFlash('pro-reg-1', Model::MSG_ERR_REG_GEN
                                . ' Error al guardar la relación entre el'
                                . ' profesor y los grupos', Model::MSG_TITLE_FAIL_REG, 5000);
                    }

                    // Retornar el valor del guardia, true or false
                    return $guardoPgp;
                } else {
                    // No se pudo guardar al profesor
                    Utilerias::setFlash('pro-reg-2', Model::MSG_ERR_REG_GEN
                            . ' Error al guardar el profesor', Model::MSG_TITLE_FAIL_REG, 5000);
                }
            } else {
                // No se pudo guardar al usuario
                Utilerias::setFlash('pro-reg-3', Model::MSG_ERR_REG_GEN
                        . ' Error al guardar el usuario', Model::MSG_TITLE_FAIL_REG, 5000);
            }

            /*
             * Si ha llegado aqui quiere decir que algo salio mal con el usuario
             * o el profesor. Retornar false. (Los mensajes de alerta ya fueron
             * lanzados)
             */
            $transaccion->rollBack();
            return false;
        } catch (Exception $ex) {
            // Ocurrio un error inesperado. Hacer rollback y devolver false
            $transaccion->rollBack();
            throwException($ex);
            return false;
        }
    }

    public function toString() {
        return $this->nivelEstudios . ' ' . $this->idProfesor0->idUsuario0->toString();
    }

}
