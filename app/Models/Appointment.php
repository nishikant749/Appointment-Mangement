<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    #Define table
    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'slot_id',
        'email',
        'patient_name',
        'disease',
        'visit_date',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date'    => 'datetime',
    ];

    /**
     * @method to define relation b/w model and patient User
     * @return relation
     * @param
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    /**
     * @method to define relation b/w model and doctor User
     * @return relation
     * @param
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

     /**
     * @method to define relation b/w model and Slot
     * @return relation
     * @param
     */
    public function slot()
    {
        return $this->belongsTo(AppointmentSlot::class, 'slot_id', 'id');
    }

    /**
     * @method to set the Attribute to fetch visit time
     * @return string
     * @param
     */
    public function getVisitTimingAttribute()
    {
        return $this->slot->start_time.'-'.$this->slot->end_time;
    }

    /**
     * @method to set the Attribute to fetch appointment Color according to status
     * @return string
     * @param
     */
    public function getStatusColorAttribute()
    {
        #Set Color class
        $colorClass = '';
        if($this->status == 'booked') {
            $colorClass = "table-info";
        } elseif ($this->status == 'completed') {
           $colorClass = "table-success";
        } else {
            $colorClass = "table-danger";
        }

        #retunr
        return $colorClass;
    }
    
}
