<?php

namespace App\Exports;

use App\Business;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BusinessSampleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
            'Bogan-Treutel',
            'Lucy Cechtelar',
            'Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit',
            '426 Jordy Lodge Cartwrightshire, SC 88120-6700',
            '17916',
            'West Judge',
            'NewMexico',
            '77.147489',
            '86.211205',
            '1',
            '+917113456789, +917145679876, +917115456466',
            'porro, sed, magni'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Company Name',
            'Owner Name', 
            'Description',
            'Address',
            'Pincode',
            'City',
            'State',
            'Lat',
            'Long',
            'Status',
            'Contact Numbers',
            'Tags'
        ];
    }
}
