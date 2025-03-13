<div class="flex justify-center mt-5 text-2xl">
    <h1>STATISTIQUES DES TRANSACTIONS</h1>
</div>
<div class="flex flex-cols md:flex-row justify-around mt-10 border p-4 mb-5 gap-5">
    {{-- MTN BANQUE TO WALLET  --}}
    <div class="">
        <div class="flex justify-center items-center border-2">
            <canvas id="myChart" style="width:100%;max-width:400px"></canvas>
        </div>

        <div class="">
            <table class=" border-collapse border border-gray-200 mt-5 ">
                <thead class="bg-gray-200">
                    <tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-yellow-500">Type de transaction</th>
                        <th class="border border-gray-300 px-4 py-2 text-yellow-500">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-yellow-500">Montant total</th>
                        <th class="border border-gray-300 px-4 py-2 text-yellow-500">Date dernière transaction</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Banque to wallet réussies</td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_b2w_ok">{{ $data['mtn_b2w_ok'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_b2w_ok">
                            {{ $data['montant_b2w_ok'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_b2w_ok">
                            {{ $data['datetime_b2w_ok'] }}</td>

                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Banque to wallet échouées</td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_b2w_ko">{{ $data['mtn_b2w_ko'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_b2w_ko">
                            {{ $data['montant_b2w_ko'] }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_b2w_ko">
                            {{ $data['datetime_b2w_ko'] }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- MTN  WALLET TO  BANQUE  --}}
    <div class="">
        <div class="flex justify-center items-center border-2">
            <canvas id="myChart1" style="width:100%;max-width:400px"></canvas>
        </div>
        <div class="">
            <table class=" border-collapse border border-gray-200 mt-5">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-yellow-500">Type de transaction
                        </th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-yellow-500">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-yellow-500">Montant total</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-yellow-500">Date dernière
                            transaction</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Wallet to banque réussies </td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_w2b_ok">{{ $data['mtn_w2b_ok'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_w2b_ok">
                            {{ $data['montant_w2b_ok'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_w2b_ok">
                            {{ $data['datetime_w2b_ok'] }}</td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Wallet to banque échouées </td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_w2b_ko">{{ $data['mtn_w2b_ko'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_w2b_ko">
                            {{ $data['montant_w2b_ko'] }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_w2b_ko">
                            {{ $data['datetime_w2b_ko'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="flex flex-cols md:flex-row justify-around mt-10 border p-4 mb-5 gap-5">
    {{-- MOOV BANQUE TO WALLET  --}}
    <div class="">
        <div class="flex justify-center items-center border-2">
            <canvas id="myChart2" style="width:100%;max-width:400px"></canvas>
        </div>

        <div class="">
            <table class=" border-collapse border border-gray-200 mt-5 ">
                <thead class="bg-gray-200">
                    <tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-green-500">Transaction</th>
                        <th class="border border-gray-300 px-4 py-2 text-green-500">Quantité</th>
                        <th class="border border-gray-300 px-4 py-2 text-green-500">Montant</th>
                        <th class="border border-gray-300 px-4 py-2 text-green-500">Date</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Banque to wallet réussies</td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_b2w_ok"></td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_b2w_ok">
                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_b2w_ok">
                        </td>

                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Banque to wallet échouées</td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_b2w_ko"></td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_b2w_ko">

                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_b2w_ko">
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- MOOV  WALLET TO  BANQUE  --}}
    <div class="">
        <div class="flex justify-center items-center border-2">
            <canvas id="myChart3" style="width:100%;max-width:400px"></canvas>
        </div>
        <div class="">
            <table class=" border-collapse border border-gray-200 mt-5">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-green-500">Transaction</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-green-500">Quantité</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-green-500">Montant</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-green-500">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Wallet to banque réussies </td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_w2b_ok"></td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_w2b_ok">
                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_w2b_ok">
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">Wallet to banque échouées </td>
                        <td class="border border-gray-300 px-4 py-2" id="mtn_w2b_ko">
                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="montant_w2b_ko">
                        </td>
                        <td class="border border-gray-300 px-4 py-2" id="datetime_w2b_ko">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
