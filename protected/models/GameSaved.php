<?php

/**
 * This is the model class for table "{{games_saved}}".
 *
 * The followings are the available columns in table '{{games_saved}}':
 * @property integer $users_id
 * @property string $games_id
 * @property string $timer
 * @property string $entries
 */
class GameSaved extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{games_saved}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, games_id, entries', 'required'),
			array('users_id', 'numerical', 'integerOnly'=>true),
			array('games_id, timer', 'length', 'max'=>10),
			array('entries', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('users_id, games_id, timer, entries', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'users_id' => 'Users',
			'games_id' => 'Games',
			'timer' => 'Timer',
			'entries' => 'Entries',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('games_id',$this->games_id,true);
		$criteria->compare('timer',$this->timer,true);
		$criteria->compare('entries',$this->entries,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameSaved the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
