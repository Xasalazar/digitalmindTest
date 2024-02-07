<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class DepartamentoController
 * @package App\Http\Controllers
 */
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departamentoId = $request->input('departamento_id');
        $cargoId = $request->input('cargo_id');
    
        $query = User::with('cargo', 'departamento');
    
        if ($departamentoId) {
            $query->where('id_departamento', $departamentoId );
        }
    
        if ($cargoId) {
            $query->where('id_cargo', $cargoId );
        }

        $users = $query->paginate();
    
        return $this->sendResponse($users, 'Mensaje de éxito', 200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($validation = $this->validateRequest($request)) {
            return $validation;
        }
        $user = User::create($request->all());
        return $this->sendResponse($user, 'Usuario creado Exitosamente', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('Usuario no encontrada', [], 404);
        }
        return $this->sendResponse($user, 'Mensaje de éxito', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('Usuario no encontrada', [], 404);
        }
        if ($validation = $this->validateRequest($request, $user)) {
            return $validation;
        }
        $user->update($request->all());
        return $this->sendResponse($user, 'Usuario actualizado Exitosamente', 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->sendError('Usuario no encontrada', [], 404);
        }
        $user->delete();
        return $this->sendResponse(null, 'Usuario eliminado Exitosamente', 200);
    }


    protected function validateRequest(Request $request, User $user = null)
    {
        $ReglaEmail = $user === null ? 'required|email:strict|unique:usuarios' : 'required|email:strict|unique:usuarios,email,' . $user->id . ',id';
        $validator = Validator::make($request->all(), [
            'primer_nombre' => 'required|max:50',
            'segundo_nombre' => 'max:50',
            'primer_apellido' => 'required|max:50',
            'segundo_apellido' => 'max:50', 
            'id_departamento' => 'required|numeric',
            'id_cargo' => 'required|numeric', 
            'email' => $ReglaEmail,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return $this->sendError('Error', $errors, 400);
        }
    }
}
