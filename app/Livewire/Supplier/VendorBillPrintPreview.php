<?php

namespace App\Livewire\Supplier;

use App\Models\VendorBillPayment;
use Livewire\Component;

class VendorBillPrintPreview extends Component
{
    public $payment;
    public $vendorBill;
    public $vendor;

    public function mount($vendorBillPaymentId)
    {
        $this->payment = VendorBillPayment::with('vendorBill.vendor', 'ledger')->findOrFail($vendorBillPaymentId);
        $this->vendorBill = $this->payment->vendorBill;
        $this->vendor = $this->vendorBill->vendor;
    }

    public function render()
    {
        $bodyAttributes = 'x-data="{ page: \'addGrn\', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
            x-init="darkMode = JSON.parse(localStorage.getItem(\'darkMode\'));
                    $watch(\'darkMode\', value => localStorage.setItem(\'darkMode\', JSON.stringify(value)))"
            :class="{\'dark bg-gray-900\': darkMode === true}"';

        return view('livewire.supplier.vendor-bill-print-preview', [
            'payment' => $this->payment,
            'vendorBill' => $this->vendorBill,
            'vendor' => $this->vendor,
        ])->layout('layouts.app', ['bodyAttributes' => $bodyAttributes]);
    }
}
