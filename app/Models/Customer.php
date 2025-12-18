<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $guarded = []; 
    
    // Relation to BuildingStage
    public function buildingStage()
    {
        return $this->belongsTo(BuildingStage::class, 'building_stage', 'id');
    }

    // Relation to ProjectType
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'project_type', 'id');
    }
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
