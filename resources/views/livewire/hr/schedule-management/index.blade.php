<div>
    <div class="my-4">
        @if (session('success'))
            <div
                class="rounded-xl border border-success-500 bg-success-50 p-4 dark:border-success-500/30 dark:bg-success-500/15">
                <div class="flex items-start gap-3">
                    <div class="-mt-0.5 text-success-500">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z"
                                fill="" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                            Success
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @elseif (session('error'))
            <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-red-500/30 dark:bg-red-500/10">
                <div class="flex items-start gap-3">
                    <div class="-mt-0.5 text-red-500">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 3C7.031 3 3 7.031 3 12s4.031 9 9 9 9-4.031 9-9-4.031-9-9-9Zm0 16c-3.866 0-7-3.134-7-7s3.134-7 7-7 7 3.134 7 7-3.134 7-7 7Zm-.75-11a.75.75 0 0 1 1.5 0v4.5a.75.75 0 0 1-1.5 0V8Zm0 6.75a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0Z"
                                fill="" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                            Error
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div x-data="{ open: false }" class="p-2 mx-auto max-w-screen-2xl md:p-4">
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-4 flex flex-col gap-4 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex justify-between items-center gap-4"> <!-- Added gap-4 here -->
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Employee Schedule Management
                        </h3>
                    </div>

                    <!-- Search Input and Action Buttons -->
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
                        <!-- Search Input -->
                        <div class="relative">
                            <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                                <svg class="fill-gray-500 dark:fill-gray-400" width="15" height="15"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                        fill="" />
                                </svg>
                            </span>
                            <input type="text" wire:model.live.debounce.100ms="search"
                                placeholder="Search Employees..."
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-[32px] w-full rounded-lg border border-gray-300 bg-transparent py-1.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>
                    </div>
                </div>

                <div class="custom-scrollbar max-w-full overflow-x-auto px-5 sm:px-6">
                    <table class="min-w-full">
                        <thead class="border-y border-gray-100 py-2 dark:border-gray-800">
                            <tr>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Employee ID</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Employee Name</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Schedule</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Actions</p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($employees as $employee)
                                <tr class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                {{ $employee->employee_id }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                {{ $employee->full_name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                @if ($employee->hrSchedule)
                                                    {{ \Carbon\Carbon::parse($employee->hrSchedule->time_in)->format('h:i A') }} - {{ \Carbon\Carbon::parse($employee->hrSchedule->time_out)->format('h:i A') }}
                                                @else
                                                    Not Assigned
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap" style="width: 5%">
                                        <div class="flex items-center justify-start">
                                            <button wire:click="showEditModal({{ $employee->id }})"
                                                class="text-gray-400 hover:text-gray-800 dark:text-gray-400 dark:hover:text-blue-500"
                                                title="Edit">
                                                <svg class="fill-current" width="19" height="19"
                                                    viewBox="0 0 21 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z"
                                                        fill="" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center">
                                        <p class="text-theme-xs text-gray-700 dark:text-gray-400">No employees found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center border-t px-6 py-4 dark:border-gray-800">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of
                        {{ $employees->total() }} entries
                    </div>

                    <div class="pagination flex justify-between">
                       {{ $employees->links('vendor.pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div x-data="{ show: @entangle('showForm') }" x-show="show" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-100 bg-opacity-40">
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h3 class="mb-4 text-lg font-semibold">Edit Employee Schedule</h3>
            <form wire:submit.prevent="updateSchedule">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Schedule<span class="text-error-500">*</span>
                    </label>
                    <select wire:model.defer="schedule_id" class="w-full h-10 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Schedule</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}">{{ \Carbon\Carbon::parse($schedule->time_in)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->time_out)->format('h:i A') }}</option>
                        @endforeach
                    </select>
                    @error('schedule_id') <p class="mt-1 text-xs text-error-500">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end gap-3 mt-8 space-x-4">
                    <button type="button" @click="show = false; $wire.showForm = false" 
                        class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-6 py-2.5 text-sm font-medium text-white bg-brand-500 border border-blue-700 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                        Update Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
