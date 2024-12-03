<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Activitylog\Models\Activity;

// use Spatie\Activitylog\Models\Activity;

class ActivitiesExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data) 
    {
        $this->data = $data;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Activity::all();
    // }

    public function headings(): array
    {
        // Cara Statis
        return [
            'id',
            'log_name',
            'description',
            'subject_type',
            'event',
            'subject_id',
            'causer_type',
            'causer_id',
            'properties',
            'batch_uuid',
            'created_at',
            'updated_at'            
        ];
        // Cara Dinamis
        // $headings = [];
        // foreach( $this->data->toArray()[0] as $key => $value ) {
        //     $headings[] = $key;
        // }

        // return $headings;
    }
    public function array(): array
    {
        return $this->data->toArray();
    }
}
