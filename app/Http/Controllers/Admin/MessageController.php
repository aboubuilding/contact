<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

use Illuminate\Http\Request;


class MessageController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $messages = Message::getListe();

        foreach($messages as $message ){
            $data []  = array(

                "id"=>$message->id,
                "date_message"=> $message->date_message == null ? ' ' : $message->date_message,
                "telephone_destinataire"=> $message->telephone_destinataire == null ? ' ' : $message->telephone_destinataire,
                "titre"=> $message->titre == null ? ' ' : $message->titre,
                "eleve"=> $message->inscription_id == null ? ' ' : $message->inscription->eleve->nom.''.$message->inscription->eleve->prenom,
                "niveau"=> $message->inscription_id == null ? ' ' : $message->inscription->niveau->libelle,



            );
        }

        return view('admin.message.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){



        $validator = \Validator::make($request->all(),[
            'date_message'=>'required',
            'telephone_destinataire'=>'required',
            'inscription_id'=>'required',





        ],[
            'date_message.required'=>'Le libellé  est obligatoire ',
            'telephone_destinataire.required'=>'Le libellé  doit etre une chaine de caracteres ',

            'inscription_id.required'=>'Le choix de l eleve est obligatoire ',





        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{


                 Message::addMessage(

                    $request->date_message,
                    $request->telephone_destinataire,
                    $request->titre,
                    $request->message,
                    $request->espace_id,
                    $request->compte_id,
                    $request->annee_id,
                    $request->inscription_id,
                    $request->utilisateur_id,


                );



                return response()->json(['code'=>1,'msg'=>'Message  ajouté avec succès ']);
            }
        }



    public function update(Request $request, $id){


        $validator = \Validator::make($request->all(),[

            'date_message'=>'required',
            'telephone_destinataire'=>'required',
            'inscription_id'=>'required',

        ],[
            'date_message.required'=>'Le libellé  est obligatoire ',
            'telephone_destinataire.required'=>'Le libellé  doit etre une chaine de caracteres ',

            'inscription_id.required'=>'Le choix de l eleve est obligatoire ',



        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

                Message::updateMessage(

                    $request->date_message,
                    $request->telephone_destinataire,
                    $request->titre,
                    $request->message,
                    $request->espace_id,
                    $request->compte_id,
                    $request->annee_id,
                    $request->inscription_id,
                    $request->utilisateur_id,

                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Message modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un Message
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $message = Message::rechercheMessageById($id);


        return response()->json(['code'=>1, 'Message'=>$message]);


    }



    /**
     * Supprimer   une  Message scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = Message::deleteMessage($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Message  supprimée ";
        } else {
            $success = true;
            $message = "Message  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }









}
