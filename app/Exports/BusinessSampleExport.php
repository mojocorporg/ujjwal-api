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
            'Lucy',
            'Cechtelar',
            'Manager',
            '+917113456789, +917145679876, +917115456466',
            'lucy.cechtelar@bogan.in',
            'Bogan-Treutel',
            'Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit',
            '426 Jordy Lodge Cartwrightshire, SC 88120-6700',
            'NewMexico',
            'West Judge',
            '17916',
            '77.147489',
            '86.211205',
            '1',
            'porro, sed, magni'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'First Name', 
            'Last Name', 
            'Designation',
            'Contact Numbers',
            'Email',
            'Business Name',
            'Nature of Trade',
            'Address',
            'City',
            'State',
            'Pincode',
            'Lat',
            'Long',
            'Status',
            'Tags'
        ];
    }
}
