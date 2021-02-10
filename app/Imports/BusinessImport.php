<?php

namespace App\Imports;

use App\Models\Business;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusinessImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        \Log::info($row);
        $business = Business::create([
            'company_name' => $row['company_name'],
            'owner_name' => $row['owner_name'],
            'description' => $row['description'],
            'address' => $row['address'],
            'pincode' => $row['pincode'],
            'city' => $row['city'],
            'state' => $row['state'],
            'lat' => $row['lat'],
            'long' => $row['long'],
            'status' => $row['status'],
        ]);

        if($row['tags']){
            $syncData = [];
            $index = 0;
            $tags = explode(",", $row['tags']);
            foreach($tags as $key => $tag){
                $tag = Tag::where('name', 'LIKE', '%'. $tag.'%')->first();
                if($tag){
                    $syncData[$index] = $tag->id;
                    ++$index;
                }
            }
            $business->tags()->sync($syncData);
        }

        if($row['contact_numbers']){
            $syncData = [];
            $index = 0;
            $contact_numbers = explode(",", $row['contact_numbers']);
            $contactArray = [];
                foreach($contact_numbers as $key => $contact){
                array_push($contactArray, ['business_id' => $business->id, 'phone_number' => $contact]);
                }
            $business->phones()->insert($syncData);
        }
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pincode' => 'required|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'lat' => 'nullable',
            'long' => 'nullable',
            'status' => ['required', Rule::in([ 0, 1])],
        ];
    }
}
