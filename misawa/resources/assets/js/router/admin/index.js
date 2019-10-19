
import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Dashboard from '../../components/Admin/DashBoard';
import UsersManagement from '../../components/Admin/UsersManagement';
import CustomersManagement from '../../components/Admin/CustomersManagement';
import NewProduct from '../../components/Admin/NewProduct';
import ProductManagement from '../../components/Admin/ProductManagement';
import CartViewer from '../../components/Admin/CartViewer';
import POS from '../../components/Admin/POS';



export default new Router({
    routes: [
        {
            path: '/',
            redirect:"/dashboard"
        },
        {
            path: '/dashboard',
            name:"dashboard",
            components:{
                // inner_menu:InnerMenu,
                maincontent:Dashboard
            }
        },
        {
            path: '/users',
            name:"usermanagement",
            components:{
                // inner_menu:InnerMenu,
                maincontent:UsersManagement
            }
        },
        {
            path: '/products',
            name:"productmanage",
            components:{
                // inner_menu:InnerMenu,
                maincontent:ProductManagement
            }
        },
        {
            path: '/addproduct',
            name:"addproduct",
            components:{
                // inner_menu:InnerMenu,
                maincontent:NewProduct
            }
        },
        {
            path: '/customers',
            name:"customermanagement",
            components:{
                // inner_menu:InnerMenu,
                maincontent:CustomersManagement
            }
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
            path: '/cartviewer',
            name:"cartviewer",
            components:{
                // inner_menu:InnerMenu,
                maincontent:CartViewer
            }
        },
    ]
})