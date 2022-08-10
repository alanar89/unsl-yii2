<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Paciente]].
 *
 * @see Paciente
 */
class PacientesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Paciente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Paciente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
