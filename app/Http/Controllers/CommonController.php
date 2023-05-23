<?php

namespace App\Http\Controllers;

use App\Models\LogAudit;
use App\Models\sertifikatData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('dokumen', compact(
            'datas1'
        ));
    } 

    public function check(Request $request){    
        
        $model1 = sertifikatData::where('uniqueId', $request->uniqueId)->first();  
        $dsa = DSA::loadPublicKey(Auth::user()->publicKey);  

        $encryptedMessage = $model1->encryptedMessage;

        // ==== DECRYPT ==== //
        // Get the IV from the encrypted message
        $iv = substr($encryptedMessage, 0, 16);

        // Get the ciphertext from the encrypted message
        $ciphertext = substr($encryptedMessage, 16);

        // Decrypt the ciphertext using the IV and AES-256-CBC
        $decryptedMessage = openssl_decrypt($ciphertext, 'aes-256-cbc', Auth::user()->encryptionKey, OPENSSL_RAW_DATA, $iv);

        // echo $dsa->verify($decryptedMessage, $model1->sign) ?
        //     'valid signature' :
        //     'invalid signature';

        $model2 = new LogAudit(); 
        $model2->aktifitas = "Melakukan Pengechekan pada Sertifikat dengan No. Sertif ". $model1->noSertifikat .".";

        $model2->save();

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

        return view('profile', compact(
            'user'
        ));  
    } 

    public function user_update(Request $request){

        $user = User::where('id', Auth::user()->id)->first(); 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->privateKey = $request->privateKey;
        $user->publicKey = $request->publicKey;
        $user->encryptionKey = $request->encryptionKey;

        $user->save();

        $model1 = new LogAudit(); 
        $model1->aktifitas = "Memperbaharui Profile dengan ID Profile ". $user->id .".";

        $model1->save();

        return back()->with('success', 'Akun Berhasil Diupdate!');
    }

    // ADDING

    public function dokumen_add(Request $request){ 

        $model1 = new sertifikatData(); 

        $model1->noPeserta = $request->noPeserta;
        $model1->nama = $request->nama;
        $model1->instansi = $request->instansi;
        $model1->tanggalTerbit = $request->tanggalTerbit;
        $model1->noSertifikat = $request->noSertifikat;
        $model1->namaPelatihan = $request->namaPelatihan;
        $model1->keikutsertaan = $request->keikutsertaan;

        $dsa = DSA::loadPrivateKey(Auth::user()->privateKey); 
        $message = (
            $model1->noPeserta.
            $model1->nama.
            $model1->asalSekolah.
            $model1->tanggalTerbit.
            $model1->noSertifikat.
            $model1->namaPelatihan.
            $model1->keikutsertaan
        ); 
        
        // $signature = $private->sign($message6);  
        $model1->sign = $dsa->sign($message);    

        // ==== ENCRYPT ==== //  
        // Generate a random initialization vector (IV)
        $iv = random_bytes(16);

        // Encrypt the message using AES-256-CBC
        $ciphertext = openssl_encrypt($message, 'aes-256-cbc', Auth::user()->encryptionKey, OPENSSL_RAW_DATA, $iv);

        // Concatenate the IV and ciphertext
        $encryptedMessage = $iv . $ciphertext;
        
        $model1->encryptedMessage = $encryptedMessage;
        $model1->uniqueId = uniqid();

        $model1->save();

        $model2 = new LogAudit(); 
        $model2->aktifitas = "Menambahkan Sertifikat dengan No. Sertifikat ". $request->noSertifikat .".";

        $model2->save();
 
        return back()->with('success', 'yey');
    }

    public function hapus(string $id){
        $model1 = sertifikatData::find($id);
        $model1->delete();

        $model2 = new LogAudit(); 
        $model2->aktifitas = "Menghapus Sertifikat dengan No. Sertifikat ". $model1->noSertifikat .".";

        $model2->save();

        return back()->with('success', 'Berhasil Menghapus Sertifikat');
    }

    // DEBUGGING

    public function phpinfo(){ 
        return phpinfo(); 
    } 
    
    public function test() {
        $encryptionKey = uniqid(); 

        $private = DSA::createKey(2048, 160);
        $public = $private->getPublicKey(); 
             
        $message5 = file_get_contents(public_path('./test/message3.docx')); 
        $message6 = file_get_contents(public_path('./test/message7.pdf')); 
        $message7 = "2032940Muhammad Shafwan Abdullah20233/P/3002/EAS/PJongkok Satu KakiPeserta";
        $message7_edit = "2032940Muhammaad Shafwan Abdullah20233/P/3002/EAS/PJongkok Satu KakiPeserta";

        $messageDigest = hash('sha256', $message7_edit);  
  
        $signature = $private->sign($message7);  
        
        // Convert the binary signature to a hex string
        $hexSignature = bin2hex($signature);

        // ==== ENCRYPT ==== //
        // Generate a random initialization vector (IV)
        $iv = random_bytes(16);

        // Encrypt the message using AES-256-CBC
        $ciphertext = openssl_encrypt($message7_edit, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);

        // Concatenate the IV and ciphertext
        $encryptedMessage = $iv . $ciphertext;

        // ==== DECRYPT ==== //
        // Get the IV from the encrypted message
        $iv = substr($encryptedMessage, 0, 16);

        // Get the ciphertext from the encrypted message
        $ciphertext = substr($encryptedMessage, 16);

        // Decrypt the ciphertext using the IV and AES-256-CBC
        $decryptedMessage = openssl_decrypt($ciphertext, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv); 

        dd($message7_edit, $message7_edit);

        echo $public->verify($decryptedMessage, $signature) ?
            'valid signature':
            'invalid signature'; 

        echo "<br><br>" . $private . "<br><br>" . $public . "<br><br>" . $signature . "<br><br>message6:" . $message7 . "<br><br>ciphertext:" . $ciphertext . "<br><br>message_digest:" . $messageDigest;
    }
}
