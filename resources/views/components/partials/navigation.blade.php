<div class="mt-4 navigation">

    <div class="hidden d-flex sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center gap-2">
            <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                Showing
                <span class="font-medium">{{ $data->firstItem() }}</span>
                to
                <span class="font-medium">{{ $data->lastItem() }}</span>
                of
                <span class="font-medium">{{ $data->total() }}</span>
                results
            </p>
            <form method="" id="paginationDropdownForm">

                <select name="per_page" id="per_page"
                    onchange="document.getElementById('paginationDropdownForm').submit()"
                    class="text-sm border-gray-300 rounded-md px-2 py-1" style="width: 3.8rem; height:30px">
                    @php
                        $perPageOptions = [10, 25, 50, 100];
                        $currentPageValue = request('per_page');
                    @endphp
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" {{ $currentPageValue == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
                {{-- Keep existing filters in query --}}
                @foreach (request()->except('per_page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>
        </div>

        {{-- PAGE DROPDOWN --}}
        <div class="flex items-center space-x-4">

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($data->onFirstPage())
                        <span aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                    @php $dotsShown = false; @endphp

                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        @if ($i < 3)
                            <a href="{{ $data->url($i) }}">
                                <span class="bg-white border border-gray-300 flex items-center justify-center"
                                    style="width: 38px; height:38px">{{ $i }}</span>
                            </a>
                        @elseif (!$dotsShown)
                            <span class="bg-white border border-gray-300 flex items-center justify-center"
                                style="width: 38px; height:38px">...</span>
                            @php $dotsShown = true; @endphp
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </div>

</div>
