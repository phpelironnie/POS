<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;

class Usuarios extends BaseController
{
    protected $usuarios, $cajas, $roles;
    protected $reglas, $reglasLogin, $reglasCambia;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();

        helper(['form']);

        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'is_unique' => 'El campo {field} debe ser unico.'
                ]
            ],

            'password' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],

            'repassword' => [
                'rules' => 'required|matches[password]', //confirmacion del password
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'matches' => 'Las contrase;as no coinciden'
                ]
            ],

            'nombre' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],

            'id_caja' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],

            'id_rol' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]
        ];

        //INGRESO
        $this->reglasLogin = [
            'usuario' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],

            'password' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]
        ];

        //CAMBIO
        $this->reglasCambia = [
            'password' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ],

            'repassword' => [
                'rules' => 'required|matches[password]', //confirmacion del password
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'matches' => 'Las contrase;as no coinciden'
                ]
            ],
        ];
    }

    public function index($activo = 1)
    {
        $usuarios = $this->usuarios->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/usuarios', $data);
        echo view('footer');
    }

    //Parar Crear
    public function nuevo()
    {
        $cajas = $this->cajas->where('activo', 1)->findAll(); //para traer los activos
        $roles = $this->roles->where('activo', 1)->findAll();

        $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles ];

        echo view('header');
        echo view('usuarios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        //Validacion Insertar
        if($this->request->getMethod() == "post" && $this->validate( $this->reglas))
        {
            //Cifrar password
            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            //Normal Insertar
            $this->usuarios -> save([
                'usuario'   => $this->request->getPost('usuario'),
                'password'  => $hash,
                'nombre'    => $this->request->getPost('nombre'),
                'id_caja'   => $this->request->getPost('id_caja'),
                'id_rol'    => $this->request->getPost('id_rol'),
                'activo'    => 1
            ]);
            
            return redirect()->to(base_url().'/usuarios');
        }

        else{
            $cajas = $this->cajas->where('activo', 1)->findAll(); //para traer los activos
            $roles = $this->roles->where('activo', 1)->findAll();

            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles , 'validation' => $this->validator];

            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    //Para Editar
    public function editar($id, $valid=null)
    {        
        $cajas = $this->cajas->where('activo', 1)->findAll(); //para traer los activos
        $roles = $this->roles->where('activo', 1)->findAll();

        $usuario = $this->usuarios->where('id',$id)->first();

        if($valid != null){
            $data = ['titulo' => 'Editar Usuario', 'cajas' => $cajas, 'roles' => $roles, 'usuario' => $usuario, 'validation' => $valid];
        }
        else{
            $data = ['titulo' => 'Editar Usuario', 'cajas' => $cajas, 'roles' => $roles, 'usuario' => $usuario];
        }

        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {        
        //Validacion Actualizar
        if($this->request->getMethod() == "post" && $this->validate( $this->reglas))
        {
            $this->usuarios -> update($this->request->getPost('id'),
            [
                'usuario'   => $this->request->getPost('usuario'),
                'nombre'    => $this->request->getPost('nombre'),
                'id_caja'   => $this->request->getPost('id_caja'),
                'id_rol'    => $this->request->getPost('id_rol'),
            ]);            
            return redirect()->to(base_url().'/usuarios');
        }
        else{
            $cajas = $this->cajas->where('activo', 1)->findAll(); //para traer los activos
            $roles = $this->roles->where('activo', 1)->findAll();

            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles , 'validation' => $this->validator];
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    //Para Eliminar (valor 0)
    public function eliminar($id)
    {
        $this->usuarios->update($id, ['activo' => 0]);
        return redirect()->to(base_url().'/usuarios');
    }

    // VISUAL ELIMINADOS
    public function eliminados($activo = 0)
    {
        $usuarios = $this->usuarios->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Usuarios eliminadas', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    //Para reestablecer (valor 0)
    public function reingresar($id)
    {
        $this->usuarios->update($id, ['activo' => 1]);
        return redirect()->to(base_url().'/usuarios');
    }

    //LOGIN
    public function login()
    {
        echo view('login');
    }

    //INGRESO-VALIDA
    public function valida()
    {
        if($this->request->getMethod() == "post" && $this->validate( $this->reglasLogin))
        {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

            if($datosUsuario != null){//validacion contraseña y cifrado
                if(password_verify($password, $datosUsuario['password'])){
                    $datosSesion = [
                        'id_usuario'    => $datosUsuario['id'],
                        'nombre'        => $datosUsuario['nombre'],
                        'id_caja'       => $datosUsuario['id_caja'],
                        'id_rol'        => $datosUsuario['id_rol']
                    ];

                    $session = session();
                    $session -> set($datosSesion);

                    return redirect()->to(base_url() . '/inicio');
                }
                else{
                    $data['error'] = "Las contraseñas no coniciden";
                    echo view('login', $data);
                }
            }
            else{
                $data['error'] = "El usuario no existe";
                echo view('login', $data);
            }
        }
        else{
            $data = ['validation' => $this->validator];
            echo view('login', $data);

        }
    }

    public function logout()
    {
        $session = session();
        $session -> destroy();
        return redirect()->to(base_url());
    }

    //PAGINA PARA CAMBIO DE CONTRASEÑA
    public function cambia_password()
    {
        $session = session();
        $usuario = $this->usuarios->where('id', $session->id_usuario)->first(); //para traer los activos

        $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario];

        echo view('header');
        echo view('usuarios/cambia_password', $data);
        echo view('footer');
    }

    //METODO PARA CAMBIO DE CONTRASEÑA
    public function actualizar_password()
    {
        //Validacion
        if($this->request->getMethod() == "post" && $this->validate( $this->reglasCambia))
        {
            $session = session();
            $idUsuario = $session->id_usuario;

            //Cifrar password
            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            //Enviar Nuevo
            $this->usuarios -> update( $idUsuario, ['password'  => $hash]);
            
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first(); //para traer los activos

            $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario, 'mensaje' => 'Contraseñaactualizada'];

            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }

        else{
            $session = session();
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first(); //para traer los activos

            $data = ['titulo' => 'Cambiar contraseña', 'usuario' => $usuario, 'validation' => $this->validator];

            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }
    }

}