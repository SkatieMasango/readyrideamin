<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enums\OrderStatus;
use App\Models\Coupon;
use App\Models\Order;

class CouponRepository extends Repository
{
    public static function model()
    {
        return Coupon::class;
    }
    public static function applyCoupon($coupon){
        return self::query()
            ->whereRaw('BINARY code = ?', [$coupon])
            ->where('is_enabled', true)
            ->where('valid_from', '<', now())
            ->where('valid_till', '>', now())
            ->first();

    }

    public static function getDiscountAmount(string $coupon, int $serviceId, float $fare)
    {
        $discountAmount = 0;
        $currentTime = now()->format('H:i:s');
            $coupon = Coupon::query()
            ->whereRaw('BINARY code = ?', [$coupon])
            ->where('is_enabled', true)
            ->where('valid_from', '<=', today())
            ->where('valid_till', '>=', today())
            ->where('start_time', '<=', $currentTime)
            ->where('expired_time', '>=', $currentTime)
            ->first();
        if (!$coupon) {
            return $discountAmount;
        }

        $riderId = auth()->user()->rider->id;

        $allowedRiderIds = $coupon->rider_ids;

        $isAllowed = false;

        if (is_null($allowedRiderIds)) {

            $isAllowed = true;
        } elseif (is_array($allowedRiderIds) && count($allowedRiderIds) === 0) {

            $isAllowed = true;
        } elseif (is_array($allowedRiderIds) && in_array($riderId, $allowedRiderIds)) {

            $isAllowed = true;
        }

        if (! $isAllowed) {
            return 0;
        }

        $couponUsage = $coupon->riders()
            ->where('rider_id', $riderId)
            ->value('usage_count') ?? 0;

        $order = OrderRepository::query()
            ->where('rider_id', $riderId)
            ->where('status', OrderStatus::COMPLETED)
            ->first();

        if (
            $coupon->max_users > $coupon->riders()->count() &&
            $coupon->max_uses_per_user > $couponUsage &&
            $coupon->minimum_cost <= $fare &&
            $coupon->maximum_cost >= $fare
        ) {
            if ($order && $coupon->is_first_travel_only == true) {
                $discountAmount = 0;
            } elseif ($coupon->discount_percent > 0) {
                $discountAmount = (float)($fare * $coupon->discount_percent) / 100;
            } elseif ($coupon->discount_flat > 0) {
                $discountAmount = (float)$coupon->discount_flat;
            }
        }

        return $discountAmount;
    }

}
