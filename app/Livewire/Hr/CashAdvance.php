<?php

namespace App\Livewire\Hr;

use App\Models\HrCashadvance;
use App\Models\HrEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class CashAdvance extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingCashAdvance = null;
    public $employee_id;
    public $amount;
    public $date_advance;
    public $modalMode = 'add';

    protected $rules = [
        'employee_id' => 'required',
        'amount' => 'required|numeric',
        'date_advance' => 'required|date',
    ];

    public function render()
    {
        $cashAdvances = HrCashadvance::with('hrEmployee')
            ->whereHas('hrEmployee', function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $employees = HrEmployee::all();

        $bodyAttributes = 'x-data="{ page: \'cash-advance\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.cash-advance.index', [
            'cashAdvances' => $cashAdvances,
            'employees' => $employees,
        ])->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function showAddModal()
    {
        $this->reset(['employee_id', 'amount', 'date_advance', 'editingCashAdvance']);
        $this->modalMode = 'add';
        $this->showForm = true;
    }

    public function showEditModal($id)
    {
        $cashAdvance = HrCashadvance::findOrFail($id);
        $this->editingCashAdvance = $id;
        $this->employee_id = $cashAdvance->employee_id;
        $this->amount = $cashAdvance->amount;
        $this->date_advance = $cashAdvance->date_advance->format('Y-m-d');
        $this->modalMode = 'edit';
        $this->showForm = true;
    }

    public function saveCashAdvance()
    {
        $this->validate();

        if ($this->editingCashAdvance) {
            $cashAdvance = HrCashadvance::findOrFail($this->editingCashAdvance);
            $cashAdvance->update([
                'employee_id' => $this->employee_id,
                'amount' => $this->amount,
                'date_advance' => $this->date_advance,
            ]);
            session()->flash('success', 'Cash Advance updated successfully.');
        } else {
            HrCashadvance::create([
                'employee_id' => $this->employee_id,
                'amount' => $this->amount,
                'date_advance' => $this->date_advance,
            ]);
            session()->flash('success', 'Cash Advance added successfully.');
        }

        $this->showForm = false;
    }

    public function deleteCashAdvance($id)
    {
        HrCashadvance::findOrFail($id)->delete();
        session()->flash('success', 'Cash Advance deleted successfully.');
    }
}
