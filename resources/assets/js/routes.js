import Home from './components/Home';
import Evaluations from './components/Evaluations';
import Games from './components/Games';
import Profile from './components/Profile';
import NotFound from './components/NotFound';
import Users from './components/Users';
import Login from './components/Login';
import Register from './components/Register';
import Categories from "./components/Categories";

export default {
    mode: 'history',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        // {
        //     path: '/',
        //     component: Home
        // },
        {
            path: '/evaluations',
            component: Evaluations
        },
        {
            path: '/',
            component: Games
        },
        {
            path: '/profile',
            component: Profile
        },
        {
            path: '/users',
            component: Users
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/categories',
            component: Categories
        }
    ]
}
