<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use Kreait\Firebase\Messaging\MulticastSendReport;

class NotificationServices
{
  public static function sendNotification(string $body, array $tokens, $title = null, $data = []): array
{
    $notification = Notification::create($title ?? 'Notification', $body);

    $firebaseCredentials = base_path('app/firebase.json');

    if (!file_exists($firebaseCredentials)) {
        return [
            'success' => false,
            'message' => 'Firebase credentials file not found.',
        ];
    }

    $messaging = (new Factory)
        ->withServiceAccount($firebaseCredentials)
        ->createMessaging();

    $message = CloudMessage::new()->withNotification($notification)->withData($data);

    try {
        /** @var MulticastSendReport $report */
        $report = $messaging->sendMulticast($message, $tokens);

        $successCount = $report->successes()->count();
        $failureCount = $report->failures()->count();
        $failedTokens = [];
        foreach ($report->getItems() as $index => $sendReport) {
            if ($sendReport->isFailure()) {
                $failedTokens[] = [
                    'token' => $tokens[$index],
                    'error' => $sendReport->error()->getMessage(),
                ];
            }
        }

        return [
            'success' => $successCount > 0,
            'success_count' => $successCount,
            'failure_count' => $failureCount,
            'failed_tokens' => $failedTokens,
            'message' => $successCount > 0
                ? "Notification sent to {$successCount} device(s)."
                : 'All notifications failed to send.',
        ];
    } catch (\Throwable $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
}
}
