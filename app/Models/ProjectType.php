<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    //
    
    protected $guarded = []; 
    public const TYPE = 'project_type';
    public const Active = '1';
    public const InActive = '0';

}
