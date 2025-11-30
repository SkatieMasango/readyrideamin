<?php

return [
    'roles' => [
        'root',
        'admin',
        'tester',
        'driver',
        'rider',
    ],
    'permissions' => [
         'dashboard' => ['root','admin'],
         'announcements.index'=> ['root'],
         'announcements.create'=> ['root'],
         'announcements.store'=> ['root'],
         'announcements.edit'=> ['root'],
         'announcements.update'=> ['root'],
         'announcements.destroy'=> ['root'],
         'announcements.user'=> ['root'],

         'vehicle-category.index'=> ['root'],
         'vehicle-category.store'=> ['root'],
         'vehicle-category.delete'=> ['root'],
         'vehicle-brand.index'=> ['root'],
         'vehicle-brand.store'=> ['root'],
         'vehicle-brand.delete'=> ['root'],
         'vehicle-model.index'=> ['root'],
         'vehicle-model.store'=> ['root'],
         'vehicle-model.delete'=> ['root'],

         'marketing-coupons.index'=> ['root'],
         'marketing-coupons.create'=> ['root'],
         'marketing-coupons.store'=> ['root'],
         'marketing-coupons.edit'=> ['root'],
         'marketing-coupons.update'=> ['root'],
         'marketing-coupons.destroy'=> ['root'],

         'drivers-pending.index'=> ['root'],
         'drivers.view'=> ['root'],
         'drivers.create'=> ['root'],
         'drivers.store'=> ['root'],
         'drivers.edit'=> ['root'],
         'drivers.update'=> ['root'],
         'drivers.updateStatus'=> ['root'],
         'drivers.destroy'=> ['root'],

         'fleets.index'=> ['root'],
         'fleets.create'=> ['root'],
         'fleets.store'=> ['root'],
         'fleets.edit'=> ['root'],
         'fleets.update'=> ['root'],
         'fleets.destroy'=> ['root'],

         'payouts.index'=> ['root'],
         'payouts.view'=> ['root'],
         'payouts.create'=> ['root'],
         'payouts.store'=> ['root'],
         'payouts.edit'=> ['root'],
         'payouts.update'=> ['root'],
         'payouts.destroy'=> ['root'],

         'regions.index'=> ['root'],
         'regions.create'=> ['root'],
         'regions.store'=> ['root'],

         'riders.index'=> ['root'],
         'riders.create'=> ['root'],
         'riders.store'=> ['root'],
         'riders.edit'=> ['root'],
         'riders.update'=> ['root'],
         'riders.destroy'=> ['root'],
         'riders.updateStatus'=> ['root'],

         'services.index'=> ['root'],
         'services.create'=> ['root'],
         'services.store'=> ['root'],
         'services.edit'=> ['root'],
         'services.update'=> ['root'],
         'services.destroy'=> ['root'],

         'services-category.index'=> ['root'],
         'services-category.store'=> ['root'],
         'services-category.update'=> ['root'],
         'services-category.destroy'=> ['root'],

         'services-option.index'=> ['root'],
         'services-option.create'=> ['root'],
         'services-option.store'=> ['root'],
         'services-option.edit'=> ['root'],
         'services-option.update'=> ['root'],
         'services-option.destroy'=> ['root'],

         'profile.edit'=> ['root'],
         'profile.update'=> ['root'],
         'profile.destroy'=> ['root'],

         'home-dispatcher.index'=> ['root'],
         'home-dispatcher.store'=> ['root'],
         'home-dispatcher.edit'=> ['root'],
         'home-dispatcher.update'=> ['root'],
         'home-dispatcher.destroy'=> ['root'],
         'home-dispatcher.driver'=> ['root'],
         'home-dispatcher.fares'=> ['root'],

         'users.index'=> ['root'],
         'users.create'=> ['root'],
         'users.store'=> ['root'],
         'users.edit'=> ['root'],
         'users.update'=> ['root'],
         'users.destroy'=> ['root'],

         'payment-gateways.index'=> ['root'],
         'payment-gateways.create'=> ['root'],
         'payment-gateways.store'=> ['root'],
         'payment-gateways.edit'=> ['root'],
         'payment-gateways.update'=> ['root'],

         'sms-configs.index'=> ['root'],
         'sms-configs.create'=> ['root'],
         'sms-configs.store'=> ['root'],
         'sms-configs.edit'=> ['root'],
         'sms-configs.update'=> ['root'],

         'sos.index'=> ['root'],

         'settings.index'=> ['root'],
         'settings.store'=> ['root'],

         'cancel-reason.index'=> ['root'],
         'cancel-reason.create'=> ['root'],
         'cancel-reason.store'=> ['root'],
         'cancel-reason.edit'=> ['root'],
         'cancel-reason.update'=> ['root'],
         'cancel-reason.destroy'=> ['root'],

         'review-parameter.index'=> ['root'],
         'review-parameter.create'=> ['root'],
         'review-parameter.store'=> ['root'],
         'review-parameter.edit'=> ['root'],
         'review-parameter.update'=> ['root'],
         'review-parameter.destroy'=> ['root'],

         'user-roles.index'=> ['root'],
         'user-roles.create'=> ['root'],
         'user-roles.store'=> ['root'],
         'user-roles.edit'=> ['root'],
         'user-roles.update'=> ['root'],

         'accounting.admin'=> ['root'],

         'favourite-location-types.index'=> ['root'],
         'favourite-location-types.create'=> ['root'],
         'favourite-location-types.store'=> ['root'],
         'favourite-location-types.edit'=> ['root'],
         'favourite-location-types.update'=> ['root'],
         'favourite-location-types.destroy'=> ['root'],

         'report-types.index'=> ['root'],
         'report-types.store'=> ['root'],
         'report-types.destroy'=> ['root'],

         'complaints.index'=> ['root'],
         'complaints.show'=> ['root'],
         'complaints.updateStatus'=> ['root'],
        //  'complaints'=> ['root'],

        //  'driverwallet'=> ['root'],
        //  'drivers'=> ['root'],
        //  'fleetwallet'=> ['root'],

        //  'gateways'=> ['root'],
        //  'giftbatch'=> ['root'],
        //  'viewcodes'=> ['root'],

        //  'providerwallet'=> ['root'],

         'request.index'=> ['root'],
        //  'reviewparameter'=> ['root'],
        //  'riderwallet'=> ['root'],

        //  'smsproviders'=> ['root'],

        //  'users'=> ['root'],

    ],
];
