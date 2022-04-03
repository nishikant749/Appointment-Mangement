<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_type',
        'mobile',
        'qualification',
        'specialization',
        'password',
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
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include doctor type user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDoctor($query)
    {
        #return 
        return $query->where('user_type', 'doctor');
    }

    /**
     * Scope a query to only include patient type user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePatient($query)
    {
        #return 
        return $query->where('user_type', 'patient');
    }

    /**
     * @method to define relationship bw doctor and appointments
     * @return relation
     * @param
     */
    public function doctorAppointments()
    {
        #return
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    /**
     * @method to define relationship bw doctor and appointments
     * @return relation
     * @param
     */
    public function patientAppointments()
    {
        #return
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }
    

    /**
     * @method to set the attribute for name and Specilaization
     * @return string
     * @param 
     */
    public function getNameWithSpecializationAttribute()
    {
        #return 
        return $this->name.'( '.$this->specialization.' )';
    }
}
