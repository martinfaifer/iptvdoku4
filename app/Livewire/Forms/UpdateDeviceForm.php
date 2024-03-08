<?php

namespace App\Livewire\Forms;

use App\Models\Device;
use App\Models\DeviceSnmp;
use Livewire\Form;

class UpdateDeviceForm extends Form
{
    public ?Device $device;

    public string $name = '';

    public $device_category_id;

    public $device_vendor_id;

    public $ip;

    public $controller_ip;

    public $username;

    public $password;

    public bool $is_snmp = false;

    public $snmp_version;

    public $snmp_private_comunity;

    public $snmp_public_comunity;

    public function rules()
    {
        return [
            'name' => [
                'required', 'string', 'max:100', 'unique:devices,name,'.$this->device->id,
            ],
            'device_category_id' => [
                'required', 'exists:device_categories,id',
            ],
            'device_vendor_id' => [
                'required', 'exists:device_vendors,id',
            ],
            'ip' => [
                'nullable', 'string', 'max:255', 'unique:devices,ip,'.$this->device->id,
            ],
            'controller_ip' => [
                'nullable', 'string', 'max:255',
            ],
            'username' => [
                'nullable', 'string', 'max:255',
            ],
            'password' => [
                'nullable', 'string', 'max:255',
            ],
            'is_snmp' => [
                'required', 'boolean',
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

    public function messages()
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

    public function setDevice($device)
    {
        $this->device = $device;
        $this->name = $device->name;
        $this->ip = $device->ip;
        $this->device_category_id = $device->device_category_id;
        $this->device_vendor_id = $device->device_vendor_id;
        $this->controller_ip = $device->controller_ip;
        $this->username = $device->username;
        $this->password = $device->password;
        $this->is_snmp = $device->is_snmp;
        $this->snmp_version = ! is_null($device->snmp_version) ? DeviceSnmp::where('name', $device->snmp_version)->first()->id : null;
        $this->snmp_private_comunity = $device->snmp_private_comunity;
        $this->snmp_public_comunity = $device->snmp_public_comunity;
    }

    public function update(): void
    {
        $this->validate();

        $this->device->update([
            'name' => $this->name,
            'device_category_id' => $this->device_category_id,
            'device_vendor_id' => $this->device_vendor_id,
            'ip' => $this->ip,
            'controller_ip' => $this->controller_ip,
            'username' => $this->username,
            'password' => $this->password,
            'is_snmp' => $this->is_snmp,
            'snmp_version' => ! is_null($this->snmp_version) ? DeviceSnmp::find($this->snmp_version)->name : $this->snmp_version,
            'snmp_private_comunity' => $this->snmp_private_comunity,
            'snmp_public_comunity' => $this->snmp_public_comunity,
        ]);

        $this->reset();
    }
}
