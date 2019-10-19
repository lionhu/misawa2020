
import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Dashboard from '../../components/Vendor/DashBoard';
import Products from '../../components/Vendor/Products';
import POS from '../../components/Vendor/POS';



export default new Router({
    routes: [
        {
            path: '/',
            redirect:"/pos"
        },
        {

            path: '/pos',
            name:"posmanagement",
            components:{
                // inner_menu:InnerMenu,
                maincontent:POS
            }
        },
        {
            path: '/products',
            name:"products",
            components:{
                // inner_menu:InnerMenu,
                maincontent:Products
            }
        },
        {
            path: '/dashboard',
            name:"dashboard",
            components:{
                // inner_menu:InnerMenu,
                maincontent:Dashboard
            }
        },
    ]
})