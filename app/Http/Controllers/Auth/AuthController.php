<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\product;
use App\Models\user;
use App\Models\wishlist;
use App\Models\cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('wishlist')
                ->withSuccess('You have Successfully loggedin');
        } else {
            return redirect("login")->withSuccess('Opps! You have entered invalid credentials');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("login")->withSuccess('Great! You have Successfully Registered now login <<');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function wish()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $products = DB::table('wishlists')
                ->join('users', 'users.id', '=', 'wishlists.customer_id')
                ->join('products', 'products.id', '=', 'wishlists.product_id')
                ->where('wishlists.customer_id', 'LIKE', '%' . $user_id . '%')
                ->select('products.*')->get();
            return view('wishlist', compact('products'));
        }

        return redirect("login");
    }
    public function cart()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $products = DB::table('carts')
                ->join('users', 'users.id', '=', 'carts.customer_id')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->where('carts.customer_id', 'LIKE', '%' . $user_id . '%')
                ->select('products.*')->get();

            return view('cart', compact('products'));
        }

        return redirect("login");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return user::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
    public function addtowishlist(Request $request, $id)
    {
        if (Auth::check()) {

            $wish = wishlist::where([['customer_id', $request->user()->id], ['product_id', $id]])->first();
            if (isset($wish)) {
                return redirect()->back()->withSuccess('already in wishlist');
            } else {
                $ins = array(
                    'customer_id' => $iduser = $request->user()->id,
                    'product_id' => $id
                );
                wishlist::create($ins);
                return redirect()->back()->with('message', 'product added to wishlist');
            }
        } else {
            return redirect('login')->withSuccess('login first');
        }
    }
    public function deletefromwishlist($id)
    {
        $user_id = Auth::id();
        $wish = wishlist::where([['customer_id', $user_id], ['product_id', $id]])->firstorfail()->delete();
        //echo("Deleted Successfully");
        return redirect()->back()->withSuccess('Deleted Successfully');
    }
    public function deletefromcart($id)
    {
        $user_id = Auth::id();
        $wish = cart::where([['customer_id', $user_id], ['product_id', $id]])->firstorfail()->delete();
        //echo("Deleted Successfully");
        return redirect()->back()->withSuccess('Deleted Successfully');
    }
    public function addtocart(Request $request, $id)
    {
        if (Auth::check()) {
            $cart = cart::where([['customer_id', $request->user()->id], ['product_id', $id]])->first();
            if (isset($cart)) {
                return redirect()->back()->withSuccess('already in cart');
            } else {
                $ins = array(
                    'customer_id' => $iduser = $request->user()->id,
                    'product_id' => $id
                );
                cart::create($ins);
                return redirect()->back()->with('message', 'product added to cart');
            }
        } else {
            return redirect('login')->withSuccess('login first');
        }
    }
    public function dashboard(Request $request)
    {
        if(Auth::check()){
            return view('dashboard');
            $user=user::find(Auth::user()->id);
            $user->weight=$request['weight'];
            $user->height=$request['height'];
            $user->save();
        }
        // dd($request);

       return redirect("login");
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if(Auth::check()){
            // return view('dashboard');
            $user=user::find(Auth::user()->id);
            $user->weight=$request['weight'];
            if($user->weight < 10 || $user->weight > 1000)
            {
                return redirect("dashboard")->withSuccess("Please enter valid data and Try again");
            }
            $user->height=$request['height'];
            if($user->height < 3 && $user->height > 0)
            {
                $user['BMI'] = $request->weight / ($request->height * $request->height);
            }
            else if ($user->height >0 && $user->height < 250)
            {
                $h = $user->height/ 100;
                $user['BMI'] = $request->weight / ($h * $h);
            }
            else
            {
                return redirect("dashboard")->withSuccess("Please enter valid data and Try again ");
            }
            if ($user['BMI']<18.5 && $user['BMI'] > 10) {
                $user['category']='u';
              }
            elseif($user['BMI']>=18.5 && $user['BMI']<25)
            {
                $user['category']='n';

            }
            elseif($user['BMI']>=25 )
            {
                $user['category']='o';
            }
            else
            {
                return redirect("dashboard")->withSuccess("Please enter valid data and Try again ");
            }
            //age and gender to calculate the daily calories
            $user->age=$request['age'];
            if($user-> age > 100 || $user->age > 100)
            {
                return redirect("dashboard")->withSuccess("Please enter valid data and Try again ");
            }
            $user->gender=$request['gender'];
            if(strcasecmp($user['gender'],'male'))
            {
                $user['calories']=66 + (13.7 *$request->weight) + (5 * $request->height) - (6.8 * $request->age);
            }
            elseif (strcasecmp($user['gender'],'female'))
            {
                $user['calories']=655 + (9.6 *$request->weight) + (1.8 * $request->height) - (4.7 * $request->age);
                //calories needed to maintain the weight
            }
            else
            {
                return redirect("dashboard")->withSuccess("Please enter valid data and Try again ");
            }
            //AddedCal is the user's calorie input
            $user->AddedCal=$request['AddedCal'];
            //total cal is the one to be displayed because this is the total of all calories the user inserted
            $user->TotalCal=($user['TotalCal'])+($user['AddedCal']);
            //remaining calories
            $user->RemCal=($user['calories'])-($user['TotalCal']);
            $user->save();
            if ($user->category == 'u') {
                return redirect("dashboard")
                ->withSuccess('Great! your BMI is : ' . round($user['BMI'], 2) .
                '  ,You are underweight.  Your Total calories is : ' . $user['TotalCal'] .
                ' To maintain your current weight, you should take  : ' . $user['calories'] . ' calories daily.',
                '. So Your remaining calories is : ' . $user['RemCal'] .'.');
            } elseif ($user->category == 'n') {
                return redirect("dashboard")
                ->withSuccess('Great! your BMI is : ' . round($user['BMI'], 2) .
                '  ,You are rockin a healthy body!. Your Total calories is : ' . $user['TotalCal'] .
                ' To maintain your current weight, you should take  : ' . $user['calories'] . ' calories daily.',
                '. So Your remaining calories is : ' . $user['RemCal'] .'.' );
            } elseif ($user->category == 'o') {
                return redirect("dashboard")
                ->withSuccess('Great! your BMI is : ' . round($user['BMI'], 2) .
                '  ,You are overweight. To maintain your current weight, you should take  : ' . $user['calories'] . ' calories daily.',
                '. So Your remaining calories is : ' . $user['RemCal'] .'.');
            }
            return 0;

        }
    }



    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
