<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BuildingStage;
use App\Models\Customer;
use App\Models\Followup;
use App\Models\Menu;
use App\Models\ProjectType;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public function Dashboard(){
        $today = Carbon::today()->toDateString();
        $reminderCount = Followup::where('status', 1) ->whereDate('followup_date', $today)
        ->whereHas('customer', function ($q) {
            $q->where('cus_status', 1);
        })->count();
        $customer =Customer::where('status',1)->count();
        $followups = Followup::where('status',1)->count();
        $bilding = BuildingStage::count();
        $project = ProjectType::count();
        $baseQuery = Followup::where('status', 1)
        ->whereHas('customer', function ($q) {
            $q->where('cus_status', 1);
        });
        $todayfollowup = (clone $baseQuery)->whereDate('followup_date', $today)->count();
        $oneWeekFollowup = (clone $baseQuery)->whereBetween('followup_date', [$today, Carbon::today()->addDays(7)       ->toDateString()])->count();
        // One month follow-ups (today to next 1 month)
        $oneMonthFollowup = (clone $baseQuery)
            ->whereBetween('followup_date', [$today, Carbon::today()->addMonth()->toDateString()])
            ->count();

        // Three months follow-ups (today to next 3 months)
        $threeMonthFollowup = (clone $baseQuery)
            ->whereBetween('followup_date', [$today, Carbon::today()->addMonths(3)->toDateString()])
            ->count();
        return view('layouts.dashboard', compact('reminderCount','customer','followups','bilding','project','todayfollowup','oneWeekFollowup','oneMonthFollowup','threeMonthFollowup'));
    }
    public function BuildingStage(){
        return view('admin.building-stage');
    }
    public function ProjectType(){
        return view('admin.project-type');

    }
    public function Customer(){
        $buildingStages = BuildingStage::where('status',ProjectType::Active)->get(); // assuming table 'building_stages'
        $projectTypes  = ProjectType::where('status',ProjectType::Active)->get();
         return view('admin.customer', compact('buildingStages', 'projectTypes'));
    }
    public function FollowUp($id = null){
        // Fetch all customers for dropdown
        $customers = Customer::select('id', 'name', 'phone')->get();
        // Selected customer (only when ID exists)
        $selectedCustomer = null;
        $followup = null;
        $buildingStages = BuildingStage::where('status',ProjectType::Active)->get();
        $projectTypes = ProjectType::where('status',ProjectType::Active)->get();

        if ($id) {
            $selectedCustomer = Customer::find($id);
            $followup =Followup::where('customer_id',$id)->orderBy('id','desc')->first();
        }
        return view('admin.followup', compact('customers', 'selectedCustomer','buildingStages','projectTypes','followup'));
    }
    public function FollowupList(){
        $customers = Customer::select('id', 'name', 'phone')->get();
        return view('admin.followup-list', compact('customers'));
    }
    public function ReminderFollowupList(){
        $customers = Customer::select('id', 'name', 'phone')->where('cus_status',1)->get();
        return view('admin.reminder', compact('customers'));
    }

    public function MenuAccess()
    {
        
         $roles = Role::where('status', 1)->get();
        $menus = Menu::where('status', 1)->get();

        return view('admin.menuaccess', compact('roles', 'menus'));
    }
}
