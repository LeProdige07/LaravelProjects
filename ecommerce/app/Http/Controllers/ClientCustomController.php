<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Order;
use App\Models\Client;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendMail;

class ClientCustomController extends Controller
{
    //
    public function home()
    {
        $sliders = Slider::all()->where('status', 1);
        $products = Product::all()->where('status', 1);
        return view('client.home',compact('sliders','products'));
    }

    public function shop()
    {
        $products = Product::all()->where('status', 1);
        $categories = Category::all();
        return view('client.shop',compact('products','categories'));
    }
    public function ajouteraupanier($id)
    {
        $product = Product::find($id);

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        Session::put('cart', $cart);

        // dd(Session::get('cart'));
        return back();
    }
    public function modifierqty(Request $request, $id){

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->updateQty($id, $request->quantity);
        Session::put('cart', $cart);

        //dd(Session::get('cart'));
        return back();
    }
    public function deletefromcart($id){
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items) > 0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }

        //dd(Session::get('cart'));
        return back();
    }
    public function panier()
    {
        if(!Session::has('cart')){
            return view('client.panier');
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        return view('client.panier', ['products' => $cart->items]);
    }
    public function paiement()
    {
        if(!Session::has('client')){
            return view('client.login');
        }

        if(!Session::has('cart')){
            return view('client.panier');
        }
        return view('client.paiement');
    }

    public function payer(Request $request){

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $order = new Order();

        $payer_id = time();

        $order->names = $request->input('name');
        $order->adresse = $request->input('address');
        $order->panier = serialize($cart); //serialize permet de sauver garder les objets en base de données
        $order->payer_id = $payer_id;

        $order->save();

        Session::forget('cart');

        $orders = Order::where('payer_id', $payer_id)->get();

        $orders->transform(function($order,$key){
            $order->panier = unserialize($order->panier);

            return $order;
        });

        $email = Session::get('client')->email;

        Mail::to($email)->send(new SendMail($orders));

        return redirect('/panier')->with('status','Votre commande a été effectuée avec succès !!');
    }

    public function login(){
      return view('client.login');

    }
    public function logout(){
        Session::forget('client');

        return back();
    }
    public function signup(){
       return view('client.signup');
    }
    public function creercompte(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:4'
        ]);

        $client = Client::create([
            'email'=> $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        return back()->with('status', 'votre compte a ete cree avec succes');
    }
    public function logincompte(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $client = Client::where('email', $request->input('email'))->first();

        if($client){
            if (Hash::check($request->input('password'), $client->password)) {
                Session::put('client', $client);
                return redirect('/shop');
            }else{
                return back()->with('status', 'Mauvais mot de passe ou email');
            }
        }else{
            return back()->with('status', 'Pas de compte avec cet email, veuillez créer un compte');
        }
    }
    public function orders(){
        $orders = Order::all();

        $orders->transform(function($order, $key){
            $order->panier = unserialize($order->panier);

            return $order;
        });

        return view('admin.orders', compact('orders'));
    }

}
