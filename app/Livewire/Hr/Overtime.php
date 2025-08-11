<?php

namespace App\Livewire\Hr;

use App\Models\HrEmployee;
use App\Models\HrOvertime;
use Livewire\Component;
use Livewire\WithPagination;

class Overtime extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingOvertime = null;

    public $employee_id, $date_overtime, $hours, $minutes, $rate;

    protected $rules = [
        'employee_id' => 'required',
        'date_overtime' => 'required|date',
        'hours' => 'required|integer|min:0',
        'minutes' => 'required|integer|min:0|max:59',
        'rate' => 'required|numeric|min:0',
    ];

    public function render()
    {
        $overtimes = HrOvertime::with('hrEmployee.hrPosition', 'hrEmployee.hrSchedule')
            ->when($this->search, function ($query) {
                $query->whereHas('hrEmployee', function ($q) {
                    $q->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        $employees = HrEmployee::with('hrPosition', 'hrSchedule')->get();

        $bodyAttributes = 'x-data="{ page: \'overtime\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.overtime.index', [
            'overtimes' => $overtimes,
            'employees' => $employees
        ])->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function createOvertime()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editOvertime($id)
    {
        $overtime = HrOvertime::find($id);
        if ($overtime) {
            $this->editingOvertime = $overtime->id;
            $this->employee_id = $overtime->employee_id;
            $this->date_overtime = $overtime->date_overtime;
            $this->hours = floor($overtime->hours);
            $this->minutes = (int) round(fmod($overtime->hours, 1) * 100);

            $this->rate = $overtime->rate;
            $this->showForm = true;
        }
    }

    public function saveOvertime()
    {
        $this->validate();

        $totalHours = $this->hours . '.' . $this->minutes;

        if ($this->editingOvertime) {
            $overtime = HrOvertime::find($this->editingOvertime);
            if ($overtime) {
                $overtime->update([
                    'employee_id' => $this->employee_id,
                    'date_overtime' => $this->date_overtime,
                    'hours' => $totalHours,
                    'rate' => $this->rate,
                ]);
                session()->flash('message', 'Overtime updated successfully.');
            }
        } else {
            HrOvertime::create([
                'employee_id' => $this->employee_id,
                'date_overtime' => $this->date_overtime,
                'hours' => $totalHours,
                'rate' => $this->rate,
            ]);
            session()->flash('message', 'Overtime created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function deleteOvertime($id)
    {
        $overtime = HrOvertime::find($id);
        if ($overtime) {
            $overtime->delete();
            session()->flash('message', 'Overtime deleted successfully.');
        }
        $this->dispatch('overtime-deleted');
    }

    private function resetForm()
    {
        $this->editingOvertime = null;
        $this->employee_id = '';
        $this->date_overtime = '';
        $this->hours = '';
        $this->minutes = '';
        $this->rate = '';
    }
}
