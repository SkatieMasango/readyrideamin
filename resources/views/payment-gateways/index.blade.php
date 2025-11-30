<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Payment Gateways
                        <span class="text-sm text-gray-500">Payment options of clients</span>
                    </h5>
                    <div class="w-28">
                        <x-primary-button type="button" x-data
                            @click="window.location.href = '{{ route('management.payment-gateways.create') }}'">
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class=" px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($paymentGateways as $paymentGateway)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <strong>{{ $paymentGateway->title ? $paymentGateway->title : 'N/A' }}
                                            ({{ $paymentGateway->type?->label() ?? 'N/A' }})
                                        </strong>
                                    </td>
                                    <td class=" tp-btn-action ">
                                        <div class="tp-order d-flex align-items-center justify-content-center relative">
                                            <x-action-button></x-action-button>
                                            <div class="tp-order-thumb-more absolute">
                                                <a type="submit"
                                                    href="{{ route('management.payment-gateways.edit', $paymentGateway->id) }}"
                                                    class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                    <i class="fa fa-edit"></i><span>Edit</span>
                                                </a>

                                                @php $modalId = 'showModal_' . $paymentGateway->id; @endphp
                                                <div x-data="{ showModal: false }" x-cloak>
                                                    <!-- Dropdown: Delete button inside -->
                                                    <button type="button" @click.stop="showModal = true"
                                                        class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                        <i class="fa fa-trash"
                                                            style="color:red; width:14px"></i><span>Delete</span>
                                                    </button>

                                                    <!-- Modal Outside Dropdown -->
                                                    <div x-show="showModal" @click.away="showModal = false" x-transition
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                                        aria-modal="true" role="dialog">
                                                        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                                            <div class="mb-4 text-center">
                                                                <h3 class="text-xl font-bold">Are you sure?</h3>
                                                                <p class="text-gray-700 mt-2 text-md">
                                                                    You want to permanently delete this gateway?
                                                                </p>
                                                            </div>

                                                            <div class="flex justify-center gap-3">
                                                                <button @click="showModal = false"
                                                                    class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                                    Cancel
                                                                </button>
                                                                <form method="POST"
                                                                    action="{{ route('management.payment-gateways.destroy', $paymentGateway->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $paymentGateways->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
