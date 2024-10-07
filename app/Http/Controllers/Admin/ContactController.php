<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

use Illuminate\Http\Request;


class ContactController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $contacts = Contact::getListe();

        foreach($contacts as $contact ){
            $data []  = array(

                "id"=>$contact->id,
                "date_email"=> $contact->date_email == null ? ' ' : $contact->date_email,
                "email_destinataire"=> $contact->date_email == null ? ' ' : $contact->date_email,
                "objet_destinataire"=> $contact->objet_destinataire == null ? ' ' : $contact->objet_destinataire,
                "eleve"=> $contact->inscription_id == null ? ' ' : $contact->inscription->eleve->nom.''.$contact->inscription->eleve->prenom,
                "niveau"=> $contact->inscription_id == null ? ' ' : $contact->inscription->niveau->libelle,



            );
        }

        return view('admin.contact.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){



        $validator = \Validator::make($request->all(),[
            'date_email'=>'required',
            'email_destinataire'=>'required',
            'inscription_id'=>'required',





        ],[
            'date_email.required'=>'Le libellé  est obligatoire ',
            'email_destinataire.required'=>'Le libellé  doit etre une chaine de caracteres ',

            'inscription_id.required'=>'Le choix de l eleve est obligatoire ',





        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{


                 Contact::addContact(

                    $request->date_email,
                    $request->email_destinataire,
                    $request->objet_destinataire,
                    $request->message,
                    $request->espace_id,
                    $request->compte_id,
                    $request->annee_id,
                    $request->inscription_id,
                    $request->utilisateur_id,


                );



                return response()->json(['code'=>1,'msg'=>'Contact  ajouté avec succès ']);
            }
        }



    public function update(Request $request, $id){


        $validator = \Validator::make($request->all(),[

            'date_email'=>'required',
            'email_destinataire'=>'required',
            'inscription_id'=>'required',

        ],[
            'date_email.required'=>'Le libellé  est obligatoire ',
            'email_destinataire.required'=>'Le libellé  doit etre une chaine de caracteres ',

            'inscription_id.required'=>'Le choix de l eleve est obligatoire ',



        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

                Contact::updateContact(

                    $request->date_email,
                    $request->email_destinataire,
                    $request->objet_destinataire,
                    $request->message,
                    $request->espace_id,
                    $request->compte_id,
                    $request->annee_id,
                    $request->inscription_id,
                    $request->utilisateur_id,

                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Contact modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un Contact
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $contact = Contact::rechercheContactById($id);


        return response()->json(['code'=>1, 'Contact'=>$contact]);


    }



    /**
     * Supprimer   une  Contact scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = Contact::deleteContact($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Contact  supprimée ";
        } else {
            $success = true;
            $message = "Contact  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }









}
