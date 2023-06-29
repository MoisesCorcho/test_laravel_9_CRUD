<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ReasonForNotVisit;
use App\Traits\Uuid;

class Visit extends Model
{
    use HasFactory, Uuid;

    protected $table        = 'visits';
    protected $keyType      = 'uuid';
    public    $incrementing = false;


    protected $fillable = [
        'visitDate',
        'rescheduledDate',
        'reasonForNotVisitDesc',
        'status',
        'sellerId',
        'reasonForNotVisitId',
        'organizationId',
        'surveyId'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerId');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizationId');
    }

    public function reasonForNotVisit()
    {
        return $this->belongsTo(ReasonForNotVisit::class, 'reasonForNotVisitId');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyId');
    }

    /*
    * Esta función retornará algo diferente de 0 si encuentra citas en la fecha que se trae del request
    */
    public static function isTimeAvailable($visitDate, $startTime, $endTime, $sellerId, $rescheduledDate)
    {
        $visits = Self::query()
            // si viene del request $rescheduledDate entra aqui
            ->when($rescheduledDate, function ($query) use ($rescheduledDate, $sellerId, $startTime, $endTime) {
                //Evitamos que se tome en cuenta el "id" de la visita que seleccionamos para que no hayan problemas al actualizar
                $query->where('id', '!=', request('id'))
                ->where( function ($query) use ($rescheduledDate) {
                    //Toma en cuenta a la fecha de las visitas que no han tenido reagendacion
                    $query->where('visitDate', $rescheduledDate)
                          ->where('rescheduledDate', null)
                          //Toma en cuenta a las visitas que si han tenido reagendacion
                          ->orWhere( function ($query) use ($rescheduledDate) {
                            $query->where('rescheduledDate', $rescheduledDate);
                        });
                })
                ->where('sellerId', $sellerId)
                ->where([
                    ['endTime',   '>', $startTime],
                    ['startTime', '<', $endTime]
                ]);
            }, function ($query) use ($visitDate, $sellerId, $startTime, $endTime) {
                $query->where('visitDate', $visitDate)
                ->where('sellerId', $sellerId)
                ->where('rescheduledDate', null)
                ->where([
                    ['endTime',   '>', $startTime],
                    ['startTime', '<', $endTime]
                ]);
            })
            ->count();

        return !$visits;
    }

    /**
     * Retorna "true" si el numero de visitas en la fecha del request actual es mayor o igual que 8.
     *
     * @param [type] $fechaVisita
     * @return bool
     */
    public function numberOfVisits($fechaVisita)
    {
        $idUser = request()->sellerId;
        $response = Visit::where(['visitDate' => $fechaVisita, 'sellerId' => $idUser])->count();
        return $response >= 8 ? true : false;
    }

    // public static function rescheduledDateTimeAvailable($startTime, $endTime, $sellerId, $rescheduledDate)
    // {
    //     $visits = Self::query()
    //         ->where('rescheduledDate', $rescheduledDate)
    //         ->where('sellerId', $sellerId)
    //         ->where([
    //             ['endTime',   '>', $startTime],
    //             ['startTime', '<', $endTime]
    //         ])
    //         ->count();

    //         return !$visits;
    // }

}
