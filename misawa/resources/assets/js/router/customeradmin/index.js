
import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import Dashboard from '../../components/CustomerAdmin/DashBoard';
import UsersManagement from '../../components/CustomerAdmin/UsersManagement';
import CustomersManagement from '../../components/CustomerAdmin/CustomersManagement';
import MyPOS from '../../components/CustomerAdmin/MyPOS';
import TeamPOS from '../../components/CustomerAdmin/TeamPOS';
import CartViewer from '../../components/CustomerAdmin/CartViewer';



export default new Router({
    routes: [
        {
            path: '/',
            redirect:"/users"
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
            path: '/dashboard',
            name:"dashboard",
            components:{
                // inner_menu:InnerMenu,
                maincontent:Dashboard
            }
        },
        {
            path: '/mypos',
            name:"MyPOS",
            components:{
                // inner_menu:InnerMenu,
                maincontent:MyPOS
            }
        },
        {
            path: '/teampos',
            name:"TeamPOS",
            components:{
                // inner_menu:InnerMenu,
                maincontent:TeamPOS
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
            path: '/cart',
            name:"cartviewer",
            components:{
                // inner_menu:InnerMenu,
                maincontent:CartViewer
            }
        },
    ]
})