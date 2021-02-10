<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Imports\BusinessImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BusinessSampleExport;

class BusinessController extends Controller
{
    public function import(Request $request)
    {

        try {
            $file = $request->file('businessImport')->store('local');
            $import = new BusinessImport;
            $import->import($file,null,\Maatwebsite\Excel\Excel::XLSX);;
        }catch(\Maatwebsite\Excel\Validators\ValidationException $ex){
            return back()->withFailures($ex->failures());
        }catch(InvalidArgumentException $ex){
            return back()->withErrors('Wrong data format in some column !');
        }catch(Exception $ex){
            return back()->withErrors('Something Went Wrong !');
        }catch(Error $e){
            return back()->withErrors('Something Went Wrong !');
        }

        if($import->failures()->isNotEmpty()){
            \Log::info($import->failures());
            return back()->withFailures($import->failures());
        }

        session()->flash('success', 'Businesses successfully imported.');

        return redirect('business');
    }

    public function export(Request $request)
    {
        return Excel::download(new BusinessSampleExport, 'business_sample.xlsx');
    }
}
