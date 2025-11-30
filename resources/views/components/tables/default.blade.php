@php
  // Table headers
  $headers = ['Order ID', 'Qty', 'Shop', 'Date', 'Status', 'Action'];

  // Table data
  $rows = [
    [
      'id' => '#RC000007',
      'qty' => 1,
      'shop' => 'Razin Shop',
      'date' => '21 Nov, 2024',
      'status' => ['text' => 'Pending', 'class' => 'text-yellow-600', 'bgClass' => 'bg-yellow-400'],
      'actions' => [
        ['url' => '#', 'icon' => 'https://demo.readyecommerce.app/assets/icons-admin/eye.svg', 'tooltip' => 'Order details'],
        ['url' => '#', 'icon' => 'https://demo.readyecommerce.app/assets/icons-admin/download-alt.svg', 'tooltip' => 'Download Invoice'],
      ],
    ],
    [
      'id' => '#RC000002',
      'qty' => 1,
      'shop' => 'Easy Life',
      'date' => '14 Nov, 2024',
      'status' => ['text' => 'On The Way', 'class' => 'text-blue-600', 'bgClass' => 'bg-blue-400'],
      'actions' => [
        ['url' => '#', 'icon' => 'https://demo.readyecommerce.app/assets/icons-admin/eye.svg', 'tooltip' => 'Order details'],
        ['url' => '#', 'icon' => 'https://demo.readyecommerce.app/assets/icons-admin/download-alt.svg', 'tooltip' => 'Download Invoice'],
      ],
    ],
  ];
@endphp

<div class="overflow-x-auto rounded-t-lg">
  <table class="min-w-full">
    <thead class="border border-gray-200 bg-gray-200">
      <tr>
        @foreach ($headers as $header)
          <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-700">
            {{ $header }}
          </th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($rows as $row)
        <tr class="border-t-none border border-gray-200 text-sm text-gray-700">
          <td class="px-6 py-4">{{ $row['id'] }}</td>
          <td class="px-6 py-4">{{ $row['qty'] }}</td>
          <td class="px-6 py-4">{{ $row['shop'] }}</td>
          <td class="px-6 py-4">{{ $row['date'] }}</td>
          <td class="px-6 py-4">
            <div class="flex items-center">
              <div class="{{ $row['status']['bgClass'] }} mr-2 h-2 w-2 animate-pulse rounded-full"></div>
              <span class="{{ $row['status']['class'] }} text-sm">{{ $row['status']['text'] }}</span>
            </div>
          </td>
          <td class="flex space-x-2 px-6 py-4">
            @foreach ($row['actions'] as $action)
              <a
                href="{{ $action['url'] }}"
                class="text-gray-500 hover:text-gray-700"
                title="{{ $action['tooltip'] }}"
              >
                <img src="{{ $action['icon'] }}" alt="Action Icon" class="h-5 w-5" />
              </a>
            @endforeach
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
