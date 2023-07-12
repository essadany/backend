<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Claim;
use App\Models\Action;
use App\Models\User;
use App\Models\Report;
use App\Models\Notification;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class DailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = now();
        $targetDate1 = now()->subDay();   


    // Retrieve records where planned_date is 1 day before the current date
    $lateActions = Action::whereDate('planned_date', $targetDate1->toDateString())
                            ->where('status','<>','done')->get();
   
    // Retrieve records where planned_date is 2 days after the current date
    $targetDate = now()->addDays(2);
    $warningActions = Action::whereDate('planned_date', $targetDate->toDateString())->get();
    foreach ($warningActions as $record) {
        //Send Email ------------------
       $claim = $record->report->claim;
       $email = $record->user->email;
       $mailData = [
           'title' => 'Advertissement,  Action Not Done :' .$record->action,
           'body' => 'You have a new Action to finish before ' . $record->planned_date . '. 
               It is about the Claim with intern Reference : ' . $claim->internal_ID,
       ];

       Mail::to($email)->send(new SendMail($mailData));
       //Update Notification
       $notif = $record->notification;
       if ($notif!==null){
           $notif->message= now()." : You have an action  to finish before ".$record->planned_date;
           $notif->save();
       } 
   }
   

        foreach ($lateActions as $record) {
            $record->status = 'delayed';
            $notif = $record->notification;
            if ($notif!==null){
                $notif->delete();
            }           
            $record->save();
        }
    
        
    
        $this->info('Actions status Verified successfully.');
    }
}
