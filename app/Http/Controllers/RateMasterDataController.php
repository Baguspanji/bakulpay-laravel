<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use App\Models\RateMasterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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



    // public function edit_rate($id)
    // {
    //     // Fetch the rate data based on the $id
    //     $rate = RateMasterData::find($id);

    //     // Return the view with the rate data
    //     return view('settings.edit_rate', ['rate' => $rate]);
    // }

    public function edit_rate($id)
    {
        // Mendapatkan data rate berdasarkan $id
        $rate = RateMasterData::findOrFail($id);

        // Mendapatkan nama_blockchain berdasarkan id_rate
        $namaBlockchain = Blockchain::where('id_rate', $id)->value('nama_blockchain');

        // Jika namaBlockchain ada, ambil price dari tabel blockchain
        if ($namaBlockchain) {
            $price = Blockchain::where('id_rate', $id)->value('price');
        } else {
            // Jika namaBlockchain tidak ada, ambil price dari tabel rate_master_data
            $price = $rate->price;
        }

        return view('settings.edit_rate', compact('rate', 'namaBlockchain', 'price'));
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


    // public function update_transactionmd(Request $request, $id)
    // {
    //     $validatorRules = [
    //         'nama_bank' => 'required',
    //         'type' => 'required',
    //         'icons' => 'required|file|max:2048',
    //     ];

    //     $request->validate($validatorRules);

    //     $rate = RateMasterData::find($id);

    //     if ($rate) {
    //         // Update 'icons' if a new file is uploaded
    //         if ($request->hasFile('icons')) {
    //             if ($rate->icons) {
    //                 Storage::delete($rate->icons);
    //             }

    //             $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //             $iconURL = URL::to('/') . Storage::url($iconPath);

    //             $rate->update(['icons' => $iconURL]);
    //         }

    //         // Update 'nama_bank' and 'type'
    //         $rate->update([
    //             'nama_bank' => $request->input('nama_bank'),
    //             'type' => $request->input('type'),
    //         ]);

    //         // Update 'nama_blockchain' in the 'blockchain' table if present
    //         if ($request->has('nama_blockchain')) {
    //             $namaBlockchainArray = $request->input('nama_blockchain');

    //             foreach ($namaBlockchainArray as $namaBlockchain) {
    //                 $blockchain = Blockchain::updateOrCreate(
    //                     ['id_rate' => $rate->id],
    //                     ['nama_blockchain' => $namaBlockchain]
    //                 );
    //             }
    //         }

    //         // Redirect with success message
    //         return redirect()->route('transactionmd')->with([
    //             'success' => 'Rate updated successfully',
    //             'iconURL' => isset($iconURL) ? $iconURL : null,
    //         ]);
    //     } else {
    //         return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
    //     }
    // }

    // public function update_transactionmd(Request $request, $id)
    // {
    //     $validatorRules = [
    //         'nama_bank' => 'required',
    //         'type' => 'required',
    //         'icons' => 'nullable|file|max:2048', // Make 'icons' optional
    //     ];

    //     $request->validate($validatorRules);

    //     $rate = RateMasterData::find($id);

    //     if (!$rate) {
    //         return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
    //     }

    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'nama_bank' and 'type'
    //     $rate->update([
    //         'nama_bank' => $request->input('nama_bank'),
    //         'type' => $request->input('type'),
    //     ]);

    //     // Redirect with success message
    //     return redirect()->route('transactionmd')->with([
    //         'success' => 'Rate updated successfully',
    //         'iconURL' => $rate->icons ?? null,
    //     ]);
    // }


    // public function update_transactionmd(Request $request, $id)
    // {
    //     $validatorRules = [
    //         'nama_bank' => 'required',
    //         'type' => 'required',
    //         'icons' => 'nullable|file|max:2048', // Make 'icons' optional
    //     ];

    //     $request->validate($validatorRules);

    //     $rate = RateMasterData::find($id);

    //     if (!$rate) {
    //         return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
    //     }

    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'nama_bank' and 'type'
    //     $rate->update([
    //         'nama_bank' => $request->input('nama_bank'),
    //         'type' => $request->input('type'),
    //     ]);

    //     // Update 'type' in 'blockchain' entries with the same 'id_rate'
    //     $rate->blockchains()->where('id_rate', $rate->id)->update(['type' => $request->input('type')]);

    //     // Redirect with success message
    //     return redirect()->route('transactionmd')->with([
    //         'success' => 'Rate updated successfully',
    //         'iconURL' => $rate->icons ?? null,
    //     ]);
    // } 

    // public function update_transactionmd(Request $request, $id)
    // {
    //     $validatorRules = [
    //         'nama_bank' => 'required',
    //         'type' => 'required',
    //         'icons' => 'nullable|file|max:2048', // Make 'icons' optional
    //     ];

    //     $request->validate($validatorRules);

    //     $rate = RateMasterData::find($id);

    //     if (!$rate) {
    //         return redirect()->route('edit_transactionmd', ['id' => $id])->with('error', 'Rate not found');
    //     }

    // // Update 'icons' if a new file is uploaded
    // if ($request->hasFile('icons')) {
    //     if ($rate->icons) {
    //         Storage::delete($rate->icons);
    //     }

    //     $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //     $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    // }

    //     // Update 'nama_bank' and 'type' in 'rate_master_data' table
    //     $rate->update([
    //         'nama_bank' => $request->input('nama_bank'),
    //         'type' => $request->input('type'),
    //     ]);

    //     // Update 'nama_blockchain' in 'blockchain' table if present
    //     if ($request->has('nama_blockchain')) {
    //         $namaBlockchainArray = $request->input('nama_blockchain');

    //         foreach ($namaBlockchainArray as $namaBlockchain) {
    //             $rate->blockchains()
    //                 ->where('id_rate', $rate->id)
    //                 ->where('nama_blockchain', $namaBlockchain)
    //                 ->update(['nama_blockchain' => $request->input('nama_bank')]);
    //         }
    //     }

    //     // Update 'nama_bank' and 'type' in 'blockchain' entries with the same 'id_rate'
    //     $rate->blockchains()->where('id_rate', $rate->id)->update([
    //         'nama_bank' => $request->input('nama_bank'),
    //         'type' => $request->input('type'),
    //     ]);

    //     // Redirect with success message
    //     return redirect()->route('transactionmd')->with([
    //         'success' => 'Rate updated successfully',
    //         'iconURL' => $rate->icons ?? null,
    //     ]);
    // }

    // public function update_transactionmd(Request $request, $id)
    // {
    //     // Validasi input form
    //     $this->validate($request, [
    //         'nama_bank' => 'required|string',
    //         'nama_blockchain.*' => 'required|string',
    //         // ... tambahkan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Update nama_bank di tabel rate_master_data
    //     $rate = RateMasterData::find($id);
    //     $rate->nama_bank = $request->nama_bank;
    //     $rate->save();

    //     // Update nama_blockchain di tabel blockchain sesuai dengan id_rate
    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['nama_blockchain' => $request->nama_blockchain[0]]);

    //     return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    // }

    // public function update_transactionmd(Request $request, $id)
    // {
    //     // Validasi input form
    //     $this->validate($request, [
    //         'nama_bank' => 'required|string',
    //         'nama_blockchain.*' => 'required|string',
    //         'icons' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk icons
    //         'type' => 'required|string', // Validasi untuk type
    //         // ... tambahkan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Update nama_bank di tabel rate_master_data
    //     $rate = RateMasterData::find($id);
    //     $rate->nama_bank = $request->nama_bank;
    //     $rate->save();

    //     // Ambil nilai dari parameter blockchain_id
    //     $blockchainId = $request->query('blockchain_id');

    //     // Update nama_bank di tabel blockchain sesuai dengan id_rate
    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['nama_bank' => $request->nama_bank]);

    //     // Update nama_blockchain di tabel blockchain sesuai dengan blockchain_id
    //     Blockchain::where('nama_blockchain', $blockchainId)
    //         ->where('nama_bank', $request->nama_bank)
    //         ->update(['nama_blockchain' => $request->nama_blockchain[0]]);

    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'type' in both rate_master_data and blockchain
    //     RateMasterData::where('id', $rate->id)
    //         ->update(['type' => $request->type]);

    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['type' => $request->type]);

    //     return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    // }

    // public function update_transactionmd(Request $request, $id)
    // {
    //     // Validasi input form
    //     $this->validate($request, [
    //         'nama_bank' => 'required|string',
    //         'nama_blockchain.*' => 'required|string',
    //         'icons' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk icons
    //         'type' => 'required|string',
    //         'nomor_rekening' => 'required|string', // Validasi untuk nomor_rekening
    //         // ... tambahkan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Update nama_bank di tabel rate_master_data
    //     $rate = RateMasterData::find($id);
    //     $rate->nama_bank = $request->nama_bank;
    //     $rate->save();

    //     // Ambil nilai dari parameter blockchain_id
    //     $blockchainId = $request->query('blockchain_id');

    //     // Update nama_bank di tabel blockchain sesuai dengan id_rate
    //     Blockchain::where('id_rate', $rate->id)
    //         ->update([
    //             'nama_bank' => $request->nama_bank,
    //             'nomor_rekening' => $request->nomor_rekening,
    //         ]);

    //     // Update nama_blockchain di tabel blockchain sesuai dengan blockchain_id
    //     Blockchain::where('nama_blockchain', $blockchainId)
    //         ->where('nama_bank', $request->nama_bank)
    //         ->update(['nama_blockchain' => $request->nama_blockchain[0]]);

    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'type' in both rate_master_data and blockchain
    //     RateMasterData::where('id', $rate->id)
    //         ->update(['type' => $request->type]);

    //     return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    // }


    // public function update_transactionmd(Request $request, $id)
    // {
    //     // Validasi input form
    //     $this->validate($request, [
    //         'nama_bank' => 'required|string',
    //         'nama_blockchain.*' => 'required|string',
    //         'icons' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk icons
    //         'type' => 'required|string', // Validasi untuk type
    //         // ... tambahkan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Update nama_bank di tabel rate_master_data
    //     $rate = RateMasterData::find($id);
    //     $rate->nama_bank = $request->nama_bank;
    //     $rate->save();

    //     // Ambil nilai dari parameter blockchain_id
    //     $blockchainId = $request->query('blockchain_id');

    //     // Update nama_bank di tabel blockchain sesuai dengan id_rate
    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['nama_bank' => $request->nama_bank]);

    //     // Update nama_blockchain di tabel blockchain sesuai dengan blockchain_id
    //     Blockchain::where('nama_blockchain', $blockchainId)
    //         ->where('nama_bank', $request->nama_bank)
    //         ->update(['nama_blockchain' => $request->nama_blockchain[0]]);

    //         // Jika blockchain_id ada, update rekening_wallet di tabel blockchain
    //         if ($blockchainId) {
    //             Blockchain::where('nama_blockchain', $blockchainId)
    //                 ->where('id_rate', $rate->id)
    //                 ->update([
    //                     'rekening_wallet' => $request->no_rekening,
    //                 ]);
    //         } else {
    //             // Jika tidak ada blockchain_id, update no_rekening di tabel rate_master_data
    //             RateMasterData::where('id', $rate->id)
    //                 ->update([
    //                     'no_rekening' => $request->no_rekening,
    //                     'nama' => $request->nama, // Update nama di tabel rate_master_data
    //                 ]);
    //         }

    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'type' in both rate_master_data and blockchain
    //     RateMasterData::where('id', $rate->id)
    //         ->update(['type' => $request->type]);

    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['type' => $request->type]);

    //     return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    // }

    // public function update_transactionmd(Request $request, $id)
    // {
    //     // Validasi input form
    //     $this->validate($request, [
    //         'nama_bank' => 'required|string',
    //         'nama_blockchain.*' => 'required|string',
    //         'icons' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk icons
    //         'type' => 'required|string', // Validasi untuk type
    //         'nama' => 'required|string',
    //         'no_rekening' => 'required|string',
    //         // ... tambahkan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Update nama_bank di tabel rate_master_data
    //     $rate = RateMasterData::find($id);
    //     $rate->nama_bank = $request->nama_bank;
    //     $rate->save();

    //     // Ambil nilai dari parameter blockchain_id
    //     $blockchainId = $request->query('blockchain_id');

    //     // Jika blockchain_id ada, update rekening_wallet di tabel blockchain
    //     if ($blockchainId) {
    //         Blockchain::where('nama_blockchain', $blockchainId)
    //             ->where('id_rate', $rate->id)
    //             ->update([
    //                 'rekening_wallet' => $request->no_rekening,
    //             ]);
    //     } else {
    //         // Jika tidak ada blockchain_id, update no_rekening di tabel rate_master_data
    //         RateMasterData::where('id', $rate->id)
    //             ->update([
    //                 'no_rekening' => $request->no_rekening,
    //                 'nama' => $request->nama, // Update nama di tabel rate_master_data
    //             ]);
    //     }


    //     // Update 'icons' if a new file is uploaded
    //     if ($request->hasFile('icons')) {
    //         if ($rate->icons) {
    //             Storage::delete($rate->icons);
    //         }

    //         $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

    //         $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
    //     }

    //     // Update 'type' in both rate_master_data and blockchain
    //     RateMasterData::where('id', $rate->id)
    //         ->update(['type' => $request->type]);

    //     Blockchain::where('id_rate', $rate->id)
    //         ->update(['type' => $request->type]);

    //     return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    // }


    public function update_transactionmd(Request $request, $id)
    {
        // Validasi input form
        $this->validate($request, [
            'nama_bank' => 'required|string',
            'nama_blockchain.*' => 'required|string',
            'icons' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk icons
            'type' => 'required|string', // Validasi untuk type
            // ... tambahkan validasi sesuai kebutuhan Anda
        ]);

        // Update nama_bank di tabel rate_master_data
        $rate = RateMasterData::find($id);
        $rate->nama_bank = $request->nama_bank;
        $rate->save();

        // Ambil nilai dari parameter blockchain_id
        $blockchainId = $request->query('blockchain_id');

        // Update nama_bank di tabel blockchain sesuai dengan id_rate
        Blockchain::where('id_rate', $rate->id)
            ->update(['nama_bank' => $request->nama_bank]);

        // //Update nama_blockchain di tabel blockchain sesuai dengan blockchain_id
        // Blockchain::where('nama_blockchain', $blockchainId)
        //     ->where('nama_bank', $request->nama_bank)
        //     ->update(['nama_blockchain' => $request->nama_blockchain[0]]);

        // Jika blockchain_id ada, update rekening_wallet di tabel blockchain
        if ($blockchainId) {
            Blockchain::where('nama_blockchain', $blockchainId)
                ->where('nama_bank', $request->nama_bank)
                ->update([
                    'rekening_wallet' => $request->no_rekening,
                    'nama_blockchain' => $request->nama_blockchain[0],
                ]);
        } else {
            // Jika tidak ada blockchain_id, update no_rekening di tabel rate_master_data
            RateMasterData::where('id', $rate->id)
                ->update([
                    'no_rekening' => $request->no_rekening,
                    'nama' => $request->nama, // Update nama di tabel rate_master_data
                ]);
        }

        // Update 'icons' if a new file is uploaded
        if ($request->hasFile('icons')) {
            if ($rate->icons) {
                Storage::delete($rate->icons);
            }

            $iconPath = $request->file('icons')->storeAs('rate/icons', uniqid() . '.' . $request->file('icons')->getClientOriginalExtension(), 'public');

            $rate->update(['icons' => URL::to('/') . Storage::url($iconPath)]);
        }

        // Update 'type' in both rate_master_data and blockchain
        RateMasterData::where('id', $rate->id)
            ->update(['type' => $request->type]);

        Blockchain::where('id_rate', $rate->id)
            ->update(['type' => $request->type]);

        return redirect()->route('transactionmd')->with('success', 'Data updated successfully');
    }

}
