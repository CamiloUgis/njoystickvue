<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class ClienteController extends Controller
{
    public function agregar()
    {
        $clientes=Cliente::all();
        return view('clientes.clienteingresar')->with('clientes', $clientes);
    }
    public function actualizar($idClientes)
    {
        $clientes=Cliente::all();
        $cli=Cliente::where('idClientes',$idClientes)->first();
        return view('clientes.clienteactualizar')->with('clientes', $clientes)->with('cli',$cli);
    }
    public function datos($idClientes){
        $clientes=Cliente::all();
        $cli=Cliente::where('idClientes',$idClientes)->first();
        return view('clientes.clientedatos')->with('clientes', $clientes)->with('cli', $cli);
    }
    public function store(Request $request)
    {
        $clientes=Cliente::all();
        $validar= $request->validate([
            'nombre'=>'required',
            'rut' => ['required', 'string', new ValidChileanRut(new ChileRut)],
            'rut' =>'required|unique:clientes,rutClientes',
            'telefono'=>'required|unique:clientes,telefonoClientes',
            'telefono'=>'integer|min:0',
            'comuna'=>'required',
            'correo'=>'required',

        ]);
        $cliente=new Cliente;
        $cliente->nombreClientes = $request->input("nombre");
        $cliente->rutClientes = $request->input("rut");
        $cliente->telefonoClientes = $request->input("telefono");
        $cliente->comunaClientes = $request->input("comuna");
        $cliente->correoClientes = $request->input("correo");
        $cliente->save();
        
        $request->session()->flash('alert-success', 'User was successful added!');    
        return view('clientes.clienteingresar')->with('clientes', $clientes);

    }
    public function update(Request $request)
    {
       $clientes=Cliente::all();
        
       $validar= $request->validate([
        'nombre'=>'required',
        'rut' => ['required', 'string', new ValidChileanRut(new ChileRut)],
        'rut' =>'required|unique:clientes,rutClientes',
        'telefono'=>'required|unique:clientes,telefonoClientes',
        'telefono'=>'integer|min:0',
        'comuna'=>'required',
        'correo'=>'required',

    ]);
        $cliente=Cliente::where('idClientes',$request->input("id"))->first();
        $cliente->nombreClientes = $request->input("nombre");
        $cliente->rutClientes = $request->input("rut");
        $cliente->telefonoClientes = $request->input("telefono");
        $cliente->comunaClientes = $request->input("comuna");
        $cliente->correoClientes = $request->input("correo");
        $cliente->save();
        $clientes=Cliente::all();

        return redirect('/');

    }
    public function lista(){
        $clientes=Cliente::all();
        return view('clientes.listaCliente')->with('clientes', $clientes);
    }

}
