<?php

namespace app\models;

use Yii;
use app\models\Utilerias;

/**
 * This is the model class for table "comite".
 *
 * @property integer $idComite
 * @property string $nombre
 * @property string $descripcion
 * @property integer $idPeriodo
 * @property integer $idDivision
 *
 * @property Division $idDivision0
 * @property Periodo $idPeriodo0
 * @property ComiteProfesor[] $comiteProfesors
 * @property Profesor[] $idProfesors
 * @property Equipo[] $equipos
 */
class Comite extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comite';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre', 'idPeriodo', 'idDivision'], 'required'],
            [['idPeriodo', 'idDivision'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 255],
            [['nombre', 'idPeriodo'], 'unique', 'targetAttribute' => ['nombre', 'idPeriodo'], 'message' => 'The combination of Nombre and Id Periodo has already been taken.'],
            [['idDivision'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['idDivision' => 'idDivision']],
            [['idPeriodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodo::className(), 'targetAttribute' => ['idPeriodo' => 'idPeriodo']],
        ];
    }

    public function attributes() {
        return array_merge(parent::attributes(), ['periodoC',]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idComite' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'idPeriodo' => 'Periodo',
            'idDivision' => 'Division',
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
    public function getIdPeriodo0() {
        return $this->hasOne(Periodo::className(), ['idPeriodo' => 'idPeriodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComiteProfesors() {
        return $this->hasMany(ComiteProfesor::className(), ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesors() {
        return $this->hasMany(Profesor::className(), ['idProfesor' => 'idProfesor'])->viaTable('comite_profesor', ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos() {
        return $this->hasMany(Equipo::className(), ['idComite' => 'idComite']);
    }

    /**
     * 
     * @param Comite $this
     * @param \app\models\Periodo $periodo
     * @param \app\models\ComiteProfesor[] $comiteProfesores
     * @return mixed
     */
    public function registrar($comiteProfesores, $validar = true) {

        // Inicialización de variables autoincrementales
        if ($this->isNewRecord) {
            $this->idComite = 0;
        }
        
        // Inicia transacción
        $transaccion = Yii::$app->db->beginTransaction();

        // Intentar guardar el comité
        if ($this->save()) {
            
            // Variable de control
            $todoBien = true;
            
            // Recorrer los comitesProfesores
            foreach ($comiteProfesores as $cp) {
                
                // Asignar id de comite
                $cp->idComite = $this->idComite;
                
                // Indicar que el profesor ahora participa en un comité
                $cp->idProfesor0->enComite = true;
                
                // Intentar gusrdar el comiteProfesor y actualizar el profesor
                if (!($cp->save($validar) && $cp->idProfesor0->save())) {
                    
                    // Algo salió mal
                    $todoBien = false;
                    break;
                }
                
            }
            
            // Verificar si todo ha salido bien
            if ($todoBien) {
                
                // Todo salió bien. Hacer commit y retornar true
                $transaccion->commit();
                return true;
            } else {
                
                // Algo salió mal. Lanzar alertas, hacer rollback y retornar false
                Utilerias::setFlash('com-reg-1', Model::MSG_ERR_REG_GEN .
                        'Error al relacionar profesores con el comité', Model::MSG_TITLE_FAIL_REG, 5000);
                $transaccion->rollBack();
                return false;
            }
        } else {
            // No se pudo guardar el comité. Lanzar alertas, hacer rollback y retornar false
            Utilerias::setFlash('com-reg-2', Model::MSG_ERR_REG_GEN .
                    'Error al registrar el comité', Model::MSG_TITLE_FAIL_REG, 5000);
            $transaccion->rollBack();
            return false;
        }
    }

}
