<?php

/**
 * This is the model class for table "{{games}}".
 *
 * The followings are the available columns in table '{{games}}':
 * @property string $id
 * @property integer $level_cd
 * @property string $grid_string
 *
 * The followings are the available model relations:
 * @property Levels $levelCd
 * @property GamesPlayed[] $gamesPlayed
 * @property Users[] $tblUsers
 */
class Game extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{games}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level_cd, grid_string', 'required'),
			array('level_cd', 'numerical', 'integerOnly'=>true),
			array('grid_string', 'length', 'max'=>400),
            array('grid_string', 'unique', 'message' => "This game grid already exists."), // 'className' => 'Game',
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, level_cd, grid_string', 'safe', 'on'=>'search'),
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
			'levelCd' => array(self::BELONGS_TO, 'Levels', 'level_cd'),
			'gamesPlayed' => array(self::HAS_MANY, 'GamesPlayed', 'games_id'),
			'tblUsers' => array(self::MANY_MANY, 'Users', '{{games_saved}}(games_id, users_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Game ID',
			'level_cd' => 'Game Level',
			'grid_string' => 'Grid String',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('level_cd',$this->level_cd);
		$criteria->compare('grid_string',$this->grid_string,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Game the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
