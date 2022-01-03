<?php

namespace App\Http\Controllers;

use App\Models\ReadyMadeProject;
use Illuminate\Http\Request;

class ControllerReadyMadeProject extends MainController
{
    public function index(Request $request){
        $rusProjects = ReadyMadeProject::filterRus()->sort()->get();
        $importProjects = ReadyMadeProject::filterImport()->sort()->get();

        $this->seoParams['title'] = 'Проект прачечной и химчистки под ключ | Компания «Вектор»';
        $this->seoParams['description'] = 'Примеры готовых решений прачечных и химчисток с профессиональным прачечным оборудованиним для использования в гостинице, больнице, детских садах, предприятиях общественного питания. ';
        parent::index($request);

        return view('pages/gotovye-proekty', [
            'rusProjects' => $rusProjects,
            'importProjects' => $importProjects,
            'title' => 'Готовые проекты',
        ]);
    }
}
