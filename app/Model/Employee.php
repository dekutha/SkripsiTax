<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	use Notifiable;

    protected $table = 'employees';

	const J_ADMIN = 0;
    const J_KEPALA_PRODUKSI = 1;
    const J_SUPERVISOR = 2;    
    const J_SECURITY = 3;
    const J_PRODUKSI = 4;
    const J_GUDANG = 5;

    const STATUS_SINGLE = 0;
    const STATUS_MARRIED = 1;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    const TYPE_P_TETAP      = 0;
    const TYPE_P_SEMENTARA  = 1;
    const TYPE_P_AHLI       = 2;

    public function job()
    {
        return $this->belongsTo(EmployeeJob::class, 'emp_job');
    }

    public function getType($field = 'label')
    {
        $status = [
            static::TYPE_P_TETAP => [
                'label'     => 'Pegawai Tetap',
                'color'     => 'success',
            ],
            static::TYPE_P_SEMENTARA => [
                'label'     => 'Pegawai Sementara',
                'color'     => 'default'
            ],
            static::TYPE_P_AHLI => [
                'label'     => 'Tenaga Ahli',
                'color'     => 'default'
            ]
        ];

        if($field !== null){
            $_tmp = [];
            foreach($status as $key => $s){
                $_tmp[$key]   = $s[$field];
            }
            $status = $_tmp;
        }

        return $status[ $this->status ];
    }

    public function getStatus($field = 'label')
    {
        $status = [
            static::STATUS_SINGLE => [
                'label'     => 'Belum Menikah',
                'color'     => 'success',
            ],
            static::STATUS_MARRIED => [
                'label'     => 'Menikah',
                'color'     => 'default'
            ]
        ];

        if($field !== null){
            $_tmp = [];
            foreach($status as $key => $s){
                $_tmp[$key]   = $s[$field];
            }
            $status = $_tmp;
        }

        return $status[ $this->marital_status ];
    }

    public function getGender($field = 'label')
    {
        $status = [
            static::GENDER_MALE => [
                'label'     => 'Laki-Laki',
                'color'     => 'success',
            ],
            static::GENDER_FEMALE => [
                'label'     => 'Perempuan',
                'color'     => 'default'
            ]
        ];

        if($field !== null){
            $_tmp = [];
            foreach($status as $key => $s){
                $_tmp[$key]   = $s[$field];
            }
            $status = $_tmp;
        }

        return $status[ $this->gender ];
    }



    public function getJob($field = 'label')
    {
        $status = [
            static::J_ADMIN => [
                'label'     => 'Staff Admin',
                'color'     => 'success',
            ],
            static::J_KEPALA_PRODUKSI => [
                'label'     => 'Kepala Produksi',
                'color'     => 'default'
            ],
            static::J_SUPERVISOR => [
                'label'     => 'Supervisor',
                'color'     => 'default'
            ],
            static::J_SECURITY => [
                'label'     => 'Security',
                'color'     => 'default'
            ],
            static::J_PRODUKSI => [
                'label'     => 'Produksi',
                'color'     => 'default'
            ],
            static::J_GUDANG => [
                'label'     => 'Gudang',
                'color'     => 'default'
            ]
        ];

        if($field !== null){
            $_tmp = [];
            foreach($status as $key => $s){
                $_tmp[$key]   = $s[$field];
            }
            $status = $_tmp;
        }

        return $status[ $this->emp_job ];
    }
    
}
