<?php
namespace ityakutia\poll\components;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class ExtendedActiveRecord extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_HIDDEN = 5;
    const STATUS_ACTIVE = 10;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function setStatusDeleted()
    {
    	$this->status = $this::STATUS_DELETED;
        return $this->save();
    }

    public function setStatusHidden()
    {
    	$this->status = $this::STATUS_HIDDEN;
        return $this->save();
    }

    public function setStatusActive()
    {
    	$this->status = $this::STATUS_ACTIVE;
        return $this->save();
    }
}
