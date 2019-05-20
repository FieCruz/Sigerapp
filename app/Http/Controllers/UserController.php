<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades;

use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('novousuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=> 'required|email|unique:users',
            'password' => 'required|confirmed|min:6|max:18'
        ],[
            'name.required' => 'O preenchimento do campo nome é obrigatório',
            'email.required'=>'É necessário preencher um e-mail válido para efetuar o cadastro',
            'email.unique'=>'Este e-mail já está cadastrado, oriente o colaborador a recuperar a senha',
            'password.required'=>'Insira uma senha, para conclusão do cadastro',
            'password.confirmed'=>'Senha digitada não confere com o campo senha',
            'password.min' =>'Minimo permitido são 6 dígitos',
            'password.max' => 'Maximo permitido é de 18 dígitos',


          ]);
          $user = new User([
            'name' => $request->get('name'),
            'email'=> $request->get('email'),
            'password' => Hash::make($request->password)
          ]);
          $user->save();
          alert()->success('Usuário cadastrado com sucesso');
          return redirect('/home');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     //recuperação de sennha (logado)
     public function password(){
        return View('user.password');
    }
 public function updatePassword(Request $request){
        $rules = [
            'mypassword' => 'required',
            'password' => 'required|confirmed|min:6|max:18',
        ];
        
        $messages = [
            'mypassword.required' =>'O campo senha atual é obrigatório',
            'password.required' =>'Campo senha nova é obrigatório',
            'password.confirmed'=> 'Senhas não coincidem',
            'password.min' =>'Minimo permitido são 6 dígitos',
            'password.max' => 'Maximo permitido é de 18 dígitos',
        ];
        
       $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('user/password')->withErrors($validator);
        } 
        else{
            if (Hash::check($request->mypassword, Auth::user()->password)){
                $user = new User();
                $user->where('email', '=', Auth::user()->email)
                     ->update(['password' => bcrypt($request->password)]);
                     alert()->success('Senha alterada  com sucesso');
                 return redirect('home');
            }
            else
            {
                alert()->error('Credenciais Incorretas');
                return redirect('user/password');;
            }
        }
    }
}
