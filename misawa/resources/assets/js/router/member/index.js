
import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import ProductList from '../../components/Member/ProductList';
import ProductView from '../../components/Member/ProductView';
import SideBar from '../../components/Member/parts/SideBar';
import TOP5 from '../../components/Member/parts/TOP5';
import Cart from '../../components/Member/Cart';
import Checkout from '../../components/Member/Checkout';
import POS from '../../components/Member/POS';
import SearchProduct from '../../components/Member/SearchProduct';

export default new Router({
    routes: [
        {
            path: '/',
            redirect:"/subcatalogue/3/33"
        },
        {
            path: '/subcatalogue/:catid/:subid',
            name:"subcatalogue",
            components:{
                sidebar:TOP5,
                maincontent:ProductList
            }
        },
        {
            path: '/cart',
            name:"cart",
            components:{
                // sidebar:SideBar,
                maincontent:Cart
            }
        },
        {
            path: '/product/:id',
            name:"product",
            components:{
                sidebar:SideBar,
                maincontent:ProductList
            }
        },
        {
            path: '/viewproduct/:id',
            name:"viewproduct",
            components:{
                // sidebar:SideBar,
                maincontent:ProductView
            }
        },
        {
            path: '/products',
            name:"products",
            components:{
                // sidebar:TOP5,
                maincontent:SearchProduct
            }
        },
        {
            path: '/checkout',
            name:"checkout",
            components:{
                // sidebar:SideBar,
                maincontent:Checkout
            }
        },
        {
            path: '/pos',
            name:"pos",
            components:{
                // sidebar:SideBar,
                maincontent:POS
            }
        },
    ]
})
