<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

/* O desconto $DISCOUNT é aplicado ao preço de cada produto no pedido da qual a
 * quantidade está entre $MIN_QTY e $MAX_QTY (inclusivo) e
 * preço unitário * quantidade é pelo menos $500.
*/
const DISCOUNT = 0.15;
const MIN_QTY = 5;
const MAX_QTY = 9;
const MIN_AMOUNT = 500;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = json_decode($request->getContent(), true);
        $aggregated_products = [];
        $totalWithDiscount = 0;
        $discount = 0;
        foreach ($products as $p) {
            $aggregated_products[$p['ArticleCode']] = $p;
            $aggregated_products[$p['ArticleCode']]['Quantity'] = 0;
        }
        foreach ($products as $p) {
            $aggregated_products[$p['ArticleCode']]['Quantity'] += $p['Quantity'];
        }
        foreach ($aggregated_products as $articleCode => $p) {
            if (MIN_QTY <= $p['Quantity'] && $p['Quantity'] <= MAX_QTY
                && MIN_AMOUNT <= $p['Quantity'] * $p['UnitPrice']) {
                $totalWithDiscount += (1 - DISCOUNT) * $p['Quantity'] * $p['UnitPrice'];
                $discount += DISCOUNT * $p['Quantity'] * $p['UnitPrice'];
            } else {
                $totalWithDiscount += $p['Quantity'] * $p['UnitPrice'];
            }
        }
        // Order::create(ALGO::serialize($request->all())); in the future
        return Order::create([
            'date' => Carbon::today()->format('Y-m-d'),
            'total' => $totalWithDiscount,
            'discount' => $discount,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
