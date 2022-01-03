<?php
namespace App\Widgets;

class Widget{
    protected $widgets; //массив доступных виджетов config/widgets.php

    public function __construct(){
        $this->widgets = config('widgets');
    }

    public function show($obj, $data =[]){
        //Есть ли такой виджет
        if(isset($this->widgets[$obj])){
            //создаем его объект передавая параметры в конструктор
            //  ------ не передаются параметры в виджет
            //  ------ $obj = \App::make($this->widgets[$obj], $data);
            $obj = new $this->widgets[$obj]($data);
            //возвращаем результат выполнения
            return $obj->execute();
        }
    }
}