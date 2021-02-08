<?php

namespace App\Http\Livewire\Admin\Review;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewComponent extends Component
{
    use WithPagination;

    public $module = 'Reviews';
    public Review $review; 
    public $query = '', $per_page = 10, $show_form= false, $updateMode = false;

    public function toggleForm()
    {
        $this->show_form=!$this->show_form;
        if($this->show_form){
            $this->review=new Review();
            $this->review->status = 0;
        }
    }

    protected $rules = [
        'review.title' => 'required|min:3',
        'review.status' => 'nullable',
    ];

    public function store()
    {
        $this->validate();

        $this->review->save();
    
        $this->show_form=false;
        if($this->updateMode)
        session()->flash('success', 'Review successfully updated.');
        else
        session()->flash('success', 'Review successfully created.');
        $this->updateMode = false;
    }

    public function edit(Review $review)
    {
        $this->show_form=true;
        $this->updateMode = true;
        $this->review=$review;
    }


    public function render()
    {
        return view('livewire.admin.review.review-component', [
            'reviews' => Review::where('title', 'like', '%'.$this->query.'%')->latest()->paginate($this->per_page),
        ])
        ->extends('layouts.app')
        ->section('content');
    }

    public function destroy($id)
    {
        if ($id) {
            $review = Review::find($id);
            $review->delete();
            session()->flash('error', 'Review successfully deleted.');
        }
    }

}
