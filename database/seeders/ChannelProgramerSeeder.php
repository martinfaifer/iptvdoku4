<?php

namespace Database\Seeders;

use App\Models\ChannelProgramer;
use App\Models\ChannelProgramerContanct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelProgramerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ChannelProgramer::count() == 0) {
            $programer = ChannelProgramer::create([
                'name' => "IFC Media"
            ]);

            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Roman Revický (smlouvy + propagace)",
                'email' => "roman@ifcmedia.sk",
                'phone' => "421905663755"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "AMC"
            ]);

            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jiří Vávra (smlouvy)",
                'email' => "Jiri.Vavra@amcnetworks.com",
                'phone' => "739 670 078"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Petra Zemínová (propagace)",
                'email' => "Petra.Zeminova@amcnetworks.com",
                'phone' => "733 668 043"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "ATV CZ s.r.o"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jan David (smlouva)",
                'email' => "j.david@golfchannel.cz",
                'phone' => "777 563 208"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "AXOCOM s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Petra Poláková (smlouvy + propagace)",
                'email' => "petra.p@axocom.net",
                'phone' => "775 485 277"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "Česká televize"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jan Svoboda (smlouva)",
                'email' => "Jan.Svoboda@ceskatelevize.cz",
                'phone' => "736 531 008"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Warner Bros.Discovery"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Martin Glacner (smlouvy)",
                'email' => "martin.glacner@wbd.com",
                'phone' => "728 589 455"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Darina Cisneros (propagace)",
                'email' => "darina.cisneros@wbd.com",
                'phone' => ""
            ]);

            $programer = ChannelProgramer::create([
                'name' => "SPI INTERNATIONAL"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Adrien Gumulak (smlouva + propagace)",
                'email' => "adrian.gumulak@spiintl.com",
                'phone' => "607057016"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Channels s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Ing. Eva Sedláčková (smlouva)",
                'email' => "sedlackova.eva@channels.cz",
                'phone' => "725 933 682"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Simona Svobodová (propagace)",
                'email' => "svobodova.simona@channels.cz",
                'phone' => "725 933 682"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "DVTV"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Marie Kurečková (propagace) + smlouva kontakt Láďa",
                'email' => "marie.kureckova@dvtv.cz",
                'phone' => "608 475 423"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Extreme Sports"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jennifer Taylor",
                'email' => "Jennifer.Taylor@evelyn.com",
                'phone' => ""
            ]);


            $programer = ChannelProgramer::create([
                'name' => "FILM EUROPE, s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Tomáš Žondra (smlouva + propagace)",
                'email' => "tomas.zondra@filmeurope.eu",
                'phone' => "606 761 587"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "France 24"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Štěpánka Červenková",
                'email' => "s.cervenkova@seznam.cz",
                'phone' => "604 688 114"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "MARKÍZA - SLOVAKIA, spol. s r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Eva Pašková (smlouva + propagace)",
                'email' => "Paskova.Eva@markiza.sk",
                'phone' => "421904700030"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "TV Nova s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jakub Vopěnka",
                'email' => "Jakub.Vopenka@nova.cz",
                'phone' => "725 755 780"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Stanice O a.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Petr Horák (smlouva)",
                'email' => "Petr.Horak@ocko.tv",
                'phone' => "725 712 423"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "OKTV"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jan Hloch (smlouva)",
                'email' => "jan.hloch@oktv.cz",
                'phone' => "604 217 907"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "PK 62, a.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Martin Laštovička",
                'email' => "martin.lastovicka@pk62.cz",
                'phone' => "608 077 629, 733 533 530"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Pressdata, s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Miroslava Drozdová (smlouva)",
                'email' => "drozdova@pressdata.cz",
                'phone' => "603 418 702"
            ]);

            ChannelProgramer::create([
                'name' => "FTV Prima, spol. s r.o."
            ]);

            $programer = ChannelProgramer::create([
                'name' => "mediální skupina POHODA"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Lucie Roubíčková (smlouva + propagace)",
                'email' => "lucie.roubickova@pohodamedia.cz",
                'phone' => "603 562 245"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Seznam.cz, a.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Ivan Mikula (smlouva)",
                'email' => "Ivan.Mikula@firma.seznam.cz",
                'phone' => "606 723 347"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Lukáš Dlouhý (propagace)",
                'email' => "Lukáš Dlouhý",
                'phone' => "724 146 401"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "Perinvest Group s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Mikuláš Schlosser",
                'email' => "schlosser@perinvest.group",
                'phone' => "603 105 307"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "PHONOTEX s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Maroš Szalay (smlouva)",
                'email' => "szalay@tv8.sk",
                'phone' => ""
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Andrea Bednárová (propagace)",
                'email' => "bednarova@mediatex.sk",
                'phone' => "421 904 700 667"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "Kafka and Partners s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Ing. Dejan Sparavalo",
                'email' => "office@yachtingtv.tv",
                'phone' => "777211122"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "Hudební televize, s.r.o."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Kamila Kraftová",
                'email' => "kamila@retromusic.cz",
                'phone' => "775 011 063"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "OSA, z.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Jakub Dufek (smlouva)",
                'email' => "jakub.dufek@osa.cz",
                'phone' => "220 315 293"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Ilona Pastrňáková",
                'email' => "ilona.pastrnakova@osa.cz",
                'phone' => "220 315 367"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "DILIA, z.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Lenka Černá n. Lenka Junová (smlouva)",
                'email' => "lcerna@dilia.cz n. junova@dilia.cz",
                'phone' => "266 199 873"
            ]);

            $programer = ChannelProgramer::create([
                'name' => "INTERGRAM, z.s."
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Hana Cyhynová",
                'email' => "hana.cahynova@intergram.cz",
                'phone' => "221 871 922, 702 190 717"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "OOA-S"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Eva Štěpánková",
                'email' => "stepankova@ooas.cz",
                'phone' => "224 934 406"
            ]);


            $programer = ChannelProgramer::create([
                'name' => "OAZA"
            ]);
            ChannelProgramerContanct::create([
                'channel_programmer_id' => $programer->id,
                'name' => "Monika Stratilová ",
                'email' => "sekretariat@oaza.eu",
                'phone' => ""
            ]);
        }
    }
}
