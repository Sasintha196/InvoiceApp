<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function all_customer(){
        $customers = Customer::orderBy('id', 'DESC')->get();

        return response()->json([
            'customers' => $customers
        ], 200);
    }



    public function create_customer() {

        $customerData = [
            'firstname' => null,
            'lastname' => null,
            'email' => null,
            'address' => null,


        ];
        return response()->json($customerData);

    }

    public function add_customer(Request $request){

        //for customer table
        $customerdata['firstname'] = $request->input("firstname");
        $customerdata['lastname'] = $request->input("lastname");
        $customerdata['email'] = $request->input("email");
        $customerdata['address'] = $request->input("address");

        Customer::create($customerdata);


    }

   public function search_customer (Request $request) {
        $searchedCustomer = $request->get('sandu');
        if($searchedCustomer != null) {
            $customer = Customer::where('email', 'LIKE', "%$searchedCustomer%")->get();
            return response()->json([
                'customer' => $customer
            ], 200);
        }

    }
}
