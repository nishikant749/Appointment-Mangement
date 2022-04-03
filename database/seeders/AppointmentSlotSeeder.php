<?php

namespace Database\Seeders;

use DateTime;
use App\Models\AppointmentSlot;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AppointmentSlotSeeder extends Seeder
{
    /**
     * @method Create the Slots for appointment
     *
     * @return void
     */
    public function run()
    {
        #Fetch the Slots
        $morningSlots = $this->getTimeSlot(60, '10:00', '14:00');
        $eveningSlots = $this->getTimeSlot(60, '16:00', '20:00');
        
        #Set Slots
        $slots = array_merge($morningSlots, $eveningSlots);

        #Insert the Slots
        foreach ($slots as $key => $slot) {
            #FEtch slot on start and end time
            $slotModel = AppointmentSlot::where('start_time', $slot['start_time'])
                             ->where('end_time', $slot['end_time'])
                             ->get();

            #VAlidate and Create Slot
            if($slotModel->isEmpty()) {
                AppointmentSlot::create(['start_time' => $slot['start_time'], 'end_time' => $slot['end_time']]);
            }
        }
    }

    /**
     * @method to Create teh SLots
     * @return slots Array
     * @param 
     */
    function getTimeSlot($interval, $startTiming, $endTiming)
    {
        #Set the start and end timing of Slots
        $start = new DateTime($startTiming);
        $end = new DateTime($endTiming);

        #format the start and End Time 
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');

        #initialize counter
        $counter = 0;
        $time = [];

        #Excute the loop till start is less then end
        while(strtotime($startTime) <= strtotime($endTime)){
            $start = $startTime;
            $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $counter++;
            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$counter]['start_time'] = $start;
                $time[$counter]['end_time'] = $end;
            }
        }
        return $time;
    }
    
}