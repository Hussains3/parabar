<x-guest-layout>


    {{-- Title --}}
    <x-slot name="title">Web Links</x-slot>

    <main>
        {{-- Web Links --}}
        <section class="" id="">
            <div class="bg-gradient-to-r from-violet-400 to-purple-300 py-8">
                <div class="container mx-auto px-4">
                    <h1 class="text-3xl font-bold text-center text-gray-800">Web Links</h1>
                </div>
            </div>
            <div class="bg-white py-8">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="">
                        @php
                            $links = [
                                ['Dhaka Customs Agents Association','www.dcaadhaka.org'],
                                ['Chittagong Customs Agents Association','www.cnfctg.net'],
                                ['Bhomra Costums C&F Agents Association','https://bhomracnf.com/'],
                                ["Government of the People's Republic of Bangladesh",'www.bangladesh.gov.bd'],
                                ['Ministry of Finance, Bangladesh','https://mof.gov.bd/'],
                                ['Ministry of Commerce, Bangladesh','https://mincom.gov.bd/'],
                                ['National Board of Revenue','https://nbr.gov.bd/'],
                                ['Bangladesh Customs (ASYCUDA World)','https://customs.gov.bd/index.jsf'],
                                ['Bangladesh Single Window','https://bswnbr.gov.bd/en/'],
                                ['Custom House, Benapole','https://benapolecustoms.portal.gov.bd/'],
                                ['The Federation of Bangladesh Chamber of Commerce & Industry','https://fbcci.org/'],
                                ['Jashore Chamber of Commerce and Industry','https://jashorechamber.com/'],
                                ['Bangladesh Garment Manufacturers & Exporters Association','https://www.bgmea.com.bd/'],
                                ['Bangladesh Knitwear Manufacturers & Exporters Association','https://www.bkmea.com/'],
                                ['Bangladesh Government Forms','https://forms.portal.gov.bd/'],
                                ['Bangladesh Bank','https://www.bb.org.bd/en/index.php'],
                                ['Daily Newspapers','https://www.allbanglanewspaper.xyz/'],
                                ['Online travel tax payment','https://billpay.sonalibank.com.bd/nbrTravelTax/Collection/Create/'],
                                ['Benapole Immigration port fee','https://passenger.blpa.gov.bd/'],
                                ['বাংলাদেশ কাস্টমস অনলাইন নিলাম','http://103.48.18.166/'],
                                ['ওয়্যারহাউস কোড অনুসন্ধান','https://www.dnbc.gov.bd/'],
                                ['এ চালান','https://www.achallan.gov.bd/acs/v2/general/home?ReturnUrl=%2Facs%2F'],
                            ];
                        @endphp

                        {{-- Individual links --}}
                        @foreach($links as $link)
                        <a href="{{ Str::startsWith($link[1], 'http') ? $link[1] : 'https://' . $link[1] }}"
                            class="hover:scale-105 transition block mb-2 hover:text-violet-400"
                            target="_blank">
                            <h3 class="text-lg font-semibold">{{ $link[0] }}</h3>
                        </a>
                        @endforeach
                        {{-- Individual links end --}}


                    </div>
                </div>
            </div>

        </section>

    </main>

</x-guest-layout>
