<?php

namespace App\Livewire\Hr;

use App\Models\HrDeduction;
use Livewire\Component;
use Livewire\WithPagination;

class Deduction extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingDeduction = null;
    public $description;
    public $amount;
    public $modalMode = 'add';

    protected $rules = [
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
    ];

    public function render()
    {
        $deductions = HrDeduction::where('description', 'like', '%' . $this->search . '%')->paginate(10);
        $bodyAttributes = 'x-data="{ page: \'deduction\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.deduction.index', [
            'deductions' => $deductions,
        ])->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function showAddModal()
    {
        $this->reset(['description', 'amount', 'editingDeduction']);
        $this->modalMode = 'add';
        $this->showForm = true;
    }

    public function showEditModal($id)
    {
        $deduction = HrDeduction::findOrFail($id);
        $this->editingDeduction = $id;
        $this->description = $deduction->description;
        $this->amount = $deduction->amount;
        $this->modalMode = 'edit';
        $this->showForm = true;
    }

    public function saveDeduction()
    {
        $this->validate();

        if ($this->editingDeduction) {
            $deduction = HrDeduction::findOrFail($this->editingDeduction);
            $deduction->update([
                'description' => $this->description,
                'amount' => $this->amount,
            ]);
            session()->flash('success', 'Deduction updated successfully.');
        } else {
            HrDeduction::create([
                'description' => $this->description,
                'amount' => $this->amount,
            ]);
            session()->flash('success', 'Deduction added successfully.');
        }

        $this->showForm = false;
    }

    public function deleteDeduction($id)
    {
        HrDeduction::findOrFail($id)->delete();
        session()->flash('success', 'Deduction deleted successfully.');
    }
}
