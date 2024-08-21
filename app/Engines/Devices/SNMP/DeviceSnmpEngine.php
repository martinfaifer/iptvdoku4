<?php

namespace App\Engines\Devices\SNMP;

use App\Models\Device;
use App\Models\DeviceOid;
use App\Traits\Network\CheckIfPortIsOpenTrait;
use FreeDSx\Snmp\Oid;
use FreeDSx\Snmp\SnmpClient;
use SNMP;

class DeviceSnmpEngine
{
    use CheckIfPortIsOpenTrait;

    public false|SnmpClient $snmp = false;

    public int $webPort = 80;

    public function __construct(public Device $device)
    {
        $isPortOpen = $this->check_port($this->device->ip, $this->webPort);

        if ($isPortOpen == true) {
            if ($device->is_snmp == true) {
                $this->snmp = new SnmpClient([
                    'host' => $device->ip,
                    'version' => (int) $device->snmp_version,
                    'community' => $device->snmp_public_comunity,
                ]);
            }
        }
    }

    public function get(string|int $oid): string
    {
        try {
            return $this->snmp->getValue($oid);
        } catch (\Throwable $th) {
            return 'n/a';
        }
    }

    public function get_bulk(string|int $oid): array
    {
        $response = [];
        $maxRepetitions = 40;

        try {
            $response[] = $this->get($oid);
            for ($i = 0; $i <= $maxRepetitions; $i++) {
                $response[] = $this->get($oid.'.'.$i);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $response;
    }

    public function snmp_walk(): void
    {
        if ($this->snmp == true) {

            $walk = $this->snmp->walk();

            $walk->subtreeOnly(false);

            // Keep the walk going until there are no more OIDs left
            while ($walk->hasOids()) {
                try {
                    $oid = $walk->next();
                    echo $oid->getValue().PHP_EOL;
                    DeviceOid::firstOrCreate(
                        [
                            'device_id' => $this->device->id,
                            'oid' => $oid->getOid(),
                        ],
                        [
                            'value' => $oid->getValue(),
                        ]
                    );
                } catch (\Exception $e) {
                    // If we had an issue, display it here (network timeout, etc)
                    echo $this->device->id.' Unable to retrieve OID. '.$e->getMessage().PHP_EOL;
                }
            }
        }
    }

    public function set(string|int $oid, mixed $value): bool
    {
        try {
            // override $this->snmp
            $this->snmp = new SnmpClient([
                'host' => $this->device->ip,
                'version' => (int) $this->device->snmp_version,
                'community' => $this->device->snmp_private_comunity,
            ]);
            $this->snmp->set(Oid::fromString($oid, $value));

            return true;
        } catch (\Throwable $th) {
            if (str_contains($th->getMessage(), ' is inconsistent')) {
                return true;
            }

            return false;
        }
    }
}
