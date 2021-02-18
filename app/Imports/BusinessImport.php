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
        $business = Business::create([
            'owner_name' => $row['first_name'].' '.$row['last_name'],
            'designation' => $row['designation'],
            'email' => $row['email'],
            'company_name' => $row['business_name'],
            'description' => $row['nature_of_trade'],
            'address' => $row['address'],
            'city' => $row['city'],
            'state' => $row['state'],
            'pincode' => $row['pincode'],
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
            $contact_numbers = explode(",", $row['contact_numbers']);
            \Log::info($contact_numbers);
            $contactArray = [];
                foreach($contact_numbers as $key => $contact){
                    $contactArray[$key] = ['business_id' => $business->id, 'phone_number' => $contact];
                }
            \Log::info($contactArray);
            $business->phones()->insert($contactArray);
        }
    }

    public function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'nature_of_trade' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'pincode' => 'required|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'lat' => 'nullable',
            'long' => 'nullable',
            'status' => ['required', Rule::in([ 0, 1])],
        ];
    }
}
