<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\TaskReminderNotification;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendTaskReminderMail;

class SendTaskReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:taskreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico a modo de recordatorio al vendedor
                              con las tareas que aun tiene pendientes de sus citas';

    /**
     * Execute the console command.
     *
     * @return int
     */

    /**
     * Busca aquellos vendedores que tengan pendientes por realizar y les manda un correo una vez al dia.
     */
    public function handle()
    {
        User::query()
            ->role('Seller')
            ->each(function ($user) {

                $response = $user
                    ->join('surveyAnswers', 'surveyAnswers.sellerId', '=', 'users.id')
                    ->join('surveyQuestionAnswers', 'surveyQuestionAnswers.surveyAnswerId', '=', 'surveyAnswers.id')
                    ->join('surveyQuestions', 'surveyQuestions.id', '=', 'surveyQuestionAnswers.surveyQuestionId')
                    ->where('surveyAnswers.sellerId', $user->id)
                    ->where('surveyQuestions.questionOfThingsToDo', 1)
                    ->where('surveyQuestionAnswers.state', 1)
                    ->get();

                if ($response->count() !== 0) {
                    $correo = new sendTaskReminderMail($response);
                    Mail::to($response->pluck('email')[0])->send($correo);
                }
            });

        $this->info('Se enviaron los correos satisfactoriamente.');
    }
}
