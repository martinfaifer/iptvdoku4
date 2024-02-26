<?php

namespace Database\Seeders;

use App\Models\DeviceVendor;
use App\Models\DeviceVendorSnmp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceVendorSnmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DeviceVendorSnmp::first()) {
            $blankomVendor = DeviceVendor::where('name', 'Blankom')->first();
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.2.1.1.5.0",
                'description' => "device_name",
                'human_description' => "Zařízení",
                'type' => "read"
            ]);

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.2.1.1.3.0",
                    'description' => "device_uptime",
                    'human_description' => "Uptime",
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.2.50.1.2",
                'description' => "device_log",
                'human_description' => "Log",
                'type' => "read"
            ]);

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.20.20.0",
                    'description' => "device_interface_ts1_status",
                    'human_description' => "TS1 status",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.20.22.0",
                    'description' => "device_interface_ts1_bitrate",
                    'human_description' => "TS1 bitrate",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read",
                    'can_chart' => true
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.16.0",
                    'description' => "device_interface_ts1_ber",
                    'human_description' => "TS1 ber",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.18.0",
                    'description' => "device_interface_ts1_s_sat_if_level",
                    'human_description' => "TS1 DVB-S sat level",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.8.0",
                    'description' => "device_interface_ts1_dvb_t_ber",
                    'human_description' => "TS1 DVB-T ber",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.6.0",
                    'description' => "device_interface_ts1_dvb_t_if_level",
                    'human_description' => "TS1 DVB-T IF level",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.8.0",
                    'description' => "device_interface_ts1_dvb_c_ber",
                    'human_description' => "TS1 DVB-C ber",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.6.0",
                    'description' => "device_interface_ts1_dvb_c_if_level",
                    'human_description' => "TS1 DVB-C IF level",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );


            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.20.50.1.5",
                    'description' => "device_interface_ts1_services",
                    'human_description' => "TS1 servicy",
                    'interface' => "input",
                    'interface_number' => 1,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.25.20.0",
                    'description' => "device_interface_ts2_status",
                    'human_description' => "TS2 status",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.25.22.0",
                    'description' => "device_interface_ts2_bitrate",
                    'human_description' => "TS2 bitrate",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read",
                    'can_chart' => true
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.16.1",
                    'description' => "device_interface_ts2_ber",
                    'human_description' => "TS2 ber",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.18.1",
                    'description' => "device_interface_ts2_s_sat_if_level",
                    'human_description' => "TS2 DVB-S sat level",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.8.1",
                    'description' => "device_interface_ts2_dvb_t_ber",
                    'human_description' => "TS2 DVB-T ber",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.6.1",
                    'description' => "device_interface_ts2_dvb_t_if_level",
                    'human_description' => "TS2 DVBT-T sat level",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.8.1",
                    'description' => "device_interface_ts2_dvb_c_ber",
                    'human_description' => "TS2 DVB-C ber",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.6.1",
                    'description' => "device_interface_ts2_dvb_c_if_level",
                    'human_description' => "TS2 DVB-C IF level",
                    'interface' => "input",
                    'interface_number' => 2,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.25.50.1.5",
                'description' => "device_interface_ts2_services",
                'human_description' => "TS2 servicy",
                'interface' => "input",
                'interface_number' => 2,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.30.20.0",
                'description' => "device_interface_ts3_status",
                'human_description' => "TS3 status",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.30.22.0",
                'description' => "device_interface_ts3_bitrate",
                'human_description' => "TS3 bitrate",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read",
                'can_chart' => true
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.16.2",
                'description' => "device_interface_ts3_ber",
                'human_description' => "TS3 ber",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.18.2",
                'description' => "device_interface_ts3_s_sat_if_level",
                'human_description' => "TS3 DVB-S IF level",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.8.2",
                'description' => "device_interface_ts3_dvb_t_ber",
                'human_description' => "TS3 DVB-T ber",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.6.2",
                'description' => "device_interface_ts3_dvb_t_if_level",
                'human_description' => "TS3 DVB-T IF level",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.8.2",
                'description' => "device_interface_ts3_dvb_c_ber",
                'human_description' => "TS3 DVB-C ber",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.6.2",
                    'description' => "device_interface_ts3_dvb_c_if_level",
                    'human_description' => "TS3 DVB-C IF level",
                    'interface' => "input",
                    'interface_number' => 3,
                    'type' => "read"
                ]
            );

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.30.50.1.5",
                'description' => "device_interface_ts3_services",
                'human_description' => "TS3 servicy",
                'interface' => "input",
                'interface_number' => 3,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.35.20.0",
                'description' => "device_interface_ts4_status",
                'human_description' => "TS4 status",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.35.22.0",
                'description' => "device_interface_ts4_bitrate",
                'human_description' => "TS4 bitrate",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read",
                'can_chart' => true
            ]);

            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.16.3",
                'description' => "device_interface_ts4_ber",
                'human_description' => "TS4 ber",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.200.1.1.18.3",
                'description' => "device_interface_ts4_s_sat_if_level",
                'human_description' => "TS4 DVB-S sat IF level",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.8.3",
                'description' => "device_interface_ts4_dvb_t_ber",
                'human_description' => "TS4 DVB-T ber",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.210.1.1.6.3",
                'description' => "device_interface_ts4_dvb_t_if_level",
                'human_description' => "TS4 DVB-T IF level",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.8.3",
                'description' => "device_interface_ts4_dvb_c_ber",
                'human_description' => "TS4 DVB-C ber",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.220.1.1.6.3",
                'description' => "device_interface_ts4_dvb_c_if_level",
                'human_description' => "TS4 DVB-C IF level",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.10.35.50.1.5",
                'description' => "device_interface_ts4_services",
                'human_description' => "TS4 servicy",
                'interface' => "input",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.20.10.0",
                'description' => "device_interface_common_1_cam",
                'human_description' => "Common 1 CAM",
                'interface' => "output",
                'interface_number' => 1,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.20.12.0",
                'description' => "device_interface_common_1_status",
                'human_description' => "Common 1 status",
                'interface' => "output",
                'interface_number' => 1,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.20.11.0",
                'description' => "device_interface_common_1_cam_keys",
                'human_description' => "Common 1 klíče",
                'interface' => "output",
                'interface_number' => 1,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.30.10.0",
                'description' => "device_interface_common_2_cam",
                'human_description' => "Common 2 CAM",
                'interface' => "output",
                'interface_number' => 2,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.30.12.0",
                'description' => "device_interface_common_2_status",
                'human_description' => "Common 2 status",
                'interface' => "output",
                'interface_number' => 2,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.30.11.0",
                'description' => "device_interface_common_2_cam_keys",
                'human_description' => "Common 2 klíče",
                'interface' => "output",
                'interface_number' => 2,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.40.10.0",
                'description' => "device_interface_common_3_cam",
                'human_description' => "Common 3 CAM",
                'interface' => "output",
                'interface_number' => 3,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.40.12.0",
                'description' => "device_interface_common_3_status",
                'human_description' => "Common 3 status",
                'interface' => "output",
                'interface_number' => 3,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.40.11.0",
                'description' => "device_interface_common_3_cam_keys",
                'human_description' => "Common 3 klíče",
                'interface' => "output",
                'interface_number' => 3,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.50.10.0",
                'description' => "device_interface_common_4_cam",
                'human_description' => "Common 4 CAM",
                'interface' => "output",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.50.12.0",
                'description' => "device_interface_common_4_status",
                'human_description' => "Common 4 status",
                'interface' => "output",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.50.11.0",
                'description' => "device_interface_common_4_cam_keys",
                'human_description' => "Common 4 klíče",
                'interface' => "output",
                'interface_number' => 4,
                'type' => "read"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.20.14.0",
                'description' => "device_interface_common_1_reset",
                'human_description' => "Common 1 reset",
                'interface' => "output",
                'interface_number' => 1,
                'type' => "write"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.30.14.0",
                'description' => "device_interface_common_2_reset",
                'human_description' => "Common 2 reset",
                'interface' => "output",
                'interface_number' => 2,
                'type' => "write"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.40.14.0",
                'description' => "device_interface_common_3_reset",
                'human_description' => "Common 3 reset",
                'interface' => "output",
                'interface_number' => 3,
                'type' => "write"
            ]);
            DeviceVendorSnmp::create([
                'device_vendor_id' => $blankomVendor->id,
                'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.20.50.14.0",
                'description' => "device_interface_common_4_reset",
                'human_description' => "Common 4 reset",
                'interface' => "output",
                'interface_number' => 4,
                'type' => "write"
            ]);
            DeviceVendorSnmp::create(
                [
                    'device_vendor_id' => $blankomVendor->id,
                    'oid' => ".1.3.6.1.4.1.16744.2.45.1.3.60.50.0",
                    'description' => "device_restart",
                    'human_description' => "Restart zařízení",
                    'type' => "write"
                ]
            );
        }
    }
}
