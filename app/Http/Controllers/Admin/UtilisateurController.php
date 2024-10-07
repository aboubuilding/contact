<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Utilisateur;

use App\Types\TypeStatus;
use Illuminate\Http\Request;


class UtilisateurController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $users = Utilisateur::getListe();

        foreach($users as $user ){
            $data []  = array(

                "id"=>$user->id,
                "nom_prenom" => $user->prenom == null ? ' ' : $user->nom.' '.$user->prenom,
                "login"=>$user->login == null ? ' ' :$user->login,

                "role"=>$user->role == null ? ' ' :$user->role,
            );
        }

        return view('admin.utilisateur.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){



        $validator = \Validator::make($request->all(),[
            'nom'=>'required',
            'prenom'=>'required',
            'login'=>'required|string|unique:Users',
            'mot_passe'=>'required',
            'role'=>'required',


        ],[
            'nom.required'=>'Le nom   est obligatoire ',
            'prenom.required'=>'Le prenom   est obligatoire ',
            'login.required'=>'Le login    est obligatoire',
            'mot_passe.required'=>'Le mot de passe    est obligatoire ',
            'role.required'=>'Le role   est  obligatoire ',
            'login.unique'=>'Le login   existe déjà ',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{





                 Utilisateur::addUtilisateur(

                    $request->nom,
                    $request->prenom,
                    $request->login,
                   $request->mot_passe,
                    $request->role,



                );



                return response()->json(['code'=>1,'msg'=>'Utilisateur ajoutée avec succès ']);
            }
        }



    public function update(Request $request, $id){

        $user = User::rechercheUserById($id);
        $validator = \Validator::make($request->all(),[

            'nom'=>'required',
            'prenom'=>'required',
            'login'=>'required|string|unique:Users,login,'.$id,
            'mot_passe'=>'required',
            'role'=>'required',


        ],[
            'nom.required'=>'Le nom   est obligatoire ',
            'prenom.required'=>'Le prenom   est obligatoire ',
            'login.required'=>'Le login    est obligatoire ',
            'mot_passe.required'=>'Le mot de passe    est obligatoire ',
            'role.required'=>'Le role   est  obligatoire ',
            'login.unique'=>'Le login   existe déjà ',



        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{



            Utilisateur::updateUtilisateur(

                $request->nom,
                $request->prenom,
                $request->login,
               $request->mot_passe,
                $request->role,

                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Utilisateur modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un User
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $user = Utilisateur::rechercheUserById($id);


        return response()->json(['code'=>1, 'utilisateur'=>$user]);


    }



    /**
     * Supprimer   une  User scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = User::deleteUser($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Utilisateur  supprimée ";
        } else {
            $success = true;
            $message = "Utilisateur  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


    /**
     * Authentifier   un Utilisateur
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\JsonResponse

     */
    public function authenticate( Request $request)
    {


        $data = Utilisateur::isAuthenticate(

            $request->login,
            $request->mot_passe,



        );


        if ($data['isValid'])
        {
            // Saisie données en session

            $compte = Utilisateur::where('etat', '!=', TypeStatus::SUPPRIME)


                ->where('login', '=', $request->login)


                ->first();

            $request->session()->put('LoginUser',[
                'compte_id' => $compte->id ,
                'annee_id' => 1,

            ]);


        }

        return response()->json(['data' => $data]);

    }




}
