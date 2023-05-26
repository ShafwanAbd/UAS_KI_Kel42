<?php

namespace App\Http\Controllers;

use App\Models\LogAudit;
use App\Models\sertifikatData;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use phpseclib3\Crypt\DSA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CommonController extends Controller
{
    public function home(){
        return view('home');
    }

    public function dokumen(){
        $datas1 = sertifikatData::all();
        $setting = Setting::first();
        $dsa = DSA::loadPublicKey($setting->publicKey);  

        return view('dokumen', compact(
            'datas1', 'dsa'
        ));
    }

    public function check(Request $request){    
        
        $model1 = sertifikatData::where('uniqueId', $request->uniqueId)->first();
        $setting = Setting::first();
        $dsa = DSA::loadPublicKey($setting->publicKey); 
        $decryptedMessage = "";

        if (isset($model1)){
            $encryptedMessage = $model1->encryptedMessage;
    
            // ==== DECRYPT ==== //
            // Get the IV from the encrypted message
            $iv = substr($encryptedMessage, 0, 16);
    
            // Get the ciphertext from the encrypted message
            $ciphertext = substr($encryptedMessage, 16);
    
            // Decrypt the ciphertext using the IV and AES-256-CBC
            $decryptedMessage = openssl_decrypt($ciphertext, 'aes-256-cbc', $setting->encryptionKey, OPENSSL_RAW_DATA, $iv);
      
            $model2 = new LogAudit(); 
            $model2->aktifitas = "Melakukan Pengecekan pada Sertifikat dengan No. Sertif ". $model1->noSertifikat .".";
    
            $model2->save();
        }

        return view('check', compact(
            'model1', 'dsa', 'decryptedMessage'
        ));
    }

    public function history(){  
        $datas1 = LogAudit::all();  

        return view('history', compact(
            'datas1'
        ));
    }

    public function profile(){   
        $user = Auth::user();
        $setting = Setting::first();

        return view('profile', compact(
            'user', 'setting'
        ));  
    } 

    public function user_update(Request $request){

        $user = User::where('id', Auth::user()->id)->first(); 
        $user->name = $request->name;
        $user->email = $request->email; 

        $user->save();

        $model1 = new LogAudit(); 
        $model1->aktifitas = "Berhasil Memperbaharui Profile.";

        $model1->save();

        return back()->with('success', 'Berhasil Memperbaharui Profile!');
    }

    public function password_update(Request $request){

        if (Hash::check($request->current_pw, Auth::user()->password)) {
            
            DB::table('users')->where('id', Auth::user()->id)
                            ->update(['password' => bcrypt($request->new_pw)]);

            $model1 = new LogAudit(); 
            $model1->aktifitas = "Berhasil Memperbaharui Password.";
    
            $model1->save();
            
            return back()->with('success', 'Berhasil Memperbaharui Password');
        } else { 
            return back()->with('failed', 'Password Aktif Salah!');
        } 
    }

    // ADDING

    public function dokumen_add(Request $request){    
         
        function adding(Request $request){
            $model1 = new sertifikatData(); 
            $setting = Setting::first();

            $model1->noPeserta = $request->noPeserta;
            $model1->nama = $request->nama;
            $model1->instansi = $request->instansi;
            $model1->tanggalTerbit = $request->tanggalTerbit;
            $model1->noSertifikat = $request->noSertifikat;
            $model1->namaPelatihan = $request->namaPelatihan;
            $model1->keikutsertaan = $request->keikutsertaan;
    
            $model1->save();
    
            $dsa = DSA::loadPrivateKey($setting->privateKey); 
            $message = (
                $model1->created_at.
                $model1->id.
                $model1->noPeserta.
                $model1->nama.
                $model1->asalSekolah.
                $model1->tanggalTerbit.
                $model1->noSertifikat.
                $model1->namaPelatihan.
                $model1->keikutsertaan.
                $model1->updated_at
            ); 
            
            // $signature = $private->sign($message6);  
            $model1->sign = $dsa->sign($message);    
    
            // ==== ENCRYPT ==== //  
            // Generate a random initialization vector (IV)
            $iv = random_bytes(16);
    
            // Encrypt the message using AES-256-CBC
            $ciphertext = openssl_encrypt($message, 'aes-256-cbc', $setting->encryptionKey, OPENSSL_RAW_DATA, $iv);
    
            // Concatenate the IV and ciphertext
            $encryptedMessage = $iv . $ciphertext;
            
            $model1->encryptedMessage = $encryptedMessage;
            $model1->uniqueId = 'UASKI' . uniqid(); 

            return $model1;
        };

        do {
            $model1 = adding($request);
        } while ($model1->created_at != $model1->updated_at);

        $model1->save();
        
        $model2 = new LogAudit(); 
        $model2->aktifitas = "Menambahkan Sertifikat dengan No. Sertifikat ". $request->noSertifikat .".";
        $model2->save();
 
        return back()->with('success', 'Berhasil Menambahkan Sertifikat!');
    } 

    public function hapus(string $id){
        $model1 = sertifikatData::find($id);
        $model1->delete();

        $model2 = new LogAudit(); 
        $model2->aktifitas = "Menghapus Sertifikat dengan No. Sertifikat ". $model1->noSertifikat .".";

        $model2->save();

        return back()->with('success', 'Berhasil Menghapus Sertifikat!');
    } 
}
