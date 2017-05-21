<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite_profesor".
 *
 * @property integer $idComite
 * @property integer $idProfesor
 *
 * @property Comite $idComite0
 * @property Profesor $idProfesor0
 */
class ComiteProfesor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite_profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idComite', 'idProfesor'], 'required'],
            [['idComite', 'idProfesor'], 'integer'],
            [['idComite'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['idComite' => 'idComite']],
            [['idProfesor'], 'exist', 'skipOnError' => true, 'targetClass' => Profesor::className(), 'targetAttribute' => ['idProfesor' => 'idProfesor']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idComite' => 'Id Comite',
            'idProfesor' => 'Id Profesor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComite0()
    {
        return $this->hasOne(Comite::className(), ['idComite' => 'idComite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesor0()
    {
        return $this->hasOne(Profesor::className(), ['idProfesor' => 'idProfesor']);
    }
}
