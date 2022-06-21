<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $user = User::where('id',1)->first();
        $stripe = new \Stripe\StripeClient(
            'sk_test_51IxDieLvcpJBrHUE2HQJNtM2jOfSsmHp3kG3lTn7FRM5PndKrGrUCWNUfWm8Uy8TVPdXqJ4XWNYhTnzvLubnU4Zo00Vo6VtuTj'
        );
        $article = Article::where('id',$request->query->get('article'))->first();
        $paymentMethod = $stripe->paymentMethods->create($request->payment_method);
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($article->price * 100, $paymentMethod);
            return response()->json('payment_success',200);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
