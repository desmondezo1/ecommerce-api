<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\billing_address;
use Illuminate\Http\Request;
use \App\Models\User;

class userController extends Controller
{

    // -- PROTECT THIS CONTROLLER --

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()){
            return ['status' => 200, 'desc' => 'no users available'];
        }

        return ['status' => 200, 'desc' => 'Users fetched successfully', 'data'=> $users];

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($user_id)
    {
        $user = User::find($user_id);

        if (is_null($user)){
            return ['status' => 200, 'desc' => 'user not found'];
        }

//        add billing info to response
           $billingInfo = $this->getUserBillingInfo($user->id);
            if( $billingInfo['status'] === 200){
                $billingInfo =  $billingInfo['data'];
            }else{
                $billingInfo =  $billingInfo['desc'];
            }

        $user['billing'] =  $billingInfo;

        return ['status' => 200, 'desc' => 'User fetched successfully', 'data'=> $user];

    }


    public function getUserBillingInfo($user_id){

        $billingInfo = billing_address::where('user_id', $user_id)->first();
        if (is_null($billingInfo)){
            return ['status' => 500, 'desc' => 'Billing info not found'];
        }

        return ['status' => 200, 'desc' => 'Billing info found', "data" => $billingInfo ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $this->validate($request,[
            'first_name' => ['required','String'],
            'last_name' => 'required',
            'email' => ['required','email'],
            'phone' => ['required', 'Integer'],
            'password' => ['required', 'String'],
            'address' => ['required', 'String'],
            'state' => 'string',
            'city' => 'string',
            'country' => 'string',
            'photo' => 'required|string',
            'role'=> ['required', 'Integer', 'exists:user_roles,id']
        ]);

        if (User::where('email', '=', $request->email)->exists() OR User::where('phone', '=', $request->phone)->exists()){
            return  ['status' => '406', 'desc' =>'User already exists'];
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => md5($request->password),
                'address' => $request->address,
                'role'=> $request->role,
            ]);
        } catch (\Exception $e){
        return  ['status' => '500', 'desc' => $e->getMessage()];
        }



        return ['status' => 200, 'desc' => 'user created successfully', 'data'=> $user ];

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
        $validatedData = $this->validate($request,[
            'first_name' => ['String'],
            'last_name' => 'String',
            'email' => ['email'],
            'phone' => ['Integer'],
            'password' => ['String'],
            'address' => ['String'],
            'role'=> ['string']
        ]);

        $user = User::find($id);
        if (is_null($user)){
            return ['status' => 500, 'desc' => 'user not found', 'data'=> $user ];
        }
        isset ($request->first_name) ? $user->first_name = $request->first_name: false;
        isset ($request->last_name) ? $user->last_name = $request->last_name: false;
        isset ($request->email) ? $user->email = $request->email: false;
        isset ($request->phone) ? $user->phone = $request->phone: false;
        isset ($request->password) ? $user->password = md5($request->password) : false;
        isset ($request->address) ? $user->address = $request->address : false;
        isset ($request->role) ? $user->role = $request->role : false;
        $user->save();

        return ['status' => 200, 'desc' => 'user updated successfully', 'data'=> $user ];
    }

    public function updateBillingAddress(Request $request, $user_id){
        $this->validate($request, [
            "is_company" => ['Boolean'],
            "first_name" => ['String'],
            "last_name" => ['String'],
            "company_name" => ['String'],
            "address1" => ['String'],
            "address2" => ['String'],
            "city" => ['String'],
            "state" => ['String'],
            "post_code" => ['String'],
            "country" => ['String'],
            "phone" => ['digits_between:5,16'],
            "email" => ['email'],
            "tax_id_code" => ['String'],
            "vat_number" => ['String'],
            "unique_code" => ['String'],
            "pec" => ['String'],
            "reference_person" => ['String'],
            "house_no" => ['String'],
            "recipient_code" => ['String'],
            "fax" => ['String'],
            "cap" => ['String'],
        ]);

        $billInfo = billing_address::where('user_id',$user_id)->first();
        if (is_null($billInfo)){
            $request->request->add(['user_id',$user_id]);
            $response = $this->createBillingAddress($request);
            return $response;
        }

        try {
            $billInfo->is_company = $request->is_company;
            $billInfo->first_name = $request->first_name;
            $billInfo->last_name = $request->last_name;
            $billInfo->company_name = $request->company_name;
            $billInfo->address1 = $request->address1;
            $billInfo->address2 = $request->address2;
            $billInfo->city = $request->city;
            $billInfo->state = $request->state;
            $billInfo->post_code = $request->post_code;
            $billInfo->country = $request->country;
            $billInfo->phone = $request->phone;
            $billInfo->email = $request->email;
            $billInfo->tax_id_code = $request->tax_id_code;
            $billInfo->vat_number = $request->vat_number;
            $billInfo->unique_code = $request->unique_code;
            $billInfo->pec = $request->pec;
            $billInfo->reference_person = $request->reference_person;
            $billInfo->house_no = $request->house_no;
            $billInfo->recipient_code = $request->recipient_code;
            $billInfo->fax = $request->fax;
            $billInfo->cap = $request->cap;
            $billInfo->save();
        } catch (\Exception $e){
            return ['status' => 500, 'desc' => 'Can\'t update Billing info : '. $e->getMessage()];

        }

    }

    public function createBillingAddress(Request $request){
        $this->validate($request, [
            "is_company" => ['Boolean'],
            "user_id" => ['Integer','exists:users,id','unique:billing_addresses,user_id'],
            "first_name" => ['String'],
            "last_name" => ['String'],
            "company_name" => ['String'],
            "address1" => ['String'],
            "address2" => ['String'],
            "city" => ['String'],
            "state" => ['String'],
            "post_code" => ['String'],
            "country" => ['String'],
            "phone" => ['digits_between:5,16'],
            "email" => ['email'],
            "tax_id_code" => ['String'],
            "vat_number" => ['String'],
            "unique_code" => ['String'],
            "pec" => ['String'],
            "reference_person" => ['String'],
            "house_no" => ['String'],
            "recipient_code" => ['String'],
            "fax" => ['String'],
            "cap" => ['String'],
        ]);

        try {
            $billInfo = billing_address::create([
                    "is_company" => $request->is_company,
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "company_name" => $request->company_name,
                    "address1" => $request->address1,
                    "address2" => $request->address2,
                    "city" => $request->city,
                    "state" => $request->state,
                    "post_code" => $request->post_code,
                    "country" => $request->country,
                    "phone" => $request->phone,
                    "email" => $request->email,
                    "tax_id_code" => $request->tax_id_code,
                    "vat_number" => $request->vat_number,
                    "unique_code" => $request->unique_code,
                    "pec" => $request->pec,
                    "reference_person" => $request->reference_person,
                    "house_no" => $request->house_no,
                    "recipient_code" => $request->recipient_code,
                    "fax" => $request->fax,
                    "cap" => $request->cap,
            ]);

            return ['status' => 200, 'desc' => 'Created Billing info Successfully ', "data" => $billInfo];
        } catch (\Exception $e){
            return ['status' => 500, 'desc' => 'Can\'t update Billing info : '. $e->getMessage()];

        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);

        if (!$user){
            return ['status' => 500, 'desc' => 'user was not deleted' ];
        }

        return ['status' => 200, 'desc' => 'user has been deleted successfully' ];


    }
}
