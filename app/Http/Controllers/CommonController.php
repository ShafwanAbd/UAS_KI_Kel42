<?php

namespace App\Http\Controllers;

use App\Models\sertifikatData;
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

    public function getQRC(){
        
        $tempdir = "temp/";
                            
        if (!file_exists($tempdir)){
            mkdir($tempdir);
        };

        include public_path('phpqrcode/qrlib.php');
    
        $isi_teks = "hallooo";
        $namafile = "helooo".".png";
        $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
        $ukuran = 5; //batasan 1 paling kecil, 10 paling besar
        $padding = 2;

        QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
    }

    public function check(string $noSertifikat){   
        
        $model1 = sertifikatData::where('noSertifikat', $noSertifikat)->first(); 

        return view('check', compact(
            'model1'
        ));
    }

    public function history(){  
        return view('history');
    }

    public function profile(){   
        return view('profile');  
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
        
        // $signature = $private->sign($message6);  
        $model1->sign = $dsa->sign(
            $model1->noPeserta.
            $model1->nama.
            $model1->asalSekolah.
            $model1->tanggalTerbit.
            $model1->noSertifikat.
            $model1->namaPelatihan.
            $model1->keikutsertaan
        );    

        $model1->save();
 
        return back()->with('success', 'yey');
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

        $messageDigest = hash('sha256', $message6);  
  
        $signature = $private->sign($message6);  
        
        // Convert the binary signature to a hex string
        $hexSignature = bin2hex($signature);

        // ==== ENCRYPT ==== //
        // Generate a random initialization vector (IV)
        $iv = random_bytes(16);

        // Encrypt the message using AES-256-CBC
        $ciphertext = openssl_encrypt($message6, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);

        // Concatenate the IV and ciphertext
        $encryptedMessage = $iv . $ciphertext;

        // ==== DECRYPT ==== //
        // Get the IV from the encrypted message
        $iv = substr($encryptedMessage, 0, 16);

        // Get the ciphertext from the encrypted message
        $ciphertext = substr($encryptedMessage, 16);

        // Decrypt the ciphertext using the IV and AES-256-CBC
        $decryptedMessage = openssl_decrypt($ciphertext, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
 
        echo $public->verify($decryptedMessage, $signature) ?
            'valid signature' : 
            'invalid signature';  

        echo "<br><br>" . $private . "<br><br>" . $public . "<br><br>" . $signature . "<br><br>message6:" . $message6 . "<br><br>ciphertext:" . $ciphertext . "<br><br>message_digest:" . $messageDigest;
      

        if (!extension_loaded('imagick')){
            echo '<br>imagick not installed';
        } else {
            echo '<br>imagick installed';
        }   

        if (!extension_loaded('gd')){
            echo '<br>gd not installed';
        } else {
            echo '<br>gd installed';
        } 
    }
}
