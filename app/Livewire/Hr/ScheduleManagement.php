<?php

namespace App\Livewire\Hr;

use App\Models\HrEmployee;
use App\Models\HrSchedule;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $employee_id;
    public $schedule_id;
    public $schedules;

    public function render()
    {
        $employees = HrEmployee::with('hrSchedule')
            ->where('firstname', 'like', '%' . $this->search . '%')
            ->orWhere('lastname', 'like', '%' . $this->search . '%')
            ->orWhere('employee_id', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $this->schedules = HrSchedule::all();

        $bodyAttributes = 'x-data="{ page: \'schedule-management\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.schedule-management.index', [
            'employees' => $employees,
        ])
            ->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function showEditModal($employeeId)
    {
        $this->employee_id = $employeeId;
        $employee = HrEmployee::find($employeeId);
        $this->schedule_id = $employee->schedule_id;
        $this->showForm = true;
    }

    public function updateSchedule()
    {
        $this->validate([
            'schedule_id' => 'required|exists:hr_schedules,id',
        ]);

        $employee = HrEmployee::find($this->employee_id);
        $employee->schedule_id = $this->schedule_id;
        $employee->save();

        session()->flash('success', 'Employee schedule updated successfully.');

        $this->showForm = false;
    }
}
