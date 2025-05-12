<?php

namespace App\Traits\Devices;

use App\Models\DeviceTemplateGpu;

trait GetDeviceGpuModuleTemplateTrait
{
    public function getGpuTemplate($deviceTemplateGpu): mixed
    {
        return DeviceTemplateGpu::find($deviceTemplateGpu);
    }
}
