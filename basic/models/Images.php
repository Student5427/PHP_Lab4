<?php

namespace app\models;

use yii\db\ActiveRecord;

class Images extends ActiveRecord 
{
	//На случай, если имя модели не совпадает с названием таблицы в БД
    public static function tableName()
    {
        return "images";
    }
	//Валидация: Поля name и caption не должны быть пустыми, safe нужен, чтобы записать новую строку в БД
    public function rules()
    {
	return[[['id', 'name', 'caption'], 'safe'], ['name', 'required'], ['caption', 'required']];
    }
}

?>
