<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Promotional;
use App\Models\Rider;
use App\Models\User;
use App\Repositories\CouponRepository;
use App\Repositories\MediaRepository;
use App\Repositories\RiderRepository;
use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarketingController extends Controller
{
    public function coupons(Request $request): View
    {
        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        $coupons = CouponRepository::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%");
            })->whereNull('rider_ids')->paginate($perPage);

        return view('marketing.coupons', [
            'data' => $coupons,
        ]);

    }

    public function couponCreate()
    {
        return view('marketing.coupons-create');
    }

    public function couponStore(Request $request)
    {
        $rules = [
            'code' => 'required|string|unique:coupons|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_users' => 'required|integer|min:0',
            'max_uses_per_user' => 'required|integer|min:1',
            'minimum_cost' => 'required|numeric|min:0',
            'maximum_cost' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'start_time' => 'required',
            'valid_till' => 'required|date|after_or_equal:valid_from',
            'expired_time' => 'required|after:start_time',
            'discount_type' => 'required|in:percentage,flat',
            'discount_percent' => 'required_if:discount_type,percentage|nullable|integer|min:1|max:100',
            'discount_flat' => 'required_if:discount_type,flat|nullable|numeric|min:1',
            'is_enabled' => 'boolean',
            'is_first_travel_only' => 'boolean',
        ];

        $messages = [
            'discount_percent.required_if' => 'The discount percent is required.',
            'discount_flat.required_if' => 'Discount flat is required.',
        ];

        $validated = $request->validate($rules, $messages);

        Coupon::create($validated);

        return redirect()->route('marketing-coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function couponEdit($id)
    {
        $users = User::all()->map(fn($user) => [
            'value' => $user->id,
            'name' => $user->name,
        ]);

        $coupon = Coupon::find($id);

        return view('marketing.coupons-edit', compact('coupon','users'));
    }
    public function couponUpdate(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $rules = [
             'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons')->ignore($coupon->id),
            ],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_users' => 'required|integer|min:0',
            'max_uses_per_user' => 'required|integer|min:1',
            'minimum_cost' => 'required|numeric|min:0',
            'maximum_cost' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'start_time' => 'required',
            'valid_till' => 'required|date|after_or_equal:valid_from',
            'expired_time' => 'required|after:start_time',
            'discount_type' => 'required|in:percentage,flat',
            'discount_percent' => 'required_if:discount_type,percentage|nullable|integer|min:1|max:100',
            'discount_flat' => 'required_if:discount_type,flat|nullable|numeric|min:1',
            'is_enabled' => 'boolean',
            'is_first_travel_only' => 'boolean',
        ];

        $messages = [
            'discount_percent.required_if' => 'The discount percent is required.',
            'discount_flat.required_if' => 'Discount flat is required.',
        ];

        $validated = $request->validate($rules, $messages);

        $validated['is_enabled'] = $request->boolean('is_enabled');
        $validated['is_first_travel_only'] = $request->boolean('is_first_travel_only');

        $coupon->update($validated);

        return redirect()->route('marketing-coupons.index')->with('success', 'Coupon updated successfully!');
    }
    public function couponDestroy( $id)
    {
        $coupon = coupon::find($id);
        $coupon->delete();
        return redirect()->route('marketing-coupons.index')->with('success', 'Coupons deleted successfully!');
    }


    public function giftCards(Request $request): View
    {

        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        $giftCards = CouponRepository::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%");
            })->whereNotNull('rider_ids')->paginate($perPage);

        return view('marketing.gift-cards', [
            'data' => $giftCards,
        ]);

    }

    public function giftCardCreate()
    {
        return view('marketing.gift-cards-create');
    }
    public function getUsersByType($type)
    {
        if($type === 'riders') {
            $riders = RiderRepository::query()->with('user')->get();
        }
        $riders = $riders->map(function ($rider) {
            $name = $rider->user->name ?? 'N/A';
            return [
                'value' => $rider->id ,
                'name' => trim($name ),
            ];
        });

        return response()->json($riders);
    }
    public function giftCardStore(Request $request)
    {

       $rules = [
            'code' => 'required|string|unique:coupons|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_uses_per_user' => 'required|integer|min:1',
            'minimum_cost' => 'required|numeric|min:0',
            'maximum_cost' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'start_time' => 'required',
            'valid_till' => 'required|date|after_or_equal:valid_from',
            'expired_time' => 'required',
            'discount_type' => 'required|in:percentage,flat',
            'discount_percent' => 'required_if:discount_type,percentage|nullable|integer|min:1|max:100',
            'discount_flat' => 'required_if:discount_type,flat|nullable|numeric|min:1',
            'rider_ids' => 'required|array',
            'is_enabled' => 'boolean',
            'is_notified' => 'boolean',
            'is_first_travel_only' => 'boolean',
        ];

        $messages = [
            'discount_percent.required_if' => 'The discount percent is required.',
            'discount_flat.required_if' => 'Discount flat is required.',
        ];

        $validated = $request->validate($rules, $messages);

        $validated['rider_ids'] = array_map('intval', $request->rider_ids ?? []);

        Coupon::create($validated);

        if($validated['is_notified'] == true){
            $title = $validated['title'];
            $body  = $validated['description'];

            $userIds = RiderRepository::query()->whereIn('id', $validated['rider_ids'])->pluck('user_id')->toArray();
            $tokens = UserRepository::query()
                ->whereIn('id', $userIds)
                ->whereNotNull('device_token')
                ->pluck('device_token')
                ->toArray();

            if (!empty($tokens)) {
                NotificationServices::sendNotification($body, $tokens, $title);
            }
        }



        return redirect()->route('marketing-gift-cards.index')->with('success', 'Gift Card created successfully.');
    }

    public function giftCardEdit($id)
    {
        $users = Rider::with('user')->get()->map(fn($user) => [
            'value' => $user->user_id,
            'name' => $user->user->name ,
        ]);

        $giftCard = Coupon::find($id);

        return view('marketing.gift-cards-edit', compact('giftCard','users'));
    }
    public function giftCardUpdate(Request $request, $id)
    {
        $giftCard = Coupon::findOrFail($id);

        $rules = [
             'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons')->ignore($giftCard->id),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            // 'max_users' => 'required|integer|min:0',
            'max_uses_per_user' => 'required|integer|min:1',
            'minimum_cost' => 'required|numeric|min:0',
            'maximum_cost' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'start_time' => 'required',
            'valid_till' => 'required|date|after_or_equal:valid_from',
            'expired_time' => 'required|after:start_time',
            'discount_type' => 'required|in:percentage,flat',
            'discount_percent' => 'required_if:discount_type,percentage|nullable|integer|min:1|max:100',
            'discount_flat' => 'required_if:discount_type,flat|nullable|numeric|min:1',
            'rider_ids' => 'nullable|array',
            'is_enabled' => 'sometimes|boolean',
            'is_notified' => 'boolean',
            'is_first_travel_only' => 'sometimes|boolean',
        ];
        $messages = [
            'discount_percent.required_if' => 'The discount percent is required.',
            'discount_flat.required_if' => 'Discount flat is required.',
        ];

        $validated = $request->validate($rules, $messages);

        $validated['is_enabled'] = $request->boolean('is_enabled');
        $validated['is_first_travel_only'] = $request->boolean('is_first_travel_only');
        $validated['rider_ids'] = array_unique(array_map('intval', $request->rider_ids ?? []));

        $giftCard->update($validated);

        if($validated['is_notified'] == true){
            $title = $validated['title'];
            $body  = $validated['description'];

            $userIds = RiderRepository::query()->whereIn('id', $validated['rider_ids'])->pluck('user_id')->toArray();
            $tokens = UserRepository::query()
                ->whereIn('id', $userIds)
                ->whereNotNull('device_token')
                ->pluck('device_token')
                ->toArray();

            if (!empty($tokens)) {
                NotificationServices::sendNotification($body, $tokens, $title);
            }
        }

        return redirect()->route('marketing-gift-cards.index')->with('success', 'Gift Card updated successfully!');
    }
    public function giftCardDestroy( $id)
    {
        $giftCard = Coupon::find($id);
        $giftCard->delete();
        return redirect()->route('marketing-gift-cards.index')->with('success', 'Gift Card deleted successfully!');
    }

    public function PromoIndex(){
        $promos = Promotional::with('media')->get();
        return view('marketing.promotionals', compact('promos'));
    }
    public function PromoStore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $promo = Promotional::create();
        MediaRepository::storeByRequest($request->file('image'), '/promotional_image', 'promotional_picture', $promo);

        return redirect()->route('marketing-promotionals.index')->with('success', 'Promotional image created successfully.');

    }

    public function PromotDestroy($id)
    {
        $promo = Promotional::with('media')->findOrFail($id);

        if ($promo->media) {
            Storage::disk('public')->delete($promo->media->path);
            $promo->media->delete();
        }

        $promo->delete();
        return redirect()->route('marketing-promotionals.index')
            ->with('success', 'Promotional image deleted successfully.');
    }

}
