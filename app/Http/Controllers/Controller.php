<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lists;
use App\Models\items;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //Before Login
        public function cadastroForms(Request $request)
        {
            $novoUsuario = new User;
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required',
                'password'=>'required',
            ],[
                'name.required'=>'Os campos marcados com * são obrigatorios',
                'email.required'=>'Os campos marcados com * são obrigatorios',
                'password.required'=>'Os campos marcados com * são obrigatorios',
            ]);
            $novoUsuario->name = $request->name;
            if(!empty(user::where('email',$request->email)->first())){
            return redirect()->back()->with('danger','E-mail já cadastrado!');
            }
            $novoUsuario->email = $request->email;
            $novoUsuario->password = Hash::make($request->password);
            $novoUsuario->save();    
            return redirect('/')->with('msg','Cadastro realizado com sucesso!');
        }
    //Login
        public function login()
        {
            return view('signup');
        }
        public function loginForms(Request $request)
        {
            $this->validate($request,[
                'email'=>'required',
                'password'=>'required'
            ],[
                //'required' => 'A :attribute é um campo obrigartorio!',
                'email.required'=>'O campo Email é obrigatorio',
                'password.required'=>'O campo Senha é obrigatorio',
                
            ]);
            $usuario=User::where('email',$request->email)->first(); 
            if($usuario && Hash::check($request->password,$usuario->password)){
                Auth::loginUsingId($usuario->id);
                return redirect('/index');
            }else{
                return redirect()->back()->with('danger','E-mail ou senha invalida!');
            }
        }
    
    //middle login
        public function indexSenha()
        {
            return view('password_reset');            
        }
        public function esqueceuSenhaFormsEmail(Request $request)
        {
            $email=$request->email;
            $status = Password::sendResetLink(
                $request->only('email')
            );
            return $status === Password::RESET_LINK_SENT
                        ? back()->with(['status' => __($status)])
                        : back()->withErrors(['email' => __($status)]);     
        }
        public function esqueceuSenhaForms ($token) {
            return view('auth.reset-password', ['token' => $token]);
        }
    //after login
        public function index(Request $request)
        {
            $usuario=auth()->user();
            $busca=$request['pesquisa'];
            if(isset($busca))
            {
                if($busca=='now')
                {
                    $suasListas=Lists::where('idCriador',$usuario->id)->whereNotIn('finaizada',[1])->orderBy('created_at','DESC')->get();
                }
                elseif($busca=='old')
                {
                    $suasListas=Lists::where('idCriador',$usuario->id)->whereNotIn('finaizada',[1])->orderBy('created_at','ASC')->get();    
                }else{
                    $suasListas=Lists::where('idCriador',$usuario->id)->whereNotIn('finaizada',[1])->where('nome','like','%'.$busca.'%')->get();
                }
            }
            else
            {
                $suasListas=Lists::where('idCriador',$usuario->id)->whereNotIn('finaizada',[1])->get();
            }
            return view('home',['suasListas'=>$suasListas]);
        }
}
