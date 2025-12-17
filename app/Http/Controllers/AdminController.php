<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function BuildingStage(){
        return view('admin.building-stage');
    }
    public function ProjectType(){
        return view('admin.project-type');

    }
    public function Customer(){
         return view('admin.customer');
    }
}
