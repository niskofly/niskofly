<?php

namespace App\Http\Controllers;
use  App\Models\CompletedProject;
use Illuminate\Http\Request;

class CompletedProjectController extends MainController
{
    public function index(Request $request){
        $this->seoParams['title'] = 'Реализованные проекты | Компания «Вектор»';
        $this->seoParams['description'] = 'Готовые и уже реализованные проекты в городах России с фотографиями установленого нами прачечного оборудования на разных предприятиях наших клиентов.  ';
        parent::index($request);

        $completedProjects = CompletedProject::orderBy('created_at', 'asc')->get();

        return view('pages/realizovannye-proekty', [ 'CompletedProjects' => $completedProjects, 'title' => 'Реализованные проекты']);
    }
}
