<?php

namespace App\Livewire\Hr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrPosition;

class Position extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingPosition = null;
    public $position_name = '';
    public $rate_per_hour = '';
    public $modalMode = 'add'; // 'add' or 'edit'

    protected $rules = [
        'position_name' => 'required|string|max:255',
        'rate_per_hour' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $positions = HrPosition::query()
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $bodyAttributes = 'x-data="{ page: \'position\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.position.index', compact('positions'))
           ->layout('layouts.app',['bodyAttributes'=>$bodyAttributes]);
    }

    public function showAddModal()
    {
        $this->resetForm();
        $this->modalMode = 'add';
        $this->showForm = true;
    }

    public function showEditModal($id)
    {
        $position = HrPosition::findOrFail($id);
        $this->editingPosition = $id;
        $this->position_name = $position->description;
        $this->rate_per_hour = $position->rate;
        $this->modalMode = 'edit';
        $this->showForm = true;
    }

    public function savePosition()
    {
        $this->validate();
        if ($this->modalMode === 'add') {
            HrPosition::create([
                'description' => $this->position_name,
                'rate' => $this->rate_per_hour,
            ]);
            session()->flash('success', 'Position added successfully!');
        } else {
            $position = HrPosition::findOrFail($this->editingPosition);
            $position->update([
                'description' => $this->position_name,
                'rate' => $this->rate_per_hour,
            ]);
            session()->flash('success', 'Position updated successfully!');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function deletePosition($id)
    {
        HrPosition::findOrFail($id)->delete();
        session()->flash('success', 'Position deleted successfully!');
    }

    public function resetForm()
    {
        $this->editingPosition = null;
        $this->position_name = '';
        $this->rate_per_hour = '';
    }
} 