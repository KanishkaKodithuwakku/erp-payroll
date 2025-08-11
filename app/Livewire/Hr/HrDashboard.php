<?php

namespace App\Livewire\Hr;

use Livewire\Component;

class HrDashboard extends Component
{
    public function render()
    {
        $bodyAttributes = 'x-data="{ page: \'hr-dashboard\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
           x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                   $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
           :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.hr.hr-dashboard.index')
            ->layout('layouts.app',['bodyAttributes'=>$bodyAttributes]);
    }
} 