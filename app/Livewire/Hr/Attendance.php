<?php

namespace App\Livewire\Hr;

use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDate;
    public $selectedEmployee;

    public function mount()
    {
        $this->selectedDate = date('Y-m-d');
    }

    public function render()
    {
         $bodyAttributes = 'x-data="{ page: \'attendance\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';
        return view('livewire.hr.attendance.index')
            ->layout('layouts.app',['bodyAttributes'=>$bodyAttributes]);
    }

    public function markAttendance($employeeId, $type)
    {
        // Attendance marking logic
        $this->dispatch('attendance-marked');
    }
} 