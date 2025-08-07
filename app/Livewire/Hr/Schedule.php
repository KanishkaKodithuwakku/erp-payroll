<?php

namespace App\Livewire\Hr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HrSchedule;

class Schedule extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingSchedule = null;
    public $time_in = '';
    public $time_out = '';
    public $modalMode = 'add'; // 'add' or 'edit'

    protected $rules = [
        'time_in' => 'required|date_format:H:i',
        'time_out' => 'required|date_format:H:i|after:time_in',
    ];

    public function render()
    {
        $schedules = HrSchedule::query()
            ->when($this->search, function ($query) {
                $query->where('time_in', 'like', '%' . $this->search . '%')
                    ->orWhere('time_out', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $bodyAttributes = 'x-data="{ page: \'schedule\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.schedule.index', compact('schedules'))
            ->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function showAddModal()
    {
        $this->resetForm();
        $this->modalMode = 'add';
        $this->showForm = true;
    }

    public function showEditModal($id)
    {
        $schedule = HrSchedule::findOrFail($id);
        $this->editingSchedule = $id;
        $this->time_in = $schedule->time_in ? date('H:i', strtotime($schedule->time_in)) : '';
        $this->time_out = $schedule->time_out ? date('H:i', strtotime($schedule->time_out)) : '';
        $this->modalMode = 'edit';
        $this->showForm = true;
    }

    public function saveSchedule()
    {
        $this->validate();
        if ($this->modalMode === 'add') {
            HrSchedule::create([
                'time_in' => $this->time_in,
                'time_out' => $this->time_out,
            ]);
            session()->flash('success', 'Schedule added successfully!');
        } else {
            $schedule = HrSchedule::findOrFail($this->editingSchedule);
            $schedule->update([
                'time_in' => $this->time_in,
                'time_out' => $this->time_out,
            ]);
            session()->flash('success', 'Schedule updated successfully!');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function deleteSchedule($id)
    {
        HrSchedule::findOrFail($id)->delete();
        session()->flash('success', 'Schedule deleted successfully!');
    }

    public function resetForm()
    {
        $this->editingSchedule = null;
        $this->time_in = '';
        $this->time_out = '';
    }
}