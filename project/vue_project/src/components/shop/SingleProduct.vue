<template>

    <div class="container clearfix">
      <section id="page-title" class="mb-5">

      <div class="container clearfix">
        <h1>{{product.name}}</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">
            <router-link :to="{name:'catalogue', params: {catalogue_id: product.catalogue}}">
                    now!
            </router-link>
          </li>
        </ol>
      </div>

    </section>

        <div class="postcontent nobottommargin clearfix">

          <div class="single-product">

            <div class="product">

              <div class="col_half">

                <!-- Product Single - Gallery
                ============================================= -->
                <div class="product-image">
                  <!-- <img :src="product.avatar" :alt="product.name"> -->
                  <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                    <div class="flexslider">
                      <div class="slider-wrap" data-lightbox="gallery">
                          <div class="slide" :data-thumb="productimage.thumbimage" v-for="productimage in product.images">
                            <a :href="productimage.avatar" title="Pink Printed Dress - Front View" data-lightbox="gallery-item">
                              <img :src="productimage.avatar" alt="Pink Printed Dress">
                            </a>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="sale-flash">Sale!</div>
                </div><!-- Product Single - Gallery End -->

              </div>

              <div class="col_half col_last product-desc">

                <!-- Product Single - Price
                ============================================= -->
                <div class="product-price"><del>$39.99</del> <ins>{{product.price|currency}}</ins></div><!-- Product Single - Price End -->

                <!-- Product Single - Rating
                ============================================= -->
                <div class="product-rating">
                  <i class="icon-star3"></i>
                  <i class="icon-star3"></i>
                  <i class="icon-star3"></i>
                  <i class="icon-star-half-full"></i>
                  <i class="icon-star-empty"></i>
                </div><!-- Product Single - Rating End -->

                <div class="clear"></div>
                <div class="line"></div>

                <!-- Product Single - Quantity & Cart Button
                ============================================= -->
                  <div class="quantity clearfix">
                    <input type="button" value="-" class="minus" @click="remove_quantity(product.slug)">
                    <input type="text" step="1" min="1"  name="quantity" v-model="quantity" title="Qty" class="qty" size="4" />
                    <input type="button" value="+" class="plus" @click="add_quantity(product.slug)">
                  </div>
                  <button class="btn btn-success" type="button" v-if="product.stock>0">
                      Stock OK</button>
                  <button class="btn btn-danger" type="button" v-if="product.stock==0">
                      Sold Out!</button>
                <div class="clear"></div>
                <div class="line"></div>

                <!-- Product Single - Short Description
                ============================================= -->
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>
                <p>Perspiciatis ad eveniet ea quasi debitis quos laborum eum reprehenderit eaque explicabo assumenda rem modi.</p>
                <ul class="iconlist">
                  <li><i class="icon-caret-right"></i> Dynamic Color Options</li>
                  <li><i class="icon-caret-right"></i> Lots of Size Options</li>
                  <li><i class="icon-caret-right"></i> 30-Day Return Policy</li>
                </ul><!-- Product Single - Short Description End -->

                <!-- Product Single - Meta
                ============================================= -->
                <div class="card product-meta">
                  <div class="card-body">
                    <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku">8465415</span></span>
                    <span class="posted_in">Category: <a href="#" rel="tag">Dress</a>.</span>
                    <span class="tagged_as">Tags: <a href="#" rel="tag">Pink</a>, <a href="#" rel="tag">Short</a>, <a href="#" rel="tag">Dress</a>, <a href="#" rel="tag">Printed</a>.</span>
                  </div>
                </div><!-- Product Single - Meta End -->

                <!-- Product Single - Share
                ============================================= -->
                <div class="si-share noborder clearfix">
                  <span>Share:</span>
                  <div>
                    <a href="#" class="social-icon si-borderless si-facebook">
                      <i class="icon-facebook"></i>
                      <i class="icon-facebook"></i>
                    </a>
                    <a href="#" class="social-icon si-borderless si-twitter">
                      <i class="icon-twitter"></i>
                      <i class="icon-twitter"></i>
                    </a>
                    <a href="#" class="social-icon si-borderless si-pinterest">
                      <i class="icon-pinterest"></i>
                      <i class="icon-pinterest"></i>
                    </a>
                    <a href="#" class="social-icon si-borderless si-gplus">
                      <i class="icon-gplus"></i>
                      <i class="icon-gplus"></i>
                    </a>
                    <a href="#" class="social-icon si-borderless si-rss">
                      <i class="icon-rss"></i>
                      <i class="icon-rss"></i>
                    </a>
                    <a href="#" class="social-icon si-borderless si-email3">
                      <i class="icon-email3"></i>
                      <i class="icon-email3"></i>
                    </a>
                  </div>
                </div><!-- Product Single - Share End -->

              </div>

              <div class="col_full nobottommargin">

                <div class="tabs clearfix nobottommargin" id="tab-1">

                  <ul class="tab-nav clearfix">
                    <li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="d-none d-md-inline-block"> Description</span></a></li>
                    <li><a href="#tabs-2"><i class="icon-info-sign"></i><span class="d-none d-md-inline-block"> Additional Information</span></a></li>
                    <li><a href="#tabs-3"><i class="icon-star3"></i><span class="d-none d-md-inline-block"> Reviews (2)</span></a></li>
                  </ul>

                  <div class="tab-container">

                    <div class="tab-content clearfix" id="tabs-1">
                      <p>Pink printed dress,  woven, round neck with a keyhole and buttoned closure at the back, sleeveless, concealed zip up at left side seam, belt loops along waist with slight gathers beneath, brand appliqu?? above left front hem, has an attached lining.</p>
                      Comes with a white, slim synthetic belt that has a tang clasp.
                    </div>
                    <div class="tab-content clearfix" id="tabs-2">

                      <table class="table table-striped table-bordered">
                        <tbody>
                          <tr>
                            <td>Size</td>
                            <td>Small, Medium &amp; Large</td>
                          </tr>
                          <tr>
                            <td>Color</td>
                            <td>Pink &amp; White</td>
                          </tr>
                          <tr>
                            <td>Waist</td>
                            <td>26 cm</td>
                          </tr>
                          <tr>
                            <td>Length</td>
                            <td>40 cm</td>
                          </tr>
                          <tr>
                            <td>Chest</td>
                            <td>33 inches</td>
                          </tr>
                          <tr>
                            <td>Fabric</td>
                            <td>Cotton, Silk &amp; Synthetic</td>
                          </tr>
                          <tr>
                            <td>Warranty</td>
                            <td>3 Months</td>
                          </tr>
                        </tbody>
                      </table>

                    </div>
                    <div class="tab-content clearfix" id="tabs-3">

                      <div id="reviews" class="clearfix">

                        <ol class="commentlist clearfix">

                          <li class="comment even thread-even depth-1" id="li-comment-1">
                            <div id="comment-1" class="comment-wrap clearfix">

                              <div class="comment-meta">
                                <div class="comment-author vcard">
                                  <span class="comment-avatar clearfix">
                                  <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='60' width='60' /></span>
                                </div>
                              </div>

                              <div class="comment-content clearfix">
                                <div class="comment-author">John Doe<span><a href="#" title="Permalink to this comment">April 24, 2014 at 10:46AM</a></span></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo perferendis aliquid tenetur. Aliquid, tempora, sit aliquam officiis nihil autem eum at repellendus facilis quaerat consequatur commodi laborum saepe non nemo nam maxime quis error tempore possimus est quasi reprehenderit fuga!</p>
                                <div class="review-comment-ratings">
                                  <i class="icon-star3"></i>
                                  <i class="icon-star3"></i>
                                  <i class="icon-star3"></i>
                                  <i class="icon-star3"></i>
                                  <i class="icon-star-half-full"></i>
                                </div>
                              </div>

                              <div class="clear"></div>

                            </div>
                          </li>

                          <li class="comment even thread-even depth-1" id="li-comment-1">
                            <div id="comment-1" class="comment-wrap clearfix">

                              <div class="comment-meta">
                                <div class="comment-author vcard">
                                  <span class="comment-avatar clearfix">
                                  <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='60' width='60' /></span>
                                </div>
                              </div>

                              <div class="comment-content clearfix">
                                <div class="comment-author">Mary Jane<span><a href="#" title="Permalink to this comment">June 16, 2014 at 6:00PM</a></span></div>
                                <p>Quasi, blanditiis, neque ipsum numquam odit asperiores hic dolor necessitatibus libero sequi amet voluptatibus ipsam velit qui harum temporibus cum nemo iste aperiam explicabo fuga odio ratione sint fugiat consequuntur vitae adipisci delectus eum incidunt possimus tenetur excepturi at accusantium quod doloremque reprehenderit aut expedita labore error atque?</p>
                                <div class="review-comment-ratings">
                                  <i class="icon-star3"></i>
                                  <i class="icon-star3"></i>
                                  <i class="icon-star3"></i>
                                  <i class="icon-star-empty"></i>
                                  <i class="icon-star-empty"></i>
                                </div>
                              </div>

                              <div class="clear"></div>

                            </div>
                          </li>

                        </ol>

                        <!-- Modal Reviews
                        ============================================= -->
                        <a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d nomargin fright">Add a Review</a>

                        <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="reviewFormModalLabel">Submit a Review</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                                <form class="nobottommargin" id="template-reviewform" name="template-reviewform" action="#" method="post">

                                  <div class="col_half">
                                    <label for="template-reviewform-name">Name <small>*</small></label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="icon-user"></i></div>
                                      </div>
                                      <input type="text" id="template-reviewform-name" name="template-reviewform-name" value="" class="form-control required" />
                                    </div>
                                  </div>

                                  <div class="col_half col_last">
                                    <label for="template-reviewform-email">Email <small>*</small></label>
                                    <div class="input-group">
                                      <div class="input-group-prepend"><div class="input-group-text">@</div></div>
                                      <input type="email" id="template-reviewform-email" name="template-reviewform-email" value="" class="required email form-control" />
                                    </div>
                                  </div>

                                  <div class="clear"></div>

                                  <div class="col_full col_last">
                                    <label for="template-reviewform-rating">Rating</label>
                                    <select id="template-reviewform-rating" name="template-reviewform-rating" class="form-control">
                                      <option value="">-- Select One --</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                    </select>
                                  </div>

                                  <div class="clear"></div>

                                  <div class="col_full">
                                    <label for="template-reviewform-comment">Comment <small>*</small></label>
                                    <textarea class="required form-control" id="template-reviewform-comment" name="template-reviewform-comment" rows="6" cols="30"></textarea>
                                  </div>

                                  <div class="col_full nobottommargin">
                                    <button class="button button-3d nomargin" type="submit" id="template-reviewform-submit" name="template-reviewform-submit" value="submit">Submit Review</button>
                                  </div>

                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <!-- Modal Reviews End -->

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="clear"></div><div class="line"></div>
            <div class="demo-image__preview">
              <el-image 
                style="width: 100px; height: 100px"
                :src="url" 
                :preview-src-list="srcList">
              </el-image>
            </div>
        </div>

        <div class="sidebar nobottommargin col_last clearfix">
          <div class="sidebar-widgets-wrap">

            <div class="widget widget_links clearfix">

              <h4>Shop Categories</h4>
              <ul>
                <li><a href="#">Shirts</a></li>
                <li><a href="#">Pants</a></li>
                <li><a href="#">Tshirts</a></li>
                <li><a href="#">Sunglasses</a></li>
                <li><a href="#">Shoes</a></li>
                <li><a href="#">Bags</a></li>
                <li><a href="#">Watches</a></li>
              </ul>

            </div>

            <div class="widget clearfix">

              <h4>Recent Items</h4>
              <div id="post-list-footer">

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/1.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Blue Round-Neck Tshirt</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$29.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/6.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Checked Short Dress</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$23.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/7.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Light Blue Denim Dress</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$19.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>

              </div>

            </div>

            <div class="widget clearfix">

              <h4>Last Viewed Items</h4>
              <div class="widget-last-view">
                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/3.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Round-Neck Tshirt</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$15</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/10.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Green Trousers</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$19</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/11.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Silver Chrome Watch</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$34.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>

            <div class="widget clearfix">

              <h4>Popular Items</h4>
              <div id="Popular-item">
                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/8.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Pink Printed Dress</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$21</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/5.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Blue Round-Neck Tshirt</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$19.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>

                <div class="spost clearfix">
                  <div class="entry-image">
                    <a href="#"><img src="images/shop/small/12.jpg" alt="Image"></a>
                  </div>
                  <div class="entry-c">
                    <div class="entry-title">
                      <h4><a href="#">Men Aviator Sunglasses</a></h4>
                    </div>
                    <ul class="entry-meta">
                      <li class="color">$14.99</li>
                      <li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>

            <div class="widget subscribe-widget clearfix">

              <h4>Subscribe For Latest Offers</h4>
              <h5>Subscribe to Our Newsletter to get Important News, Amazing Offers &amp; Inside Scoops:</h5>
              <form action="#" class="notopmargin nobottommargin">
                <div class="input-group divcenter">
                  <input type="text" class="form-control" placeholder="Enter your Email" required="">
                  <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><i class="icon-email2"></i></button>
                  </div>
                </div>
              </form>
            </div>

            <div class="widget clearfix">

              <div id="oc-clients-full" class="owl-carousel image-carousel carousel-widget" data-items="1" data-margin="10" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false">

                <div class="oc-item"><a href="#"><img src="images/clients/1.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/2.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/3.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/4.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/5.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/6.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/7.png" alt="Clients"></a></div>
                <div class="oc-item"><a href="#"><img src="images/clients/8.png" alt="Clients"></a></div>

              </div>

            </div>

          </div>
        </div>
    </div>

</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import {setToken,getToken,showNotification} from "../../lib/util.js"
  import Swal from 'sweetalert2'
  import { Image } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';


  export default {
    name: 'singleproduct',
    components:{
      elImage: Image,
    },
    data () {
      return {
        quantity:1,
        product:{
          name:"",
          avatar:"",
          price:0,
          images:{}
        },
        url: 'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg',
        srcList: [
          'https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg',
          'https://fuss10.elemecdn.com/1/8e/aeffeb4de74e2fde4bd74fc7b4486jpeg.jpeg'
        ]
      }
    },
  computed: {
    // catalogue_products:function(){
    //   return this.$store.state.lotteryshop.catalogue_products
    // }
  },
  mounted() {
    
    this.loadProductBySlug(this.$route.params.product_slug)

  },
  methods: {
    login_check(){
      const jwt_token=getToken("jwt_token")

      if (jwt_token == undefined || jwt_token ==null){
        Swal.fire({
          type:"warning",  
          title: 'Oops...',
          text: 'You have to login!',
        })
        return false
      }

      return true
    },
    loadProductBySlug(slug){
        const jwt_token=getToken("jwt_token")
        console.log(jwt_token)
        if (jwt_token !==undefined && jwt_token !==null){
            const cartitems=this.$store.state.lotteryshop.cart.cartitems

            console.log(cartitems)
            if(cartitems !==undefined && cartitems.length>1){
                console.log("cartitems existed")
                var itemIndex=cartitems.findIndex(cartitem=>cartitem.product.slug==slug)
                console.log(itemIndex)
                if (itemIndex>-1){
                  this.quantity=cartitems[itemIndex].quantity
                }else{
                  this.quantity=0
                }
            }else if(cartitems.length==1 && cartitems[0].product.slug==slug){
              this.quantity=cartitems[0].quantity
            }else{
              this.quantity=0
            }
        }



        this.$store.dispatch("lotteryshop/getProductBySlug",slug).then(product=>{
          this.product=product
          console.log(this.product)
        },
          reject=>{})
    },
    remove_quantity(product_slug){
      if(this.login_check()){
        if(this.quantity>0){
          const params={
            product_slug:product_slug,
            quantity:1
          }
          this.$store.dispatch("lotteryshop/removeFromCart",params).then(
            resolve=>{
              this.product=resolve
              this.quantity--
            },reject=>{})
        }
      }
    },
    add_quantity(product_slug){
      if(this.login_check()){
        if(this.product.stock >= 1){
          const params={
              product_slug:product_slug,
              quantity:1
            }
          this.$store.dispatch("lotteryshop/addToCart",params).then(
              resolve=>{
                this.product=resolve
                this.quantity++
              },reject=>{})
        }
      }
    },
    // add_to_cart(){

    //   if(this.login_check()){
    //       const params={
    //         product_slug:this.product.slug,
    //         quantity:this.quantity
    //       }
    //       console.log(params)
    //       this.$store.dispatch("lotteryshop/updateCartItem",params).then(
    //         resolve=>{
    //           showNotification("add successfully!","success")
    //         },reject=>{})
    //   }
    // }
  },
  watch:{
    $route:{
      handler(to,from){
        // console.log(to.params.product_slug)
        if(to !==from){
            this.loadProductBySlug(to.params.product_slug)
        }

      }

    }
  }
};
</script>

<style lang="scss">
</style>