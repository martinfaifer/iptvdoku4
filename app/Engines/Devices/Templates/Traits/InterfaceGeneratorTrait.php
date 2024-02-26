<?php

namespace App\Engines\Devices\Templates\Traits;

use App\Models\DeviceVendorSnmp;

trait InterfaceGeneratorTrait
{

    public array $listOfInterfacePosibilities = [
        'inInterfaceName' => [
            'default' => "",
            'replace' => "%inInterfaceName%",
            "human_description" => "Název"
        ],
        'hasInInterfaceFrequency' => [
            'default' => false,
            'replace' => "%frequency%",
            "human_description" => "Frekvence"
        ],
        'hasInInterfaceDvb' => [
            'default' => false,
            'replace' => "%dvb%",
            "human_description" => "DVB"
        ],
        'hasInInterfaceSatelite' => [
            'default' => false,
            'replace' => "%satelite%",
            "human_description" => "Satelit"
        ],
        'hasInInterfacepolarization' => [
            'default' => false,
            'replace' => "%polarization%",
            "human_description" => "Polarizace"
        ],
        'hasInInterfacepolarizationVoltage' => [
            'default' => false,
            'replace' => "%polarizationVolatage%",
            "human_description" => "Polarizace ( V )"
        ],
        'hasInInterfaceSymbolRate' => [
            'default' => false,
            'replace' => "%symbolRate%",
            "human_description" => "Symbol rate"
        ],
        'hasInInterfaceFec' => [
            'default' => false,
            'replace' => "%fec%",
            "human_description" => "FEC"
        ],
        'hasInInterfaceLnb' => [
            'default' => false,
            'replace' => "%lnb%",
            "human_description" => "LNB"
        ],
        'hasInInterfaceLnb22' => [
            'default' => false,
            'replace' => "%lnb22%",
            "human_description" => "LNB22KV"
        ],
        'hasIntinterfaceSatCard' => [
            'default' => false,
            'replace' => "%satCard%",
            "human_description" => "Satelitní karta"
        ],
        'outInterfaceName' => [
            'default' => "",
            'replace' => "%outInterfaceName%",
            "human_description" => "Název"
        ],
        'hasOutInterfaceInInterface' => [
            'default' => false,
            'replace' => "%OutInterfaceInInterface%",
            "human_description" => "Vazba na vstupní interface"
        ],
        'hasOutInterfaceSatCard' => [
            'default' => false,
            'replace' => "%satCard%",
            "human_description" => "Satelitní karta"
        ],

        'moduleName' => [
            'default' => "",
            'replace' => "%moduleName%",
            "human_description" => "Název"
        ],
    ];

    public array $linkToChannels = [];
    public array $linkToDevices = [];
    public array $linkToSatelitCards = [];

    public function generate_interface(array $interfaceData, int $interfaceNumber, int $deviceVendorId, string $interfaceType): array
    {
        $interface = [];
        foreach ($this->listOfInterfacePosibilities as $key => $posibility) {
            if (array_key_exists($key, $interfaceData)) {
                if ($posibility['default'] != $interfaceData[$key]) {
                    if (!is_bool($interfaceData[$key])) {
                        $interface[$posibility['human_description']] = $interfaceData[$key] . " " . $interfaceNumber;
                    } else {
                        $interface[$posibility['human_description']] = $posibility['replace'];
                    }
                }
            }
        }
        $interface['Vazba na kanály'] = [];
        $interface['Vazba na zařízení'] = [];
        $interface['Vazba na satelitní karty'] = [];

        $snmps = DeviceVendorSnmp
            ::where('device_vendor_id', $deviceVendorId)
            ->where('interface', $interfaceType)
            ->where('interface_number', $interfaceNumber)
            ->get();

        if (!$snmps->isEmpty()) {
            foreach ($snmps as $snmp) {
                $interface['snmp'][] = [
                    'oid' => $snmp->oid,
                    'human_description' => $snmp->human_description,
                    'value' => "",
                    'type' => $snmp->type
                ];
            }
        }

        return $interface;
    }
}
