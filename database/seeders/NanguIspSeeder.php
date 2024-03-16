<?php

namespace Database\Seeders;

use App\Models\NanguIsp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NanguIspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!NanguIsp::first()) {
            NanguIsp::create([
                'name' => "AIRWEB, spol.s.r.o.",
                'nangu_isp_id' => "3",
                'is_akcionar' => true,
                'hbo_key' => "ai",
                'crm_contract_id' => "78668"
            ]);

            NanguIsp::create([
                'name' => "ALPHA StylSoft, s.r.o.",
                'nangu_isp_id' => "20",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => "78669"
            ]);

            NanguIsp::create([
                'name' => "Altnet s.r.o.",
                'nangu_isp_id' => "9",
                'is_akcionar' => false,
                'hbo_key' => "altnet",
                'crm_contract_id' => "78670"
            ]);

            NanguIsp::create([
                'name' => "BMB-Green s.r.o.",
                'nangu_isp_id' => "12",
                'is_akcionar' => false,
                'hbo_key' => "bmb",
                'crm_contract_id' => "78671"
            ]);

            NanguIsp::create([
                'name' => "CB Computers v.o.s.",
                'nangu_isp_id' => "2",
                'is_akcionar' => true,
                'hbo_key' => "cbc",
                'crm_contract_id' => "78672"
            ]);

            NanguIsp::create([
                'name' => "Comtex",
                'nangu_isp_id' => "25",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => "78597"
            ]);

            NanguIsp::create([
                'name' => "Default",
                'nangu_isp_id' => "1",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "Futurenet ISP s.r.o.",
                'nangu_isp_id' => "14",
                'is_akcionar' => false,
                'hbo_key' => "fut",
                'crm_contract_id' => "78673"
            ]);

            NanguIsp::create([
                'name' => "Imasys s.r.o.",
                'nangu_isp_id' => "8",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "JHComp s.r.o.",
                'nangu_isp_id' => "11",
                'is_akcionar' => false,
                'hbo_key' => "jhc",
                'crm_contract_id' => "78674"
            ]);

            NanguIsp::create([
                'name' => "Kabel1",
                'nangu_isp_id' => "27",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => "78675"
            ]);

            NanguIsp::create([
                'name' => "LevnyNet",
                'nangu_isp_id' => "29",
                'is_akcionar' => false,
                'hbo_key' => "ln",
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "Logicprim, s.r.o.",
                'nangu_isp_id' => "10",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "Matrigo, s.r.o.",
                'nangu_isp_id' => "26",
                'is_akcionar' => false,
                'hbo_key' => "ma",
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "MAXTEL s.r.o.",
                'nangu_isp_id' => "15",
                'is_akcionar' => false,
                'hbo_key' => "max",
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "OMEGA plus Chrudim s.r.o.",
                'nangu_isp_id' => "7",
                'is_akcionar' => false,
                'hbo_key' => "op",
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "PETNet s.r.o.",
                'nangu_isp_id' => "21",
                'is_akcionar' => false,
                'hbo_key' => "pet",
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "Racingnet s.r.o.",
                'nangu_isp_id' => "17",
                'is_akcionar' => false,
                'hbo_key' => "rac",
                'crm_contract_id' => "79370"
            ]);

            NanguIsp::create([
                'name' => "Rtyně.net s.r.o.",
                'nangu_isp_id' => "6",
                'is_akcionar' => false,
                'hbo_key' => "rn",
                'crm_contract_id' => "78677"
            ]);

            NanguIsp::create([
                'name' => "rudolf-net.cz",
                'nangu_isp_id' => "16",
                'is_akcionar' => false,
                'hbo_key' => "rdn",
                'crm_contract_id' => "78678"
            ]);

            NanguIsp::create([
                'name' => "Rychlý drát, s.r.o",
                'nangu_isp_id' => "5",
                'is_akcionar' => false,
                'hbo_key' => "rd",
                'crm_contract_id' => "78679"
            ]);

            NanguIsp::create([
                'name' => "Sauron CZ s.r.o.",
                'nangu_isp_id' => "28",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => "78680"
            ]);

            NanguIsp::create([
                'name' => "SIMELON s.r.o.",
                'nangu_isp_id' => "23",
                'is_akcionar' => false,
                'hbo_key' => "si",
                'crm_contract_id' => "78681"
            ]);

            NanguIsp::create([
                'name' => "TaNET West s.r.o.",
                'nangu_isp_id' => "22",
                'is_akcionar' => false,
                'hbo_key' => null,
                'crm_contract_id' => null
            ]);

            NanguIsp::create([
                'name' => "Tlapnet s.r.o.",
                'nangu_isp_id' => "24",
                'is_akcionar' => true,
                'hbo_key' => "tl",
                'crm_contract_id' => "78682"
            ]);

            NanguIsp::create([
                'name' => "Trionet",
                'nangu_isp_id' => "4",
                'is_akcionar' => true,
                'hbo_key' => "tr",
                'crm_contract_id' => "67362"
            ]);

            NanguIsp::create([
                'name' => "Web4Soft Internet s.r.o.",
                'nangu_isp_id' => "18",
                'is_akcionar' => true,
                'hbo_key' => "w4",
                'crm_contract_id' => "78683"
            ]);

            NanguIsp::create([
                'name' => "Wolfstein, s.r.o.",
                'nangu_isp_id' => "19",
                'is_akcionar' => true,
                'hbo_key' => "wo",
                'crm_contract_id' => "78684"
            ]);
        }
    }
}
