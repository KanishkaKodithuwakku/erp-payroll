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
                            Payroll Management
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
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Gross Pay</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Deductions</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Cash Advance</p>
                                    </div>
                                </th>
                                <th class="py-2 font-normal whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">Net Pay</p>
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
                                                {{ number_format($employee->gross, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                {{ number_format($employee->total_deductions, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                {{ number_format($employee->total_cashadvance, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-1 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-theme-xs text-gray-700 dark:text-gray-400">
                                                {{ number_format($employee->net_pay, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center">
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
</div>
