<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use App\Models\Order;

use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        /*
        first we have to make sure that the 
        book user trying to buy is in our database
        */
        $book = book::find($request->book_id);
        if(!$book)
        {
            return "Book Not Found (T ^ T)!!!";
        }
        $record = new Order;
        $record->book_id = $request->book_id; 
        $record->price =  $book->book_price; 
        /*
        we have to get the price from the book table 
        not from the view so the user will not be 
        able to change the price
         */
        $record->user_id = 1; //Auth::user()->id;
        $record->payment_status = "unpaid";
        $record->save();
        //return "Order Place Successfully (^ o ^)";

        return $this->PayByThawani($record, $book);
    }
    //online payment function ... 
    public function PayByThawani($record, $book)
    {
        $products = [];
        $products[0] = [
            'name'=>$book->book_name,
            'quantity'=> 1,
            'unit_amount'=> intval($book->book_price) * 1000
            /*
             we use intval for unit_amount to change it from 
             decimal to integer and we * 1000 becouse thawani 
             work with passh and our website work with OMR
             */
        ];
        $metadata = [
            'Customer name'=>"Rahma",
            'email'=>"Rahma@fahad.com"
            /*
            in the metadata we can add what ever we want
            but we have to make sure thet we add the customer 
            name and one way to contact with him
             */
        ];
        $data = [
            //here we will but all the data thawain api need
            'client_reference_id'=>$record->id,
            /*
            client_reference_id ... it is the order id
            which store in our example in $record
             */
            'mode'=> "payment",
            // mode is always payment if we do online payment
            'products'=>$products,
            'success_url'=>"https://localhost:8000/payment/success",
            /*
            to send data through the url 
            'success_url'=>"https://localhost:8000/payment/success?Vname=$x"
            EXAMPLE:
            'success_url'=>"https://localhost:8000/payment/success?order_id=$order->id"
             */
            'cancel_url'=>"https://localhost:8000/payment/cancel",
            'metadata'=>$metadata

        ];
        $response = Http::withHeaders([
          'thawani-api-key'=>'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et'
        ])->post('https://uatcheckout.thawani.om/api/v1/checkout/session', $data);

        if($response->successful())
        {
            $tempResponse = json_decode($response);
            /*
            we use json_decode() becuase the $response coming from thawani will
            be string and we need to change it to array format 
             */
            $session_id = $tempResponse->data->session_id;
            $publishable_key = "HGvTMLDssJghr9tlN9gr4DVYt0qyBy";

            return redirect("https://uatcheckout.thawani.om/pay/$session_id?key=$publishable_key");
        }

        return "Payment Failed";

    }

    public function ThawaniCallBack($status)
    {
        return "Payment" . $status;
    }


}
