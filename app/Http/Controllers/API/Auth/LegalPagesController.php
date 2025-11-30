<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LegalPagesController extends Controller
{
    public function legalTerms()
{


      if (Auth::user()->getRoleNames()[0] === 'rider') {
        $terms = <<<TEXT
        Welcome to our Rider Terms and Conditions.

        1. Riders must possess a valid driving license.
        2. All deliveries must be completed within the scheduled time.
        3. Riders are responsible for handling goods with care.
        4. Use of helmets and safety gear is mandatory.
        5. The company is not liable for personal accidents during delivery.
        6. Riders must adhere to all traffic laws.
        7. Any misconduct or violation can lead to termination of contract.

        Thank you for being part of our delivery team.
        TEXT;
            } else {
                $terms = <<<TEXT
        Welcome to our Driver Terms and Conditions.

        1. Drivers must possess a valid driving license.
        2. All deliveries must be completed within the scheduled time.
        3. Drivers are responsible for handling goods with care.
        4. Use of helmets and safety gear is mandatory.
        5. The company is not liable for personal accidents during delivery.
        6. Drivers must adhere to all traffic laws.
        7. Any misconduct or violation can lead to termination of contract.

        Thank you for being part of our delivery team.
        TEXT;
    }

    return $this->json(' Terms and Conditions', [
         'terms' => $terms
    ]);


}

    public function privacyPolicy()
{


      if (Auth::user()->getRoleNames()[0] === 'rider') {
        $policy = <<<TEXT
        Welcome to our Rider Privacy Policy.

        1. We collect personal information such as name, contact details, and location for delivery operations.
        2. Rider data is used solely for order assignments, route optimization, and communication.
        3. We do not sell or share rider information with third parties without consent.
        4. Location tracking is used only during active delivery periods.
        5. All data is stored securely and accessed only by authorized personnel.
        6. Riders may request access or deletion of their personal data at any time.

        By using our platform, you agree to the terms of this privacy policy.
        TEXT;
            } else {
                $policy = <<<TEXT
        Welcome to our Privacy Policy.

        1. We collect personal data such as name, contact info, and usage behavior to improve our services.
        2. Your data is used for order processing, support, and service customization.
        3. We do not sell or rent your personal information to third parties.
        4. Access to your data is restricted to authorized staff only.
        5. You may request updates or removal of your data at any time.
        6. Continued use of our services implies acceptance of this policy.

        Thank you for trusting us with your information.
        TEXT;
            }

    return $this->json(' Privacy Policy', [
         'policy' => $policy
    ]);


}

}
