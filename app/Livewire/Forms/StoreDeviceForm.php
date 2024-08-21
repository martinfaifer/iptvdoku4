<?php

namespace App\Livewire\Forms;

use App\Models\Device;
use App\Models\DeviceSnmp;
use Livewire\Form;

class StoreDeviceForm extends Form
{
    public string $name = '';

    public int $device_category_id;

    public int $device_vendor_id;

    public string $ip;

    public string|null $ipmi_ip;

    public string|null $controller_ip;

    public string|null $username;

    public string|null $password;

    public bool $is_snmp = false;

    public int|null $snmp_version;

    public string|null $snmp_private_comunity;

    public string|null $snmp_public_comunity;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:devices,name',
            ],
            'device_category_id' => [
                'required',
                'exists:device_categories,id',
            ],
            'device_vendor_id' => [
                'required',
                'exists:device_vendors,id',
            ],
            'ip' => [
                'nullable',
                'string',
                'max:255',
                'unique:devices,ip',
            ],
            'ipmi_ip' => [
                'nullable',
                'string',
                'max:255',
                'unique:devices,ipmi_ip',
            ],
            'controller_ip' => [
                'nullable',
                'string',
                'max:255',
            ],
            'username' => [
                'nullable',
                'string',
                'max:255',
            ],
            'password' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_snmp' => [
                'required',
                'boolean',
            ],
            'snmp_version' => [
                'nullable',
            ],
            'snmp_private_comunity' => [
                'nullable',
            ],
            'snmp_public_comunity' => [
                'nullable',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vyplňte popis zařízení',
            'name.string' => 'Neplatný formát',
            'name.max' => 'Maximum znaků je :max',
            'name.unique' => 'Zařízení s tímto názvem již existuje',

            'device_category_id.required' => 'Vyberte typ',
            'device_category_id.exists' => 'Neexistující typ',

            'device_vendor_id.required' => 'Vyberte výrobce',
            'device_vendor_id.exists' => 'Neexistující výrobce',

            'ip.string' => 'Neplatný formát',
            'ip.max' => 'Maxmální počet znaků je :max',
            'ip.unique' => 'IP již existuje u jiného zařízení',

            'ipmi_ip.string' => 'Neplatný formát',
            'ipmi_ip.max' => 'Maxmální počet znaků je :max',
            'ipmi_ip.unique' => 'IP již existuje u jiného zařízení',

            'controller_ip.string' => 'Neplatný formát',
            'controller_ip.max' => 'Maximální počet znaků je :max',

            'username.string' => 'Neplatný formát',
            'username.max' => 'Maximální počet znaků je :max',

            'password.string' => 'Neplatný formát',
            'password.max' => 'Maximální počet znaků je :max',

            'is_snmp.required' => 'Hodnota musí být boolean',
            'is_snmp.boolean' => 'Hodnota musí být boolean',
        ];
    }

    public function store(): Device
    {
        $this->validate();

        $device = Device::create([
            'name' => $this->name,
            'device_category_id' => $this->device_category_id,
            'device_vendor_id' => $this->device_vendor_id,
            'ip' => $this->ip,
            'ipmi_ip' => $this->ipmi_ip,
            'controller_ip' => $this->controller_ip,
            'username' => $this->username,
            'password' => $this->password,
            'is_snmp' => $this->is_snmp,
            'snmp_version' => ! is_null($this->snmp_version) ? DeviceSnmp::find($this->snmp_version)->name : $this->snmp_version,
            'snmp_private_comunity' => $this->snmp_private_comunity,
            'snmp_public_comunity' => $this->snmp_public_comunity,
            'has_channels' => [],
        ]);
        $this->reset();

        return $device;
    }
}
