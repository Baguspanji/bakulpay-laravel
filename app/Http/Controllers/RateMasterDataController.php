<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use App\Models\RateMasterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class RateMasterDataController extends Controller
{


    public function createFormRateMasterData()
    {
        $rate_master_data = RateMasterData::all();

        return view('master_data.form_transactionmd', ['rate_master_data' => $rate_master_data]);
    }

    // public function submitForm(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama_bank' => 'required|string',
    //         'type' => 'required|in:Top Up,Withdraw',
    //         'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'nama' => 'nullable|required_if:type,Withdraw',
    //         'no_rekening' => 'nullable|required_if:type,Withdraw',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');

    //     $iconURL = URL::to('/') . Storage::url($iconPath);

    //     $transactionMD = new RateMasterData();
    //     $transactionMD->nama_bank = $request->nama_bank;
    //     $transactionMD->type = $request->type;

    //     if ($request->type == 'Withdraw') {
    //         $transactionMD->nama = $request->nama;
    //         $transactionMD->no_rekening = $request->no_rekening;
    //     }

    //     $transactionMD->icons = $iconURL;
    //     $transactionMD->save();

    //     return redirect()->route('transactionmd')
    //         ->with('success', 'Data transaksi master berhasil ditambahkan!')
    //         ->with('iconURL', $iconURL);
    // }

    // public function submitForm(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama_bank' => 'required|string',
    //         'type' => 'required|in:Top Up,Withdraw',
    //         'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'nama' => 'nullable|required_if:type,Withdraw',
    //         'no_rekening' => 'nullable|required_if:type,Withdraw',
    //         'nama_blockchain.*' => 'nullable|string', // Validasi untuk setiap input blockchain
    //         'rekening_wallet.*' => 'nullable|string', // Validasi untuk setiap input rekening_wallet
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');
    //     $iconURL = URL::to('/') . Storage::url($iconPath);

    //     $transactionMD = new RateMasterData();
    //     $transactionMD->nama_bank = $request->nama_bank;
    //     $transactionMD->type = $request->type;

    //     if ($request->type == 'Withdraw') {
    //         $transactionMD->nama = $request->nama;
    //         $transactionMD->no_rekening = $request->no_rekening;
    //     }

    //     $transactionMD->icons = $iconURL;
    //     $transactionMD->save();

    //     // Menyimpan data blockchain ke tabel kedua (blockchain_data)
    //     if ($request->has('nama_blockchain')) {
    //         foreach ($request->nama_blockchain as $key => $namaBlockchain) {
    //             $blockchainData = new Blockchain();
    //             $blockchainData->id_rate = $transactionMD->id; // Menggunakan id dari record yang baru dibuat di RateMasterData
    //             $blockchainData->nama_bank = $transactionMD->nama_bank;
    //             $blockchainData->type = $transactionMD->type;
    //             $blockchainData->nama_blockchain = $namaBlockchain;

    //             // Jika jenis 'Top Up', nama dan no_rekening tidak perlu disimpan di 'blockchain_data'
    //             if ($transactionMD->type == 'Withdraw') {
    //                 $blockchainData->rekening_wallet = $request->rekening_wallet[$key];
    //             }

    //             $blockchainData->save();
    //         }
    //     }

    //     return redirect()->route('transactionmd')
    //         ->with('success', 'Data transaksi master berhasil ditambahkan!')
    //         ->with('iconURL', $iconURL);
    // }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required|string',
            'type' => 'required|in:Top Up,Withdraw',
            'icons' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'nullable|string',
            'no_rekening' => 'nullable',
            'nama_blockchain.*' => 'nullable|string', // Validasi untuk setiap input blockchain
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek apakah nama_bank dan type sudah ada di database
        $existingTransaction = RateMasterData::where('nama_bank', $request->nama_bank)
            ->where('type', $request->type)
            ->first();

        if ($existingTransaction) {
            // Jika nama_bank dan type sudah ada di database rate_master_data
            if ($request->has('nama_blockchain')) {
                // Jika ada tambahan blockchain
                foreach ($request->nama_blockchain as $namaBlockchain) {
                    // Cek apakah nama_blockchain sudah ada di database kedua (Blockchain)
                    $blockchainExists = Blockchain::where('nama_blockchain', $namaBlockchain)
                        ->where('id_rate', $existingTransaction->id)
                        ->exists();

                    if (!$blockchainExists) {
                        $blockchainData = new Blockchain();
                        $blockchainData->id_rate = $existingTransaction->id;
                        $blockchainData->nama_bank = $existingTransaction->nama_bank;
                        $blockchainData->type = $existingTransaction->type;

                        if ($existingTransaction->type == 'Withdraw') {
                            // Hanya tambahkan no_rekening untuk blockchain pertama
                            if (!isset($noRekeningAdded)) {
                                $blockchainData->rekening_wallet = $request->no_rekening;
                                $noRekeningAdded = true;
                            }
                        }

                        $blockchainData->nama_blockchain = $namaBlockchain;
                        $blockchainData->save();
                    } else {
                        return redirect()->route('transactionmd')
                            ->with('warning', 'Nama blockchain sudah ada di database. Tambahkan blockchain unik atau kembali ke halaman transactionmd.');
                    }
                }

                return redirect()->route('transactionmd')
                    ->with('success', 'Data transaksi master berhasil ditambahkan!')
                    ->with('iconURL', $existingTransaction->icons);
            } else {
                // Jika tidak ada tambahan blockchain
                return redirect()->route('transactionmd')
                    ->with('warning', 'Nama bank sudah ada. Tambahkan blockchain atau kembali ke halaman transactionmd.');
            }
        }

        // Jika nama_bank dan type belum ada di database
        $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->extension(), 'public');
        $iconURL = URL::to('/') . '/storage/' . $iconPath;

        $transactionMD = new RateMasterData();
        $transactionMD->nama_bank = $request->nama_bank;
        $transactionMD->type = $request->type;

        if ($request->type == 'Withdraw') {
            $transactionMD->nama = $request->nama;
            // no_rekening diisi jika tidak ada tambahan blockchain
            if (!$request->has('nama_blockchain')) {
                $transactionMD->no_rekening = $request->no_rekening;
            }
        }

        $transactionMD->icons = $iconURL;
        $transactionMD->save();

        // Menyimpan data blockchain ke tabel kedua (blockchain_data)
        if ($request->has('nama_blockchain')) {
            foreach ($request->nama_blockchain as $namaBlockchain) {
                // Cek apakah nama_blockchain sudah ada di database kedua (Blockchain)
                $blockchainExists = Blockchain::where('nama_blockchain', $namaBlockchain)
                    ->where('id_rate', $transactionMD->id)
                    ->exists();

                if (!$blockchainExists) {
                    $blockchainData = new Blockchain();
                    $blockchainData->id_rate = $transactionMD->id;
                    $blockchainData->nama_bank = $transactionMD->nama_bank;
                    $blockchainData->type = $transactionMD->type;
                    $blockchainData->nama_blockchain = $namaBlockchain;

                    if ($transactionMD->type == 'Withdraw') {
                        // Hanya tambahkan no_rekening untuk blockchain pertama
                        if (!isset($noRekeningAdded)) {
                            $blockchainData->rekening_wallet = $request->no_rekening;
                            $noRekeningAdded = true;
                        }
                    }

                    $blockchainData->save();
                } else {
                    return redirect()->route('transactionmd')
                        ->with('warning', 'Nama blockchain sudah ada di database. Tambahkan blockchain unik atau kembali ke halaman transactionmd.');
                }
            }
        }

        return redirect()->route('transactionmd')
            ->with('success', 'Data transaksi master berhasil ditambahkan!')
            ->with('iconURL', $iconURL);
    }



    public function edit_rate($id)
    {
        // Fetch the rate data based on the $id
        $rate = RateMasterData::find($id);

        // Return the view with the rate data
        return view('settings.edit_rate', ['rate' => $rate]);
    }

    public function update_rate(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'price' => 'required|numeric', // Add any other validation rules you need
        ]);

        // Update the rate based on the provided ID
        $rate = RateMasterData::find($id);

        if ($rate) {
            $rate->update([
                'price' => $request->input('price'),
                // Update other fields as needed
            ]);

            // Redirect back or to a success page
            return redirect()->route('rate')->with('success', 'Rate updated successfully');
        } else {
            // Handle case where rate with the given ID is not found
            return redirect()->route('edit_rate')->with('error', 'Rate not found');
        }
    }

    public function edit_transactionmd($id)
    {
        // Fetch the rate data based on the $id
        $rate = RateMasterData::findOrFail($id);

        // Ambil entri blockchain sesuai dengan id_rate dari rate_master_data
        $blockchains = Blockchain::where('id_rate', $id)->get();

        // Return the view with the rate data
        return view('master_data.edit_transactionmd', ['rate' => $rate, 'blockchains' => $blockchains]);
    }

    public function update_transactionmd(Request $request, $id)
    {

        $validatorRules = [
            'nama_bank' => 'required',
            'type' => 'required',
            'icons' => 'required|file|max:2048',
        ];

        if ($request->input('type') === 'Withdraw') {
            $validatorRules['nama'] = 'required';
            $validatorRules['no_rekening'] = 'required';

            // Add validation for nama_blockchain and rekening_wallet
            $validatorRules['nama_blockchain.*'] = 'required';
            $validatorRules['rekening_wallet.*'] = 'required';
        }

        $request->validate($validatorRules);

        $rate = RateMasterData::find($id);

        if ($rate) {
            if ($request->hasFile('icons')) {
                if ($rate->icons) {
                    Storage::delete($rate->icons);
                }

                $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

                $iconURL = URL::to('/') . Storage::url($iconPath);

                $rate->update(['icons' => $iconURL]);
            }

            // Update the columns based on 'type'
            $updateData = [
                'nama_bank' => $request->input('nama_bank'),
                'type' => $request->input('type'),
            ];

            // Update 'nama' and 'no_rekening' only if 'type' is 'Withdraw'
            if ($request->input('type') === 'Withdraw') {
                $updateData['nama'] = $request->input('nama');
                $updateData['no_rekening'] = $request->input('no_rekening');
            }

            $rate->update($updateData);

            // Update 'nama_blockchain' and 'rekening_wallet' in the 'blockchain' table if present
            if ($request->input('type') === 'Withdraw' && $request->has('nama_blockchain')) {
                $namaBlockchainArray = $request->input('nama_blockchain');
                $rekeningWalletArray = $request->input('rekening_wallet');

                foreach ($namaBlockchainArray as $index => $namaBlockchain) {
                    $blockchain = $rate->blockchains[$index];
                    $blockchain->update([
                        'nama_blockchain' => $namaBlockchain,
                        'rekening_wallet' => $rekeningWalletArray[$index],
                    ]);
                }
            }

            $successMessage = 'Rate updated successfully';

            return redirect()->route('transactionmd')->with([
                'success' => $successMessage,
                'iconURL' => isset($iconURL) ? $iconURL : null,
            ]);
        } else {
            return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
        }
    }
}
