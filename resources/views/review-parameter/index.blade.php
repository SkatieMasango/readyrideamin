<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Review Parameter
                    <span class="text-sm text-gray-500">
                        List of all reviews.
                    </span>
                </h5>
                <div class="">
                    <x-primary-button type="button" x-data
                        @click="window.location.href = '{{ route('review-parameter.create') }}'">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Title</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Type</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach ($reviewParameters as $reviewParameter)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><a
                                        href="{{ route('review-parameter.edit', $reviewParameter['id']) }}"><strong>{{ $reviewParameter->title }}
                                        </strong></a>
                                </td>
                                <td class="px-4 py-3"><a
                                        href="{{ route('review-parameter.edit', $reviewParameter['id']) }}">
                                        @if ($reviewParameter->type == 1)
                                            <span class="text-green-600 font-semibold">Good</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Bad</span>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
