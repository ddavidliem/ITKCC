<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_perusahaan' => $this->nama_perusahaan,
            'bidang_perusahaan' => $this->bidang_perusahaan,
            'website' => $this->website,
            'tahun_berdiri' => $this->tahun_berdiri,
            'kantor_pusat' => $this->kantor_pusat,
            'kota' => $this->kota,
            'alamat' => $this->alamat,
            'provinsi' => $this->provinsi,
            'kode_pos' => $this->kode_pos,
        ];
    }
}
