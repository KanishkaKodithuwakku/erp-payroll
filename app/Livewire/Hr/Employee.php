<?php

namespace App\Livewire\Hr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrEmployee;
use App\Models\HrPosition;
use App\Models\HrSchedule;

class Employee extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingEmployee = null;
    public $employee_id = '';
    public $firstname = '';
    public $lastname = '';
    public $address = '';
    public $birthdate = '';
    public $contact_info = '';
    public $gender = '';
    public $position_id = '';
    public $schedule_id = '';
    public $modalMode = 'add'; // 'add' or 'edit'

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'birthdate' => 'nullable|date',
        'contact_info' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:10',
        'position_id' => 'required|exists:hr_positions,id',
        'schedule_id' => 'required|exists:hr_schedules,id',
    ];

    public function render()
    {
        $employees = HrEmployee::with(['hrPosition', 'hrSchedule'])
            ->when($this->search, function($query) {
                $query->where('firstname', 'like', '%'.$this->search.'%')
                      ->orWhere('lastname', 'like', '%'.$this->search.'%')
                      ->orWhere('employee_id', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $positions = HrPosition::orderBy('description')->get();
        $schedules = HrSchedule::orderBy('time_in')->get();

        $bodyAttributes = 'x-data="{ page: \'employee\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.employee.index', compact('employees', 'positions', 'schedules'))
            ->layout('layouts.app',['bodyAttributes'=>$bodyAttributes]);
    }

    public function showAddModal()
    {
        $this->resetForm();
        $this->modalMode = 'add';
        $this->employee_id = $this->generateEmployeeId();
        $this->showForm = true;
    }

    public function showEditModal($id)
    {
        $employee = HrEmployee::findOrFail($id);
        $this->editingEmployee = $id;
        $this->employee_id = $employee->employee_id;
        $this->firstname = $employee->firstname;
        $this->lastname = $employee->lastname;
        $this->address = $employee->address;
        $this->birthdate = $employee->birthdate;
        $this->contact_info = $employee->contact_info;
        $this->gender = $employee->gender;
        $this->position_id = $employee->position_id;
        $this->schedule_id = $employee->schedule_id;
        $this->modalMode = 'edit';
        $this->showForm = true;
    }

    public function saveEmployee()
    {
        $this->validate();
        if ($this->modalMode === 'add') {
            HrEmployee::create([
                'employee_id' => $this->generateEmployeeId(),
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'contact_info' => $this->contact_info,
                'gender' => $this->gender,
                'position_id' => $this->position_id,
                'schedule_id' => $this->schedule_id,
            ]);
            session()->flash('success', 'Employee added successfully!');
        } else {
            $employee = HrEmployee::findOrFail($this->editingEmployee);
            $employee->update([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'address' => $this->address,
                'birthdate' => $this->birthdate,
                'contact_info' => $this->contact_info,
                'gender' => $this->gender,
                'position_id' => $this->position_id,
                'schedule_id' => $this->schedule_id,
            ]);
            session()->flash('success', 'Employee updated successfully!');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function deleteEmployee($id)
    {
        HrEmployee::findOrFail($id)->delete();
        session()->flash('success', 'Employee deleted successfully!');
    }

    public function resetForm()
    {
        $this->editingEmployee = null;
        $this->employee_id = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->address = '';
        $this->birthdate = '';
        $this->contact_info = '';
        $this->gender = '';
        $this->position_id = '';
        $this->schedule_id = '';
    }

    private function generateEmployeeId()
    {
        $last = HrEmployee::orderBy('id', 'desc')->first();
        $next = $last ? $last->id + 1 : 1;
        return 'emp-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
} 