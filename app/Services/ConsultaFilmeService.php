<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConsultaFilmeService {


    public function teste1(){
        $token = '36ff17ae94a96b53ee6225f9ed5187e5d246b12378f6a4fcb94cb3e328ea1982';
        $url = 'https://gorest.co.in/public/v2/users';
        //$r = Http::withToken($token)->get($url);
        
        /*
        $post = [
            'name'   => 'Seu Nome Dev',
            'email'  => 'dev.laravel.' . rand(1, 9999) . '@email.com', // Gerando e-mail único para não dar erro
            'gender' => 'male',
            'status' => 'active'
        ];
        $r = Http::withToken($token)->post($url,$post); */
        
        $urlUpdate = 'https://gorest.co.in/public/v2/users/8500639';
        $update = [
            'name'   => 'Seu Nome De 11v',
        ];
        $r = Http::withToken($token)->put($urlUpdate,$update);

        dd($r->json());
    }
}
