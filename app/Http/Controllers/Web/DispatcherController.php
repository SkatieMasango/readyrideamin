<?php

namespace App\Http\Controllers\Web;

use App\Enums\ComplaintStatus;
use App\Enums\OrderStatus;
use App\Enums\Status;
use App\Enums\WithdrawStatus;
use App\Events\NewRideAvailable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Rider\OrderResource;
use App\Models\Coupon;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\Settings;
use App\Models\Wallet;
use App\Repositories\ComplaintRepository;
use App\Repositories\CouponRepository;
use App\Repositories\DriverRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RiderRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Repositories\WithdrawRepository;
use App\Services\DriverService;
use Illuminate\Http\Request;
use App\Services\GoogleService;
use App\Services\Models\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DispatcherController extends Controller
{

    public function dashboard(){

        $complaints = ComplaintRepository::getComplaintsWithStatus(ComplaintStatus::UNDER_INVESTIGATION);
        $approvedDrivers = DriverRepository::getApprovedDrivers(Status::APPROVED);
        $totalRiders = RiderRepository::getTotalRiders();
        $realTimeRiders = RiderRepository::getRealTimeRider();

        $acceptOrder = OrderRepository::getAll()->where('status',OrderStatus::ACCEPTED);
        $onWayOrder = OrderRepository::getAll()->where('status',OrderStatus::GO_TO_PICKUP);
        $confirmArrivalOrder = OrderRepository::getAll()->where('status',OrderStatus::CONFIRM_ARRIVAL);
        $pickedOrder = OrderRepository::getAll()->where('status',OrderStatus::PICKED_UP);
        $startRideOrder = OrderRepository::getAll()->where('status',OrderStatus::START_RIDE);
        $completedOrder = OrderRepository::getAll()->where('status',OrderStatus::COMPLETED);
        $cancelledOrder = OrderRepository::getAll()->where('status',OrderStatus::CANCELLED);


        $root = UserRepository::getRole('root');
        $totalEarning = TransactionRepository::getAll()->sum('amount');
        $commission = WalletRepository::getCommission($root->id);
        $totalCommision =TransactionRepository::getAll()->where('transaction','credit')->sum('amount');
        $completeWithdraw = WithdrawRepository::getAll()->where('status', WithdrawStatus::COMPLETED)->sum('amount');
        $pendingWithdraw = WithdrawRepository::getAll()->where('status', WithdrawStatus::PENDING)->sum('amount');
        $rejectedWithdraw = WithdrawRepository::getAll()->where('status', WithdrawStatus::REJECTED)->sum('amount');
        $orders = OrderRepository::getLatest();

        $topDrivers = OrderRepository::getTopDrivers();

        $counts = OrderRepository::getRealTimeRiders();
        $hourlyCounts = $counts->pluck('c', 'h')->toArray();

        $dataPoints = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $dataPoints[] = $hourlyCounts[$hour] ?? 0;
        }

        $filterOrders =OrderRepository::getFilterReport();


        $cronIsRunning = false;
        $path = storage_path('app/cron_last_run.txt');

        if (File::exists($path)) {
            $lastRun = Carbon::parse(File::get($path));
            $cronIsRunning = $lastRun->gt(now()->subMinutes(2));
        }

        return view('dashboard', compact('filterOrders','realTimeRiders','totalRiders','complaints','approvedDrivers','acceptOrder','onWayOrder','confirmArrivalOrder','pickedOrder','startRideOrder','completedOrder','cancelledOrder','commission','totalEarning','completeWithdraw','pendingWithdraw','totalCommision','rejectedWithdraw','orders','topDrivers','dataPoints','cronIsRunning'));
    }
    public function index(){

          $riders = Rider::with('user')
        ->whereHas('user', function ($query) {
            $query->where('status', 'approved');
        })
        ->orderBy('created_at', 'desc')
        ->get();
        $services = Service::all();
        return view('home-dispatcher.index', compact('riders','services'));
    }

    public function getDriversByService($serviceId)
{

    $drivers = Driver::where('service_id', $serviceId)
                ->with('user') // assuming relation to user
                ->get();

    return response()->json($drivers);
}
   public function getFares(OrderRequest $request): JsonResponse
    {
        $pickupLocation = $request->get('pickup_location');
        $dropLocation = $request->get('drop_location');

        $services = Service::all();

        if (! $services) {
            return errorResponse('No services available for your location');
        }
        // get distance and duration
        $matrix = GoogleService::getDistanceAndDuration($pickupLocation[0], $pickupLocation[1], $dropLocation[0], $dropLocation[1]);
        if (! $matrix) {
            return errorResponse(message: 'No route found');
        }

        $serviceOptionsFee = 0;
        if ($request->service_option_ids) {
            $serviceOptionsFee = ServiceOption::whereIn('id', $request->service_option_ids)->sum('additional_fee');
        }

        $fares = [];
        foreach ($services as $service) {
            $serviceFare = ServiceRepository::calculateFare(serviceId: $service->id, distance: $matrix['distance'], duration: $matrix['duration']);
            $fare = $serviceFare + (float) $serviceOptionsFee;
            if ($fare < (float) $service->minimum_fee) {
                $fare = (float) $service->minimum_fee;
            }

            $fares[] = [
                'id' => $service->id,
                'name' => $service->name,
                'logo' => $service->logoPath,
                'person_capacity' => $service->person_capacity,
                'minimum_fee' => (float) $service->minimum_fee,
                'service_fare' => $serviceFare,
                'cost_after_coupon' => $serviceFare,
                'additional_fee' => (float) $serviceOptionsFee,
                //                'total_fare' => round($fare, (int)$service->rounding_factor),
                'total_fare' => $fare,
            ];

        }

        return successResponse([
            'services' => $fares,
            'distance' => $matrix['distanceText'],
            'duration' => $matrix['durationText'],
        ], 'Successfully retrieve services for your location');
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $rider = Rider::query()->where('user_id', $request->user_id)->first();
        if (! $rider) {
            return errorResponse('Inactive Rider');
        }
        $pickupLocation = $request->get('pickup_location');
        $dropLocation = $request->get('drop_location');
        $waitLocation = $request->get('wait_location');
        //  get selected service
        $service = Service::find($request->service_id);
        if (! $service) {
            return errorResponse('Selected invalid service.');
        }
        // get distance and duration
        $matrix = GoogleService::getDistanceAndDuration($pickupLocation[0], $pickupLocation[1], $dropLocation[0], $dropLocation[1]);
        if (! $matrix) {
            return errorResponse(message: 'No route found');
        }

        // Service options fees
        $serviceOptionsFee = 0;
        if ($request->service_option_ids) {
            $serviceOptionsFee = ServiceOption::whereIn('id', $request->service_option_ids)->sum('additional_fee');
        }

        $serviceFare = ServiceRepository::calculateFare(serviceId: $service->id, distance: $matrix['distance'], duration: $matrix['duration']);
        $couponValue = 0;
        $coupon = null;
        if ($request->coupon_code) {
            $coupon = Coupon::query()->where('code', $request->coupon_code)->first();
            $couponValue = CouponRepository::getDiscountAmount($request->coupon_code, $service->id, $serviceFare);
        }
        $costAfterCoupon = $serviceFare - $couponValue;
        $fare = $costAfterCoupon + (float) $serviceOptionsFee;
        if ($fare < (float) $service->minimum_fee) {
            $fare = (float) $service->minimum_fee;
        }
        // create Order
        $data = [
            'rider_id' => $rider->id,
            'service_id' => $service->id,
            'coupon_id' => $coupon?->id,
            'status' => OrderStatus::PENDING,
            'distance_best' => $matrix['distance'],
            'duration_best' => $matrix['duration'],
            'service_options_cost' => $serviceOptionsFee,
            'points' => json_encode(['pickup_location' => $pickupLocation, 'drop_location' => $dropLocation, 'wait_location' => $waitLocation]),
            'addresses' => json_encode(['pickup_address' => $request->pickup_address, 'drop_address' => $request->drop_address, 'wait_address' => $request->wait_address]),
            'cost_after_coupon' => $costAfterCoupon,
            'payment_mode' => $request->payment_mode,
            'cost_best' => $fare,
        ];
        $order = OrderService::initiateOrder($data);
        if (! $order) {
            return errorResponse('Failed to create order.');
        }

        $location = GoogleService::geocodeAddress($request->pickup_address);

        $availableDrivers = DriverService::findNearbyDrivers($location['lat'], $location['lng']);
        if ($request->service_option_ids) {
            $order->serviceOptions()->sync($request->service_option_ids);
        }

        $nearestDriver = null;

        foreach ($availableDrivers as $driver) {
            $nearestDriver = DriverService::findNearestDriver(
                latitude: $location['lat'],
                longitude: $location['lng'],
            );
        }

        if(!$nearestDriver) {
            return errorResponse('No driver found');
        }

        $setting = Settings::query()->where('key', 'site_config')->value('value');
        $generalSettings = $setting ? json_decode($setting) : [];
        $commission = isset($generalSettings->commision) ? (float) $generalSettings->commision : 0;
        $commissionAmount = ($fare * $commission) / 100;

        $nearestDrivers = DriverService::findNearestDriverWeb(
            latitude: $location['lat'],
            longitude: $location['lng']
        );

        if ($nearestDrivers->isEmpty()) {
            return errorResponse('No nearby drivers found');
        }

        foreach ($nearestDrivers as $nearestDriver) {
            $driver = Driver::where('id', $nearestDriver->id)->first();

            if (!$driver) {
                continue;
            }

            $wallet = Wallet::where('user_id', $driver->user_id)->first();

            if ($wallet && $wallet->amount >= $commissionAmount) {

                \DB::table('driver_order')->insert([
                    'order_id'   => $order->id,
                    'driver_id'  => $driver->id,
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                event(new NewRideAvailable($order, $driver->user_id));


                return successResponse([
                    'order'  => OrderResource::make($order),
                    'driver' => $driver,
                ]);
            }
        }

        return errorResponse('No driver has sufficient wallet balance');

     }

        public function generateInvoice($id)
        {
            $order = Order::findOrFail($id);
            $pdf = PDF::loadView('order-invoice', [
                'order' => $order,

            ])->setPaper('a4', 'portrait');

            return $pdf->download('aaa' . '.pdf');
        }

        public function login(Request $request){
           $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

}
