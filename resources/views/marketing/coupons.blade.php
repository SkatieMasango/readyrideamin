<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Marketing
                        <span class="text-sm text-gray-500">List of all coupons.</span>
                    </h5>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('marketing-coupons.index') }}">
                            <x-reset-button type="button" style="line-height: 1.5rem"></x-reset-button>
                        </a>
                        <x-secondary-button type="button" x-data
                            @click="window.location.href = '{{ route('marketing-coupons.create') }}'">
                            {{ __('Add Coupon ') }}
                        </x-secondary-button>
                    </div>
                </div>

                <div class="card driver-middle-section mt-4 rounded-lg ">
                    <div class="card-body p-3">
                        <div class="flex flex-direction items-end lg:items-center justify-end gap-3">
                            <div class=" w-half max-w-300 ">
                                <form action="{{ route('marketing-coupons.index') }}" class="relative tp-driver-form">
                                    <div class="flex w-full">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class=" w-full " placeholder="Search coupon">
                                        <x-search></x-search>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto overflow-y-hidden">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class=" text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Date & Time</th>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Code</th>
                                <th class="px-4 py-3 text-left">Maximum user</th>
                                <th class="px-4 py-3 text-left">Valid Time</th>
                                <th class="px-4 py-3 text-left">Discount</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class=" px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $coupon)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $coupon->created_at }}</td>
                                    <td class="px-4 py-3"><strong>{{ $coupon->title }}</strong></td>
                                    <td class="px-4 py-3"> {{ $coupon->code }}</td>
                                    <td class="px-4 py-3"> {{ $coupon->max_users }}</td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d') }} to
                                        {{ \Carbon\Carbon::parse($coupon->valid_to)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        {{ $coupon->discount_percent . '% ' . '(' . $coupon->discount_flat . ' flat' . ')' }}
                                    </td>
                                    <td class="px-4 py-3"><span
                                            class="font-medium text-yellow-600">{{ $coupon->is_enabled == 1 ? 'Enabled' : 'Disabled' }}</span>
                                    </td>
                                    <td class=" tp-btn-action ">
                                        <div class="tp-order d-flex align-items-center justify-content-center relative">
                                            <x-action-button></x-action-button>
                                            <div class="tp-order-thumb-more absolute">
                                                <a type="submit"
                                                    href="{{ route('marketing-coupons.edit', $coupon->id) }}"
                                                    class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                    <i class="fa fa-edit"></i><span>Edit</span>
                                                </a>

                                                @php $modalId = 'showModal_' . $coupon->id; @endphp
                                                <div x-data="{ showModal: false }" x-cloak>
                                                    <!-- Dropdown: Delete button inside -->
                                                    <button type="button" @click.stop="showModal = true"
                                                        class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                        <i class="fa fa-trash"
                                                            style="color:red; width:14px"></i><span>Delete</span>
                                                    </button>

                                                    <!-- Modal Outside Dropdown -->
                                                    <div x-show="showModal" @click.stop x-transition
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                                        aria-modal="true" role="dialog">
                                                        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                                            <div class="mb-4 text-center">
                                                                <h3 class="text-xl font-bold">Are you sure?</h3>
                                                                <p class="text-gray-700 mt-2 text-md">
                                                                    You want to permanently delete this coupon?
                                                                </p>
                                                            </div>

                                                            <div class="flex justify-center gap-3">
                                                                <button @click="showModal = false"
                                                                    class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                                    Cancel
                                                                </button>
                                                                <form method="POST"
                                                                    action="{{ route('marketing-coupons.destroy', $coupon->id) }}">
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

                <x-partials.navigation :data="$data" />
            </div>
        </div>
    </div>
</x-app-layout>
<script>

</script>
