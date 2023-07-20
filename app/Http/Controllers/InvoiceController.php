<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Mail\InvoiceInfo;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Invoice/List', [
            'allInvoice' => Invoice::with('invoiceDetails', 'invoiceDetails.product')->orderBy('created_at', "desc")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Invoice/Create', [
            'allProducts' => Product::orderBy('created_at', "asc")->get(),
            'invoice_no' => Invoice::orderBy("created_at", "asc")->first() ? Invoice::orderBy("created_at", "desc")->first()->invoice_no + 1 : 1001,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {

        try {
            DB::beginTransaction();
            $invoice = Invoice::create([
                'invoice_no' => $request->validated()['invoice_no'],
                'customer_email' => $request->validated()['customer_email'],
                'date' => $request->validated()['date'],
                'due_date' => $request->validated()['due_date'],
                'comment' => $request->validated()['comment'],
                'subtotal' => $request->validated()['subtotal'],
                'discount' => $request->validated()['discount'],
                'tax' => $request->validated()['tax'],
                'total' => $request->validated()['total'],
            ]);


            for ($i = 0; $i < count($request->validated()['product_id']); $i++) {
                $invoice->invoiceDetails()->create([
                    'product_id' => $request->validated()['product_id'][$i],
                    'price' => $request->validated()['price'][$i],
                    'quantity' => $request->validated()['quantity'][$i],
                    'total' => $request->validated()['rowTotal'][$i],
                ]);
            }
            Mail::to($invoice->customer_email)->send(new InvoiceInfo($invoice));
            DB::commit();
            return Inertia::render('Invoice/List', [
                'allInvoice' => Invoice::with('invoiceDetails', 'invoiceDetails.product')->orderBy('created_at', "desc")->get(),
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return false;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function getProduct(Product $product)
    {
        return $product;
    }

    public function printInvoice(Invoice $invoice)
    {
        return view('print')->with('invoice',$invoice);
    }
}
