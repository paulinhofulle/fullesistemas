<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use App\Models\Loja;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller {

    public function consultaUsuario(Request $request){
        $search = $request->input('search');
        $query = User::query()
                     ->where('usutipo', 2);
    
        if ($search) {
            $query->where('usunome', 'like', "%$search%");
        }
        $usuarios = $query->paginate(9);
        $totalUsuarios = $usuarios->total();
        $lojas    = Loja::all();
        return view('site/administrador/usuario/consulta', compact('usuarios', 'lojas', 'totalUsuarios', 'search'));
    }

    public function validaInclusaoUsuario(Request $request){
        $bValido = $request->validate([
            'usunome'               => ['required'],
            'usucpf'                => ['required', 'min:11', 'unique:users'],
            'usudatanascimento'     => ['required', 'date',
            function ($attribute, $value, $fail) {
                $dob = Carbon::parse($value);
                $idadeMinima = 18;

                if ($dob->age < $idadeMinima) {
                    $fail('O lojista deve ter pelo menos ' . $idadeMinima . ' anos de idade.');
                }
            }],
            'usutelefone'           => ['required'],
            'email'                 => ['required', 'email', 'unique:users'],
            'usucep'                => ['required', 'min:8'],
            'usunumeroendereco'     => ['required', 'numeric'],
            'usurua'                => ['required'],
            'usubairro'             => ['required'],
            'usucidade'             => ['required'],
            'usuestado'             => ['required'],
            'lojcodigo'             => ['required']
        ],[
            'usunome.required'           => 'O campo Nome é obrigatório!',
            'usucpf.required'            => 'O campo CPF é obrigatório!',
            'usucpf.min'                 => 'O campo CPF deve ter 11 números!',
            'usucpf.unique'              => 'Este CPF já está sendo utilizado!',
            'usudatanascimento.required' => 'O campo Data de Nascimento é obrigatório!',
            'usutelefone.required'       => 'O campo Telefone é obrigatório!',
            'email.required'             => 'O campo E-mail é obrigatório!',
            'email.email'                => 'O campo deve ter o @, pois o mesmo é do tipo E-mail!',
            'email.unique'               => 'Este e-mail já está sendo utilizado!',
            'usucep.required'            => 'O campo CEP é obrigatório!',
            'usucep.min'                 => 'O campo CEP deve ter 8 números!',
            'usunumeroendereco.required' => 'O campo N° Endereço é obrigatório!',
            'usurua.required'            => 'O campo Rua é obrigatório!',
            'usubairro.required'         => 'O campo Bairro é obrigatório!',
            'usucidade.required'         => 'O campo Cidade é obrigatório!',
            'usuestado.required'         => 'O campo Estado é obrigatório!',
            'usunumeroendereco.numeric'  => 'Só deve ser informado números!',
            'lojcodigo'                  => 'O lojista precisa estar vinculado a uma loja!'
        ]);

        return response()->json(['isValid' => $bValido, 'errors' => $bValido ? [] : $validator->errors()->toArray()]);
    }

    public function incluirUsuario(Request $request){
            $userData = [
                'usunome' => $request->input('usunome'),
                'usucpf' => $request->input('usucpf'),
                'usudatanascimento' => $request->input('usudatanascimento'),
                'usutelefone' => $request->input('usutelefone'),
                'usutipo' => 2,
                'usucep' => $request->input('usucep'),
                'usunumeroendereco' => $request->input('usunumeroendereco'),
                'usucomplementoendereco' => $request->input('usucomplementoendereco'),
                'usurua' => $request->input('usurua'),
                'usubairro' => $request->input('usubairro'),
                'usucidade' => $request->input('usucidade'),
                'usuestado' => $request->input('usuestado'),
                'password' => bcrypt('duociclo_lojista'),
                'lojcodigo' => $request->lojcodigo,
            ];
        
            if ($request->has('email')) {
                $userData['email'] = $request->input('email');
            }
        
            User::create($userData);
            return redirect()->route('consultaUsuario')->with('sucesso', 'Usuário cadastrado com sucesso.');
    }

    public function validaAlteracaoUsuario(Request $request){
        $id = $request->input('usucodigo');
        $bValido = $request->validate([
            'usunome'               => ['required'],
            'usucpf'                => ['required', 'min:11', (new Unique('users'))->ignore($id, 'id')],
            'usudatanascimento'     => ['required', 'date',
            function ($attribute, $value, $fail) {
                $dob = Carbon::parse($value);
                $idadeMinima = 18;

                if ($dob->age < $idadeMinima) {
                    $fail('O lojista deve ter pelo menos ' . $idadeMinima . ' anos de idade.');
                }
            }],
            'usutelefone'           => ['required'],
            'email'                 => ['required', 'email', (new Unique('users'))->ignore($id, 'id')],
            'usucep'                => ['required', 'min:8'],
            'usunumeroendereco'     => ['required', 'numeric'],
            'lojcodigo'             => ['required']
        ],[
            'usunome.required'           => 'O campo Nome é obrigatório!',
            'usucpf.required'            => 'O campo CPF é obrigatório!',
            'usucpf.min'                 => 'O campo CPF deve ter 11 números!',
            'usucpf.unique'              => 'Este CPF já está sendo utilizado!',
            'usudatanascimento.required' => 'O campo Data de Nascimento é obrigatório!',
            'usutelefone.required'       => 'O campo Telefone é obrigatório!',
            'email.required'             => 'O campo E-mail é obrigatório!',
            'email.email'                => 'O campo deve ter o @, pois o mesmo é do tipo E-mail!',
            'email.unique'               => 'Este e-mail já está sendo utilizado!',
            'usucep.required'            => 'O campo CEP é obrigatório!',
            'usucep.min'                 => 'O campo CEP deve ter 8 números!',
            'usunumeroendereco.required' => 'O campo N° Endereço é obrigatório!',
            'usunumeroendereco.numeric'  => 'Só deve ser informado números!',
            'lojcodigo'                  => 'O lojista precisa estar vinculado a uma loja!'
        ]);
        return response()->json(['isValid' => $bValido, 'errors' => $bValido ? [] : $validator->errors()->toArray()]);
    }

    public function alterarUsuario(Request $request, $id){
            $usuario = User::find($id);
            if (!$usuario) {
                \Log::error("Usuário não encontrado com ID: $id");
                return redirect()->route('consultaUsuario')->with('erro', 'Usuário não encontrado.');
            }
            
            $usuario->usunome                = $request->input('usunome');
            $usuario->usucpf                 = $request->input('usucpf');
            $usuario->usudatanascimento      = $request->input('usudatanascimento');
            $usuario->usutelefone            = $request->input('usutelefone');
            $usuario->usucep                 = $request->input('usucep');
            $usuario->usunumeroendereco      = $request->input('usunumeroendereco');
            $usuario->usucomplementoendereco = $request->input('usucomplementoendereco');
            $usuario->email                  = $request->input('email');
            $usuario->lojcodigo              = $request->lojcodigo;
    
            $usuario->save();
    
            return redirect()->route('consultaUsuario')->with('sucesso', 'Usuário alterado com sucesso.');
    }

    public function excluirUsuario(Request $request, $id){
        $usuario = User::find($id);
    
        if (!$usuario) {
            return redirect()->route('consultaUsuario')->with('erro', 'Usuário não encontrado!');
        }
        $usuario->delete();
    
        return redirect()->route('consultaUsuario')->with('sucesso', 'Usuário excluído com sucesso!');
    }

}
