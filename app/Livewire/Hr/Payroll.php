<?php

namespace App\Livewire\Hr;

use App\Models\HrCashadvance;
use App\Models\HrDeduction;
use App\Models\HrEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Payroll extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedMonth;
    public $selectedYear;

    public function mount()
    {
        $this->selectedMonth = date('m');
        $this->selectedYear = date('Y');
    }

    public function render()
    {
        $employees = HrEmployee::with(['hrPosition'])
            ->where('firstname', 'like', '%' . $this->search . '%')
            ->orWhere('lastname', 'like', '%' . $this->search . '%')
            ->orWhere('employee_id', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $deductions = HrDeduction::all();
        $cashadvances = HrCashadvance::whereIn('employee_id', $employees->pluck('employee_id'))->get()->groupBy('employee_id');

        foreach ($employees as $employee) {
            $employee->gross = ($employee->hrPosition->rate)*8*20 ?? 0;//asingn normal rate to gross pay (this generate work hour *hour rate)
            $employee->total_deductions = $deductions->sum('amount');
            $employee->total_cashadvance = $cashadvances->get($employee->employee_id)?->sum('amount') ?? 0;
            $employee->net_pay = $employee->gross - $employee->total_deductions - $employee->total_cashadvance;
        }

        $bodyAttributes = 'x-data="{ page: \'payroll\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.payroll.index', [
            'employees' => $employees,
        ])
            ->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }

    public function generatePayroll()
    {
        // Payroll generation logic
        $this->dispatch('payroll-generated');
    }
}
