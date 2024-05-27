<?php

namespace App\Http\Resources;

use App\Models\NanguIsp;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiIndexNanguIspsResource extends JsonResource
{
    use ApiResponseTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->succes_response(data: NanguIsp::get()->toArray());
    }
}
