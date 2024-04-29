<?php

namespace App\Livewire\Forms;

use App\Models\NanguIspTagToChannelPackage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsTagToChannelPackageForm extends Form
{
    public ?NanguIspTagToChannelPackage $nanguIspTagToChannelPackage;

    #[Validate('required', message: 'Vyberte poskytovatele')]
    #[Validate('exists:nangu_isps,id', message: 'Neexistující poskytovatel')]
    public string $nangu_isp_id = '';

    #[Validate('required', message: 'Vyberte štítek')]
    #[Validate('exists:tags,id', message: 'Neexistující štítek')]
    public string $tag_id = '';

    #[Validate('required', message: 'Balíček')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $channelPackageName = '';

    public function setNanguIspTagToChannelPackage($nanguIspTagToChannelPackage)
    {
        $this->nanguIspTagToChannelPackage = $nanguIspTagToChannelPackage;
        $this->nangu_isp_id = $nanguIspTagToChannelPackage->nangu_isp_id;
        $this->tag_id = $nanguIspTagToChannelPackage->tag_id;
        $this->channelPackageName = $nanguIspTagToChannelPackage->nangu_channel_package_name;
    }

    public function update()
    {
        $this->validate();

        $this->nanguIspTagToChannelPackage->update([
            'nangu_isp_id' => $this->nangu_isp_id,
            'tag_id' => $this->tag_id,
            'nangu_channel_package_name' => $this->channelPackageName,
        ]);

        $this->resetErrorBag();
    }
}
