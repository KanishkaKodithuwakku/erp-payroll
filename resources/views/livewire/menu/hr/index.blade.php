             <!-- Menu Group -->
             <div>
                 <h3 class="mb-1 text-xs uppercase leading-[20px] text-gray-400">
                     <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                         HUMAN RESOURCES
                     </span>

                 </h3>

                 <ul class="flex flex-col mb-1">
                     <!-- Menu Item Payroll (Main Dropdown) -->
                     <li>
                         <a href="#" @click.prevent="selected = (selected === 'Payroll' ? '':'Payroll')"
                             class="menu-item group"
                             :class="(selected === 'Payroll') || (page === 'hr-dashboard' || page === 'attendance' ||
                                 page === 'employee-list' || page === 'overtime' || page === 'cash-advance' ||
                                 page === 'schedules' ||page === 'schedule management' || page === 'deductions' || page === 'positions' ||
                                 page === 'payroll-list' || page === 'payroll-generate') ?
                             'menu-item-active' : 'menu-item-inactive'">


                             <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                 Payroll
                             </span>

                             <svg class="menu-item-arrow"
                                 :class="[(selected === 'Payroll') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                     sidebarToggle ? 'lg:hidden' : ''
                                 ]"
                                 width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                         </a>

                         <!-- Dropdown Menu Start -->
                         <div class="overflow-hidden transform translate"
                             :class="(selected === 'Payroll') ? 'block' : 'hidden'">
                             <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                                 class="flex flex-col mt-1 menu-dropdown pl-9">
                                 <!-- HR Dashboard -->
                                 <li>
                                     <a wire:navigate href="{{ route('hr.dashboard') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'hr-dashboard' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         HR Dashboard
                                     </a>
                                 </li>

                                 <!-- Attendance -->
                                 <li>
                                     <a wire:navigate href="{{ route('attendance.index') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'attendance' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         Attendance
                                     </a>
                                 </li>

                                 <!-- Add this to your layout file if not already present -->

                                 <!-- Employee Dropdown - now with proper Alpine.js component -->
                                 <li x-data="{
                                     employeeOpen: false,
                                     init() {
                                         // Keep dropdown open if any employee sub-page is active
                                         const currentPage = window.location.pathname;
                                         if (currentPage.includes('/employees') ||
                                             currentPage.includes('/overtime') ||
                                             currentPage.includes('/cash-advance') ||
                                             currentPage.includes('/schedules')) {
                                             this.employeeOpen = true;
                                         }
                                     }
                                 }">
                                     <!-- Main dropdown toggle -->
                                     <a href="#" @click.prevent="employeeOpen = !employeeOpen"
                                         class="menu-dropdown-item group"
                                         :class="(employeeOpen || ['employee-list', 'overtime', 'cash-advance', 'schedules']
                                             .includes(page)) ?
                                         'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                         Employee
                                         <svg class="menu-item-arrow"
                                             :class="[employeeOpen ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                                                 sidebarToggle ? 'lg:hidden' : ''
                                             ]"
                                             width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke=""
                                                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                         </svg>
                                     </a>

                                     <!-- Employee Sub-dropdown -->
                                     <div class="overflow-hidden transform translate"
                                         :class="employeeOpen ? 'block' : 'hidden'" @click.stop>
                                         <ul class="flex flex-col mt-1 menu-dropdown pl-9">
                                             <li>
                                                 <a wire:navigate href="{{ route('employees.index') }}"
                                                     class="menu-dropdown-item group"
                                                     :class="page === 'employee-list' ? 'menu-dropdown-item-active' :
                                                         'menu-dropdown-item-inactive'"
                                                     @click.stop="employeeOpen = true">
                                                     1. Employee List
                                                 </a>
                                             </li>
                                             <li>
                                                 <a wire:navigate href="{{ route('overtime.index') }}"
                                                     class="menu-dropdown-item group"
                                                     :class="page === 'overtime' ? 'menu-dropdown-item-active' :
                                                         'menu-dropdown-item-inactive'"
                                                     @click.stop="employeeOpen = true">
                                                     2. Overtime
                                                 </a>
                                             </li>
                                             <li>
                                                 <a wire:navigate href="{{ route('cash-advance.index') }}"
                                                     class="menu-dropdown-item group"
                                                     :class="page === 'cash-advance' ? 'menu-dropdown-item-active' :
                                                         'menu-dropdown-item-inactive'"
                                                     @click.stop="employeeOpen = true">
                                                     3. Cash Advance
                                                 </a>
                                             </li>
                                             <li>
                                                 <a wire:navigate href="{{ route('schedules.index') }}"
                                                     class="menu-dropdown-item group"
                                                     :class="page === 'schedules' ? 'menu-dropdown-item-active' :
                                                         'menu-dropdown-item-inactive'"
                                                     @click.stop="employeeOpen = true">
                                                     4. Schedules
                                                 </a>
                                             </li>
                                         </ul>
                                     </div>
                                 </li>

                                 <!-- Deduction -->
                                 <li>
                                     <a wire:navigate href="{{ route('deductions.index') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'deductions' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         Deduction
                                     </a>
                                 </li>

                                 <!-- Position -->
                                 <li>
                                     <a wire:navigate href="{{ route('positions.index') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'positions' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         Position
                                     </a>
                                 </li>
                                 <span
                                     class="p-2 text-xs text-gray-500 bg-gray-100 rounded menu-group-title
                                     :class="sidebarToggle
                                     ? 'lg:hidden' : ''">
                                     Printables
                                 </span>

                                 {{-- <!-- Payroll List --> --}}
                                 <li>
                                     <a wire:navigate href="{{ route('payroll.index') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'payroll-list' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         Payroll
                                     </a>
                                 </li>

                                 

                                 <!-- Schedule management -->
                                 <li>
                                     <a wire:navigate href="{{ route('schedule-management.index') }}"
                                         class="menu-dropdown-item group"
                                         :class="page === 'schedule management' ? 'menu-dropdown-item-active' :
                                             'menu-dropdown-item-inactive'">
                                         Schedule Management
                                     </a>
                                 </li>
                             </ul>
                         </div>
                         <!-- Dropdown Menu End -->
                     </li>
                     <!-- Menu Item Payroll (Main Dropdown) -->
                 </ul>
             </div>
