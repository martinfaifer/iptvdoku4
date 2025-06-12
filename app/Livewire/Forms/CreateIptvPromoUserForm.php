<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Actions\Nangu\CreatePromoUserAction;
use App\Http\Requests\CreateIptvPromoRequest;
use App\Models\IptvPromo;

class CreateIptvPromoUserForm extends Form
{
    public ?string $name = null;
    public ?string $surname = null;
    public ?string $locality = null;
    public ?string $phone = null;
    public ?string $email = null;
    public string $expiration = "";


    public function setNextExpirationDate()
    {
        $this->expiration = now()->addDays(14)->format("Y-m-d");
    }

    public function rules(): array
    {
        return (new CreateIptvPromoRequest())->rules();
    }

    public function messages(): array
    {
        return (new CreateIptvPromoRequest())->messages();
    }

    public function submit(): IptvPromo|false
    {
        $validated = $this->validate();
        $actionResponse = (new CreatePromoUserAction())->execute(
            name: $validated['name'],
            surname: $validated['surname'],
            locality: $validated['locality'],
            phone: $validated['phone'],
            email: $validated['email'],
            expiration: $validated['expiration']
        );
        $this->reset();

        return $actionResponse;
    }
}
