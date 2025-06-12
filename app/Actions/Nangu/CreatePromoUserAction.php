<?php

namespace App\Actions\Nangu;

use App\Models\IptvPromo;
use Illuminate\Support\Facades\Auth;
use App\Services\Api\NanguTv\NanguIdentityService;
use App\Actions\Nangu\GenerateSubscriberCodeAction;
use App\Services\Api\NanguTv\NanguSubscribersService;
use App\Services\Api\NanguTv\NanguSubscriptionsService;

class CreatePromoUserAction
{
    // main action for triggering all sub services which will create a customer
    public function execute(
        ?string $name = null,
        ?string $surname = null,
        ?string $locality = null,
        ?string $phone = null,
        ?string $email = null,
        string $expiration
    ): IptvPromo|false {

        // try {
        $ispCode = config('services.api.iptv_promo.ispCode');
        // generate subscriberCode
        $generatedSubscriberCode = (new GenerateSubscriberCodeAction())->execute();
        info('generatedSubscriberCode', [$generatedSubscriberCode]);
        // create subscriber
        (new NanguSubscribersService())->create(subscriberCode: $generatedSubscriberCode, ispCode: $ispCode);
        // create subscription
        $subscriptionCode = (new NanguSubscriptionsService())->create(subscriberCode: $generatedSubscriberCode, ispCode: $ispCode);
        // create identity
        $identityId = (new NanguIdentityService())->create(subscriberCode: $generatedSubscriberCode, ispCode: $ispCode);
        // assign identity to subscriber
        (new NanguIdentityService())->assign(subscriptionStbAccountCode: $subscriptionCode, identityId: $identityId, ispCode: $ispCode);
        // enable subscription
        (new NanguSubscriptionsService())->enable(subscriptionCode: $subscriptionCode, ispCode: $ispCode);

        $promoUser = IptvPromo::create([
            'name' => $name,
            'surname' => $surname,
            'locality' => $locality,
            'phone' => $phone,
            'email' => $email,
            'creator' => Auth::user()->email,
            'expiration' => $expiration,
            'subscriberCode' => $generatedSubscriberCode,
            'ispCode' => $ispCode,
            'subscriptionCode' => $subscriptionCode,
            'subscriptionStbAccountCode' => $subscriptionCode,
            'username' => $generatedSubscriberCode,
            'password' => $generatedSubscriberCode,
            'identityId' => $identityId,
            'expired' => false
        ]);

        return $promoUser;
        // } catch (\Throwable $th) {
        //     info('iptv_promo_log', [$th]);
        //     return false;
        // }
    }
}
