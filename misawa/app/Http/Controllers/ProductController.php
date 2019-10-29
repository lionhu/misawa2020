<?php

namespace App\Http\Controllers;

use App\Events\BrowseProductEvent;
use App\Events\NewCommentEvent;
use App\Http\Requests\requestAddNewProduct;
use App\Http\Requests\requestCommentProduct;
use App\Http\Requests\requestEditProduct;
use App\Events\ShareProductEvent;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Notifications\notificationNewComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utilities\Cart;
use Session;
use Event;
use App\Repositories\Eloquent\ProductRepository;
use Storage;
use File;
use Intervention\Image\ImageManagerStatic as interImage;
//use Intervention\Image\Size;

class ProductController extends Controller
{
    protected $repoProduct;
    public function __construct(ProductRepository $productRepository)
    {
        $this->repoProduct=$productRepository;
    }

    public function getAllActiveProducts()
    {
        $products=Product::active()
            ->get(["id","name","name_jp","thumbimage","postimage","subcatalogue_id"]);

        return view("shop.home",[
            "result"=>"OK",
            "products"=>$products
        ]);
    }


    public function admin_updateProductInfo(Request $request)
    {
        $type=$request->input("type");

        $product=Product::find($request->input("productid"));

        if($product){
            switch ($type){
                case "price":
                    $product->o_price=$request->input("o_price");
                    $product->b_price=$request->input("b_price");
                    $product->j_price=$request->input("j_price");
                    $product->r_price=$request->input("r_price");
                    break;
                case "active":
                    $product->active=$request->input("active");
                    break;
                case "catalogue":
                    $product->catalogue_id=$request->input("catalogue_id");
                    $product->subcatalogue_id=$request->input("subcatalogue_id");
                    break;
                case "details":
                    $product->efficacy=$request->input("efficacy");
                    $product->description=$request->input("description");
                    $product->website=$request->input("website");
                    break;
                case "removeProductImage":
                    \Log::info("removeProductImage");
                    \Log::info($request);
                    $no=$request->input("no");
                    self::RemoveProductImage($product->id,$no);
                    break;

                case "basic":
                    $product->name=$request->input("name");
                    $product->name_jp=$request->input("name_jp");
                    $product->product_code=$request->input("product_code");
                    $product->manufactory=$request->input("manufactory");
                    break;
                default:
                    break;
            }

            $product->save();

            $product=Product::with("catalogue","subcatalogue","vendor","images")
                ->where("id",$request->input("productid"))
                ->first();

            return response([
                "result"=>"OK",
                "product"=>$product
            ],201);
        }

        return response([
            "result"=>"NG",
            "product"=>null
        ],201);

    }
    public function getProductInfo(Request $request,$productid){
        $productid=$request->input("productid");
        $product=Product::find($productid);

        $oldcart=null;
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;
//
        $mycart=new Cart($oldcart);

        $product_qty=$mycart->getItemCount($productid);

        return [
            "result"=>"OK",
            "productname"=>$product->name,
            "productcode"=>$product->product_code,
            "o_price"=>$product->o_price,
            "postimage"=>$product->postimage,
            "subcatalogue"=>$product->subcatalogue->name,
            "catalogue"=>$product->catalogue->name,
            "qty"=>$product_qty,
            "cart_total"=>$mycart->Total_Qty
        ];
    }

    public function postProductInfo(Request $request){
        $productid=$request->input("productid");
        $product=Product::find($productid);

        $oldcart=null;
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;

        $mycart=new Cart($oldcart);

        $product_qty=$mycart->getItemCount($productid);

//        broadcast(new BrowseProductEvent($request->user()->id,
//            $this->repoProduct->getSafeProductInfo($product->id)))->toOthers();

        event(new BrowseProductEvent($request->user()->id,$product->id));

        return [
            "result"=>"OK",
            "productname"=>$product->name,
            "productcode"=>$product->product_code,
            "o_price"=>$product->o_price,
            "postimage"=>$product->postimage,
            "subcatalogue"=>$product->subcatalogue->name,
            "catalogue"=>$product->catalogue->name,
            "qty"=>$product_qty,
            "cart_total"=>$mycart->Total_Qty,
            "efficacy"=>$product->efficacy
        ];
    }

    public function admin_getProductofSubcatalogue(Request $request)
    {
        \Log::info($request);
        $catalogue_id=$request->input("catalogue_id");
        $subcatalogue_id=$request->input("subcatalogue_id");
        $keyworld=$request->input("keyworld");
        $type=$request->input("type");

        if($type=="catalogue"){
            $products=Product::with("catalogue","subcatalogue","vendor","images")
                ->where("subcatalogue_id",$subcatalogue_id)->get();
        }else{
            $products=Product::with("catalogue","subcatalogue","vendor","images")->
            where('name', 'LIKE', '%'.$keyworld.'%')->get();
        }

        return response([
            "result"=>"OK",
            "products"=>$products
        ]);
    }


    public function member_getProductofSubcatalogue(Request $request)
    {
        \Log::info($request);
        $catalogue_id=$request->input("catalogue_id");
        $subcatalogue_id=$request->input("subcatalogue_id");
        $keyworld=$request->input("keyworld");
        $type=$request->input("type");

        if($type=="catalogue"){
            $products=Product::with("catalogue","subcatalogue","vendor","images")
                ->where("subcatalogue_id",$subcatalogue_id)->get();
        }else{
            $products=Product::with("catalogue","subcatalogue","vendor","images")->
            where('name', 'LIKE', '%'.$keyworld.'%')->get();
        }

        return response([
            "result"=>"OK",
            "products"=>$products
        ]);
    }

    public function admin_getAllProducts(){
        $products=Product::with("catalogue","subcatalogue","vendor","images")
            ->get();

        return response([
            "result"=>"OK",
            "products"=>$products
        ],201);


    }
    public function admin_getAddNewProduct(){
        return view("admin.product_add");
    }

    public function UpdateProductPostImage(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            \Log::info($request);

            $product_id=$request->input("productid");
            $photo=$request->file('file');

            $product=Product::find($product_id);

            if ($product) {
                $oldPostImage=$product->postimage;
                if($product->postimage !== "") {
                    if (File::exists($product->postimage)) {
                        \Log::info("delete image:" . $product->postimage);
                        File::delete($product->postimage);
                        $product->postimage = "";
                    }
                }
                if($product->thumbImage !== "") {
                    if (File::exists($product->thumbImage)) {
                        \Log::info("delete image:" . $product->thumbImage);
                        File::delete($product->thumbImage);
                        $product->thumbImage = "";
                    }
                }

                $dt = Carbon::now();
                $postimage_filename = $product->id .'_'.$dt->timestamp. '.jpg';
                $postimage_path = env("PRODUCT_IMAGE_FOLDER") . $postimage_filename;
                interImage::make($photo)->save($postimage_path);

                $size=env("THUMBIMAGE_SIZE");
                $thumbnail_filename = 'thumb_'.$product->id .'_'.$dt->timestamp.'.jpg';
                $thumbimage_path = env('PRODUCT_THUMBIMAGE_FOLDER').$thumbnail_filename;
                interImage::make($photo)->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbimage_path);

                $product->thumbImage=$thumbimage_path;
                $product->postimage=$postimage_path;

                $oldImage=Image::where("path_image",$oldPostImage)->first();

                if($oldImage){
                    $oldImage->delete();
                }
                $image=new Image();
                $image->path_image=$postimage_path;
                $image->save();

                $product->images()->save($image);

                $product->save();

                $product=Product::with("catalogue","subcatalogue","vendor","images")
                    ->where("id",$product_id)->first();

                return response([
                    "product" => $product,
                    "no" => 0,
                    "result" => "OK"
                ], 201);
            }
        }
    }

    protected function RemoveProductImage($product_id,$_oldImage){
        $_oldImage = Image::where("path_image", $_oldImage)->first();

        $existed=false;
\Log::info($_oldImage);
            if (File::exists($_oldImage->path_image)) {
                \Log::info("delete image:" . $_oldImage);
                File::delete($_oldImage->path_image);
                $_oldImage->delete();
                $existed=true;
            }

        return $existed;
    }
    public function UpdateProductImage(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            \Log::info($request);

            $product_id = $request->input("productid");
            $image_id = $request->input("no");
            $photo = $request->file('file');


            $dt = Carbon::now();
            $image_filename = $product_id . '_' . $image_id . '_' . $dt->timestamp . '.jpg';
            $image_path = env("PRODUCT_IMAGE_FOLDER") . $image_filename;

            $_oldImages = Image::where("imageable_id", $product_id)->get();

            $existed=false;
            foreach ($_oldImages as $oldImage) {
                $nos = explode("_", $oldImage->path_image);
                $no = $nos[1];

                \Log::info("no is: ".$no);

                if ($no == $image_id && File::exists($oldImage->path_image)) {
                    \Log::info("delete image:" . $oldImage->path_image);
                    File::delete($oldImage->path_image);
                    $oldImage->path_image = $image_path;
                    $oldImage->save();
                    $existed=true;
                }
            }


            interImage::make($photo)->save($image_path);
            $product = Product::find($product_id);

            if (!$existed){
                $image = new Image();
                $image->path_image = $image_path;
                $image->save();

                $product->images()->save($image);
            }

            $product->save();

            $product = Product::with("catalogue", "subcatalogue", "vendor", "images")
                ->where("id", $product_id)->first();

            return response([
                "product" => $product,
                "no"=>$image_id,
                "path_image"=>$image_path,
                "result" => "OK"
            ], 201);
        }else{
            return response([
                "product" => null,
                "no"=>0,
                "result" => "NG"
            ], 201);
        }

    }

//    public function admin_postAddNewProduct(Request $request){
    public function admin_postAddNewProduct(Request $request){

        \Log::info($request);

        $newproduct_id=$this->repoProduct->addNewProductInfo($request);

        \Log::info($newproduct_id);
        $product=Product::find($newproduct_id);

        return response([
            "result"=>"OK",
            "product"=>$product
        ],201);

        return redirect()->route("admin_Products_home");
    }

    public function saveProductImage($product,$file,$index,$hasthumbimage){

        $file_path = env('PRODUCT_IMAGE_FOLDER')  ;
        $filename = $file_path . $product->id .'_'.$index. '.jpg';
        Storage::disk('local')->put($filename, File::get($file));

        $image=new Image();
        $image->path_image=$filename;
        $image->save();



        $product->images()->save($image);

        if ($hasthumbimage == true){
            $thumbimage_path = env('PRODUCT_THUMBIMAGE_FOLDER');
            $thumbnail_filename = $thumbimage_path . 'thumb_'.$product->id. '.jpg';
            $size=env("THUMBIMAGE_SIZE");

            interImage::make($file)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnail_filename);

            $product->thumbImage=$thumbnail_filename;
            $product->postimage=$filename;
        }

        $product->save();


    }


    public function admin_getEditProduct(Request $request){
        $id=$request->input("productid");

        $product=Product::with("catalogue","subcatalogue","images")->find($id);

//        dd($product);
        if ($product !=null){
            return view("admin.product_edit",[
                "product"=>$product
            ]);
        }else{
            echo "NG";
        }
//        return view("admin.product_edit");
    }

    public function admin_postEditProduct(requestEditProduct $request){
        $id=$request->input("productid");

        $product=$this->repoProduct->updateProductInfo($request,$id);




        $image_1=$request->file("postimage_1");
        $image_2=$request->file("postimage_2");

        if ($image_1){
            foreach ($product->images as $image){
                $image->delete();
            }
            $this->saveProductImage($product,$image_1,1,true);
        }
        if ($image_2){
            $this->saveProductImage($product,$image_2,2,false);
        }
        return redirect()->back()->withInput();
    }

    public function getSearchProducts(Request $request){
        $searchtext=$request->input("searchtext");

        $products=$this->repoProduct->searchForProduct($searchtext);

//        dd($products);

        if (count($products)>0){
            return view("shop.searchproduct",[
                "products"=>$products
            ]);
        }

    }


    public function newcomment(Request $request,$productid){
        $message=$request->input("message");
        if ($message){
            $comment=new Comment();
            $comment->comment=$message;
            $comment->product_id=$productid;
            $comment->user_id=$request->user()->id;
            $comment->save();

            $newcomment=Comment::with("product","user")->find($comment->id);
            Event::fire(new NewCommentEvent($newcomment));

            return [
                "result"=>"OK",
                "comment"=>$comment
            ];

        }
    }

    public function deletecomment(Request $request,$commentid){
        if ($commentid){
            $comment=Comment::findOrFail($commentid);
            $comment->delete();

            return [
                "result"=>"OK",
                "comment"=>$comment
            ];

        }
    }


    public function getProductComments(Request $request,$productid){

        $product=Product::with("comments","comments.user")->find($productid);

        return [
          "result"=>"OK",
            "comments"=>$product->comments
        ];
    }
    
    
    public function ShareProduct(Request $request){
        $productid=$request->input("productid");
        $email=$request->input("email");

        Event::fire(new ShareProductEvent($email,$productid));
        return redirect()->back();

    }


    public function getProductsOfSubcatalogue(Request $request){
        $subcatalogue_id=$request->input("subcatalogue_id");
        $products=Product::active()->with("catalogue","subcatalogue","vendor","images")
            ->where("subcatalogue_id",$subcatalogue_id)
            ->get();

        return response([
            "result"=>"OK",
            "products"=>$products
        ],201);


    }


}
