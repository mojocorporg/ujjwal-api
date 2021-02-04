<?php

namespace App\Http\Livewire\Admin\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class TagComponent extends Component
{   

    use WithPagination;

    public $module = 'Tag';
    public Tag $tag; 
    public $query = '', $per_page = 10, $show_form= false, $updateMode = false;

    public function toggleForm()
    {
        $this->show_form=!$this->show_form;
        if($this->show_form){
            $this->tag=new Tag();
            $this->tag->status = 0;
        }
    }

    protected $rules = [
        'tag.name' => 'required|min:3',
        'tag.status' => 'nullable',
    ];

    public function store()
    {
        $this->validate();

        $this->tag->save();
    
        $this->show_form=false;
        if($this->updateMode)
        session()->flash('success', 'Tag successfully updated.');
        else
        session()->flash('success', 'Tag successfully created.');
        $this->updateMode = false;
    }

    public function edit(Tag $tag)
    {
        $this->show_form=true;
        $this->updateMode = true;
        $this->tag=$tag;
    }


    public function render()
    {
        return view('livewire.admin.tag.tag-component', [
            'tags' => Tag::where('name', 'like', '%'.$this->query.'%')->latest()->paginate($this->per_page),
        ])
        ->extends('layouts.app')
        ->section('content');
    }

    public function destroy($id)
    {
        if ($id) {
            $tag = Tag::find($id);
            $tag->delete();
            session()->flash('error', 'Tag successfully deleted.');
        }
    }
}
