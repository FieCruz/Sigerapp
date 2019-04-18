<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Equipamentos;

class EquipamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipamentos = Equipamentos::all();
        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('equipamentos.create');
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
             'eqdescricao'          => 'required|max:30',
             'marca'                => 'required|:max:30',
             'modelo'               => 'required|:max:30',
             'status'               => 'required',
             'codidentificacao'     => 'required|unique:equipamentos|max:30',
             'dt_aquisicao'         => 'required|date',
            
        ],[
            'eqdescricao.required' => 'O Tipo de equipamento deve ser preenchido obrigatóriamente',
            'marca.required'=>'O campo marca deve ser preenchido obrigatóriamente',
            'modelo.required'=>'O campo modelo deve ser preenchido obrigatóriamente',
            'codidentificacao.required'=>'O campo de número de série deve ser preenchido obrigatóriamente',
            'codidentificacao.unique'=>'O campo número de série é único',
            'eqdescricao.max'=>'É permitido no máximo 30 digitos',
            'modelo.max'=>'É permitido no máximo 30 dígitos',
                   
            ]
    
         
              
              );
                $equipamentos = new Equipamentos([
                  'eqdescricao'        => $request->get('eqdescricao'),
                  'marca'              => $request->get('marca'),
                  'modelo'             => $request->get('modelo'),
                  'status'             => $request->get('status'),
                  'codidentificacao'   => $request->get('codidentificacao'),
                  'dt_aquisicao'       => $request->get('dt_aquisicao'),
                  
                 
                ]
            
            
            );
                $equipamentos->save();
                return redirect('/equipamentos')->with('success', 'Equipamento incluido com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $equipamentos = Equipamentos::find($id);

        return view('equipamentos.edit', compact('equipamentos'));
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
        $request->validate([
            'eqdescricao'           => 'required|max:30',
            'marca'                 => 'required|max:30',
            'modelo'                => 'required|max:30',
            'status'                => 'required',
            'codidentificacao'      => 'required|max:30',
            'dt_aquisicao'          => 'required|date',
            
                 
        ],
        [
            'eqdescricao.required' => 'O Tipo de equipamento deve ser preenchido obrigatóriamente',
            'marca.required'=>'O campo marca deve ser preenchido obrigatóriamente',
            'modelo.required'=>'O campo modelo deve ser preenchido obrigatóriamente',
            'codidentificacao.required'=>'O campo de número de série deve ser preenchido obrigatóriamente',
            'codidentificacao.unique'=>'O campo número de série é único',
            'eqdescricao.max'=>'É permitido no máximo 30 digitos',
            'modelo.max'=>'É permitido no máximo 30 dígitos',
                   
        ]
        
             
             );
                $equipamentos = Equipamentos::find($id);
                $equipamentos->eqdescricao        = $request->get('eqdescricao');
                $equipamentos->marca              = $request->get('marca');
                $equipamentos->modelo             = $request->get('modelo');
                $equipamentos->status              = $request->get('status');
                $equipamentos->codidentificacao   = $request->get ('codidentificacao');
                $equipamentos->dt_aquisicao       = $request->get ('dt_aquisicao');
               
                
              
               $equipamentos->save();
               return redirect('/equipamentos')->with('success', 'Equipamento atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipamentos = Equipamentos::find($id);
        $equipamentos ->delete();

        return redirect('/equipamentos')->with('success', 'Equipamento excluido com sucesso');
    }

    
   
}
