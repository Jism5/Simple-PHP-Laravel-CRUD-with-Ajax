<?php

namespace App\Http\Controllers;

use App\Models\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;

class CrudController extends Controller
{

    public function displayproduct(){

        $data = Crud::all();
        return response()->json([
            'product'=>$data
        ]);
    }

    public function deleteproduct($id){

        $product = Crud::find($id);
        $product->delete();
        return response()->json([
            'status'=>200,
            'success'=>'Product delete successfully'
        ]);
    }

    public function seteditdata($id){
        $data = Crud::find($id);

        if($data){
            return response()->json([
                'status'=>200,
                'product'=>$data
                    ]);
        }else{
            return response()->json([
                'status'=>404,
                'success'=>'product did not found'
            ]);
        }
        
    }

    public function updateproduct(Request $request, $id){

        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'brand'=>'required',
            'price'=>'required',
            'stock'=>'required'
        ]);

        if($validation->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validation->messages()
            ]);
        }else{
            $product = Crud::find($id);
            if($product){
                $product->Product_name = $request->input('name');
                $product->Product_brand = $request->input('brand');
                $product->Product_price = $request->input('price');
                $product->Product_stock = $request->input('stock');
                $product->update();

                return response()->json([
                    'status'=>200,
                    'success'=>'Product updated'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'success'=>'Product did not found'
                ]);
            }
            
        }
    }


    public function insertproduct(Request $request){

        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'brand'=>'required',
            'price'=>'required',
            'stock'=>'required'
        ]);

        if($validation->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validation->messages()
            ]);
        }else{
            $product = new Crud;
            $product->Product_name = $request->input('name');
            $product->Product_brand = $request->input('brand');
            $product->Product_price = $request->input('price');
            $product->Product_stock = $request->input('stock');
            $product->save();

            return response()->json([
                'status'=>200,
                'success'=>'New product inserted'
            ]);
        }
    }
}
